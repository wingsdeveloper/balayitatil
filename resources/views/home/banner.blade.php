<section  class="Banner Banner_lg Banner-back"
style="background-image: url({{ Agent::isDesktop() ? ImageProcess::getImageByPath($home->banner_image_pc) : ImageProcess::getImageByPath($home->banner_image_mobile) }});">

<div class="container">
    <div class=" Banner_search-text   pos-ab-xy-center ">
        <h1 class="animated fadeInDown ">KİRALIK VİLLA</h1>
        <h2 class="animated fadeInDown ">{{ isset($home->banner_title) ? $home->banner_title : '' }}</h2>
        <p class="animated fadeInDown desktop flex-column "><span>{{ isset($home->banner_subtitle) ? $home->banner_subtitle : '' }}</span>
         {{ isset($home->banner_description) ? $home->banner_description : '' }}
     </p>
 </div>
</div>
@if(Agent::isDesktop())
@include('layouts.searchMenu')
@endif
</section>
@if(Agent::isMobile() || Agent::isTablet())
@include('layouts.searchMenuMobile')
@endif
