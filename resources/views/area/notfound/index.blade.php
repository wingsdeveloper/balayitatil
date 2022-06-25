<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    @include('layouts.head')
    @push('extrahead')
@include('layouts.criteo_view')
@endpush
</head>
@include('layouts.svg')
<body>
<main id="main">
    @include('villa.notfound.header')
    <section class="Villa_not guttert">
        <div class="container">
            <div class="Villa_not-in flex-column a-i-c">
                <svg class="icon icon-agly"><use xlink:href="#icon-agly"></use></svg>

                <p class="header-md text-center">BELİRTTİĞİNİZ TARİHLER ARASINDA
                    <br>  KRİTERLERİNİZE UYGUN VİLLA BULAMADIK. </p>

                <p class="text-gri">
                    <span>Dilerseniz</span><br>
                    Müşteri temsilcimiz sizlere farklı alternatifler konusunda<br>
                    <strong>telefon ile destek verebilir.</strong>
                </p>

                <form action="" >
                    <div class="R_talep-right-form-item">
                        <input type="text" class="form-control" placeholder="İsim Soyisim">
                    </div>
                    <div class="R_talep-right-form-item dropdown-flag">
                        <input type="number" class="form-control" placeholder="Telefon Numaranız">
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button"  data-toggle="dropdown" >
                                <img src="{{ asset('images/flag.png') }}" alt="">
                            </button>
                            <div class="dropdown-menu" >
                                <a class="dropdown-item" href="#"><img src="{{ asset('images/flag.png') }}" alt="">Germany</a>
                                <a class="dropdown-item" href="#"><img src="{{ asset('images/flag.png') }}" alt="">Germany</a>
                                <a class="dropdown-item" href="#"><img src="{{ asset('images/flag.png') }}" alt="">Germany</a>

                            </div>
                        </div>
                    </div>
                    <input type="submit" class="buton_orange p-0 mx-auto" value="GÖNDER">
                </form>

            </div>
        </div>
    </section>
</main>
</body>
</html>
