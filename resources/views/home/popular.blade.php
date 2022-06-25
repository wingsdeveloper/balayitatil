<section class="A_p P_villas back_b">

    <div class="Head flex-column a-i-c j-c-c">
        <h6>POPÜLER</h6>
        <h5>KİRALIK VİLLALAR</h5>
        <p>
            {{ isset($pop_content->content_description) ? $pop_content->content_description : '' }}
        </p>
    </div>

    <div class=" containerindex">
        @if(Agent::isDesktop())
            <div class="P_villas-in flex ">

                @foreach($populars->homepage_villas as $homepage)

                    @php
                        $seo_url = isset($homepage->villa->seo) ? $homepage->villa->seo->seo_url : '';

                     //   $gecelikFiyat=App\Helpers\Helper::nPrice($homepage->villa->id);
                    @endphp
                    <div class="P_villas-item item-2  flex">


                        <span class="P_villas-locasyon">
                            <svg class="icon icon-point">
                                <use xlink:href="#icon-point"></use>
                            </svg>
                            {{ isset($homepage->villa->area) ? $homepage->villa->area->name : 'Bölge Yok' }}
                        </span>
                        <div
                            class="P_villas-img "> {!! view('ux.badge',['param'=>$homepage->villa->panel_villa->panel_tag])->render() !!}
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
                                <span>Villa Kodu: {{ $website->prefix }}{{ $homepage->villa->code }}</span>
                                <p>{{ $homepage->villa->name }}</p>
                            </div>
                            <div class="P_villas-info-in">
                                <div class="info">
                                    <svg class="icon icon-bed">
                                        <use xlink:href="#icon-bed"></use>
                                    </svg>
                                    <span>{{ $homepage->villa->number_bedroom }} Yatak Odalı</span>
                                </div>
                                <div class="info">
                                    <svg class="icon icon-shower">
                                        <use xlink:href="#icon-shower"></use>
                                    </svg>
                                    <span>{{ $homepage->villa->number_bathroom }} Banyo</span>
                                </div>
                                <div class="info">
                                    <svg class="icon icon-user">
                                        <use xlink:href="#icon-user"></use>
                                    </svg>
                                    <span>{{ $homepage->villa->number_person }} Kişilik</span>
                                </div>

                            </div>
                            <div class="P_villas-info-money">
                                <svg class="icon icon-wallet ">
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
                                <svg class="icon icon-right-arrow ">
                                    <use xlink:href="#icon-right-arrow"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        @elseif(Agent::isMobile())
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
{{--                <script>--}}
{{--                    $(".f_item-like input").click(function () {--}}
{{--                        if ($(this).is(":checked")) {--}}
{{--                            $("#like1").modal();--}}

{{--                        }--}}
{{--                    });--}}
{{--                </script>--}}
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>

            <div class="flex">
                <a href="{{url('/kiralik-villa')}}" class="buton mx-auto">
                    Tümünü Görüntüle
                    <svg class="icon icon-right-arrow ">
                        <use xlink:href="#icon-right-arrow"></use>
                    </svg>
                </a>
            </div>

    </div>

    <!-- Modal -->
    <!--<div class="modal M_like fade" id="like1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header flex justify-content-between a-i-c">
                    <button class="M_like-shear">
                        <svg class="icon icon-heart2">
                            <use xlink:href="#icon-heart2"></use>
                        </svg>
                        <p>BEĞENDİĞİN <strong> VİLLARI SEÇ</strong></p>
                    </button>
                    <button class="M_like-shear">
                        <svg class="icon icon-shaer">
                            <use xlink:href="#icon-shaer"></use>
                        </svg>
                        <p>SEVDİKLERİNLE <strong> PAYLAŞ</strong></p>
                    </button>
                    <button class="M_like-shear">
                        <svg class="icon icon-sweet">
                            <use xlink:href="#icon-sweet"></use>
                        </svg>
                        <p>VİLLALAR ARASINDA <strong> KAYBOLMA!</strong></p>
                    </button>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg class="icon icon-like_close">
                            <use xlink:href="#icon-like_close"></use>x
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>-->
</section>
