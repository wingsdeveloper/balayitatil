@extends('layouts.app')
@push('extrahead')

<script>

    const countdown = () => {
        const countDate = new Date("{{ \Carbon\Carbon::parse($rez->updated_at->addHours(12))->format('M d, Y H:i:s') }} ").getTime();

        const currentTime = new Date().getTime();

        const gap = countDate - currentTime;

        const millisecond = 1;
        const second = millisecond * 1000;
        const minutes = second * 60;
        const hour = minutes * 60;
        const day = hour * 24;


        const textHour = Math.floor((gap % day) / hour);
        const textMinutes = Math.floor((gap % hour) / minutes);
        const textSecond = Math.floor((gap % minutes) / second);
        const textMillisecond = Math.floor((gap % second) / millisecond);


        document.querySelector('.hour').innerText = textHour;
        document.querySelector('.minutes').innerText = textMinutes;
        document.querySelector('.seconds').innerText = textSecond;
        document.querySelector('.miliSeconds').innerText = textMillisecond;

    };

    setInterval(countdown, 250);
</script>
<!-- counter js -->


<!-- copy js -->
<script>
    function CopyToClipboard(id)
    {
        var r = document.createRange();
        r.selectNode(document.getElementById(id));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(r);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
    }
</script>
<!-- copy js -->
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
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <section class="Rez-finish ">
        <div class="Rez-finish-ok flex-column a-i-c" style="width: 100%">
            <svg class='icon icon-yes'><use xlink:href='#icon-yes'></use></svg>
            <p class="Rez-finish-ok-code"><span>{{$rez->code}}</span> Rezervasyon kodu ile</p>
            <h1 class="Rez-finish-ok-header">Rezervasyonunuz Tamamlanmıştır. <br>
                Lütfen ödeme yapınız.</h1>

            <p class="Rez-finish-ok-desc">{{ \Carbon\Carbon::parse($rez->updated_at->addHours(12))->formatLocalized('%d %B %Y %H:%m') }} (İstanbul yerel saati) tarihine kadar Öde&Tatilini Yap.</p>

            <div class="Rez-examination">
                <div class="Rez-examination-finish">
                    <h4 class="Rez-examination-finish-header">Ödeme için kalan süre</h4>
                    <div class="Rez-examination-countdown">
                        <div class="Rez-examination-countdown-item">
                            <h6 class="hour">Time</h6>
                            <p>Saat</p>
                        </div>
                        <div class="Rez-examination-countdown-item">
                            <h6 class="minutes">Time</h6>
                            <p>Dakika</p>
                        </div>
                        <div class="Rez-examination-countdown-item">
                            <h6 class="seconds">Time</h6>
                            <p>Saniye</p>
                        </div>

                    </div>
                </div>

                <div class="Rez-examination-info">
                    <h5 class="Rez-examination-info-header">EFT Bilgileri</h5>

                    <div class="Rez-examination-info-item">
                        <div class="Rez-examination-info-item-left">
                            <h6>EFT Kodu</h6>
                        </div>
                        <div class="Rez-examination-info-item-right">
                            <button id="copy" onclick="CopyToClipboard('copy');return false;"
                                    class="Rez-examination-code" type="button">{{$rez->code}}</button>
                            <div class="Rez-examination-info-item-right-in">
                                <p>
                                    (Bu Kodu EFT açıklama bölümüne mutlaka yazmalısınız.)
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="Rez-examination-info-item">
                        <div class="Rez-examination-info-item-left">
                            <h6>Ödemeniz  Gereken Tutar</h6>
                        </div>
                        <div class="Rez-examination-info-item-right">
                            <h3> {{ $gunlukFiyat[5] }} </h3>
                            <div class="Rez-examination-info-item-right-in">
                                <p>
                                    ( Lütfen belirtilen tutarı ekranda görüldüğü biçimde, küsuratlarıyla transfer edin.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="Rez-examination-info-item">
                        <div class="Rez-examination-info-item-left">
                            <h6>Alıcı Adı</h6>
                        </div>
                        <div class="Rez-examination-info-item-right">
                            <div class="Rez-examination-info-item-right-in">
                                <p>
									<b>Wings Seyahat Turizm sanayi ve Ticaret Ltd.Şti</b> <br/>
									( Lütfen alıcı adının doğruluğunu kontrol edin. Aksi takdirde ödemeniz firma hesabımıza
                                    ulaşmayabilir.)
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="Rez-examination-info-item">
                        <div class="Rez-examination-info-item-left">
                            <h6>Banka Bilgisi</h6>
                        </div>
                        <div class="Rez-examination-info-item-right">
                            <div class="Rez-examination-info-item-right-in">
                            <p><b>TRY Hesabı</b> TR65 0006 2001 3680 0006 2986 81 </p>
                <br/>
                <p><b>USD Hesabı</b> TR40 0006 2001 3680 0009 0970 96 (SwiftKodu: TGBATRISXXX) </p>
                <br/>
                <p><b>EURO Hesabı</b> TR67 0006 2001 3680 0009 0970 95 (SwiftKodu: TGBATRISXXX) </p>
                            </div>
                        </div>
                    </div>


                </div>
               <span style="display:none;"> <input type="submit" class="Rez-left-gonder " style="" value="HAVALE BİLDİRİMİ YAP"></span>

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
