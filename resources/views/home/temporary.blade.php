@if(!isset($temporaries) || empty($temporaries))
    <style type="text/css">.A_firsat:before {
            background-image: none !important;
        }</style>
@else
    <section class="K_villalar">
        <div class=" containerindex">
            <div class="Head flex-column a-i-c j-c-c">
                <h6>KISA SÜRELİ</h6>
                <h5>VİLLALAR</h5>
                <p>
                    {{ isset($short_villas_content->content_description) ? $short_villas_content->content_description : '' }} </p>
            </div>
            @if(Agent::isDesktop())
                <div class="K_villalar-in flex a-i-fs" style="align-items: unset; justify-content: center;">
                    @foreach($temporaries as $ay=>$temporary)
                        @continue(count($temporary) == 0)
                        <div class="K_villalar-item">
                            <p>{{$ay}}</p>
                            @forelse($temporary as $item)
                                <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') }}">{{$item->geceFarki}}
                                    Gecelik <span>({{$item->count}})</span></a>
                            @empty
                            @endforelse
                        </div>
                    @endforeach
                    @foreach($temporariesNext as $ay=>$temporary)
                        @continue(count($temporary) == 0)
                        <div class="K_villalar-item">
                            <p>{{$ay}}</p>
                            @forelse($temporary as $item)
                                <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') + 1 }}">{{$item->geceFarki}}
                                    Günlük <span>({{$item->count}})</span></a>
                            @empty
                            @endforelse
                        </div>
                    @endforeach
                </div>
            @else
                <div class="swiper-container-kv mobile">
                    <div class="swiper-wrapper">

                        @foreach($temporaries as $ay=>$temporary)
                            @continue(count($temporary) == 0)
                            <div class="swiper-slide">
                                <div class="K_villalar-item">
                                    <p>{{$ay}}</p>
                                    @forelse($temporary as $item)
                                        <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') }}">{{$item->geceFarki}}
                                            Günlük <span>({{$item->count}})</span></a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                        @endforeach
                        @foreach($temporariesNext as $ay=>$temporary)
                            @continue(count($temporary) == 0)
                            <div class="swiper-slide">
                                <div class="K_villalar-item">
                                    <p>{{$ay}}</p>
                                    @forelse($temporary as $item)
                                        <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') + 1 }}">{{$item->geceFarki}}
                                            Günlük <span>({{$item->count}})</span></a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            @endif
        </div>
    </section>
@endif

{{--<section class="K_villalar">--}}
{{--<div class=" containerindex">--}}
{{--<div class="Head flex-column a-i-c j-c-c">--}}
{{--            <h6>{{ $temporary_name->type_name }}</h6>--}}
{{--<p>--}}
{{--Nefes kesici doğa manzarası, muhteşem plajları, begonvillerin süslediği beyaz badanalı--}}
{{--taş evleri ve yıldız yağmuru altındaki teraslarıyla bir Akdeniz rüyası…--}}
{{--</p>--}}
{{--</div>--}}
{{--<div class="K_villalar-in flex a-i-fs">--}}

{{--<div class="A_firsat-right flex wrap">--}}

{{--@forelse($populars->homepage_villas as $homepage_villas)--}}
{{--@php--}}
{{--$villa=$homepage_villas->villa;--}}
{{--@endphp--}}
{{--<div class="f_item">--}}
{{--<a href="" class="global_link"></a>--}}
{{--<div class="f_item-image">--}}
{{--<img src="{{asset("uploads/villa/gallery/$villa->list_image/$villa->list_image_name") }}" class="w-100" alt="">--}}
{{--<span class="f_item-badge"><strong>2</strong>GECE</span>--}}
{{--<p class="f_item-kod flex-column"><span>{{ $website->prefix }}{{ $villa->code }}</span>{{ $villa->name }}</p>--}}
{{--<div class="f_item-like">--}}

{{--<input type="checkbox" id="v1">--}}
{{--<label for="v1">--}}
{{--<svg class="icon icon-heart ">--}}
{{--<use xlink:href="#icon-heart"></use>--}}
{{--</svg>--}}
{{--</label>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="f_item-info">--}}

{{--<span class="f_item-info-item">--}}
{{--<svg class="icon icon-point ">--}}
{{--<use xlink:href="#icon-point"></use>--}}
{{--</svg>--}}
{{--{{ isset($villa->area) ? $villa->area['name'] : 'Bölge Yok' }}--}}
{{--</span>--}}
{{--<span class="f_item-info-item">--}}
{{--<svg class="icon icon-user ">--}}
{{--<use xlink:href="#icon-user"></use>--}}
{{--</svg>--}}
{{--{{ $villa->number_person }} Kişi--}}
{{--</span>--}}
{{--<span class="f_item-info-item">--}}
{{--<svg class="icon icon-bed ">--}}
{{--<use xlink:href="#icon-bed"></use>--}}
{{--</svg>--}}
{{--{{ $villa->number_bedroom}} Yatak Odası--}}
{{--</span>--}}
{{--<div class="f_item-info-in">--}}
{{--<span>15-24 HAZİRAN</span>--}}
{{--<p >{{ $villa->starting_price }} ₺</p>--}}
{{--</div>--}}
{{--</div>--}}

{{--</div>--}}
{{--@empty--}}
{{--@endforelse--}}
{{--</div>--}}

{{--</div>--}}
{{--<div class="swiper-container-kv mobile">--}}
{{--<div class="swiper-wrapper">--}}
{{--<div class="swiper-slide">--}}
{{--<div class="K_villalar-item">--}}
{{--<p>HAZİRAN</p>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="swiper-slide">--}}
{{--<div class="K_villalar-item">--}}
{{--<p>HAZİRAN</p>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="swiper-slide">--}}
{{--<div class="K_villalar-item">--}}
{{--<p>HAZİRAN</p>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="swiper-slide">--}}
{{--<div class="K_villalar-item">--}}
{{--<p>HAZİRAN</p>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="swiper-slide">--}}
{{--<div class="K_villalar-item">--}}
{{--<p>HAZİRAN</p>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--<a href="">2 Günlük <span>(2)</span></a>--}}
{{--</div>--}}
{{--</div>--}}

{{--</div>--}}
{{--<!-- Add Pagination -->--}}
{{--<div class="swiper-pagination"></div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
