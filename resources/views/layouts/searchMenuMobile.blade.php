<div class="Villa_Search_M mobile">

    <div class="Villa_Search_M-head ">
        <p>
            <span>HAYALİNDEKİ TATİL İÇİN</span>
            VİLLANI ARAMAYA BAŞLA
        </p>
    </div>
    <div class="Villa_Search_M-in flex-column">
        <form action="{{ route('search') }}" method="get" id="searchForm" autocomplete="off" class="w-100">
            <input id="selected-categories" type="hidden" name="category">

            <div class="Villa_Search_M-item">
                <div class="Dropdown">
                    <button class="Dropdown-buton" type="button">

                        <b class="tursay">@if(isset($req) AND !empty($req->category)) {{count($req->category)}} @else
                                0 @endif</b> <span class="turaciklama">Tür Seçildi</span>
                    </button>
                    <div class="Dropdown-menu ">
                        <div class="Dropdown-menu-in ">


                            @forelse($website->categories as $category)
                                <div class="Dropdown-menu-item {{ isset($view_name) && ($view_name != 'villa-category-detail') && ($category->show != 1) ? 'hidden' : '' }}">
                                    <input data-id="{{ $category->id }}" type="checkbox" class="category_check"
                                           @if(isset($req) AND !empty($req->category))
                                           @if(in_array($category->panel_seo->seo_url, explode('_', $req->category))) checked="checked" @endif
                                           @elseif($view_name=="villa-category-detail")
                                           checked="checked"
                                           @endif value="{{ $category->panel_seo->seo_url }}" id="m{{$category->id}}">
                                    <label for="m{{$category->id}}">{{$category->name}}</label>
                                </div>
                            @empty

                            @endforelse
                                <div class="Dropdown-menu-in-warning">
                                    5 kategoriden fazlası seçilemez.
                                </div>
                            <button class="Dropdown-close" type="button">Kapat</button>
                        </div>
                    </div>
                </div>
                <svg class="icon icon-caret-down addon">
                    <use xlink:href="#icon-caret-down"></use>
                </svg>
            </div>
            <div class="flex justify-content-between">
                <div class="Villa_Search_M-item villa_date">
                    <input
                        id="mgiris_tarih"
                        class="datepicker"
                        name="giris" placeholder="Giriş Tarihi"
                        type="text" autocomplete="off"
                        @if(isset($req) AND !empty($req->giris_tarih)) value="{{$req->giris_tarih}}"
                        data-value="{{$req->giris_tarih}}" @endif
                    >

                    <svg class="icon icon-date addon">
                        <use xlink:href="#icon-calendar"></use>
                    </svg>
                </div>
                <div class="Villa_Search_M-item villa_date">
                    <input
                        id="mcikis_tarih"
                        class="datepicker"
                        name="cikis" placeholder="Çıkış Tarihi"
                        type="text" autocomplete="off"
                        @if(isset($req) AND !empty($req->cikis_tarih)) value="{{$req->cikis_tarih}}"
                        data-value="{{$req->cikis_tarih}}" @endif >
                    <svg class="icon icon-date addon">
                        <use xlink:href="#icon-calendar"></use>
                    </svg>
                </div>
            </div>
            <div class="Villa_Search_M-G-buton">Gelişmiş Arama</div>

            <div class="Villa_Search_M-G">
                <div class="Villa_Search_M-G-item villa_tur">

                    <div class="Dropdown">
                        <button class="Dropdown-buton" type="button">
                            <b id="mtotal_person">@if(isset($req) && !empty($req->adult) || !empty($req->child)) {{(int)$req->adult+(int)$req->child}} @else
                                    1 @endif
                            </b> Kişi
                            <span class="Dropdown-buton-person">
              (
              <b id="mtotal_adult">@if(isset($req) && !empty($req->adult)) {{$req->adult}} @else 1 @endif
              </b> Yetişkin,
              <b id="mtotal_child">@if(isset($req) && !empty($req->child)) {{$req->child}} @else 0 @endif
              </b> Çocuk,
              <b id="mtotal_baby">@if(isset($req) && !empty($req->baby)) {{$req->baby}} @else 0 @endif
              </b> Bebek )
            </span>
                        </button>
                        <div class="Dropdown-menu  Rezervasyon-search-person ">
                            <div class="Dropdown-menu-item">
                                <p>Yetişkin
                                </p>
                                <div class="Dropdown-menu-item-spinner ">
                                    <button type="button" onclick="eksilt(this,1,'m','adult')">
                                        <svg class="icon icon-minus">
                                            <use xlink:href="#icon-minus">
                                            </use>
                                        </svg>
                                    </button>
                                    <input type="text"
                                           value="@if(isset($req) && !empty($req->adult)) {{$req->adult}} @else 1 @endif"
                                           name="adult" style="display: block;" readonly="readonly">
                                    <button id="m-adult-button" type="button" data-max="20"
                                            onclick="arttir(this,'11','m','adult')">
                                        <svg class="icon icon-plus">
                                            <use xlink:href="#icon-plus">
                                            </use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="Dropdown-menu-item">
                                <p>Çocuk
                                    <span>6-13 Yaş Arası
                </span>
                                </p>
                                <div class="Dropdown-menu-item-spinner ">
                                    <button type="button" onclick="eksilt(this,0,'m','child')">
                                        <svg class="icon icon-minus">
                                            <use xlink:href="#icon-minus">
                                            </use>
                                        </svg>
                                    </button>
                                    <input type="text"
                                           value="@if(isset($req) && !empty($req->child)) {{$req->child}} @else 0 @endif"
                                           name="child" style="display: block;" readonly="readonly">
                                    <button type="button" onclick="arttir(this,'11','m','child')">
                                        <svg class="icon icon-plus">
                                            <use xlink:href="#icon-plus">
                                            </use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="Dropdown-menu-item">
                                <p>Bebek
                                    <span>0-5 Yaş Arası
                </span>
                                </p>
                                <div class="Dropdown-menu-item-spinner ">
                                    <button type="button" onclick="eksilt(this,0,'m','baby')">
                                        <svg class="icon icon-minus">
                                            <use xlink:href="#icon-minus">
                                            </use>
                                        </svg>
                                    </button>
                                    <input type="text"
                                           value="@if(isset($req) && !empty($req->baby)) {{$req->baby}} @else 0 @endif"
                                           name="baby" style="display: block;" readonly="readonly">
                                    <button type="button" onclick="arttir(this,'5','m','baby')">
                                        <svg class="icon icon-plus">
                                            <use xlink:href="#icon-plus">
                                            </use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="Dropdown-menu-item">
                                <button class="Dropdown-close" type="button">
                                    ONAYLA
                                </button>
                            </div>
                        </div>
                    </div>

                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                </div>
                <div class="Villa_Search_M-G-item">
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
                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                </div>
                <div class="Villa_Search_M-G-item">
                    <select autocomplete="off" class="selectpicker" name="mahalle" id="filter_area">
                        <option value="0">Alt Bölge Seçiniz</option>
                    </select>
                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                </div>
            </div>

            <button type="button" onclick="searchControl()" class="buton_orange mx-auto">
                Arama Yap
                <svg class="icon icon-right-arrow">
                    <use xlink:href="#icon-right-arrow"></use>
                </svg>
            </button>
        </form>
    </div>

</div>
