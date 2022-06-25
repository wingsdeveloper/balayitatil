@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
        }
    </style>
    @if(Agent::isDesktop())
        <section class="Tekliflerim desktop" id="foto">
            <div class="container">

                <div class="col-md-12 text-center" style="justify-content: center;">
                    {!!  $villas_arr->links() !!}
                </div>


                <div class="Tekliflerim-top flex-column">
                    <p class="Tekliflerim-no">TEKLİF NO {{ $offer->id }}</p>
                    <p class="Tekliflerim-best">SİZİN İÇİN EN İYİ TEKLİF</p>
                </div>
                <div class="Tekliflerim-in">
                    @foreach($villas_arr as $villa)

                        @php
                            if(isset($villa->panel_villa) && !empty($villa->panel_villa)){
                                if(isset($villa->panel_villa->panel_tag) && !empty($villa->panel_villa->panel_tag)){
                                    $badge="<div class='Badge' style='background-color: " . $villa->panel_villa->panel_tag->color . "'>
                                    <span>" . $villa->panel_villa->panel_tag->name . "</span> </div>";
                                }else{$badge="";}
                            }else{
                                $badge="";
                            }
                            $key=array_search($villa->id,array_column($json, 0));
                            $offer_note=$json[$key][1];
                            $offer_start_date=$json[$key][2];
                            $offer_end_date=$json[$key][3];
                            $giris = Carbon\Carbon::parse($offer_start_date);
                            $cikis = Carbon\Carbon::parse($offer_end_date);
                            $giris_tarih=$giris->format('Y-m-d');
                            $cikis_tarih=$cikis->format('Y-m-d');
                            $gunlukFiyat=App\Helpers\Helper::gunlukFiyat($villa->id,$giris_tarih,$cikis_tarih);
                            $giris_ay=iconv('latin5','utf-8',$giris->formatLocalized('%b'));
                            $giris_gun=$giris->formatLocalized('%d');
                            $giris_gun_yazi=iconv('latin5','utf-8',$giris->localeDayOfWeek);
                            $cikis_ay=iconv('latin5','utf-8',$cikis->formatLocalized('%b'));
                            $cikis_gun=$cikis->formatLocalized('%d');
                            $cikis_gun_yazi=iconv('latin5','utf-8',$cikis->localeDayOfWeek);

                        @endphp
                        <div class="Tekliflerim-item flex ">
                            <div class="Tekliflerim-item-left" style="width: 53%">
                                <div class="Tekliflerim-item-image">
                                    {{--<div class="Tekliflerim-item-image-icon flex a-i-c">--}}
                                    {{--<svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg>--}}
                                    {{--Büyük Fotoğraflar--}}
                                    {{--</div>--}}
                                    <div class="Tekliflerim-item-image-in flex a-i-c">
                                        {{--<div id="gallery" class="gallery">--}}


                                        {{--                                @forelse($villa->photos as $photo)--}}
                                        {{--<figure itemprop="associatedMedia" itemscope itemtype="">--}}
                                        {{--<!-- Büyük Resim linki -->--}}

                                        {{--@if(Agent::isMobile())--}}
                                        {{--<a href="{{ImageProcess::getImageByPath($resim)}}"--}}
                                        {{--data-caption="{{$villa->name}}"--}}
                                        {{--data-width="1920" data-height="1080"--}}
                                        {{--itemprop="contentUrl">--}}
                                        {{--<!-- Küçük Resim -->--}}

                                        {{--<img src="{{ImageProcess::getImageByPath($resim)}}" itemprop="thumbnail" alt="{{$villa->name}}">--}}
                                        {{--</a>--}}
                                        {{--@else--}}
                                        {{--<a href="{{ImageProcess::getImageByPath($resim)}}"--}}
                                        {{--data-caption="{{$villa->name}}"--}}
                                        {{--data-width="1920" data-height="1080"--}}
                                        {{--itemprop="contentUrl">--}}
                                        {{--<!-- Küçük Resim -->--}}

                                        {{--<img src="{{ImageProcess::getImageByPath($resim)}}" itemprop="thumbnail" alt="{{$villa->name}}">--}}
                                        {{--</a>--}}

                                        {{--@endif--}}
                                        {{--</figure>--}}
                                        {{--@empty--}}
                                        {{--@endforelse--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                                {!! $badge !!}
                                {{--<a class="global_link" href="{{ route('villa.detail.search',[$villa->seo->seo_url, $offer_start_date, $offer_end_date]) }}"></a>--}}
                                <p class="f_item-kod flex-column"><span><a
                                            href="/{{$villa->seo->seo_url}}">{{ $website->prefix }}{{ $villa->code }}</a></span><a
                                        href="/{{$villa->seo->seo_url}}">{{ $villa->name }}</a></p>
                                <p class="f_item-kod flex-column" style="left: unset; right: 20px!important">
                                    <a href="">{{ $villa->area->name }}</a></p>

                                <div id="carousel{{$villa->id}}" class="carousel slide lazy"
                                     data-ride="carousel">
                                    <div class="carousel-inner" role="listbox">
                                        @php

                                            if(empty($villa->panel_villa) || empty($villa->panel_villa->list_image)){
                                                $resim="uploads/villa/gallery/$villa->list_image/$villa->list_image_name";
                                            }else{
                                                $resim=$villa->panel_villa->list_image;
                                            }
                                        @endphp
                                        @if(count($villa->photos) > 0)
                                            @foreach($villa->photos->take(3) as $key=>$photo)
                                                @php
                                                    $yuklenecek = ImageProcess::getImageByPath('uploads/villa/gallery/' . $photo->path . '/' . $photo->name);
                                                @endphp
                                                @if(!empty($yuklenecek))
                                                    <div class="carousel-item {{($key==0)? 'active':''}} item"
                                                         style="/*background-image: url({{ImageProcess::getImageByPath($yuklenecek)}});*/">
                                                        <img class="lazy" data-lazy-load-src="{{ImageProcess::getImageByPath($yuklenecek)}}" style="height: 100%; width: 100%;" {{($key==0)? '':''}} alt="">
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel{{$villa->id}}"
                                       role="button" data-slide="prev">
                                        <svg class="icon icon-chevron-right">
                                            <use xlink:href="#icon-chevron-right"></use>
                                        </svg>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel{{$villa->id}}"
                                       role="button" data-slide="next">
                                        <svg class="icon icon-chevron-right">
                                            <use xlink:href="#icon-chevron-right"></use>
                                        </svg>
                                    </a>
                                </div>

                                @if(isset($offer_note) && !empty($offer_note))
                                    <div class="Tekliflerim-item-not flex">
                                        <h5 class="Tekliflerim-item-not-left">BU VİLLA İÇİN SİZE NOTUMUZ</h5>
                                        <p class="Tekliflerim-item-not-right">{{ $offer_note }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="Tekliflerim-item-right">
                                <div class="Tekliflerim-item-price flex a-i-c justify-content-between">
                                    <p class="Tekliflerim-item-price-left">
                                        <span>{{number_format($gunlukFiyat[1], 0, ',', '.')}} ₺ Gece Fiyatı </span> {{number_format($gunlukFiyat[7], 0, ',', '.')}} ₺</p>
                                        
                                        <h5 style="height: 50px; justify-content: center" class="Tekliflerim-item-not-left">
                                            <a href="{{ route('villa.detail.search',[$villa->seo->seo_url, $offer_start_date, $offer_end_date]) }}">Villayı İnceleyin</a>
                                        </h5>

                                    <div class="Tekliflerim-item-price-right flex a-i-c">
                                        <p class="Tekliflerim-item-price-right-date">
                                            <span>{{ $giris_ay }}</span>{{ $giris_gun }}</p>
                                        <span class="Tekliflerim-item-price-right-icon">
                                        {{ $gunlukFiyat[2] }} GECE
                                        <svg class="icon icon-right-arrow">
                                            <use xlink:href="#icon-right-arrow"></use>
                                        </svg>
                                    </span>
                                        <p class="Tekliflerim-item-price-right-date">
                                            <span>{{ $cikis_ay }}</span>{{ $cikis_gun }}</p>
                                    </div>
                                </div>
                                <div class="Tekliflerim-item-info flex a-i-c ">
                                    <p>
                                        <svg class="icon icon-bed">
                                            <use xlink:href="#icon-bed"></use>
                                        </svg>{{ $villa->number_bedroom }} Yatak Odası
                                    </p>
                                    <p>
                                        <svg class="icon icon-shower">
                                            <use xlink:href="#icon-shower"></use>
                                        </svg>{{ $villa->number_bathroom }} Banyo
                                    </p>
                                    <p>
                                        <svg class="icon icon-user">
                                            <use xlink:href="#icon-user"></use>
                                        </svg>{{ $villa->number_person }} Kişilik
                                    </p>
                                </div>
                                <div class="Tekliflerim-item-road">
                                    <h6>MESAFELER</h6>
                                    <div class="Tekliflerim-item-road-in flex wrap a-i-c">
                                        <div class="Tekliflerim-item-road-in-item">
                                            <svg class="icon icon-airport">
                                                <use xlink:href="#icon-airport">
                                                </use>
                                            </svg>
                                            <p>Havaalanı Mesafesi
                                                <span>{{$villa->airport_distance}}
                      </span>
                                            </p>
                                        </div>
                                        <div class="Tekliflerim-item-road-in-item">
                                            <svg class="icon icon-sea">
                                                <use xlink:href="#icon-sea">
                                                </use>
                                            </svg>
                                            <p>Deniz Mesafesi
                                                <span>{{$villa->sea_distance}}
                  </span>
                                            </p>
                                        </div>
                                        <div class="Tekliflerim-item-road-in-item">
                                            <svg class="icon icon-market">
                                                <use xlink:href="#icon-market">
                                                </use>
                                            </svg>
                                            <p>Market Mesafesi
                                                <span>{{$villa->shop_distance}}
              </span>
                                            </p>
                                        </div>
                                        <div class="Tekliflerim-item-road-in-item">
                                            <svg class="icon icon-medicane">
                                                <use xlink:href="#icon-medicane">
                                                </use>
                                            </svg>
                                            <p>Hastane Mesafesi
                                                <span>{{$villa->hospital_distance}}
          </span>
                                            </p>
                                        </div>
                                        <div class="Tekliflerim-item-road-in-item">
                                            <svg class="icon icon-restorant">
                                                <use xlink:href="#icon-restorant">
                                                </use>
                                            </svg>
                                            <p>Restaurant Mesafesi
                                                <span>{{$villa->restaurant_distance}}
          </span>
                                            </p>
                                        </div>
                                        <div class="Tekliflerim-item-road-in-item">
                                            <svg class="icon icon-house2">
                                                <use xlink:href="#icon-house2">
                                                </use>
                                            </svg>
                                            <p>Merkez Mesafesi
                                                <span>{{$villa->center_distance}}
          </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @if(count($villa->prominents) > 0)
                                    <div class="Tekliflerim-item-extra">
                                        <h6>ÖNE ÇIKAN ÖZELLİKLER</h6>
                                        <div class="Tekliflerim-item-extra-in">
                                            @foreach($villa->prominents as $villaProminent)
                                                @if(isset($villaProminent->generalProminent) && !empty($villaProminent->generalProminent))
                                                    <span>{{ $villaProminent->generalProminent->name }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <form action="{{ route('reservation', [$id])}}" method="get">
                                    <input type="hidden" name="giris_tarih" value="{{$offer_start_date}}">
                                    <input type="hidden" name="cikis_tarih" value="{{$offer_end_date}}">
                                    <input type="hidden" name="villa" value="{{ $villa->id }}">
                                    <div class="flex">
                                        <h5 style="justify-content: center; height: 90px; width: 100%;" class="Tekliflerim-item-not-left">
                                            <a class="flex a-i-c" style="height: 90px;" href="{{ route('villa.detail.search',[$villa->seo->seo_url, $offer_start_date, $offer_end_date]) }}">VİLLAYI İNCELEYİN</a>
                                        </h5>
                                        <button style="cursor: pointer;" type="submit" class="Tekliflerim-item-link">HEMEN
                                            REZERVASYON YAP
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="col-md-12 text-center" style="justify-content: center;">
                    {!!  $villas_arr->links() !!}
                </div>

            </div>

        </section>
    @elseif(Agent::isMobile())
        <section class="Tekliflerim TekliflerimM mobile">

            <div class="col-md-12 text-center" style="justify-content: center;margin-bottom:20px;">
                {!!  $villas_arr->links() !!}
            </div>

            <div class="container">
                <div class="TekliflerimM-header">
                    <h2>SİZİN İÇİN TEKLİFLERİMİZ <strong>({{count($villas)}})</strong></h2>
                    <p></p>
                </div>
                <div class="Tekliflerim-top flex-column">
                    <p class="Tekliflerim-no">TEKLİF NO {{ $offer->id }}</p>
                    <p class="Tekliflerim-best">SİZİN İÇİN EN İYİ TEKLİF</p>
                </div>
                <div class="Tekliflerim-in">
                    @if(count($villas_arr) > 0)
                        @foreach($villas_arr as $villa)
                            @php
                                if(isset($villa->panel_villa) && !empty($villa->panel_villa)){
                                    if(isset($villa->panel_villa->panel_tag) && !empty($villa->panel_villa->panel_tag)){
                                        $badge="<div class='Badge' style='background-color: " . $villa->panel_villa->panel_tag->color . "'>
                                        <span>" . $villa->panel_villa->panel_tag->name . "</span> </div>";
                                    }else{$badge="";}
                                }else{
                                    $badge="";
                                }

                                $key=array_search($villa->id,array_column($json, 0));
                                $offer_note=$json[$key][1];
                                $offer_start_date=$json[$key][2];
                                $offer_end_date=$json[$key][3];
                                $giris = Carbon\Carbon::parse($offer_start_date);
                                $cikis = Carbon\Carbon::parse($offer_end_date);
                                $giris_tarih=$giris->format('Y-m-d');
                                $cikis_tarih=$cikis->format('Y-m-d');
                                $gunlukFiyat=App\Helpers\Helper::gunlukFiyat($villa->id,$giris_tarih,$cikis_tarih);
                                $giris_ay=$giris->formatLocalized('%b');
                                $giris_gun=$giris->formatLocalized('%d');
                                $giris_gun_yazi=iconv('latin5','utf-8',$giris->localeDayOfWeek); $cikis_ay=$cikis->formatLocalized('%b');
                                $cikis_gun=$cikis->formatLocalized('%d');
                                $cikis_gun_yazi=iconv('latin5','utf-8',$cikis->localeDayOfWeek);
                            @endphp
                            <form action="{{ route('reservation', [$id])}}" method="get">
                                <div class="Tekliflerim-item  ">
                                    <div class="Tekliflerim-item-price flex a-i-c justify-content-between">
                                        <p style="font-size: 24px" class="Tekliflerim-item-price-left">
                                            <span
                                                style="font-size: 10px">{{number_format($gunlukFiyat[1], 0, ',', '.')}} Gece Fiyatı </span> {{number_format($gunlukFiyat[7], 0, ',', '.')}}
                                            ₺ 
                                        </p>
                                        <div class="Tekliflerim-item-price-right flex a-i-c">
                                            <p class="Tekliflerim-item-price-right-date">
                                                <span>{{ $giris_gun }}</span>{{ $giris_ay }}</p>
                                            <span class="Tekliflerim-item-price-right-icon">
                                {{ $gunlukFiyat[2] }} GECE
                                <svg class="icon icon-right-arrow">
                                    <use xlink:href="#icon-right-arrow"></use>
                                </svg>
                            </span>
                                            <p class="Tekliflerim-item-price-right-date">
                                                <span>{{ $cikis_gun }}</span>{{ $cikis_ay }}</p>
                                        </div>
                                    </div>
                                    <div class="TekliflerimM-item-image">
                                        {!! $badge !!}
                                        <p class="f_item-kod flex-column">
                                            <span>{{ $website->prefix }}{{ $villa->code }}</span>{{ $villa->name }}</p>

                                        @php
                                            if(empty($villa->panel_villa->list_image)){
                                                $resim="uploads/villa/gallery/$villa->list_image/$villa->list_image_name";
                                            }else{
                                                $resim=$villa->panel_villa->list_image;
                                            }
                                        @endphp
                                        <img src="{{asset($resim)}}" class="w-100" alt="{{ $villa->name }}">
                                    </div>
                                    @if(!empty($offer_note))
                                        <div class="TekliflerimM-item-not">
                                            <h6>BU VİLLA İÇİN SİZE NOTUMUZ</h6>
                                            <p>{{ $offer_note }}</p>
                                        </div>
                                    @endif
                                    <div class="TekliflerimM-item-link flex">
                                        <input type="hidden" name="giris_tarih" value="{{$offer_start_date}}">
                                        <input type="hidden" name="cikis_tarih" value="{{$offer_end_date}}">
                                        <input type="hidden" name="villa" value="{{ $villa->id }}">

                                        <button style="cursor: pointer;" type="submit"
                                                class="TekliflerimM-item-link-left">HEMEN REZERVASYON YAP
                                        </button>

                                        @if(isset($villa->seo) && !empty($villa->seo))
                                            <a href="{{ route('villa.detail.search', [$villa->seo->seo_url, $offer_start_date, $offer_end_date]) }}"
                                               class="TekliflerimM-item-link-right">VİLLAYI İNCELE</a>
                                        @else
                                            <a href="#" class="TekliflerimM-item-link-right">VİLLAYI İNCELE</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    @endif
                </div>
            </div>


            <div class="col-md-12 text-center" style="justify-content: center;margin-bottom:20px;">
                {!!  $villas_arr->links() !!}
            </div>

        </section>
    @endif
@endsection
@push('javascripts')
    <script>

var cHeight = 0;

$('.carousel.lazy').on('slide.bs.carousel', function(e) {

  var $nextImage = $(e.relatedTarget).find('img');

  $activeItem = $('.active.item', this);

  // prevents the slide decrease in height
  if (cHeight == 0) {
    cHeight = $(this).height();
    $activeItem.next('.item').height(cHeight);
  }

  // prevents the loaded image if it is already loaded
  var src = $nextImage.data('lazy-load-src');

  if (typeof src !== "undefined" && src != "") {
    $nextImage.attr('src', src)
    $nextImage.data('lazy-load-src', '');
  }
});
    </script>
@endpush
