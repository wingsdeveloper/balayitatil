@extends('layouts.app')

@section('content')
    Deneme
    {{--<section class="Villas">--}}
        {{--<div class=" containerindex">--}}
            {{--<div class="Villas-filter flex a-i-c">--}}
                {{--<p>Toplam {{$villas->total()}} özel havuzlu villa listelendi.</p>--}}
                {{--<div class="Villas-filter-item ml-auto">--}}
                    {{--<select class="selectpicke " id="v_filter">--}}
                        {{--<option>Artan Fiyat</option>--}}
                        {{--<option>Azalan Fiyat</option>--}}
                    {{--</select>--}}
                    {{--<svg class="icon icon-caret-down addon">--}}
                        {{--<use xlink:href="#icon-caret-down"></use>--}}
                    {{--</svg>--}}
                    {{--<svg class="icon icon-caret-down addon">--}}
                        {{--<use xlink:href="#icon-caret-down"></use>--}}
                    {{--</svg>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="Villas-in flex wrap desktop">--}}
                {{--@forelse($villas as $villa)--}}
                    {{--@php--}}
                        {{--$areas = App\Area::select("name")->where('id',$villa->area_id)->first();--}}
                        {{--if(!empty($villa->tag_id)){--}}
                        {{--$tag = App\WebsitePanelTag::where('id',$villa->tag_id)->where('website_id',15/*APP_WEBSITE_ID*/)->first();--}}
                        {{--if(isset($tag) && !empty($tag)){--}}
						{{--$badge="<div class='Badge' style='background-color: $tag->color'>--}}
                                                {{--<span>$tag->name</span>--}}
                                            {{--</div>";--}}
											{{--}else{$badge="";}--}}
                        {{--}else{$badge="";}--}}
                    {{--@endphp--}}
                    {{--<div class="P_villas-item item-3   flex">--}}
                        {{--<a href="{{ route('villa.detail',$villa->villa_id) }}" class="global_link"></a>--}}
                        {{--{!! $badge !!}--}}
                        {{--<span class="P_villas-locasyon">--}}
                        {{--<svg class="icon icon-point">--}}
                            {{--<use xlink:href="#icon-point"></use>--}}
                        {{--</svg>--}}
                        {{--{{ isset($areas->name) ? $areas->name : '' }}--}}
                    {{--</span>--}}
                        {{--<div class="P_villas-img ">--}}
                            {{--@php--}}
                                {{--if(empty($villa->list_image)){--}}
                                {{--$resim="uploads/villa/gallery/$villa->orjlist_image/$villa->list_image_name";--}}
                                {{--}else{--}}
                                {{--$resim=$villa->list_image;--}}
                                {{--}--}}
                            {{--@endphp--}}
                            {{--<img src="{{asset($resim)}}" class="w-100" alt="{{ $villa->name }}">--}}

                        {{--</div>--}}
                        {{--<div class="P_villas-info">--}}
                            {{--<div class="P_villas-info-kod">--}}
                                {{--<span>Villa Kodu: {{ $website->prefix }}{{ $villa->code }}</span>--}}
                                {{--<p>{{ $villa->name }}</p>--}}
                            {{--</div>--}}

                            {{--<div class="P_villas-info-in">--}}
                                {{--<div class="info mobile-f">--}}
                                    {{--<svg class="icon icon-point">--}}
                                        {{--<use xlink:href="#icon-point"></use>--}}
                                    {{--</svg>--}}
                                    {{--<span>{{ isset($areas->name) ? $areas->name : '' }}</span>--}}
                                {{--</div>--}}
                                {{--<div class="info">--}}
                                    {{--<svg class="icon icon-bed">--}}
                                        {{--<use xlink:href="#icon-bed"></use>--}}
                                    {{--</svg>--}}
                                    {{--<span>{{ $villa->number_bedroom }} Yatak Odası</span>--}}
                                {{--</div>--}}
                                {{--<div class="info">--}}
                                    {{--<svg class="icon icon-shower">--}}
                                        {{--<use xlink:href="#icon-shower"></use>--}}
                                    {{--</svg>--}}
                                    {{--<span>{{ $villa->number_bathroom }} Banyo</span>--}}
                                {{--</div>--}}
                                {{--<div class="info">--}}
                                    {{--<svg class="icon icon-user">--}}
                                        {{--<use xlink:href="#icon-user"></use>--}}
                                    {{--</svg>--}}
                                    {{--<span>{{ $villa->number_person }} Kişilik</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="P_villas-info-money">--}}
                                {{--<svg class="icon icon-wallet ">--}}
                                    {{--<use xlink:href="#icon-wallet"></use>--}}
                                {{--</svg>--}}
                                {{--<div class="flex-column">--}}
                                    {{--<h6>{{ isset($villa->starting_price) ? $villa->starting_price : '' }} ₺</h6>--}}
                                    {{--<p>{{ isset($villa->list_price) ? $villa->list_price : '' }} </p>--}}
                                    {{--<span>ARALIĞINDA</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="P_villas-info-link">--}}
                                {{--Detaylı İncele--}}
                                {{--<svg class="icon icon-right-arrow ">--}}
                                    {{--<use xlink:href="#icon-right-arrow"></use>--}}
                                {{--</svg>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@empty--}}
                    {{--Henüz Villa Eklenmedi--}}
                {{--@endforelse--}}
            {{--</div>--}}

            {{--@forelse($villas as $villa_mobile)--}}
                {{--@php--}}
                    {{--$areas = App\Area::select("name")->where('id',$villa_mobile->area_id)->first();--}}
                {{--@endphp--}}
                {{--<div class="VillasM flex wrap mobile">--}}
                    {{--<div class="f_item">--}}
                        {{--<a href="{{ route('villa.detail',$villa_mobile->villa_id) }}" class="global_link"></a>--}}
                        {{--<div class="f_item-image">--}}
                            {{--@php--}}
                                {{--if(empty($villa->list_image)){--}}
                                {{--$resim="uploads/villa/gallery/$villa->orjlist_image/$villa->list_image_name";--}}
                                {{--}else{--}}
                                {{--$resim=$villa->list_image;--}}
                                {{--}--}}
                            {{--@endphp--}}
                            {{--<img src="{{asset($resim)}}" class="w-100" alt="{{ $villa->name }}">--}}
                            {{--<p class="f_item-kod flex-column"><span>Villa Kodu</span>{{ $website->prefix }}{{ $villa_mobile->code }}</p>--}}
                        {{--</div>--}}
                        {{--<div class="f_item-info">--}}

                         {{--<span class="f_item-info-item">--}}
                        {{--<svg class="icon icon-point ">--}}
                            {{--<use xlink:href="#icon-point"></use>--}}
                        {{--</svg>--}}
                       {{--{{ isset($areas->name) ? $areas->name : '' }}--}}
                    {{--</span>--}}
                            {{--<span class="f_item-info-item">--}}
                        {{--<svg class="icon icon-user ">--}}
                            {{--<use xlink:href="#icon-user"></use>--}}
                        {{--</svg>--}}
                        {{--{{ $villa_mobile->number_person }} Kişilik--}}
                    {{--</span>--}}
                            {{--<div class="P_villas-info-money">--}}
                                {{--<svg class="icon icon-wallet ">--}}
                                    {{--<use xlink:href="#icon-wallet"></use>--}}
                                {{--</svg>--}}
                                {{--<div class="flex-column">--}}
                                    {{--<h6>{{ $villa_mobile->starting_price}}₺</h6>--}}
                                    {{--<p>{{ $villa_mobile->list_price }}₺</p>--}}
                                    {{--<span>ARALIĞINDA</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@empty--}}
                {{--Henüz Villa Eklenmedi--}}
            {{--@endforelse--}}
            {{--<nav class="flex j-c-c">--}}
                {{--{{ $villas->links() }}--}}
            {{--</nav>--}}
        {{--</div>--}}
    {{--</section>--}}
@endsection
