@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    <section class="Villa_not">
        <div class="container">
            <div class="Villa_not-in flex-column a-i-c mt-5">
                <svg class="icon icon-agly"><use xlink:href="#icon-agly"></use></svg>

                <p class="header-md text-center">BELİRTTİĞİNİZ TARİHLER ARASINDA
                    <br>  KRİTERLERİNİZE UYGUN VİLLA BULAMADIK.
                </p>
                <p class="text-center ">
                    Seçtiğiniz kriterleri azaltabilir ya da konaklama süresini uzatarak(en az 5 gece) tekrar arama yapabilirsiniz
                    <br>veya sayfada bulunan WhatsApp butonuna tıklayarak ekibimizden canlı yardım alabilirsiniz.
                </p>
                <br>
                <a href="{{ url('/') }}" class="buton_orange p-0 mx-auto mt-2" >
                    Anasayfaya Dön
                </a>
                <a href="{{ url('/yaklasan-firsatlar') }}" class="buton_orange p-0 mx-auto mt-2" >
                    Yaklaşan Fırsatları Görüntüle
                </a>

                {{--<p class="text-gri">--}}
                {{--<span>Dilerseniz</span><br>--}}
                {{--Müşteri temsilcimiz sizlere farklı alternatifler konusunda<br>--}}
                {{--<strong>telefon ile destek verebilir.</strong>--}}
                {{--</p>--}}



                {{--<form action="" >--}}
                {{--<div class="R_talep-right-form-item">--}}
                {{--<input type="text" class="form-control" placeholder="İsim Soyisim">--}}
                {{--</div>--}}
                {{--<div class="R_talep-right-form-item dropdown-flag">--}}
                {{--<input type="number" class="form-control" placeholder="Telefon Numaranız">--}}
                {{--<div class="dropdown">--}}
                {{--<button class="dropdown-toggle" type="button"  data-toggle="dropdown" >--}}
                {{--<img src="{{ asset('images/flag.png') }}" alt="">--}}
                {{--</button>--}}
                {{--<div class="dropdown-menu" >--}}
                {{--<a class="dropdown-item" href="#"><img src="{{ asset('images/flag.png') }}" alt="">Germany</a>--}}
                {{--<a class="dropdown-item" href="#"><img src="{{ asset('images/flag.png') }}" alt="">Germany</a>--}}
                {{--<a class="dropdown-item" href="#"><img src="{{ asset('images/flag.png') }}" alt="">Germany</a>--}}

                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<input type="submit" class="buton_orange p-0 mx-auto" value="GÖNDER">--}}
                {{--</form>--}}

            </div>
        </div>
    </section>
@endsection

