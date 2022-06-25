@if(count($villas) || count($areas) || count($categories))

    @if(count($villas))
        <div style="margin-bottom: 15px;">
            <h6 class="">Villalar</h6>
            <hr style="margin-top: 0!important; margin-bottom: 0!important">
            <div style="max-height: 250px; overflow-y: scroll">
                @foreach($villas as $villa)
                    <div style="display: flex; justify-content: space-between;align-items: center;">
                        <img height="30" src="{{ ImageProcess::getVillaImageByPath($villa[resim])}}"
                             alt="{{ $villa['name'] }}">
                        <a style="width: 100%" href="/{{ $villa['seo'] }}" class="Navtop-search-menu-link">
                            <p>{{ $villa['name'] }}<span>({{ $villa['code'] }})</span></p>
                            {{--<i class="icon-right_short"></i>--}}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif



    @if(!empty($villas))

        @if(!empty($areas))

            <h6 class="">Bölgeler</h6>
            <hr style="margin-top: 0!important; margin-bottom: 0!important">

            <div style="margin-bottom: 15px;">
                @foreach($areas as $area)
                    <div style="display: flex; justify-content: space-between;align-items: center;margin-bottom: 15px;">

                        <img height="30"
                             src="{{ ImageProcess::getImageByPath($area->websitePanelAreaContent->list_image_thumb) }}"
                             alt="{{ $villa['name'] }}">

                        <a style="width: 100%" href="{{ route('static', [$area->seo->seo_url]) }}"
                           class="Navtop-search-menu-link">
                            <p>{{ $area->name }}</p>
                            {{--<i class="icon-right_short"></i>--}}
                        </a>
                    </div>
                @endforeach
            </div>
        @else
        @endif
    @else
        @if(!empty($areas))

            <h6 class="">Bölgeler</h6>
            <hr style="margin-top: 0!important; margin-bottom: 0!important">

            <div style="margin-bottom: 15px;">
                @foreach($areas as $area)
                    <div style="display: flex; justify-content: space-between;align-items: center;margin-bottom: 15px;">

                        <img height="30"
                             src="{{ ImageProcess::getImageByPath($area->websitePanelAreaContent->list_image_thumb) }}"
                             alt="{{ $villa['name'] }}">

                        <a style="width: 100%" href="{{ route('static', [$area->seo->seo_url]) }}"
                           class="Navtop-search-menu-link">
                            <p>{{ $area->name }}</p>
                            {{--<i class="icon-right_short"></i>--}}
                        </a>
                    </div>
                @endforeach
            </div>
        @else
        @endif
    @endif


    @if(count($categories))

        <h6 class="">Villa Seçenekleri</h6>
        <hr style="margin-top: 0!important; margin-bottom: 0!important">

        <div style="margin-bottom: 15px;">
            @foreach($categories as $category)
                <div style="display: flex; justify-content: space-between;align-items: center;">
                    <img height="30" src="{{ ImageProcess::getImageByPath($category->list_image) }}"
                         alt="{{ $category }}">

                    <a style="width: 100%"
                       href="{{ route('category.detail', ['villa-secenekleri', $category->panel_seo->seo_url]) }}"
                       class="Navtop-search-menu-link">
                        <p>{{ $category->name }}</p>
                        {{--<i class="icon-right_short"></i>--}}
                    </a>
                </div>
            @endforeach
        </div>

    @else
    @endif



@else
    <p>Sonuç Bulunamadı..</p>
@endif
