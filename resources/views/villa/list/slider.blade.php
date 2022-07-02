<!-- background-image: url({{ isset($kiralik) ? Agent::isDesktop() ? ImageProcess::getImageByPath($kiralik->static_banner_image_pc ): ImageProcess::getImageByPath($kiralik->static_banner_image_mobile) : '' }});-->

<section class="Home-banner Home-banner-detail" style="background-image: url({{ asset('images/banner-detail.jpg') }});">
        <div class="container">
            <div class="Home-banner-in">
                <div class="Home-banner-text">
                    <div class="Home-banner-text-left">
                        <h1 class="animated fadeInDown">{{ isset($kiralik) ? $kiralik->static_banner_title : '' }}</h1>
                    </div>
                    <div class="Home-banner-text-right">

                        <p class="animated fadeInDown">
                        <span>{{ isset($kiralik) ? $kiralik->static_banner_subtitle : '' }}</span>
                        {{ isset($kiralik->static_banner_description) ? $kiralik->static_banner_description : '' }}
                        </p>

                    </div>
                </div>

                @include('layouts.searchMenu')

                <div class="Home-banner-contact">
                    <div class="Home-banner-contact-social">
                        <a href=""><i class="fa fa-facebook"></i></a>
                        <a href=""><i class="fa fa-instagram"></i></a>
                        <a href=""><i class="fa fa-twitter"></i></a>
                    </div>

                    <div class="Contact-support Contact-support-white">
                        <a href="">
                            <p><span>Yardım & Destek</span>+90 252 606 0 876</p>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @if($view_name == "villa-search-index")
        
            @include('layouts.homeInfo') 
            
    @endif