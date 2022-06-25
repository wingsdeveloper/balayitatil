<header class="Navtop
@if($view_name == "ekstra-index" || $view_name == "errors::404" || $view_name == "errors::500" || $view_name == "villa-notfound-index" || $view_name == "offer-offer" || $view_name == "static-index" || $view_name == "offer-getOffer" || $view_name == "offer-done"  ||  $view_name == "villa-reservation-index" ||  $view_name == "villa-reservation-kredikart_index" || $view_name == "villa-reservation-done"|| $view_name == "villa-reservation-error")
        Navtop-Relative
@elseif($view_name == "villa-detail-index")
        Navtop-detay
@elseif(($view_name == "villa-list-index") || $view_name == "home-index" || ($view_name == "villa-search-index") || ($view_name == "villa-search-index_new") || ($view_name == "villa-category-detail") || ($view_name == "area-detail-index"))
        Navtop-search
@elseif($view_name == "faq-index" || $view_name == "payment-error" || $view_name == "payment-success" || $view_name == "villa-reservation-prekvk" || $view_name == "villa-reservation-prereservationdone" || $view_name == "about-index" || $view_name == "contact-index")
        Navtop-backfixed
@endif
        ">

    <div class="container ">
        <nav class="navbar navbar-expand-lg">

            <a href="{{ url('/') }}" class="navbar-brand  ">
                <svg class="icon navbar-brand-logo ">
                    <use xlink:href="#logo_vk_w"></use>
                </svg>
            </a>

            <div class="  navbar-collapse navbar-collapse-menu  " id="ac">
                <div class="Navtop-top flex a-i-c ml-auto">
                    <!-- <div class="Navtop-top-login">
                         <a href="" class="global_link"></a>
                         <svg class="icon icon-user"><use xlink:href="#icon-person"></use></svg>
                         Müşteri Girişi
                     </div>
                 -->
                    {{--<div class="Navtop-top-favoriler">--}}
                    {{--<a href="" class="global_link"></a>--}}
                    {{--<span class="Navtop-top-favoriler-badge">12</span><svg class="icon icon-heart"><use xlink:href="#icon-heart"></use></svg>--}}
                    {{--Favorilerim--}}
                    {{--</div>--}}
                    @if(Agent::isDesktop())
                    <!--    
                    <a href="{{ url('/villa-secenekleri/2022-villa-tatili') }}" class="buton_orange mx-auto"
                           style="-webkit-border-radius: unset;-moz-border-radius: unset;border-radius: unset;width: auto!important;height:auto!important;padding: 5.4px 10px;background-color: #102754;;font-weight: normal;font-size:11px;margin-right: 3px!important;">
                            2022 Villaları
                        </a>-->
                        <a href="{{ url('/villa-secenekleri/populer-villalar') }}" class="buton_orange mx-auto"
                           style="-webkit-border-radius: unset;-moz-border-radius: unset;border-radius: unset;width: auto!important;height:auto!important;padding: 5px 10px;background-color: #eb4034;;font-weight: normal;font-size:11px;margin-right: 3px!important;">
                           Popüler Villalar
                        </a>
                        <a href="{{ url('/yaklasan-firsatlar') }}" class="buton_orange mx-auto"
                           style="-webkit-border-radius: unset;-moz-border-radius: unset;border-radius: unset;width: auto!important;height:auto!important;padding: 5px 10px;background: rgba(245,132,31,1);font-weight: normal;font-size:11px;">
                            Yaklaşan Fırsatlar
                        </a>
                        <div class="Navtop-top-search" style="display: flex; justify-content: space-around;margin-left: 8px">

                            <a href="https://www.lycianescapes.com" class="" style="min-width: 45px;">
                                <img height="30" src="{{ asset('images/uk-flag-desktop.png') }}" alt="" >
                            </a>

                            <input type="text" id="searchinput" class="form-control" autocomplete="off"
                                   placeholder="Villa Ara">
                            <svg class="icon icon-search">
                                <use xlink:href="#icon-search"></use>
                            </svg>
                            <input type="button" id="searchfocus" class="Navtop-top-search-buton">
                        </div>
                        <div id="villaListele"></div>
                    @endif
                </div>
                <ul class="navbar-nav  ml-auto">
                    @forelse($pages as $page)
                        @php
                            $placement=json_decode($page->placements);
                        @endphp

                        @if(isset($placement))
                            @if($placement->header == 1)
                                <li class="nav-item">
                                    <a href="{{ url($page->seo->seo_url) }}"
                                       class="nav-link {{ Request::segment(1) == $page->seo->seo_url ? 'active' : '' }}">
                                        {{ $page->page_name }}
                                    </a>
                                </li>
                            @endif
                        @endif
                    @empty
                        Herhangi bir sayfa eklenmedi henüz.
                    @endforelse
                </ul>
            </div>

            @if(Agent::isMobile())
                <div class="Mobil_menu mobile-f">
                    <a href="https://www.lycianescapes.com"
                       class="nav-link" style="padding-top: .2rem!important;margin-top: .1rem!important;padding-right: 12px!important;">
                        <img height="25" src="{{ asset('images/uk-flag-mobile.png') }}" alt="" >
                    </a>
                    <div class="Search-icon">
                        <svg class="icon icon-search" id="searchfocus">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                        <svg class="icon icon-close" onclick="searchClose();">
                            <use xlink:href="#icon-close"></use>
                        </svg>
                    </div>

                    <div class="btn-menu btn-menu-open" >
                        <a class="" href="#"></a>
                        <svg class="icon icon-menu" style="width: 30px; height: 30px">
                            <use xlink:href="#icon-menu"></use>
                        </svg>
                        <svg class="icon icon-close" style="width: 30px; height: 30px">
                            <use xlink:href="#icon-close"></use>
                        </svg>
                    </div>
                </div>
            @endif
        </nav>

        @if(Agent::isMobile())
            <div class="Search-menu">
                <!-- <form action="">-->
                <div class="Search-menu-in flex a-i-c">
                    <input type="text" id="searchinput" autocomplete="off" placeholder="Aramaya Başla">
                    <!-- <button>ARA</button>-->
                </div>
                <!--  </form>-->
            </div>
        @endif
    </div>
</header>
@if(Agent::isMobile())
    <div id="villaListele"></div>
@endif
