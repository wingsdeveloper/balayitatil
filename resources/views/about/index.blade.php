@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    @include('layouts.criteo_view')
@endsection

@section('content')
    @include('about.slider')

    <section class="Content">
        <div class="container">
            <div class="Content-in">
                <h3 class="Content-title">Hakkımızda</h3>
                <p>Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirketi bünyesinde faaliyet göstermekte olan www.balayisepeti.com.tr ; Farklı bölgelerdeki yüzlerce tatil villası ve konaklama tesisi seçeneği ile sizlere hizmet vermektedir.
                    Sektördeki gelişmeleri ve pazardaki yeni talepleri yakından takip eden firmamız yönetimi, güçlü idari ve mali birikimi ile sektörde öncü firmalardan biri olmayı sürdürmektedir.</p>
                
                <p>TURSAB A grubu (Acente ünvanı “Villa Kalkan Turizm) seyahat acentası belgesine sahip, Kumluca Sanayi ve Ticaret Odası ile Fethiye Ticaret ve Sanayi Odasına kayıtlı Wings Seyahat Turizm Sanayi ve Ticaret Limited Şirketi olarak, deneyimli kadromuz ile ihtiyaçların doğru analizini yaparak en uygun portföyle siz değerli müşterilerimize hizmet vermekten ve birlikte çalışmaktan gurur duyarız.</p>

                <div class="Content-features">
                    <div class="Content-features-item">
                        <h4>24+ Bölge </h4>
                        <p>ile müşterlerimize Türkiye’nin
                            en güzel bölgelerinde tatil imkanı sunuyoruz.</p>
                    </div>
                    <div class="Content-features-item">
                        <h4>50.000+ Misafir</h4>
                        <p>Mutluluğumuzu; Müştelerimizin memnuniyetinden alarak, her geçen gün büyüyen bir aile
                            oluyoruz.</p>
                    </div>
                    <div class="Content-features-item">
                        <h4>1.500+ Tesis </h4>
                        <p>ile her geçen gün portföyümüzü büyütüyor ve
                            müşterlerimize zengin bir liste sunuyoruz.</p>
                    </div>


                </div>

            </div>
        </div>
    </section>

    <section class="Info">
        <div class="container">
            <div class="Info-in">
                <div class="Info-left">
                    <h3 class="new-title">Banka Bilgilerimiz</h3>

                    <div class="Info-left-in">
                        <img src="{{ asset('images/garanti-bankasi-logo.png') }}" alt="">
                        <div class="Info-left-item">
                            <span>Alıcı Ünvan</span>
                            <p>Wings Seyahat Turizm Sanayi ve Ticaret Ltd.Şti.</p>
                        </div>
                        <div class="Info-left-item">
                            <span>TL(₺) IBAN</span>
                            <p id="myInput"><input type="text" value="TR65 0006 2001 3680 0006 2986 81">
                                <button type="button" id="copy" class="button-copy"><i class="icon-copy"></i></button>
                            </p>
                        </div>
                        <hr>
                        <img src="{{ asset('images/garanti-bankasi-logo.png') }}" alt="">
                        <div class="Info-left-item">
                            <span>Alıcı Ünvan</span>
                            <p>Wings Seyahat Turizm Sanayi ve Ticaret Ltd.Şti.</p>
                        </div>
                        <div class="Info-left-item">
                            <span>EUR(€) IBAN</span>
                            <p id="myInput"><input type="text" value="TR67 0006 2001 3680 0009 0970 95">
                                <button type="button" id="copy" class="button-copy"><i class="icon-copy"></i></button>
                            </p>
                        </div>
                        <div class="Info-left-item">
                            <span>SWIFT KODU</span>
                            <p id="myInput"><input type="text" value="TGBATRISXXX">
                                <button type="button" id="copy" class="button-copy"><i class="icon-copy"></i></button>
                            </p>
                        </div>
                    </div>

                    <div class="Info-left-alert">
                        <i class="icon-alert"></i>
                        <p>Dikkat! Lütfen para transferi yaparken, onaysız işlem yapmayınız.</p>
                    </div>

                </div>
                <div class="Info-right">
                    <h3 class="new-title">Resmi belgelerimiz</h3>

                    <div class="Info-right-in">
                        <div class="Info-right-item">
                            <a href="images/belgeler/marka-tescil-1.jpeg" data-fancybox="group_1" class="global_link"></a>
                            <div class="Info-right-item-text">
                            <h5>Marka Tescil Belgesi</h5>
                            </div>
                            <div class="Info-right-item-link">
                                <p><i class="icon-info-pdf"></i>Belgeyi Görüntüle</p>
                            </div>
                            <a href="images/belgeler/marka-tescil-2.png" data-fancybox="group_1" style="display:none;"></a>
                            <a href="images/belgeler/marka-tescil-3.png" data-fancybox="group_1" style="display:none;"></a>
                        </div>
                        <div class="Info-right-item">
                            <a href="images/belgeler/tursab.jpeg" data-fancybox="group_1" class="global_link"></a>
                            <div class="Info-right-item-text">
                            <h5>TURSAB Belgesi</h5>
                            </div>
                            <div class="Info-right-item-link">
                                <p><i class="icon-info-pdf"></i>Belgeyi Görüntüle</p>
                            </div>
                        </div>
                        <div class="Info-right-item">
                            <a href="images/belgeler/vergilevhasi.png" data-fancybox="group_1" class="global_link"></a>
                            <div class="Info-right-item-text">
                                <h5>Vergi Levhası</h5>
                            </div>
                            <div class="Info-right-item-link">
                                <p><i class="icon-info-pdf"></i>Belgeyi Görüntüle</p>
                            </div>
                        </div>
                        <div class="Info-right-item">
                            <a href="images/belgeler/ticaret-sicil.jpeg" data-fancybox="group_1" class="global_link"></a>
                            <div class="Info-right-item-text">
                            <h5>Ticaret Sicil Belgesi </h5>
                            </div>
                            <div class="Info-right-item-link">
                                <p><i class="icon-info-pdf"></i>Belgeyi Görüntüle</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="Basin">
        <div class="container">
            <div class="Basin-in">
                <div class="Basin-head">
                    <h3 class="new-title">Diğer Markalarımız</h3>
                    <h2>Mutluluğumuzu; Müştelerimizin memnuniyetinden alarak, her geçen gün büyüyen bir aile oluyoruz.</h2>
                    <p>Wings Seyahat Turizm Sanayi ve Ticaret Ltd.Şti.</p>
                </div>
                <div class="Basin-content">
                    <div class="Basin-content-item">
                        <a target="_blank" href="https://villakalkan.com.tr/"><img src="images/villa-kalkan-logo.png"
                                                                          alt=""></a></div>
                 
                    <div class="Basin-content-item">
                        <a href="https://www.lycianescapes.com/"><img src="images/lyc-logo.png" alt="Diğer Markalarımız - Lycian Escapes"></a>
                    </div>
                    <div class="Basin-content-item">
                        <a href="https://otelbnb.com/"><img src="images/otelbnb-logo.png" alt="Diğer Markalarımız - Otel Bnb"></a>
                    </div>
                    <div class="Basin-content-item">
                        <a href="https://villadukkani.com/"><img src="images/villadukkani-logo.png" alt="Diğer Markalarımız - Villa Dükkanı"></a>
                    </div>
                    <div class="Basin-content-item">
                        <a href="https://www.balayivillasi.com.tr/"><img src="images/balayi-villasi-logo.svg" alt="Diğer Markalarımız - Balayı Villası"></a>
                    </div>
                    <div class="Basin-content-item">
                        <a href="https://kalkanaktivite.com/"><img src="images/kalkan-aktivite-logo.svg" alt="Diğer Markalarımız - Kalkan Aktivite"></a>
                    </div>
               
                </div>
            </div>
        </div>
    </section>

    <section class="Ofis">
        <div class="container">
            <div class="Ofis-in">
                <h3 class="new-title">Kalkan Ofis</h3>

                <div class="Ofis-content">
                    <div class="Ofis-content-item">
                    <a href="images/kalkan-ofis/1.jpg" data-fancybox="group-ofis">
                            <img src="images/kalkan-ofis/1.jpg" alt="Villa Kalkan - Kalkan Ofis">
                        </a>
                    </div>
                    <div class="Ofis-content-item">
                    <a href="images/kalkan-ofis/2.jpg" data-fancybox="group-ofis">
                            <img src="images/kalkan-ofis/2.jpg" alt="Balayı Villası - Kalkan Ofis">
                            <span class="Ofis-content-item-more"><i class="icon-gallery"></i>+6 Fotoğraf Daha</span>
                        </a>
                        <div class="Ofis-content-item-list">
                            <a href="images/kalkan-ofis/4.jpg" data-fancybox="group-ofis"></a>
                            <a href="images/kalkan-ofis/5.jpg" data-fancybox="group-ofis"></a>
                            <a href="images/kalkan-ofis/6.jpg" data-fancybox="group-ofis"></a>
                            <a href="images/kalkan-ofis/7.jpg" data-fancybox="group-ofis"></a>
                            <a href="images/kalkan-ofis/8.jpg" data-fancybox="group-ofis"></a>
                            <a href="images/kalkan-ofis/9.jpg" data-fancybox="group-ofis"></a>
                        </div>
                    </div>
                    <div class="Ofis-content-item Ofis-content-item-video">
                    <a href="https://www.youtube.com/embed/abWhzr3Y2Ow" data-fancybox>
                            <img src="images/kalkan-ofis/6.jpg" alt="Villa Kalkan - Kalkan Ofis Tanıtım Videosu">
                            <span class="Ofis-content-item-play"><i class="icon-play"></i></span>
                        </a>
                    </div>
                </div>
                <div class="Ofis-bottom">
                    <div class="Contact-support Contact-support-pink">
                        <a href="te:+902422520032">
                            <p><span>Yardım & Destek</span>+90 242 252 00 32</p>
                        </a>
                    </div>
                    <div class="Ofis-bottom-text">
                        <p>MERKEZ: Kalkan Mah. Cumhuriyet Cd. No:48/2 Kaş/Antalya</p>
                        <a href="mailto:info@villakalkan.com.tr">info@villakalkan.com.tr</a>
                    </div>
                    <a target="_blank" href="https://www.google.com/maps/dir/36.6180363,29.1450962/Kalkan,+Villa+Kalkan,+Cumhuriyet+Cd.+No:48%2F2,+07960+Ka%C5%9F%2FAntalya/@36.6180363,29.1450962,17z/data=!4m9!4m8!1m1!4e1!1m5!1m1!1s0x14c02d2a84da91fd:0x81ede568b29dcff4!2m2!1d29.4065087!2d36.2654048" class="Ofis-konum-buton">
                        <i class="icon-marker"></i>Ofise Konum Al
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="Ofis Ofis-fethiye">
        <div class="container">
            <div class="Ofis-in">
                <h3 class="new-title">Fethiye Ofis</h3>

                <div class="Ofis-content">
                    <div class="Ofis-content-item">
                    <a href="images/fethiye-ofis/1.jpg" data-fancybox="group-ofis-fethiye">
                            <img src="images/fethiye-ofis/1.jpg" alt="">
                        </a>
                    </div>
                    <div class="Ofis-content-item">
                    <a href="images/fethiye-ofis/2.jpg" data-fancybox="group-ofis-fethiye">
                            <img src="images/fethiye-ofis/2.jpg" alt="">
                            <span class="Ofis-content-item-more"><i class="icon-gallery"></i>+7 Fotoğraf Daha</span>
                        </a>
                        <div class="Ofis-content-item-list">
                            <a href="images/fethiye-ofis/3.jpg" data-fancybox="group-ofis-fethiye"></a>
                            <a href="images/fethiye-ofis/4.jpg" data-fancybox="group-ofis-fethiye"></a>
                            <a href="images/fethiye-ofis/5.jpg" data-fancybox="group-ofis-fethiye"></a>
                            <a href="images/fethiye-ofis/ofis2.jpg" data-fancybox="group-ofis-fethiye"></a>
                            <a href="images/fethiye-ofis/6.jpg" data-fancybox="group-ofis-fethiye"></a>
                            <a href="images/fethiye-ofis/7.jpg" data-fancybox="group-ofis-fethiye"></a>
                            <a href="images/fethiye-ofis/ofis1.jpg" data-fancybox="group-ofis-fethiye"></a>
                        </div>
                    </div>
                    <div class="Ofis-content-item Ofis-content-item-video">
                    <a href="https://www.youtube.com/watch?v=abWhzr3Y2Ow" data-fancybox>
                            <img src="images/fethiye-ofis/ofis1.jpg" alt="Balayı Sepeti - Fethiye Ofis Tanıtım Videosu">
                            <span class="Ofis-content-item-play"><i class="icon-play"></i></span>
                        </a>
                    </div>
                </div>
                <div class="Ofis-bottom">
                    <div class="Contact-support Contact-support-pink">
                    <a href="te:+902526060669">
                            <p><span>Yardım & Destek</span>+90 252 606 06 69</p>
                        </a>
                    </div>
                    <div class="Ofis-bottom-text">
                    <p>MERKEZ: Taşyaka Mah. Baha Şıkman Cad. N:201/A Fethiye-MUĞLA</p>
                        <a href="mailto:info@balayisepeti.com.tr">info@balayisepeti.com.tr</a>
                    </div>
                    <a target="_blank" href="https://www.google.com/maps/dir//Patlang%C4%B1%C3%A7,+Wings+Seyahat+Turizm+Limited+%C5%9Eirketi,+Baha+%C5%9E%C4%B1kman+Cd.+no:201%2FA,+48300+Fethiye%2FMu%C4%9Fla/@36.6179479,29.1427447,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x14c0436e28536a4b:0x88ef25d63cafd7f6!2m2!1d29.1452536!2d36.6179504" class="Ofis-konum-buton">
                        <i class="icon-marker"></i>Ofise Konum Al
                    </a>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('javascripts')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


    <script>
        $(".fancybox").fancybox({
            afterShow: function(){
                // fancybox is open, run myFunct()
                $('.Navtop ').css({opacity: 0, "z-index": 0});
                $('.Navbottom ').css({opacity: 0, "z-index": 0});
            },
            afterClose: function(){
                // fancybox is closed, run myOtherFunct()
                $('.Navtop ').css({opacity: 1,"z-index": 99999999});
                $('.Navbottom ').css({opacity: 1, "z-index": 99999999});
            }
        });

    </script>
@endpush

