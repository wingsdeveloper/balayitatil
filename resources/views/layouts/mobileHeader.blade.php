<div class="overlay">
    <div class="wra">
        @php
            $category_prefix = App\WebsitePage::where(['website_id' => 15/*APP_WEBSITE_ID*/,'page_type' => 'kategori_liste'])->first();
        @endphp
        @if(!empty($category_prefix))
            <ul class="wra-nav" style="padding: 0;height: calc(93vh - 40px)">
{{--                <li>--}}
{{--                    <a href="https://www.lycianescapes.com"--}}
{{--                       class="nav-link">--}}
{{--                        <img height="40" src="{{ asset('images/uk-flag-mobile.png') }}" alt="">--}}
{{--                    </a>--}}
{{--                </li>--}}
                @forelse($pages as $page)
                    @php
                        $placement=json_decode($page->placements);

                    @endphp
                    @if(isset($placement))
                        @if($placement->header == 1)
                            @if($page->page_type == 'kategori_liste')
                                <li>
                                    <a id="secenek" data-toggle="collapse"> {{ $page->page_name }}
                                    <!--<svg class="icon icon-angle-down">
                                    <use xlink:href="#icon-angle-down"></use>
                                </svg>-->
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{(isset($page->seo))?url($page->seo->seo_url):'#'}}"
                                       class="nav-link"> {{ $page->page_name }}</a>
                                </li>
                            @endif
                        @endif
                    @endif
                @empty
                    Herhangi bir sayfa eklenmedi henüz.
                @endforelse
                <li class="nav-item" style="margin-top: 0px;position: absolute;width: 100%;bottom: 135px;">
                    <a href="{{url('/villa-secenekleri/populer-villalar')}}"
                       class="nav-link red-button" style="background-color: #eb4034; padding: 20px"> POPÜLER VİLLALAR   </a>
                </li>
                <ul class="overlay-bottom" style="padding-bottom: 75px!important">
                    <li class="nav-item" style="border-radius: 5px;">
                        <a href="{{ url('/yaklasan-firsatlar') }}" class=" buton_orange mx-auto"
                           style="width: auto !important;border-radius: 8px;margin: 0 6px !important;padding: 15px !important;font-size: .8em;">
                            Yaklaşan Fırsatlar
                        </a>
                    </li>
                    {{--<li>--}}
                    {{--<a href="">--}}
                    {{--<svg class="icon icon-person"><use xlink:href="#icon-person"></use></svg>--}}
                    {{--Müşteri Girişi--}}
                    {{--</a>--}}
                    {{--</li>--}}

                    <li>
                        <a onclick="gtag('event', 'whatsapp', {'event_category' : 'click'});" href="https://api.whatsapp.com/send?phone={{ isset($general->whatsapp_number) ? $general->whatsapp_number : '' }}&"
                           target="_blank" class="overlay-bottom-iletisim">
                            <p><span>Whatapp ile </span> İLETİŞİME GEÇ</p>
                            <svg class="icon icon-whatsapp">
                                <use xlink:href="#icon-whatsapp"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </ul>
        @endif
        @php
            $website = \App\Website::with(['categories'])->where('id', 2/*APP_WEBSITE_ID*/)->first();

        @endphp

        <div class=" vsecenek " id="v">
            <button class="vsecenek-geri">
                <svg class="icon icon-right-arrow">
                    <use xlink:href="#icon-right-arrow"></use>
                </svg>
                Geri
            </button>
            @if(!empty($category_prefix))
                <ul class="wra-nav-in">
                    @forelse($website->categories as $cat)
                        @php
                            $seo = App\WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,'item_id' => $cat->id,'pivot' => 'website_panel_categories'])->first();
                        @endphp
                        <li>
                            <a href="@if(isset($seo)){{ route('category.detail',[$category_prefix->seo->seo_url,$seo->seo_url]) }}@else # @endif">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @empty
                    @endforelse
                </ul>
            @endif
        </div>

    </div>

</div>
