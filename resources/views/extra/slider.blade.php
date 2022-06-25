<section  class="Banner Banner_md Banner-back "
          style="background-image:
                  url(
                  @if(Agent::isDesktop())
                    {{ImageProcess::getImageByPath( $extra->banner_image_pc) }}
                  @else
                    {{ImageProcess::getImageByPath( $extra->banner_image_mobile) }}
                  @endif
                   )" >
    <div class="container">
        <div class=" Banner_search-text  pos-ab-xy-center ">
            <h1 class="animated fadeInDown ">{{ isset($extra->banner_title) ? $extra->banner_title : '' }}</h1>
            <p class="animated fadeInDown desktop flex-column">
                <span>{{ isset($extra->banner_subtitle) ? $extra->banner_subtitle : '' }}</span>
                {{ isset($extra->banner_description) ? $extra->banner_description : '' }}
            </p>
        </div>
    </div>
</section>
