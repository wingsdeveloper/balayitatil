<!--
<section class="Banner Banner_md Banner-back " style="background-image:
@if(!empty($bolge->static_banner_image_pc))
url({{ Agent::isDesktop() ? ImageProcess::getImageByPath($bolge->static_banner_image_pc) : ImageProcess::getImageByPath($bolge->static_banner_image_mobile) }}"
@endif
>
    <div class="container">
        <div class=" Banner_search-text   pos-ab-xy-center ">
            <h1 class="animated fadeInDown">{{ !empty($bolge->static_banner_title) ? $bolge->static_banner_title : '' }}</h1>
            <p class="animated fadeInDown desktop flex-column">
               <span>{{ !empty($bolge->static_banner_subtitle ) ? $bolge->static_banner_subtitle : '' }}</span>
                {{ !empty($bolge->static_banner_description) ? $bolge->static_banner_description  :' '}}
            </p>
        </div>
    </div>
</section>
-->

<section class="Home-banner Home-banner-detail" style="background-image: url({{ asset('images/banner-detail.jpg') }});">
        <div class="container">
            <div class="Home-banner-in">
                <div class="Home-banner-text">
                    <div class="Home-banner-text-left">
                        <h1 class="animated fadeInDown  ">{{ !empty($bolge->static_banner_title) ? $bolge->static_banner_title : '' }}</h1>
                    </div>
                    <div class="Home-banner-text-right">

                    <p class="animated fadeInDown "><span>{{ !empty($bolge->static_banner_subtitle ) ? $bolge->static_banner_subtitle : '' }}</span>
                {{ !empty($bolge->static_banner_description) ? $bolge->static_banner_description  :' '}}</p>

                    </div>
                </div>

            </div>
        </div>
    </section>



