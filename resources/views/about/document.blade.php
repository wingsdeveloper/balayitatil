<section class="Belgelerimiz">
    <div class="container">
        <div class="Belgelerimiz-header">
            <p>VİLLA KALKAN</p>
            <h2>BELGELERİMİZ</h2>
        </div>
        @if(count($about->documents) > 0)
        <div class="gallery" {{--id="gallerybelgeler"--}}>
            <div class="row">
                <div class="col-md-12">
                    <div class="swiper-container-belgeler">
                        <div class="swiper-wrapper" style="height:auto !important;">
                            @foreach($about->documents as $key => $document)
                            <div class="swiper-slide ">
                                <figure data-index="{{ $key }}" itemprop="associatedMedia" itemscope itemtype="">
                                    <!-- Büyük Resim linkit -->
                                    <a href="{{asset( $document->document_photo) }}"
                                        @php
                                        list($width, $height, $type, $attr) = getimagesize(ImageProcess::getImageByPath($document->document_photo));
                                        @endphp
                                       data-caption="Belgelerimiz"

                                       {{--data-width="{{ $width }}" data-height="{{ $height }}"
                                       itemprop="contentUrl"--}} class="fancybox global_link">
                                    </a>
                                    <img src="{{ImageProcess::getImageByPath( $document->document_photo) }}" class="w-100" alt="">
                                </figure>
                            </div>
                            @endforeach
                        </div>
                        <!-- Add Arrows -->
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-next">
            <svg class="icon icon-chevron-right">
                <use xlink:href="#icon-chevron-right"></use>
            </svg>
        </div>
        <div class="swiper-button-prev">
            <svg class="icon icon-chevron-right">
                <use xlink:href="#icon-chevron-right"></use>
            </svg>
        </div>
        @endif
    </div>
</section>

