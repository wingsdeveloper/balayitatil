@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    <style>
        .pagination {
            flex-wrap: wrap;

        }
    </style>
    @include('villa.opportunity.slider')
    <section class="Villas" style="z-index: 999">
        <div class=" containerindex">
            <div class="Villas-filter flex a-i-c">
                <p>Toplam {{$count}} özel fırsat listelendi.</p>
                <div class="Villas-filter-item ml-auto">
                    @php
                        $parametre = \App\Helpers\Helper::parametreTemizle(Request::getQueryString());
                    @endphp
                    <select autocomplete="off" class="selectpicke"
                            onchange="location = '{{Request::url().'?'.$parametre}}&siralama='+this.value;"
                            id="v_filter">
                        <option value="0"
                                @if(!isset($req->siralama) OR empty($req->siralama)) selected="selected" @endif >
                            Sıralama Şeklini Seçiniz
                        </option>
                        <option value="artan"
                                @if($req->siralama=="artan") selected="selected" @endif >Artan Fiyat
                        </option>
                        <option value="azalan"
                                @if($req->siralama=="azalan") selected="selected" @endif >Azalan Fiyat
                        </option>
                    </select>


                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                </div>
                <div class="Villas-filter-item @if(Agent::isMobile()) ml-auto @endif">
                    <select autocomplete="off" class="selectpicke"
                            onchange="location = '{{Request::url().'?'.$parametre}}&ay_filtrele='+this.value;"
                            id="v_filter">
                        <option value="0"
                                @if(!isset($req->siralama) OR empty($req->siralama)) selected="selected" @endif >
                            Aya Göre Filtrele
                        </option>
                        {{--                        <option value="1"--}}
                        {{--                                @if($req->siralama=="1") selected="selected" @endif >Ocak--}}
                        {{--                        </option>--}}
                        {{--                        <option value="2"--}}
                        {{--                                @if($req->siralama=="2") selected="selected" @endif >Şubat--}}
                        {{--                        </option>--}}
                        <option value="3"
                                @if($req->ay_filtrele=="3") selected="selected" @endif >Mart
                        </option>
                        <option value="4"
                                @if($req->ay_filtrele=="4") selected="selected" @endif >Nisan
                        </option>
                        <option value="5"
                                @if($req->ay_filtrele=="5") selected="selected" @endif >Mayıs
                        </option>
                        <option value="6"
                                @if($req->ay_filtrele=="6") selected="selected" @endif >Haziran
                        </option>
                        <option value="7"
                                @if($req->ay_filtrele=="7") selected="selected" @endif >Temmuz
                        </option>
                        <option value="8"
                                @if($req->ay_filtrele=="8") selected="selected" @endif >Ağustos
                        </option>
                        <option value="9"
                                @if($req->ay_filtrele=="9") selected="selected" @endif >Eylül
                        </option>
                        <option value="10"
                                @if($req->ay_filtrele=="10") selected="selected" @endif >Ekim
                        </option>
                        {{--                        <option value="11"--}}
                        {{--                                @if($req->siralama=="11") selected="selected" @endif >Kasım--}}
                        {{--                        </option>--}}
                        {{--                        <option value="12"--}}
                        {{--                                @if($req->siralama=="12") selected="selected" @endif >Aralık--}}
                        {{--                        </option>--}}
                    </select>


                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                </div>
            </div>
            <div class="Villas-in flex wrap">
                @forelse($opportunities as $opportunity)
                    @continue(empty($opportunity->villa))
                    @php

                        $seo_url = isset($opportunity->villa->seo->seo_url) ? $opportunity->villa->seo->seo_url : '';
                               !empty($opportunity->villa->list_image)?$resim="uploads/villa/gallery/".$opportunity->villa->list_image."/".$opportunity->villa->list_image_name:(($opportunity->villa)?$resim=$opportunity->villa->panel_villa->list_image:$resim='');

                              if(!empty($opportunity->start_date)){
                              $start=iconv('latin5','utf-8',\Carbon\Carbon::parse($opportunity->start_date)->formatLocalized('%d %b'));
                              }else{$start="";}
                              if(!empty($opportunity->end_date)){
                              $end=iconv('latin5','utf-8',\Carbon\Carbon::parse($opportunity->end_date)->formatLocalized('%d %b'));
                              }else{$end="";}
                              $giris=Carbon\Carbon::parse($opportunity->start_date);
                              $cikis=Carbon\Carbon::parse($opportunity->end_date);
                              $gun_farki=$giris->diffInDays($cikis, false);
                              $gunlukFiyat=App\Helpers\Helper::gunlukFiyat($opportunity->villa_id,$giris,$cikis);
                    @endphp
                    <div class="f_item">
                        <a href="{{ route('villa.detail.search',[$seo_url,$opportunity->start_date,$opportunity->end_date]) }}"
                           class="global_link">
                        </a>
                        <div class="f_item-image">
                            <img src="{{ImageProcess::getImageByPath($resim)}}" class="w-100"
                                 alt="{{ $opportunity->name }}">
                            <span class="f_item-badge">
            <strong>{{$gun_farki}}
            </strong>GECE
          </span>
                            <p class="f_item-kod flex-column">

                                <span>{{ $website->prefix }}{{ $opportunity->villa->code }}
            </span>{{ $opportunity->villa->name }}
                            </p>
                            <div class="f_item-like">
                                <input type="checkbox" id="v1">
                                {{--<label for="v1">--}}
                                {{--<svg class="icon icon-heart ">--}}
                                {{--<use xlink:href="#icon-heart">--}}
                                {{--</use>--}}
                                {{--</svg>--}}
                                {{--</label>--}}
                            </div>
                        </div>
                        <div class="f_item-info">
          <span class="f_item-info-item">
            <svg class="icon icon-point ">
              <use xlink:href="#icon-point">
              </use>
            </svg>
              {{ isset($opportunity->villa->area->name) ? $opportunity->villa->area->name : '' }}
          </span>
                            <span class="f_item-info-item">
            <svg class="icon icon-user ">
              <use xlink:href="#icon-user">
              </use>
            </svg>
                                {{ $opportunity->villa->number_person }} Kişi
          </span>
                            <span class="f_item-info-item">
            <svg class="icon icon-bed ">
              <use xlink:href="#icon-bed">
              </use>
            </svg>
                                {{ $opportunity->villa->number_bedroom }} Yatak Odası
          </span>
                            <div class="f_item-info-in">
            <span>{{$start}} - {{$end}}
            </span>
                                <p>{{number_format((float)$gunlukFiyat[7], 0, ',', '.')}} ₺
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            <nav class="flex j-c-c">
                {{-- {{ $opportunities->links() }} --}}
                {!! $pagination !!}
            </nav>
        </div>
    </section>
@endsection
