<!--
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
-->

<div class="Navtop-discount" style="display: block">
        <div class="container">
            <div class="Navtop-discount-in">
                <p>Villa bahar’da <span>%20 indirim</span> kısa süreli</p>
                <button type="button" class="Navtop-discount-close"><i class="icon-navtop-close"></i></button>
            </div>
        </div>
    </div>

<header class="Navtop @if($view_name == "ekstra-index" || $view_name == "errors::404" || $view_name == "errors::500" || $view_name == "villa-notfound-index" || $view_name == "offer-offer" || $view_name == "static-index" || $view_name == "offer-getOffer" || $view_name == "offer-done"  ||  $view_name == "villa-reservation-index" ||  $view_name == "villa-reservation-kredikart_index" || $view_name == "villa-reservation-done"|| $view_name == "villa-reservation-error")
        Navtop-Relative
@elseif($view_name == "villa-detail-index")
        Navtop-ic
@elseif(($view_name == "villa-list-index") || $view_name == "home-index" || ($view_name == "villa-search-index") || ($view_name == "villa-search-index_new") || ($view_name == "villa-category-detail") || ($view_name == "area-detail-index"))
        Navtop-search
@elseif($view_name == "faq-index" || $view_name == "payment-error" || $view_name == "payment-success" || $view_name == "villa-reservation-prekvk" || $view_name == "villa-reservation-prereservationdone" || $view_name == "about-index" || $view_name == "contact-index")
        Navtop-backfixed
@endif">

    <div class="container">

        <nav class="navbar navbar-expand-lg">

            <a href="{{ url('/') }}" class="navbar-brand  ">
                    <svg width="229" height="63" viewBox="0 0 229 63" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.309 19.8028C12.1371 19.8028 10.1782 20.3564 8.51729 21.4211V10.3912H2.59777V40.6276H8.51729V39.4351C10.1782 40.4998 12.1371 41.0534 14.309 41.0534C17.1197 41.0534 19.5046 40.0314 21.4636 37.9872C23.4651 35.9005 24.4446 33.3879 24.4446 30.4068C24.4446 27.4684 23.4225 24.9558 21.4636 22.9116C19.462 20.8249 17.1197 19.8028 14.309 19.8028ZM13.3296 36.0708C11.2854 36.0708 9.66712 35.2617 8.51729 33.686V27.1702C9.70971 25.5945 11.328 24.828 13.3296 24.828C14.8201 24.828 16.0551 25.3816 17.0772 26.4889C18.0567 27.5535 18.6103 28.8737 18.6103 30.4068C18.6103 31.9399 18.0992 33.2601 17.0772 34.4099C16.0977 35.5172 14.8201 36.0708 13.3296 36.0708ZM48.0331 20.2287H42.1136V21.4211C40.4527 20.3564 38.4937 19.8028 36.3218 19.8028C33.5111 19.8028 31.1263 20.8249 29.1247 22.9116C27.1231 24.9558 26.1437 27.4684 26.1437 30.4494C26.1437 33.3879 27.1231 35.9005 29.1247 37.9872C31.1263 40.0314 33.5111 41.0534 36.3218 41.0534C38.4937 41.0534 40.4527 40.4998 42.1136 39.4351V40.6276H48.0331V20.2287ZM37.3013 36.0282C35.7682 36.0282 34.4906 35.4746 33.5111 34.4099C32.5316 33.3027 32.0206 31.9825 32.0206 30.4494C32.0206 28.8737 32.5316 27.5535 33.5111 26.4463C34.4906 25.339 35.7682 24.7854 37.3013 24.7854C39.3454 24.7854 40.9637 25.5945 42.1136 27.1702V33.686C40.9211 35.2617 39.3029 36.0282 37.3013 36.0282ZM57.568 10.3912H51.6485V40.6276H57.568V10.3912ZM82.0704 20.2287H76.1509V21.4211C74.49 20.3564 72.5311 19.8028 70.3592 19.8028C67.5484 19.8028 65.1636 20.8249 63.162 22.9116C61.1605 24.9558 60.181 27.4684 60.181 30.4494C60.181 33.3879 61.1605 35.9005 63.162 37.9872C65.1636 40.0314 67.5484 41.0534 70.3592 41.0534C72.5311 41.0534 74.49 40.4998 76.1509 39.4351V40.6276H82.0704V20.2287ZM71.3386 36.0282C69.8055 36.0282 68.5279 35.4746 67.5484 34.4099C66.569 33.3027 66.0579 31.9825 66.0579 30.4494C66.0579 28.8737 66.569 27.5535 67.5484 26.4463C68.5279 25.339 69.8055 24.7854 71.3386 24.7854C73.3828 24.7854 75.0011 25.5945 76.1509 27.1702V33.686C74.9585 35.2617 73.3402 36.0282 71.3386 36.0282ZM108.735 20.1861H102.517L96.5554 34.1118L89.9545 20.1861H83.6517L93.5743 41.1386L89.6138 50.4224H95.8314L108.735 20.1861ZM116.843 20.2287H110.923V40.6276H116.843V20.2287Z" fill="#D6385E"/>
                        <path d="M121.276 32.9307C121.489 35.6136 122.469 37.5726 124.257 38.8076C126.046 40.0426 128.261 40.6388 130.901 40.6388C136.352 40.6388 140.1 38.1688 140.1 33.7398C140.1 30.4606 138.055 28.4165 133.925 27.7351L130.22 27.1389C128.601 26.8834 127.792 26.202 127.792 25.2225C127.792 24.2004 128.899 23.4765 130.816 23.4765C132.903 23.4765 134.436 24.2856 134.563 26.0316L139.972 25.9891C139.759 23.2635 138.396 21.3046 136.48 20.3676C134.563 19.4307 132.817 19.0475 130.816 19.0475C125.535 19.0475 122 21.6452 122 25.7761C122 29.3108 124.47 31.2272 128.005 31.8234L132.349 32.5474C133.712 32.7603 134.393 33.3565 134.393 34.2508C134.393 35.3155 132.988 35.9969 130.944 35.9969C128.431 35.9969 126.983 34.9748 126.685 32.9732L121.276 32.9307ZM162.314 29.396C162.314 26.3723 161.335 23.9449 159.418 22.0285C157.502 20.1121 155.117 19.1752 152.221 19.1752C148.985 19.1752 146.344 20.1973 144.343 22.1989C142.341 24.2004 141.362 26.713 141.362 29.8218C141.362 32.8881 142.384 35.4433 144.385 37.4448C146.43 39.4464 149.07 40.4685 152.307 40.4685C157.119 40.4685 160.994 37.9559 162.059 34.0379H155.884C155.245 35.06 154.095 35.571 152.434 35.571C149.751 35.571 148.048 34.3786 147.324 31.9512H162.187C162.272 31.3975 162.314 30.5458 162.314 29.396ZM152.051 24.0301C154.478 24.0301 156.097 25.4354 156.437 27.8203H147.239C147.878 25.3077 149.496 24.0301 152.051 24.0301ZM203.784 29.396C203.784 26.3723 202.805 23.9449 200.888 22.0285C198.972 20.1121 196.587 19.1752 193.691 19.1752C190.455 19.1752 187.814 20.1973 185.813 22.1989C183.811 24.2004 182.832 26.713 182.832 29.8218C182.832 32.8881 183.854 35.4433 185.855 37.4448C187.899 39.4464 190.54 40.4685 193.776 40.4685C198.589 40.4685 202.464 37.9559 203.529 34.0379H197.354C196.715 35.06 195.565 35.571 193.904 35.571C191.221 35.571 189.518 34.3786 188.794 31.9512H203.656C203.742 31.3975 203.784 30.5458 203.784 29.396ZM193.521 24.0301C195.948 24.0301 197.567 25.4354 197.907 27.8203H188.709C189.347 25.3077 190.966 24.0301 193.521 24.0301Z" fill="#FFD9C3"/>
                        <path d="M164.373 19.8786V40.5063H169.499V35.2584H172.29C175.111 35.2584 177.326 34.5607 178.964 33.1653C180.602 31.7396 181.421 29.8285 181.421 27.432C181.421 25.0962 180.632 23.2761 179.055 21.9111C177.508 20.546 175.384 19.8786 172.685 19.8786H164.373ZM169.499 30.7689V24.3985H172.594C174.869 24.3985 176.325 25.5816 176.325 27.432C176.325 29.4645 174.869 30.7689 172.594 30.7689H169.499Z" fill="#FFD9C3"/>
                        <path d="M218.673 34.8744C217.313 35.1399 216.35 35.2727 215.819 35.2727C214.126 35.2727 213.296 34.4761 213.296 32.8498V28.2363H218.773V23.6228H213.296V18.1464H207.92V23.6228H204.767V28.2363H207.92V33.0157C207.92 35.1731 208.484 36.9322 209.679 38.2598C210.84 39.5543 212.434 40.2181 214.392 40.2181C215.952 40.2181 217.578 39.9525 219.271 39.4215L218.673 34.8744Z" fill="#FFD9C3"/>
                        <path d="M227.439 23L224.72 23.7323L222 23V39.7365H227.439V23Z" fill="#FFD9C3"/>
                        <path d="M188.779 62.1566L169.467 52.6172C166.969 51.3781 164.217 50.7332 161.427 50.7333L122.804 50.7333V44.7712L161.427 44.7712C165.129 44.735 168.789 45.5511 172.123 47.156L191.435 56.6953L188.779 62.1566Z" fill="#D6385E"/>
                        <path d="M228.371 14.1236C227.532 13.2671 226.172 13.2671 225.333 14.1236L224.647 14.8236L223.961 14.1236C223.122 13.2671 221.762 13.2671 220.923 14.1236C220.084 14.9801 220.084 16.3687 220.923 17.225L221.609 17.9249L224.647 21.0266L227.685 17.9249L228.371 17.225C229.21 16.3687 229.21 14.9801 228.371 14.1236Z" fill="#D6385E"/>
                    </svg>
                </a>

            <div class="  navbar-collapse navbar-collapse-menu " id="ac">
              
                <ul class="navbar-nav  ml-auto">
                    @forelse($pages as $page)
                        @php
                            $placement=json_decode($page->placements);
                        @endphp

                        @if(isset($placement))
                            @if($placement->header == 1)
                            <li class="nav-item">
                                <a href="{{ url($page->seo->seo_url) }}" class="nav-link {{ Request::segment(1) == $page->seo->seo_url ? 'active' : '' }}">{{ $page->page_name }}</a>
                            </li>
                            @endif
                        @endif
                    @empty
                        Herhangi bir sayfa eklenmedi henüz.
                    @endforelse
                    <li class="nav-item nav-item-search">
                            <label for="">
                                <svg class="icon icon-search" data-original-title="" title="">
                                    <use xlink:href="#icon-search"></use>
                                </svg>
                                <input type="button" id="searchfocus" class="Navtop-top-search-buton">
                                <input type="text" id="searchinput" autocomplete="off" placeholder="Villa Ara">
                            </label>
                            <div id="villaListele" style="display: none;"></div>
                        </li>
                </ul>
            </div>

            @if(Agent::isMobile())
                <div class="Mobil_menu mobile-f">
                    
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
