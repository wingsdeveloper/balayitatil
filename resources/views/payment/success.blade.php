

@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">

@endsection
@section('content')
<section class="Rez-finish ">
        <div class="Rez-finish-ok flex-column a-i-c" style="width: 100%">
            <svg class='icon icon-yes'><use xlink:href='#icon-yes'></use></svg>
            <p class="Rez-finish-ok-code"><span>{{$code}}</span> Rezervasyon kodu ile</p>
            <h1 class="Rez-finish-ok-header">Ödemeniz başarı ile alındı. <br>
                Rezervasyonunuz tamamlanmıştır.</h1>



        </div>
    </section>


@endsection


