@extends('layouts.app')
@push('extrahead')
    <!-- Yandex.Metrika counter -->
    {{--<script type="text/javascript" >--}}
    {{--   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};--}}
    {{--   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})--}}
    {{--   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");--}}

    {{--   ym(51957467, "init", {--}}
    {{--        id:51957467,--}}
    {{--        clickmap:true,--}}
    {{--        trackLinks:true,--}}
    {{--        accurateTrackBounce:true,--}}
    {{--        webvisor:true--}}
    {{--   });--}}
    {{--</script>--}}
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/51957467" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Criteo Sales Tag -->
    <script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
    <script type="text/javascript">
        window.criteo_q = window.criteo_q || [];
        var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
        window.criteo_q.push(
            {event: "setAccount", account: 46955}, // You should never update this line
            {event: "setEmail", email: ""},
            {event: "setSiteType", type: deviceType},
            {
                event: "viewSearch",
                checkin_date: "{{ date('Y-m-d', strtotime($reservation->start_date)) }}",
                checkout_date: "{{ date('Y-m-d', strtotime($reservation->end_date)) }}"
            },
            {
                event: "trackTransaction", id: "{{ $reservation->code }}", item: [
                    {
                        id: "{{ $reservation->villa_id }}",
                        price: {{ number_format($reservation->total_price, 2, '.', '') }},
                        quantity: 1
                    }
                    //add a line for each additional line in the basket
                ]
            }
        );
    </script>
    <!-- END Criteo Sales Tag -->

@endpush



@section('content')
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
    <section class="Rez-finish guttert">
        <div class="Rez-finish-ok flex-column a-i-c" style="width: 100%">
            {!!  $bilgi[99]  !!}
            <h1 class="header-md">{{ $bilgi[0] }}</h1>
            <h1 class="header-md" style="
    font-size: 14px;
">Her villamızın farklı giriş ve çıkış günleri olması nedeniyle tarihlerde boşluk bırakılmadan kiralama yapılmaktadır. Seçtiğiniz tarihlerin uygunluğu ile ilgili lütfen yetkililerimizden teyit alınız.</h1>
            <p class="Rez-finish-ok-info1">{{ $bilgi[1] }}</p>
            <h6 class="Rez-finish-ok-info2">{{ $bilgi[2] }}</h6>
            <a href="#myModal" data-toggle="modal"><span class="Rez-finish-ok-no">+{{ $customer->phone }}</span>
                <span>Değiştir</span></a>
            <div class="Rez-finish-ok-links flex a-i-c">
                <a href="{{ url($seo_url) }}" class="buton_orange">GERİ</a>
                <a href="{{ url('/') }}" class="buton_orange">TAMAM</a>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade guttert" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive ">
                        <h5>Telefon Numaranızı Değiştirin</h5>
                        <br>
                        <form method="post" action="">
                            @csrf
                            <input type="hidden" name="customer_type" value="{{ $reservation->customer_type }}">
                            <input type="hidden" name="customer" value="{{ $customer->id }}">
                            <input type="hidden" name="reservation" value="{{ $reservation->id }}">
                            <input type="tel" minlength="9" maxlength="15" required="required"
                                   placeholder="Telefon Numaranız" name="phone" value="{{ $customer->phone }}">
                            <input type="submit" value="Değiştir">
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div>

@endsection
