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
                        
                        <svg class="icon addon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 16px;height: 16px;">
                            <path d="M14.3992 0H4.79922C3.91682 0 3.19922 0.7176 3.19922 1.6V11.2C3.19922 12.0824 3.91682 12.8 4.79922 12.8H14.3992C15.2816 12.8 15.9992 12.0824 15.9992 11.2V1.6C15.9992 0.7176 15.2816 0 14.3992 0ZM4.79922 11.2V1.6H14.3992L14.4008 11.2H4.79922Z" fill="#CBC2D8"/>
                            <path d="M1.6 4.8001H0V14.4001C0 15.2825 0.7176 16.0001 1.6 16.0001H11.2V14.4001H1.6V4.8001ZM8.7464 7.6153L7.3656 6.2345L6.2344 7.3657L8.8536 9.9849L13.4152 4.5129L12.1848 3.4873L8.7464 7.6153Z" fill="#CBC2D8"/>
                        </svg>
                        <button class="Dropdown-buton" type="button">
                            <b class="tursay">@if(isset($req) AND !empty($req->category)) {{count($req->category)}} @else
                                    0 @endif</b> <span class="turaciklama">Tür Seçildi</span>
                        </button>
                    </div>
                </div>

                @if(Agent::isDesktop())
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
                @elseif(Agent::isMobile())
                <div class="Villa_Search-item Villa_Search-item-date">
                    <div class=" villa_date " id="two-inputs">
                        <label for="mgiris_tarih" class="Villa_Search-item-info desktop_takvim_label">Giriş Tarihi</label>
                        <input type="text" id="mgiris_tarih" class="villa_date-input" placeholder="Giriş Tarihi"
                           @if(isset($req) AND !empty($req->giris_tarih)) value="{{$req->giris_tarih}}"
                           @endif  name="giris_tarih"
                           data-datepicker="separateRange"/>
                        <i class="icon-form-change"></i>
                    </div>
                    <div class=" villa_date">
                        <label for="mcikis_tarih" class="Villa_Search-item-info desktop_takvim_label">Çıkış Tarihi</label>
                        <input type="text" id="mcikis_tarih" class="villa_date-input" placeholder="Çıkış Tarihi"
                           @if(isset($req) AND !empty($req->cikis_tarih)) value="{{$req->cikis_tarih}}"
                           @endif name="cikis_tarih"
                           data-datepicker="separateRange"/>
                        <svg class="icon icon-form-calendar addon" data-original-title="" title="">
                            <use xlink:href="#icon-form-calendar"></use>
                        </svg>
                    </div>
                </div>
                @endif

                <div class="Villa_Search-item Villa_Search-item-kisi">
                    <label class="Villa_Search-item-info" for="">Kişi Sayısı Seçiniz</label>
                    <div class="dropdown bootstrap-select">
                    <select autocomplete="off" class="selectpicker " name="kisi_sayisi" id="v_filter_kisi">
                        <option value="0">Kişi Sayısı</option>
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
                        <span>TESİS <b>ARA</b></span>
                    </button>
                </div>

            </div>

            <div class="Dropdown-menu " style="display: none">
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
        </form>
    </div>

</div>
