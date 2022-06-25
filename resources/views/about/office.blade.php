<section class="Ofis">
    <div class="container">
        <div class="Ofis-header">
            <p>VİLLA KALKAN</p>
            <h2>OFİSTEN KARELER</h2>
        </div>
        <div {{--id="gallery" class="gallery"--}}>
            <div class="Ofis-in flex ">
                @if(isset($vertical) && !empty($vertical))
                    @if($vertical->office_photo != null)
                        <div class="Ofis-inner-one">
                            <div class="Ofis-item hover_zoom2">
                                <figure {{--itemprop="associatedMedia" itemscope itemtype=""--}}>
                                    <!-- Büyük Resim linki -->
                                    <a  href="{{asset( $vertical->office_photo) }}"

                                       @php
                                        list($width, $height, $type, $attr) = getimagesize(ImageProcess::getImageByPath($vertical->office_photo));
                                        @endphp
                                       {{--data-width="{{ $width }}" data-height="{{ $height }}"
                                       itemprop="contentUrl"--}} class="fancybox global_link">
                                    </a>
                                    <img src="{{ImageProcess::getImageByPath( $vertical->office_photo) }}" class="w-100" alt="">
                                </figure>
                            </div>
                        </div>
                    @endif
                @endif

                @if(isset($hr1) && !empty($hr1))
                <div class=" Ofis-inner-two flex-column">
                    @foreach($hr1 as $hr)
                    <div class="Ofis-item hover_zoom2">
                        <figure {{--itemprop="associatedMedia" itemscope itemtype=""--}}>
                            <!-- Büyük Resim linki -->
                            <a  href="{{asset( $hr->office_photo) }}"

                                @php
                                list($width, $height, $type, $attr) = getimagesize(ImageProcess::getImageByPath($hr->office_photo));
                                @endphp
                               {{--data-width="{{ $width }}" data-height="{{ $height }}"
                               itemprop="contentUrl"--}} class="fancybox global_link">
                            </a>
                            <img src="{{ImageProcess::getImageByPath( $hr->office_photo) }}" class="w-100" alt="">
                        </figure>
                    </div>
                    @endforeach
                </div>
                @endif
                @if(isset($hr2) && !empty($hr2))
                <div class=" Ofis-inner-two flex-column">
                    @foreach($hr2 as $h)
                    <div class="Ofis-item hover_zoom2">
                        <figure {{--itemprop="associatedMedia" itemscope itemtype=""--}}>
                            <!-- Büyük Resim linki -->
                            <a   href="{{asset( $h->office_photo) }}"

                               @php
                                list($width, $height, $type, $attr) = getimagesize(ImageProcess::getImageByPath($h->office_photo));
                                @endphp
                               {{--data-width="{{ $width }}" data-height="{{ $height }}"
                               itemprop="contentUrl"--}} class="fancybox global_link">
                            </a>
                            <img src="{{ImageProcess::getImageByPath( $h->office_photo) }}" class="w-100 fancybox" alt="">
                        </figure>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
