<div class="Villa_Search ">

    <div class=" containerindex">
        <form action="{{ route('search') }}" method="get" id="searchForm" autocomplete="off" class="w-100">
            <input id="selected-categories" type="hidden" name="category">
            <div class="Villa_Search-in flex  justify-content-between wrap">

                <div class="Villa_Search-item Villa_Search-item-bolge">
                    <label class="Villa_Search-item-info" for="">Bölge Seçiniz</label>
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

                <div class="Villa_Search-item Villa_Search-item-tur">
                    <label class="Villa_Search-item-info" for="">Villa Türü Seçiniz</label>
                    <div class="Dropdown">
                        <svg class="icon addon" data-original-title="" title="">
                            <use xlink:href="#icon-marker"></use>
                        </svg>
                        <button class="Dropdown-buton" type="button">
                            <b class="tursay">@if(isset($req) AND !empty($req->category)) {{count($req->category)}} @else
                                    0 @endif</b> <span class="turaciklama">Tür Seçildi</span>
                        </button>
                    </div>
                </div>

                <div class="Villa_Search-item Villa_Search-item-date">
                    <div class=" villa_date " id="two-inputs">
                        <label for="dgiris_tarih" class="Villa_Search-item-info desktop_takvim_label">Giriş Tarihi</label>
                        <input type="text" id="dgiris_tarih" class="villa_date-input" placeholder="Giriş Tarihi"
                           @if(isset($req) AND !empty($req->giris_tarih)) value="{{$req->giris_tarih}}"
                           @endif  name="giris_tarih"
                           data-datepicker="separateRange"/>
                        <i class="icon-form-change"></i>
                    </div>
                    <div class=" villa_date">
                        <label for="dcikis_tarih" class="Villa_Search-item-info desktop_takvim_label">Çıkış Tarihi</label>
                        <input type="text" id="dcikis_tarih" class="villa_date-input" placeholder="Çıkış Tarihi"
                           @if(isset($req) AND !empty($req->cikis_tarih)) value="{{$req->cikis_tarih}}"
                           @endif name="cikis_tarih"
                           data-datepicker="separateRange"/>
                        <svg class="icon icon-form-calendar addon" data-original-title="" title="">
                            <use xlink:href="#icon-form-calendar"></use>
                        </svg>
                    </div>
                </div>

                <div class="Villa_Search-item Villa_Search-item-kisi">
                    <label class="Villa_Search-item-info" for="">Kişi Sayısı Seçiniz</label>
                    <div class="dropdown bootstrap-select">
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
                </div>
                
                <div class="Villa_Search-item Villa_Search-item-button">
                    <button onclick="searchControl()" type="button" class="Villa_Search-item-button-buton">
                        <svg class="icon icon-search" data-original-title="" title="">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                        <span>ARA</span>
                    </button>
                </div>

            </div>

            <div class="Dropdown-menu " style="display: none">
                <div class="Dropdown-menu-in ">

                    @php

                    @endphp
                    <div class="Dropdown-menu-item  {{ isset($view_name) && ($view_name != 'villa-category-detail') && ($category->show != 1) ? 'hidden' : '' }} " style="display:none">
                            <input data-id="291" autocomplete="off" type="checkbox"
                                   class="category_check" name=""
                                    value="tum-villalarimiz"  id="291"  checked="checked">
                            <label for="291">TÜM VİLLALARIMIZ</label>
                        </div>
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
        </form>
    </div>

</div>
