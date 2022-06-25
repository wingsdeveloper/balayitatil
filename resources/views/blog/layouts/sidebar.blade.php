<div class="Blog-links desktop flex-column">
    <div class="Blog-links-item">
        <h5 class="Blog-links-head">BÖLGELER</h5>


        @forelse($areas as $area)
            @if($area->blog_categories->isNotEmpty())
                <div class="Blog-links-content">
                    <h6 class="Blog-links-content-header">{{ $area->name }}</h6>
                    <ul>
                        @forelse($area->blog_categories as $category)
                            @if($category->category_status == 1)
                                @if($category->blogs->isNotEmpty())
                                    {{--@php--}}
                                        {{--$seo = App\WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,'item_id' => $category->id,'pivot' => 'website_panel_blog_categories'])->first();--}}
                                        {{--$seo_url = isset($seo->seo_url) ? $seo->seo_url : 'no-link';--}}
                                    {{--@endphp--}}
                                    <li>
                                        @if(isset($category->seo) && !empty($category->seo))
                                        <a href="{{ route('blog.control',$category->seo->seo_url) }}">
                                            {{ $category->name }}
                                        </a>
                                        @else
                                            <a href="#">
                                                {{ $category->name }}
                                            </a>
                                        @endif
                                    </li>
                                @endif
                            @endif
                        @empty
                        @endforelse
                    </ul>
                </div>
            @endif
        @empty
        @endforelse

    </div>

    <div class="Blog-links-item">
    <h5 class="Blog-links-head">KATEGORİLER</h5>

        @if(count($generals) > 0)
    <div class="Blog-links-content">
    <h6 class="Blog-links-content-header">GENEL</h6>
    <ul>
        @forelse($generals as $general)
                @if($general->category_status == 1)
                    @if($general->blogs->isNotEmpty())

                        <li>
                            @if(isset($general->seo) && !empty($general->seo))
                                <a href="{{ route('blog.control',$general->seo->seo_url) }}">{{ $general->name }}</a>
                            @else
                                <a href="#">{{ $general->name }}</a>
                            @endif
                        </li>
                    @endif
                @endif
        @empty
        @endforelse
    </ul>

    </div>
            @endif


    </div>
</div>
