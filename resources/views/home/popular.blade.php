
@include('layouts.homeInfo') 

@if(Agent::isDesktop())
<section class="A_p P_villas desktop">
        <div class="Head flex-column a-i-c j-c-c">
            <h6>POPÜLER</h6>
            <h5>VİLLALAR</h5>
            <p>{{ isset($pop_content->content_description) ? $pop_content->content_description : '' }}</p>
        </div>
        <div class=" containerindex">
            <div class="P_villas-in flex ">

            @foreach($populars->homepage_villas as $homepage)

                    @php
                        $seo_url = isset($homepage->villa->seo) ? $homepage->villa->seo->seo_url : '';

                     //   $gecelikFiyat=App\Helpers\Helper::nPrice($homepage->villa->id);
                    @endphp

                <div class="P_villas-item item-2  flex">
                     
                        <div class="On-odeme">
                            <p class="On-odeme-yuzde">%<b>20</b></p>
                            <p class="On-odeme-text">Şimdi Öde<span>Kalanı</span>Girişte Öde!</p>
                        </div>

                        <div class="P_villas-img "> {!! view('ux.badge',['param'=>$homepage->villa->panel_villa->panel_tag])->render() !!}
                            <a href="{{ url($seo_url) }}" class="global_link"></a>
                            <div class="f_item-like">

                                <input type="checkbox" id="v1">
                                {{--<label for="v1"  >--}}
                                {{--<svg class="icon icon-heart ">--}}
                                {{--<use xlink:href="#icon-heart"></use>--}}
                                {{--</svg>--}}
                                {{--</label>--}}

                            </div>
                            @php
                                !empty($homepage->villa->list_image)?$resim="uploads/villa/gallery/".$homepage->villa->list_image."/".$homepage->villa->list_image_name:$resim=$homepage->villa->panel_villa->list_image;
                            @endphp
                            <img src="{{ asset('images/default.jpg') }}" data-src="{{ImageProcess::getVillaImageByPath($resim)}}" class="w-100 lazy-load"
                                 alt="{{ $homepage->villa->name }}">


                        </div>
                    <div class="P_villas-info">
                        <a href="{{ url($seo_url) }}" class="global_link"></a>
                        <div class="P_villas-info-kod">
                            <p>{{ $homepage->villa->name }}</p>
                            <span>Villa Kodu: {{ $website->prefix }}{{ $homepage->villa->code }}</span>
                        </div>
                        <div class="P_villas-info-people">
                            <p><b>2</b> Kişi /  En Az <b>4</b> Gece</p>
                        </div>
                        <div class="P_villas-info-in">
                            <div class="info">
                                <svg class="icon icon-bed" data-original-title="" title="">
                                    <use xlink:href="#icon-bed"></use>
                                </svg>
                                <span>{{ $homepage->villa->number_bedroom }} Yatak Odalı</span>
                            </div>
                            
                            <div class="info">
                                <svg class="icon" width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M.55 0c.234 0 .424.183.424.41v1.463h6.43c1.46.002 2.695 1.049 2.887 2.45 2.397.216 4.232 2.158 4.238 4.487v.85c.37.167.604.527.598.921-.003.554-.464 1.003-1.036 1.01H5.619a1.036 1.036 0 0 1-1-.808 1.002 1.002 0 0 1 .591-1.122v-.85c0-2.327 1.83-4.271 4.224-4.488-.185-.945-1.037-1.63-2.03-1.63H.974V4.39c0 .226-.19.41-.423.41a.417.417 0 0 1-.424-.41V.41c0-.227.19-.41.424-.41zM5.62 10.771h8.472c.1 0 .181-.078.181-.175a.179.179 0 0 0-.181-.176H5.619c-.1 0-.182.079-.182.176 0 .097.081.175.182.175zm.438-1.17v-.79c0-2.038 1.707-3.689 3.813-3.689 2.105 0 3.812 1.651 3.812 3.688v.79H6.057zM12.15 14.574c-.17-.183-.42-.46-.42-.973v-.235c0-.227.164-.412.367-.412.202 0 .366.185.366.412v.235c0 .155.045.218.195.379.17.183.424.46.424.973 0 .513-.259.79-.43.973-.149.16-.201.224-.201.379 0 .154.051.218.2.378.17.183.428.46.428.974 0 .513-.25.79-.421.973-.15.16-.195.224-.195.379v.352c0 .228-.164.412-.366.412-.203 0-.367-.184-.367-.412v-.352c0-.514.25-.79.42-.974.15-.16.198-.224.198-.378 0-.155-.053-.218-.202-.38-.17-.182-.428-.459-.428-.972 0-.514.257-.79.427-.973.149-.161.204-.225.204-.38 0-.153-.049-.217-.198-.378zM8.742 14.574c-.17-.183-.421-.46-.421-.973v-.235c0-.227.164-.412.367-.412.202 0 .366.185.366.412v.235c0 .155.045.218.195.379.17.183.423.46.423.973 0 .513-.258.79-.428.973-.15.16-.202.224-.202.379 0 .154.051.218.2.378.17.183.427.46.427.974 0 .513-.25.79-.42.973-.15.16-.195.224-.195.379v.352c0 .228-.164.412-.366.412-.203 0-.367-.184-.367-.412v-.352c0-.514.25-.79.42-.974.15-.16.198-.224.198-.378 0-.155-.053-.218-.202-.38-.17-.182-.428-.459-.428-.972 0-.514.256-.79.426-.973.15-.161.204-.225.204-.38 0-.153-.048-.217-.197-.378z" fill="#fff"/>
                                </svg>
                                <span>{{ $homepage->villa->number_bathroom }} Banyo</span>
                            </div>
                            <div class="info">
                                <svg class="icon icon-new-location" data-original-title="" title="">
                                    <use xlink:href="#icon-new-location"></use>
                                </svg>
                                <span><b>Kalkan</b> Bölgesinde </span>
                            </div>
                            <div class="info takvim">
                                <svg class="icon icon-new-calendar" data-original-title="" title="">
                                    <use xlink:href="#icon-new-calendar"></use>
                                </svg>
                                <span><b>Takvimi Güncel!</b></span>
                            </div>
                        </div>
                        <div class="P_villas-info-money">
                            <svg class="icon icon-wallet " data-original-title="" title="">
                                <use xlink:href="#icon-wallet"></use>
                            </svg>
                            <div class="flex-column">
                                <h6>{{number_format((float)$homepage->villa->starting_price, 0, ',', '.')}} ₺</h6>
                                <p>GECELİK</p>
                                <span>BAŞLAYAN FİYATLARLA</span>
                            </div>
                        </div>
                        <div class="P_villas-info-link">
                            Detaylı İncele
                            <svg class="icon icon-right-arrow " data-original-title="" title="">
                                <use xlink:href="#icon-right-arrow"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="flex">
            <a href="{{url('/kiralik-villa')}}" class="buton mx-auto">
                Tümünü Görüntüle
            </a>
        </div>
    </section>

    @elseif(Agent::isMobile())

    <section class="A_p P_villas back_b mobile">
        <div class="Head flex-column a-i-c j-c-c">
            <h6>POPÜLER</h6>
            <h5>KİRALIK VİLLALAR</h5>
            <p></p>
        </div>
        <div class=" containerindex">
        <div class="swiper-container-pv mobile">
                <div class="swiper-wrapper">

                    @foreach($populars->homepage_villas as $homepage)
                        @php
                            $seo_url = isset($homepage->villa->seo->seo_url) ? $homepage->villa->seo->seo_url : '';
                           // $gecelikFiyat=App\Helpers\Helper::nPrice($homepage->villa->id);
                            @endphp
                        <div class="swiper-slide">
                            <div class="f_item">

                                <a href="{{ url($seo_url) }}" class="global_link"></a>
                                <div class="f_item-image">
                                    {!! view('ux.badge',['param'=>$homepage->villa->panel_villa->panel_tag])->render() !!}
                                    @php
                                        !empty($homepage->villa->list_image)?$resim="uploads/villa/gallery/".$homepage->villa->list_image."/".$homepage->villa->list_image_name:$resim=$homepage->villa->panel_villa->list_image;
                                    @endphp

                                    <img src="{{ImageProcess::getVillaImageByPath($resim)}}" class="w-100"
                                         alt="{{ $homepage->villa->name }}">

                                    <p class="f_item-kod flex-column">
                                        <span>{{ $website->prefix }}{{ $homepage->villa->code }}</span>{{ $homepage->villa->name }}
                                    </p>
                                </div>
                                <div class="f_item-info">

                   <span class="f_item-info-item">
                    <svg class="icon icon-point ">
                        <use xlink:href="#icon-point"></use>
                    </svg>
                       {{ isset($homepage->villa->area) ? $homepage->villa->area->name : 'Bölge Yok' }}
                </span>
                                    <span class="f_item-info-item">
                    <svg class="icon icon-user ">
                        <use xlink:href="#icon-user"></use>
                    </svg>
                                        {{ $homepage->villa->number_person }} Kişilik
                </span>
                                    <div class="P_villas-info-money">
                                        <svg class="icon icon-wallet ">
                                            <use xlink:href="#icon-wallet"></use>
                                        </svg>
                                        <div class="flex-column">
                                        <h6>{{number_format((float)$homepage->villa->starting_price, 0, ',', '.')}} ₺</h6> 
                                    <p>GECELİK</p>
                                    <span>BAŞLAYAN<br/> FİYATLARLA</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
                @endif

                <div class="swiper-pagination"></div>
            </div>
            <div class="flex mobile">
                <a href="{{url('/kiralik-villa')}}" class="buton mx-auto">
                    Tümünü Görüntüle 
                </a>
            </div>
        </div>
    </section>