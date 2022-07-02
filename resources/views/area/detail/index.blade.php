@extends('layouts.app')
@push('extrahead')
<!-- Criteo Listing Tag -->
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
    { event: "setAccount", account: 46955 },
    { event: "setEmail", email: "", hash_method: "" },
    { event: "setSiteType", type: deviceType},
    { event: "setZipcode", zipcode: "" },
    { event: "viewList", item: [{{ implode(",", $villas->pluck('id')->toArray()) }}] });
</script>
<!-- END Criteo Listing Tag -->
@endpush
@section('content')

    @include('area.detail.slider')
    <section class="Villas">
        <div class=" containerindex">

            <div class="Villas-filter flex a-i-c">
                <p>Toplam {{ !empty($villas) ? $villas->total() : '' }} adet tesis listelendi.</p>
                <div class="Villas-filter-item ml-auto">
                    @php
                        $parametre=\App\Helpers\Helper::parametreTemizle(Request::getQueryString());
                    @endphp
                    <select autocomplete="off" class="selectpicke"
                            onchange="location = '{{Request::url().'?'.$parametre}}&siralama='+this.value;"
                            id="v_filter">
                        <option value="0"
                                @if(!isset($req->siralama) OR empty($req->siralama)) selected="selected" @endif >
                            Sıralama Şeklini Seçiniz
                        </option>
                        <option value="artan"
                                @if($req->siralama=="artan") selected="selected" @endif >Artan Fiyat
                        </option>
                        <option value="azalan"
                                @if($req->siralama=="azalan") selected="selected" @endif >Azalan Fiyat
                        </option>
                    </select>
                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                    <svg class="icon icon-caret-down addon">
                        <use xlink:href="#icon-caret-down"></use>
                    </svg>
                </div>
            </div>

            <div class="Villas-in flex wrap">
                @if(Agent::isDesktop())
                    @forelse($villas as $villa)
                        @php
                            $seo_url = isset($villa->seo->seo_url) ? $villa->seo->seo_url : '';
                           // $gecelikFiyat=\App\Helpers\Helper::nPrice($villa->id);
                        @endphp
                        <div class="P_villas-item item-3   flex">
                            <a href="{{ url($seo_url) }}" class="global_link"></a>
                            @if($villa->panel_villa)
                            {!! view('ux.badge',['param'=>$villa->panel_villa->panel_tag])->render() !!}
                            @endif

                             <div class="On-odeme">
                                <p class="On-odeme-yuzde">%<b>{{$villa->prepayment_rate}}</b></p>
                                <p class="On-odeme-text">Şimdi Öde<span>Kalanı</span>Girişte Öde!</p>
                            </div>

                            <div class="P_villas-img ">
                                @php
                                    !empty($villa->list_image)?$resim="uploads/villa/gallery/$villa->list_image/$villa->list_image_name":$resim=$villa->panel_villa->list_image;
                                @endphp
                                <img src="{{ImageProcess::getImageByPath($resim)}}" class="w-100"
                                     alt="{{ $villa->name }}">
                            </div>
                            <div class="P_villas-info">
                            <div class="P_villas-info-kod">
                                <p>{{ $villa->name }}</p>
                                <span>Villa Kodu: {{ $website->prefix }}{{ $villa->code }}</span>
                            </div>

                            <div class="P_villas-info-people">
                        <p><b>{{ $villa->number_person }} </b> Kişi /  En Az <b>{{ $villa->min_accommodation }}</b> Gece</p>
                    </div>
                                <div class="P_villas-info-in">
                                    
                                <div class="info">
                                    <svg class="icon icon-bed">
                                        <use xlink:href="#icon-bed"></use>
                                    </svg>
                                    <span>{{ $villa->number_bedroom }} Yatak Odası</span>
                                </div>
                                <div class="info">
                                <svg class="icon" width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M.55 0c.234 0 .424.183.424.41v1.463h6.43c1.46.002 2.695 1.049 2.887 2.45 2.397.216 4.232 2.158 4.238 4.487v.85c.37.167.604.527.598.921-.003.554-.464 1.003-1.036 1.01H5.619a1.036 1.036 0 0 1-1-.808 1.002 1.002 0 0 1 .591-1.122v-.85c0-2.327 1.83-4.271 4.224-4.488-.185-.945-1.037-1.63-2.03-1.63H.974V4.39c0 .226-.19.41-.423.41a.417.417 0 0 1-.424-.41V.41c0-.227.19-.41.424-.41zM5.62 10.771h8.472c.1 0 .181-.078.181-.175a.179.179 0 0 0-.181-.176H5.619c-.1 0-.182.079-.182.176 0 .097.081.175.182.175zm.438-1.17v-.79c0-2.038 1.707-3.689 3.813-3.689 2.105 0 3.812 1.651 3.812 3.688v.79H6.057zM12.15 14.574c-.17-.183-.42-.46-.42-.973v-.235c0-.227.164-.412.367-.412.202 0 .366.185.366.412v.235c0 .155.045.218.195.379.17.183.424.46.424.973 0 .513-.259.79-.43.973-.149.16-.201.224-.201.379 0 .154.051.218.2.378.17.183.428.46.428.974 0 .513-.25.79-.421.973-.15.16-.195.224-.195.379v.352c0 .228-.164.412-.366.412-.203 0-.367-.184-.367-.412v-.352c0-.514.25-.79.42-.974.15-.16.198-.224.198-.378 0-.155-.053-.218-.202-.38-.17-.182-.428-.459-.428-.972 0-.514.257-.79.427-.973.149-.161.204-.225.204-.38 0-.153-.049-.217-.198-.378zM8.742 14.574c-.17-.183-.421-.46-.421-.973v-.235c0-.227.164-.412.367-.412.202 0 .366.185.366.412v.235c0 .155.045.218.195.379.17.183.423.46.423.973 0 .513-.258.79-.428.973-.15.16-.202.224-.202.379 0 .154.051.218.2.378.17.183.427.46.427.974 0 .513-.25.79-.42.973-.15.16-.195.224-.195.379v.352c0 .228-.164.412-.366.412-.203 0-.367-.184-.367-.412v-.352c0-.514.25-.79.42-.974.15-.16.198-.224.198-.378 0-.155-.053-.218-.202-.38-.17-.182-.428-.459-.428-.972 0-.514.256-.79.426-.973.15-.161.204-.225.204-.38 0-.153-.048-.217-.197-.378z" fill="#fff"/>
                                </svg>
                                <span>{{ $villa->number_bathroom }} Banyo</span>
                            </div>
                    <div class="info">
                        <svg class="icon icon-new-location" data-original-title="" title="">
                            <use xlink:href="#icon-new-location"></use>
                        </svg>
                        <span><b>Kalkan</b> Bölgesinde </span>
                    </div>
                                </div>
                                <div class="P_villas-info-money">
                                    <svg class="icon icon-wallet ">
                                        <use xlink:href="#icon-wallet"></use>
                                    </svg>
                                    <div class="flex-column">
                                    <h6>{{number_format((float)$villa->starting_price, 0, ',', '.')}} ₺</h6>
                                    <p>GECELİK </p>
                                    <span>BAŞLAYAN FİYATLARLA</span>
                                    </div>
                                </div>

                                <div class="P_villas-info-link">
                                    Detaylı İncele
                                    <svg class="icon icon-right-arrow ">
                                        <use xlink:href="#icon-right-arrow"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @empty
                        Henüz Villa Eklenmedi
                    @endforelse

                @elseif(Agent::isMobile())
                    @forelse($villas as $villa_mobile)
                        @php

                            $seo_url = isset($villa_mobile->seo->seo_url) ? $villa_mobile->seo->seo_url : '';
                          //  $gecelikFiyat=\App\Helpers\Helper::nPrice($villa_mobile->id);
                        @endphp
                        <div class="VillasM flex wrap mobile">
                            <div class="f_item">
                                    <a href="{{ url($seo_url) }}" class="global_link"></a>
                                <div class="f_item-image">
                                    @if($villa_mobile->panel_villa)
                                        {!! view('ux.badge',['param'=>$villa_mobile->panel_villa->panel_tag])->render() !!}
                                    @endif
                                    @php
                                        !empty($villa_mobile->list_image)?$resim="uploads/villa/gallery/$villa_mobile->list_image/$villa_mobile->list_image_name":$resim=$villa_mobile->panel_villa->list_image;
                                    @endphp
                                    <img src="{{asset($resim)}}" class="w-100" alt="{{ $villa_mobile->name }}">
                                    <p class="f_item-kod flex-column">
                                        <span>{{ $website->prefix }}{{ $villa_mobile->code }}</span>{{ $villa_mobile->name }}
                                    </p>
                                </div>
                                <div class="f_item-info">

               <span class="f_item-info-item">
                <svg class="icon icon-point ">
                    <use xlink:href="#icon-point"></use>
                </svg>
                   {{ isset($villa_mobile->area->name) ? $villa_mobile->area->name : '' }}
            </span>
                                    <span class="f_item-info-item">
                <svg class="icon icon-user ">
                    <use xlink:href="#icon-user"></use>
                </svg>
                                        {{ $villa_mobile->number_person }} Kişilik
            </span>
                                    <div class="P_villas-info-money">
                                        <svg class="icon icon-wallet ">
                                            <use xlink:href="#icon-wallet"></use>
                                        </svg>
                                        <div class="flex-column">
                                        <h6>{{number_format((float)$villa_mobile->starting_price, 0, ',', '.')}} ₺</h6>
                                    <p>GECELİK </p>
                                    <span>BAŞLAYAN <br/>FİYATLARLA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        Henüz Villa Eklenmedi
                    @endforelse
                @endif


            </div>
            <nav class="flex j-c-c">
                {{ $villas->links() }}
            </nav>

        </div>
    </section>
@endsection
