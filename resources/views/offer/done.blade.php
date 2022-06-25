@php
$curl = curl_init();
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$event_id_lead = random_int(10000000000, 99999999999);
$ph = hash('sha256',$customer->phone);
$fn = hash('sha256',$customer->name);
$em = hash('sha256',$customer->email);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v13.0/1757769984530411/events',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('data' => '[{"event_name": "Lead","event_id": "' . $event_id_lead . '","event_time": "' . time() .'","event_source_url": "'. $actual_link .'", "user_data": {"client_ip_address": "' . $fb_ip . '","ph" : "' . $ph . '","fn" : "' . $fn . '","em" : "' . $em . '","client_user_agent": "' . $_SERVER['HTTP_USER_AGENT'] . '"},"custom_data": {"content_name": "' . $reservation->villa->name . '","content_type": "product","currency": "TRY","value": "' . $value_final . '","order_id": "' . $reservation->code . '","content_id": "' . $reservation->villa_id . '"}}]','access_token' => 'EAAHTPiGDALEBAEcNNXC1nNAXJDI4V2r1hnaSlKvSH0TgWcoFPBzKGtKGZABzUVuszLurTdQ9qZBSunk0PZCqzVI73s07w2s5ZA2YgVaFl6ZCREl8buwcpAwC3bgZAWiVVegefRultu8o3Bx5nEJe6WYZC0RyNpZCR1ZA7bZALHsF8SDMsAL6WQQVd9JEwVSRuhx58ZD','test_event_code' => 'TEST50377'),
));

$response = curl_exec($curl);

curl_close($curl);



@endphp


@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
<style>
  .check_mark {
    width: 80px;
    height: 130px;
    margin: 0 auto;
  }
  .hide{
    display:none;
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
    border-color: transparent\9;
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
  @keyframes animateSuccessTip {
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

  @keyframes animateSuccessLong {
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
  @keyframes rotatePlaceholder {
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

<script>

fbq('init', '1757769984530411', {
    ph: '{{ $ph }}',
    fn: '{{ $fn }}',
    em: '{{ $em }}' });
fbq('track', 'Lead', {}, {eventID: '{{ $event_id_lead }}'});


window.dataLayer = window.dataLayer || [];

dataLayer.push({
 event: 'lead',
 event_id: '{{ $event_id_lead }}',
 musteri_adi: '{{ $fn }}',
 musteri_telefon: '{{ $ph }}',
 musteri_mail: '{{ $em }}',
 
});
</script>
<section class="Rez-finish guttert">
  <div class="Rez-finish-ok flex-column a-i-c">
    {!!  $bilgi[99]  !!}
    <h1 class="header-md">{{ $bilgi[0] }}</h1>
    <p class="Rez-finish-ok-info1">{{ $bilgi[1] }}</p>
    <h6 class="Rez-finish-ok-info2" >{{ $bilgi[2] }}</h6>
    <a href="#myModal" data-toggle="modal"><span class="Rez-finish-ok-no">+{{ $customer->phone }}</span>
      <span>Değiştir</span></a>
    <div class="Rez-finish-ok-links flex a-i-c">
    <a href="{{ url('/') }}" class="buton_orange">TAMAM</a>
  </div>
  </div>
</section>

 <!-- Modal -->
<div class="modal fade guttert" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      
      <div class="modal-body">

       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

<div class="embed-responsive ">
  <h5>Telefon Numaranızı Değiştirin</h5>
  <br>
  <form method="post" action="">
    @csrf
<input type="hidden" name="customer_type" value="{{ $offerRequest->customer_type }}">
<input type="hidden" name="customer" value="{{ $customer->id }}">
<input type="hidden" name="offerRequest" value="{{ $offerRequest->id }}">
<input type="tel" minlength="9" pattern="\d+" maxlength="15" required="required" placeholder="Telefon Numaranız" name="phone" value="{{ $customer->phone }}">
<input type="submit" value="Değiştir">
</form>
</div>

      </div>

    </div>
  </div>
</div> 

@endsection
