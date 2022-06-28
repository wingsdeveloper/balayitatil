<footer class="Navbottom">

    <div class="Navbottom-top">
        <div class="containerindex">
            <div class="Navbottom-top-in">
                <a href="" class="footer-logo">
                    <svg class="" data-original-title="" title="">
                        <use xlink:href="#logo_bt_w"></use>
                    </svg>
                </a>
                <div class="Navbottom-top-text">
                    @php
<<<<<<< HEAD
                        $defaultContact = \App\Website::with(['contacts' => function($q){
=======
                        $defaultContact = App\Website::with(['contacts' => function($q){
>>>>>>> 3a4ae6ca4df3ec61d8cc23a47e5fb4d5474923d1
                            $q->orderBy('id','ASC');
                            $q->first();
                        }])->where('id',15/*APP_WEBSITE_ID*/)->select('id')->firstOrFail();
                        $defaultContact = $defaultContact->contacts[0];
                    @endphp
                    <div class="Navbottom-top-text-item">
                        <span>Adres</span>
                        <p>MERKEZ : {{ $defaultContact->address }}</p>
                        <a href="" class="konum-al">Adrese Konum Al</a>
                    </div>
                    <div class="Navbottom-top-text-item">
                        <span>Çağrı Merkezi</span>
                        <a href="tel:{{ $defaultContact->phone }}" class="cagri-telefon">{{ $defaultContact->phone }}</a>
                    </div>
                    <div class="Navbottom-top-text-item">
                        <span>E-Posta</span>
                        <a href="mailto:{{ $defaultContact->email }}" class="footer-mail">{{ $defaultContact->email }}</a>
                    </div>
                </div>
                <div class="Navbottom-top-social">
                    <h6>Temasta Kal</h6>
                    <div class="Navbottom-top-social-links">
                        @if(!empty($general->facebook ))
                            <a href="{{ $general->facebook }}"><i class="fa fa-facebook-official"></i></a>
                        @endif
                        @if(!empty($general->instagram ))
                        <a href="{{ $general->instagram }}"><i class="fa fa-instagram"></i></a>
                        @endif
                        @if(!empty($general->twitter ))
                        <a href="{{ $general->twitter }}"><i class="fa fa-twitter"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="Navbottom-menu">
    <div class="container">
        <div class="Navbottom-menu-in ">

        @if(Agent::isDesktop() || ($view_name != "villa-reservation-index" && $view_name != "villa-reservation-done" && $view_name != "villa-reservation-done"))
    
            <div class="Navbottom-menu-left">
                <div class="Navbottom-menu-left-head">
                    <svg class="" data-original-title="" title="">
                        <use xlink:href="#icon-ayin-villasi"></use>
                    </svg>
                    <h4>Ayın Villası</h4>
                </div>
                @if(!empty($month))
                        @php
                            #$seo = App\WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,'item_id' => $month->id,'pivot' => 'website_panel_villas'])->first();
                            $seo = $footerData['seo'];
                            $seo_url = isset($seo->seo_url) ? $seo->seo_url : '';
                            $gecelikFiyat=App\Helpers\Helper::nPrice($homepage->villa->id);
                        @endphp

                <div class="Ayin-villasi">
                    <a href="{{ url($seo->seo_url) }}">
                        <div class="Ayin-villasi-img">
                            <img src="{{ ImageProcess::getImageByPath('uploads/villa/gallery/' . $month->list_image . '/' . $month->list_image_name) }}" alt="">
                            <h4 class="Ayin-villasi-title">{{ $month->name }}</h4>
                        </div>
                        <div class="Ayin-villasi-text">
                            <div class="Ayin-villasi-text-info">
                                <div class="Ayin-villasi-text-info-item">
                                    <svg class="icon icon-bed" data-original-title="" title="">
                                        <use xlink:href="#icon-bed"></use>
                                    </svg>
                                    <span>{{ $month->number_bedroom }} Yatak Odalı</span>
                                </div>
                                <div class="Ayin-villasi-text-info-item">
                                    <svg class="icon icon-point " data-original-title="" title="">
                                        <use xlink:href="#icon-point"></use>
                                    </svg>
                                    <span>{{ $month->area->name }}</span>
                                </div>
                                <div class="Ayin-villasi-text-info-item">
                                    <svg class="icon icon-user " data-original-title="" title="">
                                        <use xlink:href="#icon-user"></use>
                                    </svg>
                                    <span>{{ $month->number_person }} Kişi</span>
                                </div>
                            </div>
                            <p><b>{{number_format((float)$month->starting_price, 0, ',', '.')}} ₺</b>GECELİK<span>BAŞLAYAN FİYATLAR</span></p>
                        </div>
                    </a>
                </div>
                @elseif(empty($month))
                        Ayın villası seçilmedi
                    @endif
            </div>

            @endif

            <div class="Navbottom-menu-right">
                <div class="Navbottom-menu-right-head">
                    <h3>En özel anlarınız</h3>
                    <h4>en unutulmaz tatil deneyimi ile geçirin.</h4>
                </div>

                <div class="Navbottom-menu-list">
                    <div class="Navbottom-menu-list-item">
                        <h5>Balayi Sepeti</h5>
                        @forelse($pages as $page)
                                @php
                                    $placement=json_decode($page->placements);
                                    $page_name=App\Helpers\Helper::ali_ucwords($page->page_name);
                                   // $page_name=ucwords($page_name);
                                @endphp
                                @if(isset($placement))
                                    @if($placement->footer == 1)
                                            <a href="{{ url('')}}/{{ $page->link}}">
                                                {{ $page_name }}
                                            </a>
                                    @endif
                                @endif
                            @empty
                                Herhangi bir sayfa eklenmedi henüz.
                        @endforelse
                    </div>
                    <div class="Navbottom-menu-list-item">
                        <h5>Villa Seçenekleri</h5>

                            @php
                                $category_prefix = $footerData['category_prefix'];
                            @endphp

                            @foreach($villa_secenekleri_footer->categories as $catkey=>$category)
                                @php
                                    #$website = App\Website::with('categories')->where('id', 4)->first();
                                    $seo = $category->panel_seo;
                                    $category_name=App\Helpers\Helper::ali_ucwords($category->name);
                                @endphp
                        
                                    <a  href="@if(isset($seo)){{ route('category.detail',[$category_prefix->seo->seo_url,$seo->seo_url]) }}@else # @endif">
                                        {{$category_name}}
                                    </a>
                                
                            @endforeach

                    </div>
                    <div class="Navbottom-menu-list-item Navbottom-menu-list-item-links ">
                        <h5>Balayı Sepeti</h5>
                        <a href="{{ url('/hakkimizda') }}">Hakkımızda</a>
                        <a href="{{ url('/iletisim') }}">Bize Ulaşın</a>
                        <div class="Navbottom-menu-list-item-logo">
                            <a href="https://etbis.eticaret.gov.tr/sitedogrulama/6017645271083507" target="_blank" class="Etbis">
                                <img src="{{ asset('images/etbis.png') }}" alt="">
                            </a>
                            <a href="https://www.tursab.org.tr/tr/ddsv" target="_blank" class="Tursab">
                                <img src="{{ asset('images/tursab.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <img class="Navbottom-menu-back" src="{{ asset('images/footer-back.svg') }}" alt="">
        <img class="Navbottom-menu-back-m" src="{{ asset('images/footer-back-mobile.svg') }}" alt="">
    </div>
</div>

<div class="Navbottom-banks ">
    <div class="container containerindex">
        <div class="Navbottom-banks-in">
            <img src="{{ asset('images/banks.svg') }}" alt="Çalıştığımız Bankalar" class="bank">
            <img src="{{ asset('images/banks-mobile.svg') }}" alt="Çalıştığımız Bankalar" class="bank-m">
            <img src="i{{ asset('images/guvenli-odeme.svg') }}" alt="Güvenli Ödeme" class="guvenli-odeme">
        </div>
    </div>
</div>
<div class="Navbottom-copy">
    <div class=" container containerindex ">
        <div class="Navbottom-copy-in">
            <div class="Navbottom-copy-left">
                <p>Copyright © {{ date('Y') }} Tüm Hakları Saklıdır.</p>

                @forelse($pages as $page)
                    @php
                        $placement=json_decode($page->placements);
                        $page_name=App\Helpers\Helper::ali_ucwords($page->page_name);

                       // $page_name=ucwords($page_name);
                    @endphp
                    @if(isset($placement))
                        @if($placement->alt_menu == 1)
                            <a href="{{ url('')}}/{{ $page->seo->seo_url}}">
                                {{ $page_name }}
                            </a>
                        @endif
                    @endif
                @empty

                @endforelse
            </div>
            <div class="Navbottom-copy-right">
                <p>Balayı Villası bir <a href="https://wings.com.tr/" target="_blank">Wings</a> iştirakidir.</p>
            </div>
        </div>
    </div>
</div>
 
</footer>


<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
            PhotoSwipe keeps only 3 of them in the DOM to save memory.
            Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Kapat (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Paylaş"></button>

                <button class="pswp__button pswp__button--fs" title="Tam Ekran Yap"></button>

                <button class="pswp__button pswp__button--zoom" title="Yakınlaştır/Uzaklaştır"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Geri (sol ok)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="İleri (sağ ok)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>
