<section  class="Banner Banner_md Banner-back"
         style="z-index: 999;background-image: url({{ isset($kiralik) ? Agent::isDesktop() ? ImageProcess::getImageByPath($kiralik->static_banner_image_pc ): ImageProcess::getImageByPath($kiralik->static_banner_image_mobile) : '' }});">

    <div class="container">
        <div class=" Banner_search-text   pos-ab-xy-center ">
            <h1 class="animated fadeInDown ">{{ isset($kiralik) ? $kiralik->static_banner_title : '' }}</h1>
            <p class="animated fadeInDown desktop flex-column ">
                <span>{{ isset($kiralik) ? $kiralik->static_banner_subtitle : '' }}</span>
                {{ isset($kiralik->static_banner_description) ? $kiralik->static_banner_description : '' }}
            </p>
        </div>
    </div>

    @if(Agent::isDesktop())
        @include('layouts.searchMenu')
    @endif
</section>

@if(Agent::isMobile())
    @include('layouts.searchMenuMobile')
@endif
