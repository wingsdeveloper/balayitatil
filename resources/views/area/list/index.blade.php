@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    @include('area.list.slider')
    <div class="Bolge_list">
        <div class="containerindex">
            <div class="Bolge_list-in flex wrap">
@forelse($areas as $area)
        @php
            $villa = App\Villa::join('website_panel_villas', function ($join) {
                $join->on('villas.id', '=', 'website_panel_villas.villa_id')
                    ->where('website_panel_villas.website_id', '=', 2/*APP_WEBSITE_ID*/)
                    ->where('website_panel_villas.status', '=', 1);
            })->where("villas.area_id",$area->id)->whereNotNull('list_price')->where('villas.status', 1)->get();
            if(count($villa) == 0):
                continue;
            endif;
        @endphp
                <div class="Bolge_list-item hover_zoom2">
                    @if(isset($area->seo) && !empty($area->seo) )
                        <a href="{{ url($area->seo->seo_url) }}" class="global_link"></a>
                    @else
                        <a href="#" class="global_link"></a>
                    @endif
                    @if(isset($area->websitePanelAreaContent) && !empty($area->websitePanelAreaContent))
                        <img src="{{ImageProcess::getImageByPath($area->websitePanelAreaContent->list_image)}}" class="w-100" alt="Balayı Sepeti - Bölgeler">
                    @endif
                    <div class="Bolge_list-info">

                        <div class="Bolge_list-locasyon">
                            <svg class="icon icon-location2">
                                <use xlink:href="#icon-location2"></use>
                            </svg>
                            <div class="Bolge_list-locasyon-in">
                                <span>BÖLGE</span>
                                <h3>{{$area->name}}</h3>
                            </div>
                        </div>

                        <div class="Bolge_list-link">
                            <p>VİLLALARI LİSTELE <span>({{count($villa)}})</span></p>
                            <svg class="icon icon-right-arrow">
                                <use xlink:href="#icon-right-arrow"></use>
                            </svg>
                        </div>

                    </div>
                    <!--<div class="Bolge_list-acti flex">
                           <div class="Bolge_list-acti-item">
                                <img src="images/villa.jpg" class="w-100" alt="">
                                <p>KALKAN'DA AKTİVİTE</p>
                           </div>
                         <div class="Bolge_list-acti-item">
                             <img src="images/villa.jpg" class="w-100" alt="">
                             <p>KALKAN'DA AKTİVİTE</p>
                         </div>
                         <div class="Bolge_list-acti-item">
                             <img src="images/villa.jpg" class="w-100" alt="">
                             <p>KALKAN'DA AKTİVİTE</p>
                         </div>
                 </div>-->
                </div>
                @empty
                    Bölge bulunamadı...
                @endforelse
            </div>
        </div>
    </div>
@endsection
