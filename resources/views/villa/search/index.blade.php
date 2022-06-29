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
    <section style="position: unset!important" class="Villas" id="Villas-list"
         @if(!isset($req->siralama) OR empty($req->siralama)) data-order-by="" @endif
         @if($req->siralama=="artan") data-order-by="artan" @endif
         @if($req->siralama=="azalan") data-order-by="azalan" @endif
         data-is-desktop="{{ Agent::isDesktop() ? 'desktop' : 'non-desktop'}}"
         data-search-route="{{ route('search.alter') }}"
         data-area="{{ $req->bolge }}"
         data-mahalle="{{ $req->mahalle }}"
         data-person="{{ $kisi_sayisi  }}"
         data-fiyat="{{ $req->fiyat }}"
         data-start-date="{{ date('Y-m-d', strtotime($req->giris_tarih)) }}"
         data-end-date="{{ date('Y-m-d', strtotime($req->cikis_tarih)) }}"
         data-active-page="{{ request()->sayfa ?? 1 }}"
         data-categories="{{ implode(',', \App\Helpers\Helper::searchHelper(request()->category)->toArray()) }}">

    </section>
@endsection

