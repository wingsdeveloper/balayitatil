@extends('layouts.app')
@push('extrahead')
<!-- Criteo Listing Tag -->
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
    { event: "setAccount", account: 46955 },
    { event: "setEmail", email: "", hash_method: "" },
    { event: "setSiteType", type: deviceType},
    { event: "setZipcode", zipcode: "" },
    { event: "viewList", item: [{{ implode(",", $villas->pluck('id')->toArray()) }}] });
</script>
<!-- END Criteo Listing Tag -->
@endpush
@section('content')

    @include('area.detail.slider')
    <section class="Villas">
        <div class=" containerindex">

            <div class="Villas-filter flex a-i-c">
                <p>Toplam {{ !empty($villas) ? $villas->total() : '' }} adet tesis listelendi.</p>
                <div class="Villas-filter-item ml-auto">
                    @php
                        $parametre=\App\Helpers\Helper::parametreTemizle(Request::getQueryString());
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
            </div>

            <div class="Villas-in flex wrap">
                @if(Agent::isDesktop())
                    @forelse($villas as $villa)
                        @php
                            $seo_url = isset($villa->seo->seo_url) ? $villa->seo->seo_url : '';
                           // $gecelikFiyat=\App\Helpers\Helper::nPrice($villa->id);
                        @endphp
                        <div class="P_villas-item item-3   flex">
                            <a href="{{ url($seo_url) }}" class="global_link"></a>
                            @if($villa->panel_villa)
                            {!! view('ux.badge',['param'=>$villa->panel_villa->panel_tag])->render() !!}
                            @endif
                            <span class="P_villas-locasyon">
                        <svg class="icon icon-point">
                            <use xlink:href="#icon-point"></use>
                        </svg>
                                {{ isset($villa->area->name) ? $villa->area->name : '' }}
                    </span>

                            <div class="P_villas-img ">
                                @php
                                    !empty($villa->list_image)?$resim="uploads/villa/gallery/$villa->list_image/$villa->list_image_name":$resim=$villa->panel_villa->list_image;
                                @endphp
                                <img src="{{ImageProcess::getImageByPath($resim)}}" class="w-100"
                                     alt="{{ $villa->name }}">
                            </div>
                            <div class="P_villas-info">
                                <div class="P_villas-info-kod">
                                    <span>Villa Kodu: {{ $website->prefix }}{{ $villa->code }}</span>
                                    <p>{{ $villa->name }}</p>
                                </div>

                                <div class="P_villas-info-in">
                                    <div class="info mobile-f">
                                        <svg class="icon icon-point">
                                            <use xlink:href="#icon-point"></use>
                                        </svg>
                                        <span>{{ isset($villa->area->name) ? $villa->area->name : '' }}</span>
                                    </div>
                                    <div class="info">
                                        <svg class="icon icon-bed">
                                            <use xlink:href="#icon-bed"></use>
                                        </svg>
                                        <span>{{ $villa->number_bedroom }} Yatak Odası</span>
                                    </div>
                                    <div class="info">
                                        <svg class="icon icon-shower">
                                            <use xlink:href="#icon-shower"></use>
                                        </svg>
                                        <span>{{ $villa->number_bathroom }} Banyo</span>
                                    </div>
                                    <div class="info">
                                        <svg class="icon icon-user">
                                            <use xlink:href="#icon-user"></use>
                                        </svg>
                                        <span>{{ $villa->number_person }} Kişilik</span>
                                    </div>
                                </div>
                                <div class="P_villas-info-money">
                                    <svg class="icon icon-wallet ">
                                        <use xlink:href="#icon-wallet"></use>
                                    </svg>
                                    <div class="flex-column">
                                    <h6>{{number_format((float)$villa->starting_price, 0, ',', '.')}} ₺</h6>
                                    <p>GECELİK </p>
                                    <span>BAŞLAYAN FİYATLARLA</span>
                                    </div>
                                </div>

                                <div class="P_villas-info-link">
                                    Detaylı İncele
                                    <svg class="icon icon-right-arrow ">
                                        <use xlink:href="#icon-right-arrow"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @empty
                        Henüz Villa Eklenmedi
                    @endforelse

                @elseif(Agent::isMobile())
                    @forelse($villas as $villa_mobile)
                        @php

                            $seo_url = isset($villa_mobile->seo->seo_url) ? $villa_mobile->seo->seo_url : '';
                          //  $gecelikFiyat=\App\Helpers\Helper::nPrice($villa_mobile->id);
                        @endphp
                        <div class="VillasM flex wrap mobile">
                            <div class="f_item">
                                    <a href="{{ url($seo_url) }}" class="global_link"></a>
                                <div class="f_item-image">
                                    @if($villa_mobile->panel_villa)
                                        {!! view('ux.badge',['param'=>$villa_mobile->panel_villa->panel_tag])->render() !!}
                                    @endif
                                    @php
                                        !empty($villa_mobile->list_image)?$resim="uploads/villa/gallery/$villa_mobile->list_image/$villa_mobile->list_image_name":$resim=$villa_mobile->panel_villa->list_image;
                                    @endphp
                                    <img src="{{asset($resim)}}" class="w-100" alt="{{ $villa_mobile->name }}">
                                    <p class="f_item-kod flex-column">
                                        <span>{{ $website->prefix }}{{ $villa_mobile->code }}</span>{{ $villa_mobile->name }}
                                    </p>
                                </div>
                                <div class="f_item-info">

               <span class="f_item-info-item">
                <svg class="icon icon-point ">
                    <use xlink:href="#icon-point"></use>
                </svg>
                   {{ isset($villa_mobile->area->name) ? $villa_mobile->area->name : '' }}
            </span>
                                    <span class="f_item-info-item">
                <svg class="icon icon-user ">
                    <use xlink:href="#icon-user"></use>
                </svg>
                                        {{ $villa_mobile->number_person }} Kişilik
            </span>
                                    <div class="P_villas-info-money">
                                        <svg class="icon icon-wallet ">
                                            <use xlink:href="#icon-wallet"></use>
                                        </svg>
                                        <div class="flex-column">
                                        <h6>{{number_format((float)$villa_mobile->starting_price, 0, ',', '.')}} ₺</h6>
                                    <p>GECELİK </p>
                                    <span>BAŞLAYAN <br/>FİYATLARLA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        Henüz Villa Eklenmedi
                    @endforelse
                @endif


            </div>
            <nav class="flex j-c-c">
                {{ $villas->links() }}
            </nav>

        </div>
    </section>
@endsection
