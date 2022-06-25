@extends('layouts.app')

@section('content')
    @include('extra.slider')
    <section class="Extralar" id="foto">
        <div class="containerindex">
            <div class="Extralar-in">
                <div class="Extralar-head flex a-i-c ">
                    <p class="Extralar-head-header"><span>TATİLDE GÜZEL VAKİT GEÇİRİN </span>
                        {{ isset($extra) && !empty($extra) ? $extra->name : ''}}
                    </p>
                    <a href="{{ isset($extra) && !empty($extra) ? $extra->link : '' }}" target="_blank" class="Extralar-head-link desktop">
                        <p>BİLGİ & REZERVASYON
                        </p>
                        <span class="Extralar-head-link-icon">
                           <svg class="icon icon-right-arrow"><use xlink:href="#icon-right-arrow"></use></svg>
                       </span>
                    </a>
                </div>
                <div class="Extralar-inner flex">
                    <div class="Extralar-inner-image">
                        @if(isset($extra) && !empty($extra))
                            <img src="{{ImageProcess::getImageByPath( $extra->list_image) }}" class="w-100 hvr-float-shadow"
                                 alt="{{ $extra->name }}" style="width:200px!important">
                        @endif
                    </div>
                    <div class="Extralar-inner-text">
                        {!! isset($extra) && !empty($extra) ? $extra->description  : '' !!}
                    </div>
                </div>
                <div class="gallery" id="gallery">
                    <div class="Extralar-galeri gallery flex wrap">
                        @forelse($extra->extra_galleries as $gallery)
                        <div class="Extralar-galeri-item item-5">
                            <figure itemprop="associatedMedia" itemscope itemtype="">
                                <!-- Büyük Resim linki -->
                                <a href="{{asset( $gallery->image) }}"
                                   data-caption=""
                                   data-width="1280" data-height="720"
                                   itemprop="contentUrl">
                                    <!-- Küçük Resim -->
                                    <img src="{{ImageProcess::getImageByPath( $gallery->image) }}" class="w-100" itemprop="thumbnail" alt="{{ $extra->name }}">
                                </a>
                            </figure>
                        </div>
                            @empty
                        @endforelse
                    </div>
                </div>
                <div class="flex">
                    <a href="{{ isset($extra) && !empty($extra) ? $extra->link : '' }}" target="_blank" class="Extralar-head-link mobile-f">
                        <p>BİLGİ & REZERVASYON <span></span></p>
                        <span class="Extralar-head-link-icon">
                           <svg class="icon icon-right-arrow"><use xlink:href="#icon-right-arrow"></use></svg>
                       </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!--Galeri pop-up -->
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
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
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
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
@endsection