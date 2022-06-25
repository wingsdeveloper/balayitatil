@extends('layouts.app')
@section('content')
    <section class="Notfound">
        <div class="container">
            <div class="Notfound-in flex wrap a-i-c">
                <div class="Notfound-left">
                    <h1>404</h1>
                    <p><strong>Üzgünüz, </strong>Sayfa bulunamadı</p>
                </div>
                <div class="Notfound-right">
                    <img src="{{ asset('images/not.png') }}" class="w-100" alt="">
                </div>
                <a href="{{ url('/') }}" class="Notfound-link buton_orange pos-ab-x-center p-0">ANASAYFAYA GİT</a>
            </div>
            <div class="Notfound-404">
                <img src="{{ asset('images/404.svg') }}" class="  " alt="">
            </div>
        </div>
    </section>
@endsection