<div class="Villa_Search ">

    <div class=" containerindex">
        <form action="{{ route('search') }}" method="get" id="searchForm" autocomplete="off" class="w-100">
            <input id="selected-categories" type="hidden" name="category">
            <div class="Villa_Search-in flex  justify-content-between wrap">

                <div class="Villa_Search-icon">
                    <a href="{{ url('/') }}">
                        <svg class="icon icon-logo_vk_w ">
                            <use xlink:href="#logo_vk_w"></use>
                        </svg>
                    </a>
                </div>
                <div class="Villa_Search-item villa_tur">

                    <label class="Villa_Search-item-info" for="">Villa Türü Seçiniz</label>
                    <div class="Dropdown">
                        <svg class="icon icon-caret-down addon">
                            <use xlink:href="#icon-caret-down"></use>
                        </svg>
                        <button class="Dropdown-buton" type="button">
                            <b class="tursay">@if(isset($req) AND !empty($req->category)) {{count($req->category)}} @else
                                    0 @endif</b> <span class="turaciklama">Tür Seçildi</span>
                        </button>

                    </div>

                </div>
                <div class="Villa_Search-item villa_date " id="two-inputs">
                    <label for="dgiris_tarih" class="Villa_Search-item-info desktop_takvim_label">Giriş Tarihi</label>
                    <input type="text" id="dgiris_tarih" class="villa_date-input"
                           @if(isset($req) AND !empty($req->giris_tarih)) value="{{$req->giris_tarih}}"
                           @endif  name="giris_tarih"
                           data-datepicker="separateRange"/>
                    <svg class="icon icon-date addon">
                        <use xlink:href="#icon-calendar"></use>
                    </svg>
                </div>
                <div class="Villa_Search-item villa_date">
                    <label for="dcikis_tarih" class="Villa_Search-item-info desktop_takvim_label">Çıkış Tarihi</label>
                    <input type="text" id="dcikis_tarih" class="villa_date-input"
                           @if(isset($req) AND !empty($req->cikis_tarih)) value="{{$req->cikis_tarih}}"
                           @endif name="cikis_tarih"
                           data-datepicker="separateRange"/>
                    <svg class="icon icon-date addon">
                        <use xlink:href="#icon-calendar"></use>
                    </svg>
                </div>
                <div class="Villa_Search-item search_buton">
                    <button onclick="searchControl()" type="button" class="search_buton-buton">
                        <svg class="icon icon-search">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                        VİLLANI BUL
                    </button>
                    <button type="button" class="G_search-buton">Gelişmiş Arama</button>
                </div>
                <div class="Villa_Search-top">
                    <div id='UpTotop' class="flex-column a-i-c">
                        <svg class="icon icon-chevron-right">
                            <use xlink:href="#icon-chevron-right"></use>
                        </svg>
                        YUKARI ÇIK
                    </div>
                </div>
            </div>
            <div class="Dropdown-menu ">
                <div class="Dropdown-menu-in ">
                    @php

                        @endphp
                    @forelse($website->categories as $category)
                        <div class="Dropdown-menu-item {{ isset($view_name) && ($view_name != 'villa-category-detail') && ($category->show != 1) ? 'hidden' : '' }}">
                            <input data-id="{{ $category->id }}" autocomplete="off" type="checkbox"
                                   class="category_check" name=""
                                   @if(isset($req) AND !empty($req->category))
                                   @if(in_array($category->panel_seo->seo_url, explode('_', $req->category))) checked="checked"
                                   @endif
                                   @elseif($view_name=="villa-category-detail")
                                   checked="checked"
                                   @endif value="{{ $category->panel_seo->seo_url }}" {{--value="{{$category->id}}"--}} id="{{$category->id}}">
                            <label for="{{$category->id}}">{{$category->name}}</label>
                        </div>
                    @empty

                    @endforelse
                    <div class="Dropdown-menu-in-warning">
                        5 kategoriden fazlası seçilemez.
                    </div>
                    <button class="Dropdown-close" type="button">Kapat</button>
                </div>
            </div>
            <div class="G_search-menu ">

                <div class="G_search-menu-in">
                    <span>Gelişmiş Arama</span>
                    <div class="G_search-menu-item">
                        <select autocomplete="off" class="selectpicker " name="bolge" id="v_filter">
                            @php
                                $areas = App\Area::get();
                            @endphp
                            <option value="0">Bölge Seçiniz</option>
                            @foreach($areas as $areasearch)
                                <option
                                    @if(isset($req) && !empty($req->bolge))
                                    @if($req->bolge==$areasearch->id)
                                    selected="selected"
                                    @endif
                                    @endif
                                    @if(isset($area) && !empty($area))
                                    @if($area->id==$areasearch->id)
                                    selected="selected"
                                    @endif
                                    @endif
                                    value="{{$areasearch->id}}">
                                    {{$areasearch->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="G_search-menu-item">
                        <select autocomplete="off" class="selectpicker" name="mahalle" id="filter_area">
                            <option value="0">Alt Bölge Seçiniz</option>
                        </select>
                    </div>
                    <div class="G_search-menu-item">
                        <select autocomplete="off" class="selectpicker " name="kisi_sayisi" id="v_filter_kisi">
                            <option value="0">Kişi Sayısı Seçiniz</option>
                            @for($i=1; $i<=11; $i++)
                                <option value="{{$i}}"
                                        @if(isset($req) AND !empty($req->kisi_sayisi)) @if($req->kisi_sayisi==$i) selected="selected" @endif @endif>{{$i}}{{($i==11)?'+':''}}
                                    Kişi
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="G_search-menu-item" style="margin-top: -15px;">
                        <!-- <select class="selectpicker " name="fiyat" id="v_filter">
                             <option value="0">Fiyat Aralığı Seçiniz</option>
                             <option value="1000-2000">1000-2000</option>
                             <option value="2000-3000">2000-3000</option>
                             <option value="4000-5000">4000-5000</option>
                             <option value="5000-7500">5000-7500</option>
                             <option value="7500-10000">7500-10000</option>
                             <option value="10000">10000+</option>
                         </select>-->
                    </div>

                    <button type="button" class="G_search-menu-buton">KAPAT</button>

                </div>

            </div>
        </form>
    </div>

</div>
