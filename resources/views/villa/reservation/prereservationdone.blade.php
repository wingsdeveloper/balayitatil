@php

$curl = curl_init();
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$value_final = number_format($reservation->total_price, 2, ".", "");
$ph = hash('sha256',$reservation->customer_real->phone);
$fn = hash('sha256',$reservation->customer_real->name);
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$event_id_search = random_int(1000000000000, 9999999999999);
session_start();   
$s_id = session_id();

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
      "event_name": "Purchase",
      "event_id": "' . $reservation->code . '",
      "event_time": "' . time() .'",
      "event_source_url": "'. $actual_link .'",
      "user_data": {
          "client_ip_address": "' . $fb_ip . '",
          "ph" : "' . $ph . '",
          "fn" : "' . $fn . '",
          "client_user_agent": "' . $user_agent . '",
          "external_id" : "'. $s_id . '"
      },
      "custom_data": {
          "content_name": "' . $reservation->villa->name . '",
          "content_type": "product",
          "currency": "TRY",
          "value": "' . $value_final . '",
          "order_id": "' . $reservation->code . '",
          "content_ids": "' . $reservation->villa_id . '"
        }}]',
        
        'access_token' => 'EAAHTPiGDALEBANKENo2ZAPSKmLeN0opQJsrrQdmeUyANnci2JKxLdpi7ZAPnfwwZA1VLWdP6UVf48N1MWo9l2fQ5CbZA0ZAJ487F18aZCsTpo5Mgpy6hZCiq0E6mZCuLLEnrCvSm2vty3KKQPFHUasZBLWqmsLi6SWZCsUg0mQr98ne7G9WvojsLUc','test_event_code' => 'TEST50377'),
));

$response = curl_exec($curl);

curl_close($curl);



@endphp


@extends('layouts.app')
 

@section('content')

 <!-- Criteo Sales Tag -->
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
    { event: "setAccount", account: 46955 },
    { event: "setEmail", email: "", hash_method: "" },
    { event: "setSiteType", type: deviceType},
    { event: "setZipcode", zipcode: "" },
    { event: "trackTransaction", id: "{{ $reservation->code }}", item: [
            {id: "{{ $reservation->villa_id }}", price: "{{ $value_final }}", quantity: "1" }
            //add a line for each additional line in the order
    ]}
);
</script>
<!-- END Criteo Sales Tag -->


<script>
window.dataLayer = window.dataLayer || [];
fbq('init', '3420393284913528', {
    ph: '{{ $ph }}',
    fn: '{{ $fn }}',
    external_id:'{{ $s_id }}' });
fbq('track', 'Purchase', {
    value: '{{ $value_final }}',
    currency: 'TRY',
    content_name:'{{ $reservation->villa->name}}',
    order_id: '{{$reservation->code}}',
    content_type:'product',
    content_ids: ["{{ $reservation->villa_id }}"],
}, {eventID: '{{ $reservation->code }}'});


dataLayer.push({
 event: 'purchase',
 id: '{{ $reservation->villa_id }}',
 event_id: '{{ $event_id_purchase }}',
 vila_adi: '{{ $reservation->villa->name}}',
 rezervasyon_kodu: '{{$reservation->code}}',
 musteri_adi: '{{ $fn }}',
 musteri_telefon: '{{ $ph }}',
 start_date: '{{ date('Y-m-d', strtotime($reservation->start_date)) }}',
 end_date: '{{ date('Y-m-d', strtotime($reservation->end_date)) }}',
 currency: "TRY",
 rezervasyon_tutar: '{{ $value_final }}'
});
</script>

    <!-- END Criteo Sales Tag -->
    <!-- counter js -->
<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<style>
        .check_mark {
            width: 80px;
            height: 130px;
            margin: 0 auto;
        }

        .hide {
            display: none;
        }

        .sa-icon {
            width: 80px;
            height: 80px;
            border: 4px solid gray;
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50%;
            margin: 20px auto;
            padding: 0;
            position: relative;
            box-sizing: content-box;
        }

        .sa-icon.sa-success {
            border-color: #4CAF50;
        }

        .sa-icon.sa-success::before, .sa-icon.sa-success::after {
            content: '';
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50%;
            position: absolute;
            width: 60px;
            height: 120px;
            background: white;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .sa-icon.sa-success::before {
            -webkit-border-radius: 120px 0 0 120px;
            border-radius: 120px 0 0 120px;
            top: -7px;
            left: -33px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 60px 60px;
            transform-origin: 60px 60px;
        }

        .sa-icon.sa-success::after {
            -webkit-border-radius: 0 120px 120px 0;
            border-radius: 0 120px 120px 0;
            top: -11px;
            left: 30px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 0px 60px;
            transform-origin: 0px 60px;
        }

        .sa-icon.sa-success .sa-placeholder {
            width: 80px;
            height: 80px;
            border: 4px solid rgba(76, 175, 80, .5);
            -webkit-border-radius: 40px;
            border-radius: 40px;
            border-radius: 50%;
            box-sizing: content-box;
            position: absolute;
            left: -4px;
            top: -4px;
            z-index: 2;
        }

        .sa-icon.sa-success .sa-fix {
            width: 5px;
            height: 90px;
            background-color: white;
            position: absolute;
            left: 28px;
            top: 8px;
            z-index: 1;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        .sa-icon.sa-success.animate::after {
            -webkit-animation: rotatePlaceholder 4.25s ease-in;
            animation: rotatePlaceholder 4.25s ease-in;
        }

        .sa-icon.sa-success {
            border-color: transparent \9;
        }

        .sa-icon.sa-success .sa-line.sa-tip {
            -ms-transform: rotate(45deg) \9;
        }

        .sa-icon.sa-success .sa-line.sa-long {
            -ms-transform: rotate(-45deg) \9;
        }

        .animateSuccessTip {
            -webkit-animation: animateSuccessTip 0.75s;
            animation: animateSuccessTip 0.75s;
        }

        .animateSuccessLong {
            -webkit-animation: animateSuccessLong 0.75s;
            animation: animateSuccessLong 0.75s;
        }

        @-webkit-keyframes animateSuccessLong {
            0% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            84% {
                width: 55px;
                right: 0px;
                top: 35px;
            }
            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }

        @-webkit-keyframes animateSuccessTip {
            0% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }
            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }
            100% {
                width: 25px;
                left: 14px;
                top: 45px;
            }
        }

        @keyframes  animateSuccessTip {
            0% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }
            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }
            100% {
                width: 25px;
                left: 14px;
                top: 45px;
            }
        }

        @keyframes  animateSuccessLong {
            0% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            84% {
                width: 55px;
                right: 0px;
                top: 35px;
            }
            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }

        .sa-icon.sa-success .sa-line {
            height: 5px;
            background-color: #4CAF50;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 2;
        }

        .sa-icon.sa-success .sa-line.sa-tip {
            width: 25px;
            left: 14px;
            top: 46px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .sa-icon.sa-success .sa-line.sa-long {
            width: 47px;
            right: 8px;
            top: 38px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        @-webkit-keyframes rotatePlaceholder {
            0% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            5% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            12% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
            100% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
        }

        @keyframes  rotatePlaceholder {
            0% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            5% {
                transform: rotate(-45deg);
                -webkit-transform: rotate(-45deg);
            }
            12% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
            100% {
                transform: rotate(-405deg);
                -webkit-transform: rotate(-405deg);
            }
        }
    </style>
    <section class="Rez-finish ">
        <div class="Rez-finish-ok flex-column a-i-c" style="width: 100%">
            <svg class='icon icon-yes'><use xlink:href='#icon-yes'></use></svg>
            <p class="Rez-finish-ok-code"><span>{{ $code}}</span> Rezervasyon kodu ile</p>
            <h1 class="Rez-finish-ok-header">Ön Rezervasyon talebiniz alınmıştır.</h1>

            <p class="Rez-finish-ok-desc">Satış ekibimiz tesisle ilgili son kontrolleri yapıp
                sms veya telefonla size geri dönüş sağlayacaktır.</p>

        </div>
    </section>
@endsection
