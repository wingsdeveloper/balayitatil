<section class="Banner Banner_md Banner-back"
         style="background-image: url({{Agent::isDesktop() ? ImageProcess::getImageByPath( $opp->static_banner_image_pc) : ImageProcess::getImageByPath($opp->static_banner_image_mobile) }});">
    <div class="container">
        <div class=" Banner_search-text   pos-ab-xy-center ">
            @if(!empty($req->gece) && !empty($req->ay))
                <h1 class="animated fadeInDown ">{{$aylar[$req->ay]}}</h1>
                <p class="animated fadeInDown desktop flex-column ">
                    <span><b>{{$req->gece}}</b> GECELİK FIRSATLAR</span>
                </p>
            @else
                <h1 class="animated fadeInDown ">{{ $opp->static_banner_title }}</h1>

                <p class="animated fadeInDown desktop flex-column ">
                    <span>{{ $opp->static_banner_subtitle }}</span>
                    {{ $opp->static_banner_description }}
                </p>

            @endif

        </div>
    </div>
</section>
