<section class="A_firsat">
    <div class=" containerindex">
        <div class="A_firsat-in flex wrap a-i-c">

            <div onclick="window.location.replace('{{ url('/yaklasan-firsatlar') }}')" class="A_firsat-head" id="yaklasan-firsatlar-alan" style="cursor: pointer">
                <h6>YAKLAŞAN</h6>
                <h2>FIRSATLAR <span><a href="{{ url('/yaklasan-firsatlar') }}">({{ $opportunities->total() }})</a></span></h2>
                <p>Bu aya özel toplam <a href="{{ url('/yaklasan-firsatlar') }}"><u><b>{{ $opportunities->total() }}</b></u></a> fırsat villası var. Fırsatı kaçırma, huzurlu bi tatili yakala!</p>
                <a href="{{ url('/yaklasan-firsatlar') }}" class="buton_orange">
                    Tüm Fırsatları Görüntüle
                    <svg class="icon icon-right-arrow">
                        <use xlink:href="#icon-right-arrow"></use>
                    </svg>
                </a>
            </div>


            <div class="A_firsat-right flex wrap">

                @forelse($opportunities as $villad)

                    @php
                        $seo_url = isset($villad->villa->seo) ? $villad->villa->seo->seo_url : '';
                        $tarihPara=$villad->tarihPara($villad);
                    @endphp
                        <div class="f_item">
                            <div class="f_item-image">
                                <a href="{{ route('villa.detail.search',[$seo_url,$villad->start_date,$villad->end_date]) }}" class="global_link"></a>
                                @php
                                    !empty($villad->villa->list_image)?$resim="uploads/villa/gallery/".$villad->villa->list_image."/".$villad->villa->list_image_name:$resim=$villad->villa->panel_villa->list_image;
                                @endphp
                                <img src="{{ asset('images/default.jpg') }}" data-src="{{ ImageProcess::getVillaImageByPath("$resim")}}" class="w-100 lazy-load" alt="{{ $villad->villa->name }}">
                                <span class="f_item-badge"><strong>{{$tarihPara['gun_farki']}}</strong>GECE</span>
                                <p class="f_item-kod flex-column"><span>{{ $website->prefix }}{{ $villad->villa->code }}</span>{{ $villad->villa->name }}</p>
                                <div class="f_item-like">

                                    <input type="checkbox" id="v1">
                                    <label for="v1">
                                        <svg class="icon icon-heart ">
                                            <use xlink:href="#icon-heart"></use>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                            <div class="f_item-info">

                    <span class="f_item-info-item">
                        <svg class="icon icon-point ">
                            <use xlink:href="#icon-point"></use>
                        </svg>
                        {{ isset($villad->villa->area) ? $villad->villa->area->name : 'Bölge Yok' }}
                    </span>
                                <span class="f_item-info-item">
                        <svg class="icon icon-user ">
                            <use xlink:href="#icon-user"></use>
                        </svg>
                        {{ $villad->villa->number_person }} Kişi
                    </span>
                                <span class="f_item-info-item">
                        <svg class="icon icon-bed ">
                            <use xlink:href="#icon-bed"></use>
                        </svg>
                        {{ $villad->villa->number_bedroom}} Yatak Odası
                    </span>
                                <div class="f_item-info-in">
                                     <span>{{$tarihPara['start']}} - {{$tarihPara['end']}}</span>
                                  <p>{{number_format((float)$tarihPara['gunlukFiyat'][7], 0, ',', '.')}}₺</p>
                                </div>
                            </div>

                        </div>
                @empty
                @endforelse

            </div>

            <div class="A_firsat-mobile mobile ">
                <div class="swiper-container-fv">
                    <div class="swiper-wrapper">
                        @forelse($opportunities as $villam)
                    @php
                         $seo_url = isset($villam->villa->seo) ? $villam->villa->seo->seo_url : '';
                    $tarihPara=$villam->tarihPara($villam);
                    @endphp
                             <div class="swiper-slide">
                            <div class="f_item">
                                <a href="{{ route('villa.detail.search',[$seo_url,$villam->start_date,$villam->end_date]) }}" class="global_link"></a>
                                <div class="f_item-image">
                                    @php
                                        !empty($villam->villa->list_image)?$resim="uploads/villa/gallery/".$villam->villa->list_image."/".$villam->villa->list_image_name:$resim=$villam->villa->panel_villa->list_image;
                                    @endphp
                                    <img src="{{ asset('images/default.jpg') }}" data-src="{{ImageProcess::getVillaImageByPath("$resim") }}" class="w-100 lazy-load" alt="{{ $villam->villa->name }}">

                                    <span class="f_item-badge"><strong>{{$tarihPara['gun_farki']}}</strong>GECE</span>
                                    <p class="f_item-kod flex-column"><span>{{ $website->prefix }}{{ $villam->villa->code }}</span>{{ $villam->villa->name }}</p>
                                    <div class="f_item-like">

                                        <input type="checkbox" id="v1">
                                        <label for="v1">
                                            <svg class="icon icon-heart ">
                                                <use xlink:href="#icon-heart"></use>
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                                <div class="f_item-info">

                         <span class="f_item-info-item">
                        <svg class="icon icon-point ">
                            <use xlink:href="#icon-point"></use>
                        </svg>
                        {{ isset($villam->villa->area) ? $villam->villa->area->name: 'Bölge Yok' }}
                    </span>
                                 <span class="f_item-info-item">
                                    <svg class="icon icon-user ">
                                        <use xlink:href="#icon-user"></use>
                                    </svg>
                                    {{ $villam->villa->number_person }} Kişilik
                                 </span>
                                <div class="f_item-info-in">
                                     <span>{{$tarihPara['start']}} - {{$tarihPara['end']}}</span>
                                  <p>{{number_format((float)$tarihPara['gunlukFiyat'][7], 0, ',', '.')}} ₺</p>
                                </div>
                                </div>

                            </div>
                        </div>
                        @empty
                        @endforelse


                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>

                <div class="flex">
                    <a href="{{ url('/yaklasan-firsatlar') }}" class="buton mx-auto">
                        Tümünü Görüntüle
                        <svg class="icon icon-right-arrow ">
                            <use xlink:href="#icon-right-arrow"></use>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
