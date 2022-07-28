

@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">

@endsection
@section('content')
@php


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.infoset.app/v1/deals?Name='. $code .'&additionalProp1[op]=0&additionalProp1[val]=string&additionalProp2[op]=0&additionalProp2[val]=string&additionalProp3[op]=0&additionalProp3[val]=string');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'X-Api-Key: 418a190c-ebae-4d1c-bee3-cf9395b141ee';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$result = json_decode($result);
$rezinfoset = ($result->items)[0]->id;
$cusinfoset = ($result->items)[0]->contactId;

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

// echo json_encode($result);

//error_reporting(E_ALL);

//echo $rezinfoset;

// Ödeme alındı bilgisi gönderiyoruz 

$postData=[ "notes" =>"success"];  
               
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.infoset.app/v1/deals/'. $rezinfoset .'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'X-Api-Key: 418a190c-ebae-4d1c-bee3-cf9395b141ee';
$headers[] = 'Content-Type: application/json-patch+json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
   echo 'Error:' . curl_error($ch);
}
curl_close($ch);
// echo json_encode($result);


@endphp
<section class="Rez-finish ">
        <div class="Rez-finish-ok flex-column a-i-c" style="width: 100%">
            <svg class='icon icon-yes'><use xlink:href='#icon-yes'></use></svg>
            <p class="Rez-finish-ok-code"><span>{{$code}}</span> Rezervasyon kodu ile</p>
            <h1 class="Rez-finish-ok-header">Ödemeniz başarı ile alındı. <br>
                Rezervasyonunuz tamamlanmıştır.</h1>



        </div>
    </section>


@endsection


