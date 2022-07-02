@extends('layouts.app')
@push('search_app_js')
    <script src="{{ asset('js/app.js') }}?v=1.12"></script>
@endpush

@push('extrahead')
    {{--    <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
    @if( isset($villas) && !empty($villas) && isset($_GET['cikis_tarih']) && isset($_GET['giris_tarih']) )
    @php
        try {
            $viewList = implode( ',', $villas->pluck('id')->toArray() );
        } catch (\Exception $e) {
            $viewList = null;
        }

    @endphp
        @if(!empty($viewList))
      

<!-- Criteo Listing Tag -->
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
    { event: "setAccount", account: 46955 },
    { event: "setEmail", email: "##Email Address##", hash_method: "##Hash Method##" },
    { event: "setSiteType", type: deviceType},
    { event: "setZipcode", zipcode: "##Zip Code##" },
    { event: "viewSearch",
      checkin_date: "{{ date('Y-m-d', strtotime($_GET['giris_tarih'])) }}",
      checkout_date: "{{ date('Y-m-d', strtotime($_GET['cikis_tarih'])) }}" },
    { event: "viewList", item: [{{ $viewList }}]});

</script>
<!-- END Criteo Listing Tag -->
        @endif
    @endif
@endpush
@section('content')
    @include('villa.list.slider')
    @php
    $kisi_sayisi = isset($req->kisi_sayisi) ? $req->kisi_sayisi : $req->adult + $req->child;

 @endphp
 @php


$curl = curl_init();

$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$event_id_search = random_int(1000000000000, 9999999999999);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v13.0/1757769984530411/events',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('data' => '[{
      "event_name": "Search",
      "event_id": "'. $event_id_search .'",
      "event_time": "' . time() .'",
      "event_source_url": "'. $actual_link .'",
      "user_data": {
          "client_ip_address": "' . $fb_ip . '",
          "client_user_agent": "' . $user_agent . '"
        } }]',
       'access_token' => 'EAAHTPiGDALEBANKENo2ZAPSKmLeN0opQJsrrQdmeUyANnci2JKxLdpi7ZAPnfwwZA1VLWdP6UVf48N1MWo9l2fQ5CbZA0ZAJ487F18aZCsTpo5Mgpy6hZCiq0E6mZCuLLEnrCvSm2vty3KKQPFHUasZBLWqmsLi6SWZCsUg0mQr98ne7G9WvojsLUc','test_event_code' => 'TEST50377'),
));

$response = curl_exec($curl);

curl_close($curl);

@endphp

<script>
    fbq('track', 'Search', {}, {eventID: '{{ $event_id_search }}'});

window.dataLayer = window.dataLayer || [];
dataLayer.push({
 event: 'search',
 event_id: '{{ $event_id_search }}',
 
});
</script>
<section class="Villas">
    <div class=" containerindex">
        <div class="Villas-filter flex a-i-c">
            <p>Toplam {{$count}} adet tesis listelendi.</p>
            @php
            $parametre=\App\Helpers\Helper::parametreTemizle(Request::getQueryString());
        @endphp
<form style="" class="Filtre-form">
<div class="Villas-filter-item  ml-auto" @if(Agent::isDesktop()) style="" @endif>
               
    <select name="area" autocomplete="off" class="selectpicker"
    onchange="this.form.submit()" id="v_filter" >
            <option value="0">Bölge Seçiniz</option>
            @foreach($areas as $area)
            <option value="{{ $area->id }}" @if($req->area== $area->id) selected="selected" @endif>{{ $area->name }}</option>

            @endforeach
    </select>
    <svg class="icon icon-caret-down addon">
        <use xlink:href="#icon-caret-down"></use>
    </svg>
    <svg class="icon icon-caret-down addon">
        <use xlink:href="#icon-caret-down"></use>
    </svg>
</div>
<div class="Villas-filter-item" @if(Agent::isDesktop()) style="" @endif>
               
    <select name="district" autocomplete="off" class="selectpicker"
    onchange="this.form.submit()" id="v_filter" >
            <option value="0">Alt Bölge Seçiniz</option>
            @foreach($districts as $district)
            <option value="{{ $district->id }}" @if($req->district== $district->id) selected="selected" @endif>{{ $district->name }}</option>

            @endforeach
    </select>
    <svg class="icon icon-caret-down addon">
        <use xlink:href="#icon-caret-down"></use>
    </svg>
    <svg class="icon icon-caret-down addon">
        <use xlink:href="#icon-caret-down"></use>
    </svg>
</div>

<div class="Villas-filter-item " @if(Agent::isDesktop())  @endif>
               
    <select name="price" autocomplete="off" class="selectpicker"
    onchange="this.form.submit()" id="v_filter" >
            <option value="0" @if(!isset($req->price) OR empty($req->price)) selected="selected" @endif>Fiyat Aralığı</option>
            <option value="1500"  @if($req->price=="1500") selected="selected" @endif>Gecelik 500-1500₺</option>
            <option value="3000" @if($req->price=="3000") selected="selected" @endif>Gecelik 1500-3000₺</option>
            <option value="5000" @if($req->price=="5000") selected="selected" @endif>Gecelik 3000-5000₺</option>
            <option value="5000+" @if($req->price=="5000+") selected="selected" @endif>Gecelik 5000₺ Üzeri</option>
    </select>
    <svg class="icon icon-caret-down addon">
        <use xlink:href="#icon-caret-down"></use>
    </svg>
    <svg class="icon icon-caret-down addon">
        <use xlink:href="#icon-caret-down"></use>
    </svg>
</div>
             
             
          
            <div class="Villas-filter-item" style="margin-right: 0">
               
                <select name="siralama" autocomplete="off" class="selectpicker"
                onchange="this.form.submit()" id="v_filter">
                    <option value="0"
                            @if(!isset($req->siralama) OR empty($req->siralama)) selected="selected" @endif >Sıralama Şeklini Seçiniz</option>
                    <option value="artan"
                            @if($req->siralama=="artan") selected="selected" @endif >Artan Fiyat</option>
                    <option value="azalan"
                            @if($req->siralama=="azalan") selected="selected" @endif >Azalan Fiyat</option>
                </select>
                <svg class="icon icon-caret-down addon">
                    <use xlink:href="#icon-caret-down"></use>
                </svg>
                <svg class="icon icon-caret-down addon">
                    <use xlink:href="#icon-caret-down"></use>
                </svg>
            </div>
            <input type="hidden" name="kisi_sayisi" value="{{ $req->kisi_sayisi}}"/>
</form>
        </div>

        @if(Agent::isDesktop())
            <div class="Villas-in flex wrap desktop">
                @forelse($villas as $villa)
                    @php
                    
                        if(!empty($villa->tag["color"])){
                            $badge="<div class='Badge' style='background-color:".$villa->tag["color"]."'>
                            <span>".$villa->tag["name"]."</span> </div>";
                        }else{
                            $badge="";
                        }
                    @endphp
                    <div class="P_villas-item item-3   flex">
                        {!! $badge !!}
                        <div class="On-odeme">
                            <p class="On-odeme-yuzde">%<b>20</b></p>
                            <p class="On-odeme-text">Şimdi Öde<span>Kalanı</span>Girişte Öde!</p>
                        </div>
                        <div class="P_villas-img ">
                            <a href="{{ url($villa->seo_url) }}" class="global_link"></a>
                            
                            <img src="{{ url($villa->resim) }}" class="w-100" alt="{{ $villa->name }}">


                        </div>
                        <div class="P_villas-info">
                <a href="{{ url($seo_url) }}" class="global_link"></a>
                <div class="P_villas-info-kod">
                    <p>{{ $villa->name }}</p>
                    <span>Villa Kodu: {{ $website->prefix }}{{ $villa->code }}</span>
                </div>
                    <div class="P_villas-info-people">
                        <p><b>2</b> Kişi /  En Az <b>4</b> Gece</p>
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
                    <div class="info takvim">
                        <svg class="icon icon-new-calendar" data-original-title="" title="">
                            <use xlink:href="#icon-new-calendar"></use>
                        </svg>
                        <span><b>Takvimi Güncel!</b></span>
                    </div>
                </div>
                <div class="P_villas-info-money">
                    <svg class="icon icon-wallet ">
                        <use xlink:href="#icon-wallet"></use>
                    </svg>
                    <div class="flex-column">

                        <span>{{ $staticData['gun_farki'] }} GECE</span>
                                        <p>{{ $staticData['start_date'] }} - {{ $staticData['end_date'] }}</p>
                                        <h6>{{number_format((float)$villa->toplam, 0, ',', '.')}} ₺</h6>
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
                    <script type="text/javascript">
                        window.location = "/villa-bulunamadi";
                    </script>
                @endforelse
            </div>


        @elseif(Agent::isMobile())
            @forelse($villas as $villa_mobile)
                @php
                   
                    if(!empty($villa_mobile->tag["color"])){
                                $badge="<div class='Badge' style='background-color: ".$villa_mobile->tag["color"]."'>
                                <span>".$villa_mobile->tag["name"]."</span> </div>";
                            }else{
                                $badge="";
                            }
                @endphp
                <div class="VillasM flex wrap mobile">
                    <div class="f_item">
                        @if(isset($seo))
                            <a href="{{ url($villa_mobile->seo_url) }}" class="global_link"></a>
                        @endif
                        <div class="f_item-image">
                            {!! $badge !!}
                            <a href="{{ url($villa_mobile->seo_url) }}" class="global_link"></a>

                            <img src="{{ url($villa_mobile->resim)}}" class="w-100" alt="{{ $villa_mobile->name }}">
                            <p class="f_item-kod flex-column"><span>{{ $website->prefix }}{{ $villa_mobile->code }}</span>{{ $villa_mobile->name }}</p>
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
                                    <h6>{{ $villa_mobile->toplam}} ₺</h6>
                                    <p>{{ $staticData['gun_farki'] }} GECE</p>
                                    <span>{{ $staticData['start_date'] }} - {{ $staticData['end_date'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                Henüz Villa Eklenmedi
            @endforelse
        @endif
        <nav class="flex j-c-c">
            {!! $pagination !!}
        </nav>
    </div>
</section>
@endsection

