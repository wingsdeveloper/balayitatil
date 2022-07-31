<?php

function getMonthName($month_number)
{
    $months = [
        1 => "Ocak",
        2 => "Şubat",
        3 => "Mart",
        4 => "Nisan",
        5 => "Mayıs",
        6 => "Haziran",
        7 => "Temmuz",
        8 => "Ağustos",
        9 => "Eylül",
        10 => "Ekim",
        11 => "Kasım",
        12 => "Aralık",
        "01" => "Ocak",
        "02" => "Şubat",
        "03" => "Mart",
        "04" => "Nisan",
        "05" => "Mayıs",
        "06" => "Haziran",
        "07" => "Temmuz",
        "08" => "Ağustos",
        "09" => "Eylül",
    ];

//    $month_number = strlen($month_number) == 2 ? $month_number[1] : $month_number;

    return $months[$month_number];
}

?>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="/reservation_assets/css/library/bootstrap.min.css">
    <link rel="stylesheet" href="/reservation_assets/css/library/swiper.css">
    <link rel="stylesheet" href="/reservation_assets/css/library/slick.css">
    <link rel="stylesheet" href="/reservation_assets/css/library/slick-theme.css">
    <link rel="stylesheet" href="/reservation_assets/css/library/bootstrap-select.min.css">
    <link rel="stylesheet" href="/reservation_assets/css/main.css?v=1.24vk">

    <style>
        .Rez_detail-right-header:before {
            display: none!important;
        }
    </style>
</head>

<body>

<main>
    <header class="Navbar">
        <div class="Navbar-inner">
            <div class="Navbar-top">
                <a href="" class="Navbar-logo"></a>
                {{--<a @if($reservation->villa->enterance_manager && $reservation->villa->enterance_manager_phone)
                   href="tel:{{$reservation->villa->enterance_manager_phone}}"
                   @else
                   href="tel:+90 533 718 45 52"
                   @endif class="Navbar-top-phone mobile"></a>--}}
            </div>
            <div class="Navbar-info">
{{--                <p class="Navbar-info-name">{{$reservation->villa->owner->name}}</p>--}}
                <p class="Navbar-info-day" style="z-index: 999">
                    <a style="color: white; z-index: 999;" href="{{ route('static', [$reservation->villa->seo->seo_url]) }}">{{ !empty($reservation->villa->original_name) ? $reservation->villa->original_name : $reservation->villa->name }}</a>
                </p>
            </div>
        </div>
    </header>

    <section class="Rez_detail">
        <div class="container">
            <div class="Rez_detail-inner ">
                <div class="Rez_detail-left">
                    <h6 class="Rez_detail-header Rez_detail-header-house">REZERVASYON DETAYLARI</h6>
                    <div class="Rez_detail-left-villa" @if(Agent::isMobile()) style="display: block" @endif>
                        <div class="Rez_detail-left-villa-image" @if(Agent::isMobile()) style="width: 100%" @endif>
                            @php

                                if(empty($reservation->villa->panel_villa) || empty($reservation->villa->panel_villa->list_image)){
                                    $resim="uploads/villa/gallery/{$reservation->villa->list_image}/{$reservation->villa->list_image_name}";
                                }else{
                                    $resim=$reservation->villa->panel_villa->list_image;
                                }
                            @endphp
                            @php
                                try {$villa_url=$reservation->villa->seo->seo_url;} catch(\Exception $e) {$villa_url = null;}
                            @endphp
                            @if($villa_url != null)
                                <a href="{{ route('static', [$reservation->villa->seo->seo_url]) }}">
                                    <img src="/{{$resim}}" alt="Balayı Sepeti - Rezervasyon">
                                </a>
                            @else
                                <img src="/{{$resim}}" alt="Balayı Sepeti - Rezervasyon">
                            @endif

                        </div>

                        <div class="Rez_detail-left-villa-text">
                            <p>{{$reservation->villa->name}}</p>
                            <p>

                                GİRİŞ:
                                @if(!Agent::isMobile()) <br> @endif
                                {{date("d",strtotime($reservation->start_date)) . " " . getMonthName(date("m",strtotime($reservation->start_date))) . " " . date("Y",strtotime($reservation->start_date))    }} {{$reservation->villa->checkin_time ? "(EN ERKEN {$reservation->villa->checkin_time})":""}}
                            </p>
                            <p>

                                ÇIKIŞ:
                                @if(!Agent::isMobile()) <br> @endif
                                {{date("d",strtotime($reservation->end_date)) . " " . getMonthName(date("m",strtotime($reservation->end_date))) . " " . date("Y",strtotime($reservation->end_date))    }} {{$reservation->villa->checkout_time ? "(EN GEÇ {$reservation->villa->checkout_time})":""}}
                            </p>
                            <p><br>{{$reservation->adult_count}}
                                Yetişkin {{$reservation->child_count ? "- {$reservation->child_count} Çocuk":"" }} {{$reservation->baby_count ? "- {$reservation->baby_count} Bebek":"" }}
                            </p>
                        </div>
                    </div>
                    <div class="Rez_detail-left-price">
                        <p>
                            <span>Müşteri Adı</span>
                            <span>{{ $reservation->customer->name }}</span>
                        </p>
                        <p>
                            <span>Telefonu</span>
                            <span><a style="text-align: right;color: #34c28d;" href="tel:+{{ $reservation->customer->phone }}">{{ $reservation->customer->phone }}</a></span>
                        </p>
                        <p>
                            <span>KALAN ÖDEME TUTARI</span>
                            <span>{{number_format($reservation->entry_payment,2)}}₺</span>
                        </p>
                        @if($reservation->villa->damage_deposit_amount)
                            <p><span>Villaya girişte Nakit ödenecek tutardır.Ayrıca
{{$reservation->villa->damage_deposit_amount}} TL değerinde hasar depozitosu alınacaktır.</span></p>
                        @endif
                    </div>
                </div>

                <div class="Rez_detail-right">
                    <h5 class="Rez_detail-right-header mobile">
                        ÖNEMLİ BİLGİLER
                    </h5>
                    <div class="Rez_detail-right-contact">
                        <p>
                            Müşterinizle iletişime geçip yardımcı olmanız rica olunur
                        </p>
                    </div>
                    <div class="Rez_detail-right-contact">
                        <p>
                            Kimlik bidirimi yapmayı ve misafirlerin HES kodunu kaydetmeyi unutmayınız
                        </p>
                    </div>

                    <div class="Rez_detail-right-contact">
                        <p>
                            Belirtilen hasar depozitosu ve kalan ödeme tutarınızı tahsil etmeyi unutmayınız.
                        </p>
                    </div>

                </div>


            </div>
        </div>
    </section>


</main>


<script src="/reservation_assets/js/library/jquery-3.2.1.slim.min.js"></script>
<script src="/reservation_assets/js/library/popper.min.js"></script>
<script src="/reservation_assets/js/library/bootstrap.min.js"></script>
<script src="/reservation_assets/js/library/swiper.js"></script>
<script src="/reservation_assets/js/library/slick.js"></script>
<script src="/reservation_assets/js/library/bootstrap-select.min.js"></script>
<script src="/reservation_assets/js/main.js"></script>


</body>
</html>
