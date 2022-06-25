

@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">

@endsection
@section('content')
<section class="Rez-finish " style="margin-top: 50px;">
        <div class="Rez-finish-ok flex-column a-i-c" style="width: 100%">
            <svg class='icon icon-sad'><use xlink:href='#icon-no'></use></svg>
            <p class="Rez-finish-ok-code"><span>{{$code}}</span> Rezervasyon kodu ile</p>
            <h1 class="Rez-finish-ok-header">Ödemeniz başarısız olmuştur.</h1>
            <p >{{$error_message}}</p><br>
            <a class="btn btn-success" href="{{ route('odemeYap',['code' =>$code])}}">Tekrar Deneyiniz</a>



        </div>
    </section>


@endsection


