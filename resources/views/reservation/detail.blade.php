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

</head>

<body>



@php

$now = date('Y-m-d'); // or your date as well
$your_date= date("Y-m-d", strtotime($reservation->start_date));  
$datediff =  $your_date - $now ;
;

$tarih1= new DateTime($now);
$tarih2= new DateTime($your_date);
$interval= $tarih1->diff($tarih2);
$fark= $interval->format('%a');





 @endphp
<main>
    <header class="Navbar">
        <div class="Navbar-inner">
            <div class="Navbar-top">
                <a href="" class="Navbar-logo"></a>
                <a @if($reservation->villa->enterance_manager && $reservation->villa->enterance_manager_phone)
                   
                    @if($fark <= 3)
                    href="tel:{{$reservation->villa->enterance_manager_phone}}"
                    @else
                    href="#"
                    @endif

                   @else
                   href="tel:+90 533 718 45 52"
                   @endif class="Navbar-top-phone mobile"></a>
            </div>
            <div class="Navbar-info">
                <p class="Navbar-info-name">SN.  {{ Transliterator::create('tr-title')->transliterate($reservation->customer->name) }}</p>
                <p class="Navbar-info-day">TATİLİNİZE <br>
                    SON {{$fark}} GÜN
         </p>


            </div>
        </div>
    </header>

    @if($fark <= 3)
 
    <section class="Person desktop">
        <div class="Person-inner">
            <div class="Person-danger">
                <p>
                    İŞLEMLERİNİZİ KOLAYLAŞTIRABİLMEK ADINA, KONAKLAYACAK KİŞİ BİLGİLERİNİ TARAFIMIZLA PAYLAŞMANIZ
                    GEREKMEKTEDİR.
                </p>
                <span>
                 NOT: Ziyaretciler 678 sayılı kanun hükmünde kararname, 22 Kasım 2016 tarihli ve 29896 sayılı Resmi Gazete de yayımlanan Kimlik Bildirme Kanununa göre;
                    Villaya girişlerden önce villada konaklayacak tüm kişilere ait uyruk, isim, soyisim ve T.C. kimlik numarası bilgilerini firmamıza bildirmek ile yükümlüdür.
                </span>
            </div>
            <div class="Person-add">
                <a href="{{route("kisiListesiEkle",$reservation->code)}}" class="Person-add-link">KONAKLAYACAK KİŞİ
                    LİSTESİ EKLE</a>
            </div>
        </div>
    </section>
    
    
    @endif
 
    <section class="Rez_detail">
        <div class="container">
            <div class="Rez_detail-inner ">
                <div class="Rez_detail-left">
                    <h6 class="Rez_detail-header Rez_detail-header-house">REZERVASYON DETAYLARI</h6>
       
                    <div class="Rez_detail-left-villa">
       
                        <div class="Rez_detail-left-villa-image">
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

                                <br>{!! date("d",strtotime($reservation->start_date)) . " " . getMonthName(date("m",strtotime($reservation->start_date))) . " " . date("Y",strtotime($reservation->start_date))    !!} {!! $reservation->villa->checkin_time ? "(EN ERKEN <b>{$reservation->villa->checkin_time}) </b>":"" !!}
                            </p>
                            <p>

                                ÇIKIŞ:
                                <br> {!!date("d",strtotime($reservation->end_date)) . " " . getMonthName(date("m",strtotime($reservation->end_date))) . " " . date("Y",strtotime($reservation->end_date))    !!} {!! $reservation->villa->checkout_time ? "(EN GEÇ <b>{$reservation->villa->checkout_time}) </b>":""!!}
                            </p>
                            <p><br>{{$reservation->adult_count}}
                                Yetişkin {{$reservation->child_count ? "- {$reservation->child_count} Çocuk":"" }} {{$reservation->baby_count ? "- {$reservation->baby_count} Bebek":"" }}
                            </p>
                        </div>
                    </div>
                    <div class="Rez_detail-left-price">
                        <p>
                            <span>Toplam  Tutar</span>
                            <span>{{number_format($reservation->total_price,2)}}₺</span>
                        </p>
                        <p>
                            <span>Ön Ödeme Tutarı</span>
                            <span>{{number_format($reservation->pre_payment,2)}}₺</span>
                        </p>
                        <p>
                            <span>KALAN ÖDEME TUTARI</span>
                            <span>{{number_format($reservation->entry_payment,2)}}₺</span>
                        </p>
                        @if($reservation->villa->damage_deposit_amount)
                            <p><span>Villaya girişte Nakit ödenecek tutardır.Ayrıca
{{$reservation->villa->damage_deposit_amount}} TL değerinde hasar depozitosu alınacaktır.</span></p>
                        @endif
                        <center><a  href="{{ route('nav.reservation.pdf.downloadSozlesme',$reservation->id) }}"
       class="Rez_detail-right-get_road">
        <i class="fa fa-book"></i> Sözleşme Görüntüle
    </a></center>
                    </div>
                </div>
       
                @if($fark <= 3)
                @if($reservation->villa->area_id == 1)
                    <div class="Rez_detail-right">
                        <h5 class="Rez_detail-right-header mobile">
                            VİLLA TESLİM SORUMLUNUZ !
                        </h5>
                        <h6 class="Rez_detail-header Rez_detail-header-person">
                            <p>
                                Yolculuğunuz Esnasında <br> İletişime Geçilecek Personel Bilgisi
                                <span>&nbsp;</span>
                            </p>
                        </h6>
                        <div class="Rez_detail-right-contact">
                            @if($reservation->villa->enterance_manager && $reservation->villa->enterance_manager_phone)
                                <p>
                                    <span>İsim</span>
                                    {{$reservation->villa->enterance_manager}}
                                </p>
                                <a href="tel:{{$reservation->villa->enterance_manager_phone}}">{{$reservation->villa->enterance_manager_phone}}</a>
                            @else
                                <p>
                                    <span>İsim</span>
                                   İsmail Kılınç
                                </p>
                                <a href="tel:+90 533 718 45 52">+90 533 718 45 52</a>
                            @endif

                        </div>
                        @if(!$reservation->villa->enterance_manager)
                            <h6 class="Rez_detail-header Rez_detail-header-house">
                                <p>
                                    BULUŞMA NOKTASI
                                    <span>&nbsp;</span>
                                </p>
                            </h6>


                            @if($reservation->villa->area_id == 1)
                                <a href="https://g.page/villakalkan?share"
                                   target="_blank" class="Rez_detail-right-get_road">YOL TARİFİ AL</a>
                            @else
                                <a href="" class="Rez_detail-right-get_road">YOL TARİFİ AL</a>
                            @endif
                        @endif
                    </div>

                @else


                    <div class="Rez_detail-right">
                        <h5 class="Rez_detail-right-header mobile">
                            VİLLA TESLİM SORUMLUNUZ
                        </h5>
                        <h6 class="Rez_detail-header Rez_detail-header-person">
                            <p>
                                Villa Sorumlusu <br> İletişim Bilgileri
                                <span>&nbsp;</span>
                            </p>
                        </h6>
                        <div class="Rez_detail-right-contact">
                            <p>
                                <span>İsim</span>
                                {{$reservation->villa->enterance_manager}}
                            </p>
                            <a href="">{{$reservation->villa->enterance_manager_phone}}</a>
                        </div>



                        @if(!$reservation->villa->enterance_manager)
                            <h6 class="Rez_detail-header Rez_detail-header-house">
                                <p>
                                    BULUŞMA NOKTASI
                                    <span>&nbsp;</span>
                                </p>
                            </h6>


                            @if($reservation->villa->area_id == 1)
                                <a href="https://g.page/villakalkan?share"
                                   target="_blank" class="Rez_detail-right-get_road">YOL TARİFİ AL</a>
                            @else
                                <a href="" class="Rez_detail-right-get_road">YOL TARİFİ AL</a>
                            @endif
                        @endif


                    </div>

                @endif
                @else
                <h4 style="margin-left:25px; margin-top:20px;">Tatilinize 3 gün kala tesis giriş bilgileriniz burada gözükecektir.</h4>
                @endif

            </div>
        </div>
    </section>
    @if($fark < 3)
    <section class="Person mobile">
        <div class="Person-inner">
            <div class="Person-danger">
                <p>
                    İŞLEMLERİNİZİ KOLAYLAŞTIRMAK ADINAKONAKLAYACAK KİŞİ LİSTESİNİ VE
                    BİLGİLERİNİZİ BİZİMLE PAYLAŞMANIZ GEREKMEKTEDİR.
                </p>
                <span>
                  NOT: Ziyaretciler 678 sayılı kanun hükmünde kararname, 22 Kasım 2016 tarihli ve 29896 sayılı Resmi
                    Gazete de yayımlanan Kimlik Bildirme Kanununa göre; Villaya girişlerden önce villada
                    konaklayacak tüm kişilere ait uyruk, isim, soyisim ve T.C. kimlik numarası bilgilerini firmamıza bildirmek ile yükümlüdür.
                </span>
            </div>
            <div class="Person-add">
                <a href="{{route("kisiListesiEkle",$reservation->code)}}" class="Person-add-link">KONAKLAYACAK KİŞİ
                    LİSTESİ EKLE</a>
            </div>
        </div>
    </section>
    @endif

    @if($reservation->villa->area_id == 1 && $reservation->villa->area_id == 5)
        <section class="Activity" style="display: none">
            <div class="container">
                <div class="Activity-header">
                    <a href="" class="Activity-header-logo"></a>
                    <a href="" class="Activity-header-detail">DETAYLI BİLGİ AL</a>
                </div>
                <div class="Activity-inner " id="Activity-slider">
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="Activity-item">
                            <a href="" class="global_link"></a>
                            <div class="Activity-item-image">
                                <img src="images/activite.jpg" alt="Balayı Sepeti - Aktivite">
                            </div>
                            <div class="Activity-item-text">
                                <p>
                                    ÖZEL ATV TURU
                                    <span>opposed to using 'Content here, content here',
                                making it look like readable </span>
                                </p>
                                <p>
                                    100₺
                                    <span>Başlayan Fiyatlarla</span>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

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
