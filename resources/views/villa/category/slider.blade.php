<section  class="Banner Banner_md Banner-back " style="background-image: url(
@if($view_name == "villa-category-index")
        {{ Agent::isDesktop() ? ImageProcess::getImageByPath($secenek->static_banner_image_pc) :ImageProcess::getImageByPath($secenek->static_banner_image_mobile)}}
@else
    {{ImageProcess::getImageByPath(Agent::isDesktop() ?$website->categories[0]->image:$website->categories[0]->image_mobile)}}
@endif
    )" >

    <div class="container">
        <div class=" Banner-v_secenek-text   pos-ab-xy-center ">
            <h6 class="animated fadeInDown ">
                @if($view_name == "villa-category-index")
                    {{ $secenek->static_banner_title }}
                @endif
            </h6>
            <h1 class="animated fadeInDown ">
                @if($view_name == "villa-category-index")
                    {{ $secenek->static_banner_subtitle }}
                @else
                    {{$website->categories[0]->name}}
                @endif
            </h1>
            @if($view_name == "villa-category-index")
                <p>
                    {{ $secenek->static_banner_description }}
                </p>
            @endif
        </div>
    </div>

        @if(Agent::isDesktop())
    @if($view_name == "villa-category-detail")
    @include('layouts.searchMenu')
        @endif
        @endif
</section>

        @if(Agent::isMobile())
@if($view_name == "villa-category-detail")
@include('layouts.searchMenuMobile')
@endif
@endif

