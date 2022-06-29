
<!-- background-image: url({{ Agent::isDesktop() ? ImageProcess::getImageByPath($home->banner_image_pc) : ImageProcess::getImageByPath($home->banner_image_mobile) }}); -->

<section class="Home-banner" style="background-image: url({{ asset('images/Home-banner.jpg') }});">
        <div class="container">
            <div class="Home-banner-in">
                <div class="Home-banner-text">
                    <div class="Home-banner-text-left">
                        <h1 class="animated animate__fadeInLeft "><span>{{ isset($home->banner_title) ? $home->banner_title : '' }}</span>{{ isset($home->banner_subtitle) ? $home->banner_subtitle : '' }}</h1>
                    </div>
                    <div class="Home-banner-text-right">
                        <p class="animated animate__fadeInRight ">{{ isset($home->banner_description) ? $home->banner_description : '' }}</p>
                    </div>
                </div>


                    @include('layouts.searchMenu')


                <div class="Home-banner-contact">
                    <div class="Home-banner-contact-social">
                        <a href="https://facebook.com/balayisepeticomtr"><i class="fa fa-facebook"></i></a>
                        <a href="https://instagram.com/balayisepeticomtr"><i class="fa fa-instagram"></i></a>
-                    </div>

                    <div class="Contact-support Contact-support-white">
                        <a href="">
                            <p><span>Yardım & Destek</span>+90 252 606 06 69</p>
                        </a>
                    </div>

                </div>
            </div>
        </div>
</section>

