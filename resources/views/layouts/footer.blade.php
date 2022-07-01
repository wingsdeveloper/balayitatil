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

                        $defaultContact = \App\Website::with(['contacts' => function($q){


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
                   
                            <a href="https://facebook.com/balayisepeticomtr"><i class="fa fa-facebook-official"></i></a>
               
            
                        <a href="https://instagram.com/balayisepeticomtr"><i class="fa fa-instagram"></i></a>
              
                 
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
<!--
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
                    -->
                    </div>
                    <div class="Navbottom-menu-list-item Navbottom-menu-list-item-links ">
                        <h5>Balayı Sepeti</h5>
                        <a href="{{ url('/hakkimizda') }}">Hakkımızda</a>
                        <a href="{{ url('/iletisim') }}">Bize Ulaşın</a>
                        <div class="Navbottom-menu-list-item-logo">
                            <a href="https://etbis.eticaret.gov.tr/sitedogrulama/6017645271084452" target="_blank" class="Etbis">
                                <img src="data:image/jpeg;base64, iVBORw0KGgoAAAANSUhEUgAAAIIAAACWCAYAAAASRFBwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAEYMSURBVHhe7Z0HnF5F9f4l1BCSUASkgyBNQCH0jqAggiAt0lsQBESa9A4CCgpKBwHpKJ3QDAgESNtsTTY9kN7bpleY//nevc+b896dt+xmA/r393w+D2Fn7sy979wzM+ecOTP3W4bQGvzb3/4Wsnj66aej18ZYX1+flOnevXuTvA4dOoQpU6Yk+aVw++2358r169cvSfv000/z6oPt27cPkyZNSvJj+OKLL8JKK63UpFxtbW2S36NHj1za/fffn6QVwhFHHJFct9lmm4VFixalqUvxwx/+MMnfY4890pSlmDt3bthwww2T/OOOOy5NDeHnP/957v7LyFeMCWKZzWZMEB577LHotTHW1dUlZT744INo/uLFi5P8UrjjjjtyZWpqapK0mCDACRMmJPkxlBIEL7B33313klYIEoQtttgiTcnHVlttleTvsMMOaUo+Nt544yT/axGELbfcMpx66qnN4o9//ONchTFB+Oyzz5qUOfroo3Nldtppp1z62LFjkzKDBw/Oux6eeeaZ4fHHH09GmFK8+eabc+VGjx6d1OkFgV5H3jnnnBNmzpyZ5I8YMSJXXs9RShCGDh2au8/777+fpCGsL730UlIPgiJIEL797W+HJ598Mncv8fzzz0/qufDCC5vk0a5rrbVWUj4mCO3atQsnn3xy7lnK4UknnRRWX311/aZ8QfjVr36V3qJ8VFZWqrKoIMQwefLksMIKKyRl6L3lIvZSYrzqqqvSEkvhBeGZZ55JU5eCBlf+66+/nqQhHCuuuGIuXZQgxDBnzpyw6qqrJtf99Kc/TVOXCkIhDhs2LLmuf//+0XwxJgibb755mtI8bLLJJqo3XxBOP/309JLy8eGHH6qysgWBniRBuO2229LU4qDn0pt0r2K88cYb01JLUVFRkctnusri5ZdfzuWrd0+cODGX5llVVZXkF8IGG2yQXHfiiSemKSFvFIyRURAgZLF8MSYIm266aVi4cGGaWh7mz58fNtpoI9VbWBCuvPLKcOihhxakhtyYINAreOBsGTWgFwSmI+WPHDkyyY/BC8KPfvSj8N577+Xx73//e2jTpk2S/93vfjfv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" alt="">
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
            <img src="{{ asset('images/guvenli-odeme.svg') }}" alt="Güvenli Ödeme" class="guvenli-odeme">
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
                <p>Balayı Sepeti bir <a href="https://wings.com.tr/" target="_blank">Wings</a> iştirakidir.</p>
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
