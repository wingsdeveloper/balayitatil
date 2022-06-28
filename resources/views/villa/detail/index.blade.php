@extends('layouts.app')
@push('extrahead')


    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $seo->seo_title }}"/>
    <meta property="og:description" content="{{ $seo->seo_description }}"/>
    <meta property="og:image" content="{{ !empty($villa->banner_image_mobile) ? asset($villa->banner_image_mobile) : asset($villa->banner_image)  }}"/>
    <link rel="image_src" href="{{ !empty($villa->banner_image_mobile) ? asset($villa->banner_image_mobile) : asset($villa->banner_image)  }}"/>
    <meta property="og:image:width" content="400"/>
    <meta property="og:image:height" content="350"/>
    @if(!empty($req->giris_tarih) AND !empty($req->cikis_tarih))
        <meta name="robots" content="noindex">
        <meta property="og:url" content="{{ route('villa.detail.search', [$seo->seo_url, $req->giris_tarih, $req->cikis_tarih]) }}"/>
    @else
        <meta property="og:url" content="{{ route('static', $seo->seo_url) }}"/>
    @endif

   <!-- Criteo Product Tag -->
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
    { event: "setAccount", account: 46955 },
    { event: "setEmail", email: "", hash_method: "" },
    { event: "setSiteType", type: deviceType},
    { event: "setZipcode", zipcode: "" },
    {event: "viewItem", item: "{{ $villa->id }}"}
);
</script>
<!-- END Criteo Product Tag -->

    <style>
        .dont-show {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <script src="js/library/lazyload.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
          integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
 

@endpush
@push('javascripts')

    <script type="text/javascript">
        $(document).on('ready', function () {
            $('img[data-src]').lazyLoad();
        })

        var currentUrl = "{{ url() ->current() }}";
        var closeControl = true;
            @if(Agent::isMobile() || Agent::isTablet())
        var urlReplace = null;
        $("#doluluk-takvimi").on("shown.bs.modal", function () {
            urlReplace = "#" + $(this).attr('id');
            history.pushState({page: 1}, null, urlReplace);
            closeControl = true;
        });
        $("#doluluk-takvimi").on("hidden.bs.modal", function () {
            $("#doluluk-takvimi").modal('hide');
            if (closeControl == true) {
                history.back();
            } else {

            }

            //history.replaceState(null, null, currentUrl)
        });

        // This code gets executed when the back button is clicked, hide any/open modals.
        $(window).on('popstate', function () {
            //$("#doluluk-takvimi").modal('hide');
            $("#doluluk-takvimi").find('.close').trigger('click');
            closeControl = false;

            //window.history.back();
            //window.back();
            //history.popState();
            // console.log(currentUrl);
            // history.pushState(null, null, currentUrl);

        });

            @endif




        var url = $('meta[name="base_url"]').attr('content');

        function fiyatGetir(device) {
            var giris_tarih = $("#" + device + "giris_tarih").val();
            var cikis_tarih = $("#" + device + "cikis_tarih").val();
            if (device == "m") {
                'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'
                giris_tarih = giris_tarih.replace(" ", "-").replace(" ", "-").replace(",", "").replace('Ocak', '01').replace('Şubat', '02').replace('Mart', '03').replace('Nisan', '04').replace('Mayıs', '05').replace('Haziran', '06').replace('Temmuz', '07').replace('Ağustos', '08').replace('Eylül', '09').replace('Ekim', '10').replace('Kasım', '11').replace('Aralık', '12');
                cikis_tarih = cikis_tarih.replace(" ", "-").replace(" ", "-").replace(",", "").replace('Ocak', '01').replace('Şubat', '02').replace('Mart', '03').replace('Nisan', '04').replace('Mayıs', '05').replace('Haziran', '06').replace('Temmuz', '07').replace('Ağustos', '08').replace('Eylül', '09').replace('Ekim', '10').replace('Kasım', '11').replace('Aralık', '12');
                /*  var giris_tarih=$("#"+device+"giris_tarih").attr("data-value");
                var cikis_tarih=$("#"+device+"cikis_tarih").attr("data-value");*/
            }
            var villa_id = $("#data_villa").text();
            $.ajax({
                    type: "GET",
                    url: url + "/getPrices/" + villa_id + "/" + giris_tarih + "/" + cikis_tarih,
                    success: function (sonc) {
                        var data = $.parseJSON(sonc);
                        let temizlik_gun_sayisi = data.min_temizlik_gun_sayisi;
                        $(".temizlik-tooltip").tooltip('hide')
                            .attr('data-original-title', temizlik_gun_sayisi + " geceden az konaklamalarda temizlik ücreti alınır");
                        //parse JSON
                        var rezuyari = 0;
                        var rezvaruyari = 0;
                        var rezuyarifiyatsiz = 0;

                        var pricedetail = "";
                        let temizlik_ucreti = data.temizlik_ucreti;
                        console.log(temizlik_ucreti);
                        if((temizlik_ucreti == " ₺") || parseInt(temizlik_ucreti.replace('₺', '')) == "0"  || (parseInt(temizlik_ucreti.replace('₺', '')) == undefined)) {
                            $("#" + device + "temizlik_ucreti").parent('div').addClass('hidden dont-show');
                        } else {
                            $("#" + device + "temizlik_ucreti").parent('div').removeClass('hidden');
                            $("#" + device + "temizlik_ucreti").parent('div').removeClass('dont-show');
                        }
                        $("#" + device + "temizlik_ucreti").text(data.temizlik_ucreti);
                        $("#" + device + "gece_sayisi").text(data.gece_sayisi);
                        $("#" + device + "gecelik_fiyat").text(data.gecelik_fiyat);
                   
                       
                        let fiyat = data.hesap_toplam.replace('₺','');
                        let formatted = Math.round(fiyat).toLocaleString();

                        let fiyat4 = data.toplam_fiyat.replace('₺','');
                        let formatted4 = Math.round(fiyat4).toLocaleString();

                        let fiyat2 = data.on_odeme.replace('₺','');
                        let formatted2 = Math.round(fiyat2).toLocaleString();
                        
                        let fiyat3 = data.kalan_odeme.replace('₺','');
                        let formatted3 = Math.round(fiyat3).toLocaleString();


                        $("#" + device + "hesap_toplam").text(formatted+" ₺");
                        $("#" + device + "toplam_fiyat").text(formatted4+" ₺");
                        $("#" + device + "on_odeme").text(formatted2+" ₺");
                        $("#" + device + "kalan_odeme").text(formatted3+" ₺");

                        if (data.gece_sayisi < data.minimum_konaklama) {
                            $("#Rezervasyon_gonderBtn").css("background", "#ccc").attr("disabled", "disabled");
                            $("#rezervasyon_uyari").css("display", "block");
                            $("#rezGeceSayisi").text(data.gece_sayisi);
                            $("#rezMinKonaklama").text(data.minimum_konaklama);
                            rezuyari = 0;
                        } else {
                            rezuyari = 1;
                            $("#rezervasyon_uyari").css("display", "none");
                        }

                        if (data.durum === false || data.durum == "false" || data.durum == false) {
                            $("#Rezervasyon_gonderBtn").css("background", "#ccc").attr("disabled", "disabled");
                            $("#rezervasyon_var_uyari").css("display", "block");
                            rezvaruyari = 0;
                        } else {
                            rezvaruyari = 1;
                            $("#rezervasyon_var_uyari").css("display", "none");
                        }


                        if (data.gecelik_fiyat == "0 \u20ba" || data.toplam_fiyat == "0 \u20ba" || data.hesap_toplam == "0 \u20ba" || data.on_odeme == "0 \u20ba" || ((data.kalan_odeme == "0 \u20ba") && (data.on_odeme == "0 \u20ba" && data.toplam_fiyat == "0 \u20ba"))) {
                            $("#Rezervasyon_gonderBtn").css("background", "#ccc").attr("disabled", "disabled");
                            $("#rezervasyon_uyari_fiyatsiz").css("display", "block");
                            rezuyarifiyatsiz = 0;
                        } else {
                            $("#rezervasyon_uyari_fiyatsiz").css("display", "none");
                            rezuyarifiyatsiz = 1;
                        }
                        if (rezuyarifiyatsiz == 1 && rezuyari == 1 && rezvaruyari == 1) {
                            $("#Rezervasyon_gonderBtn").removeAttr('style').removeAttr('disabled');
                        }

                        if (data.gun_ve_fiyat != "") {
                            data.gun_ve_fiyat.forEach(function (g_f) {
                                    pricedetail += g_f[1] + " - <b>" + g_f[0] + "</b> ₺   <br>";
                                }
                            );
                            $("#" + device + "fiyat_tooltip").attr('data-original-title', pricedetail);
                            $("#" + device + "fiyat_tooltip").attr('title', pricedetail);
                        }
                    }
                }
            );
        }
        $(document).ready(function(){
  
  let fiyat = $('#dhesap_toplam').text().replace('₺','');


  let formatted = Math.round(fiyat).toLocaleString();


  $('#dhesap_toplam2').html(formatted+" ₺");

});

window.addEventListener('load', function () {
        //

        var galleryThumbs = new Swiper('.gallery-thumbs', {
            slidesPerView: 9,
            loop: true,
            lazy: true,
            spaceBetween: 10,
            centeredSlides: true,
            preloadImages: !1,
            grabCursor: true,
            slideToClickedSlide: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,

        });

        var galleryTop = new Swiper('.gallery-top', {
            slidesPerView: 1,
            loop: true,
            lazy: true,
            preloadImages: !1,
            navigation: {
                nextEl: '#detail_next_btn',
                prevEl: '#detail_prev_btn',
            },
            thumbs: {
                swiper: galleryThumbs,
            },
        });

        galleryTop.on('slideChangeTransitionEnd', function() {
            let index_currentSlide = galleryTop.realIndex;
            let currentSlide = galleryTop.slides[index_currentSlide]
            galleryThumbs.slideTo(index_currentSlide, 1000, false);
        });

        galleryThumbs.on('slideChangeTransitionEnd', function() {
            let index_currentSlide = galleryThumbs.realIndex;
            let currentSlide = galleryThumbs.slides[index_currentSlide]
            galleryTop.slideTo(index_currentSlide, 1000, false);
        });


    });

    </script>

<script src=" {{ asset('js/library/intlTelInput-jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

                                    
    $("#phone").intlTelInput({
        formatOnDisplay: false,
        nationalMode: false,
        separateDialCode: true,
        preferredCountries: ['TR', 'DE', 'FR', 'AT', 'NL', 'BE', 'CH', 'GB', 'RU'],


        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () {
            }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        //hiddenInput: "full_number",
        initialCountry: "tr",
        //autoPlaceholder: "off",
    });
    $(document).ready( function() {
        $('#phone').inputmask("(599) 999-9999");

    });

    $('#phone').on('countrychange', function (e) {
        if ($("#phone").intlTelInput('getSelectedCountryData').iso2 === "tr") {
            $('#phone').inputmask("(599) 999-9999");
        }else{
            $('#phone').inputmask("(999) 999-9999-99999");
        }
    });

    $("#OnRezervasyonM1Form").submit(function(e) {
     
        //prevent Default functionality
        e.preventDefault();
             @if(Agent::isDesktop())
            var girisT=$("#dgiris_tarih").val();
            var cikisT=$("#dcikis_tarih").val()
        @elseif(Agent::isMobile() || Agent::isTablet())
            var girisT=$("#mgiris_tarih").val();
            var cikisT=$("#mcikis_tarih").val()
            girisT = girisT.replace(" ", "-").replace(" ", "-").replace(",", "").replace('Ocak', '01').replace('Şubat', '02').replace('Mart', '03').replace('Nisan', '04').replace('Mayıs', '05').replace('Haziran', '06').replace('Temmuz', '07').replace('Ağustos', '08').replace('Eylül', '09').replace('Ekim', '10').replace('Kasım', '11').replace('Aralık', '12');
            cikisT = cikisT.replace(" ", "-").replace(" ", "-").replace(",", "").replace('Ocak', '01').replace('Şubat', '02').replace('Mart', '03').replace('Nisan', '04').replace('Mayıs', '05').replace('Haziran', '06').replace('Temmuz', '07').replace('Ağustos', '08').replace('Eylül', '09').replace('Ekim', '10').replace('Kasım', '11').replace('Aralık', '12');
        @endif

        var number = $("#phone").intlTelInput('getNumber');
        iso = $("#phone").intlTelInput('getSelectedCountryData').iso2;
 
        
       // $('#phone').inputmask("(599) 999-9999");
        var exampleNumber = intlTelInputUtils.getExampleNumber(iso, 0, 0);
        if (number == '') number = exampleNumber;

        var formattedNumber = intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.NATIONAL);
        var isValidNumber = intlTelInputUtils.isValidNumber(number, iso);
        var validationError = intlTelInputUtils.getValidationError(number, iso);
        // console.log(number);
        // console.log(formattedNumber);
        // console.log(intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.INTERNATIONAL));
        // console.log(intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.E164));
        // console.log(intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.RFC3966));
        // console.log(isValidNumber);
        // console.log(validationError);
        if (!isValidNumber) {
            alert('Hatalı Telefon Numarası');


            return false;
        }else{
            $("#OnRezervasyonM1").modal('hide');
            Swal.fire({
            icon: 'info',
            title: 'İşleminiz devam ediyor, lütfen bekleyiniz...',
            showConfirmButton: false,
            allowOutsideClick: false
            });

            $("#OnRezervasyonM1Form .Rez-left-gonder").prop('disabled', true);
            $.ajax({
                url: "{{ route('addPreReservation')}}",
                type: 'POST',
                dataType: 'json',
                data: {villa:{{$villa->id}},_token: '{{csrf_token()}}',giris_tarih : girisT,cikis_tarih: cikisT,
            adult:$("input[name=adult]").val(),child:$("input[name=child]").val(),baby:$("input[name=baby]").val(),
            name:$("#name").val(),email:$("#email").val(),phone:number,prephone:$("#phone").intlTelInput("getSelectedCountryData").dialCode },
                success: function (response) {

                   window.location.href = "{{route('preReservationDone')}}?code="+response.code;
                },
                error: function (error) {

                }
            });

        }


        });
        $(document).ready(function(){
                                          
                                          let fiyat = $('#dhesap_toplam').text().replace('₺','');
                                      
                                      
                                          let formatted = Math.round(fiyat).toLocaleString();
                                      
                                      
                                          $('.sonuc').html(formatted+" ₺");
                                      
                                        });

</script>
<link rel="stylesheet" href="{{ asset('css/library/intlTelInput.min.css') }}">

@endpush
@section('content')
    @include('villa.detail.slider')
    <div id="data_villa" style="display:none">{{$villa->id}}</div>
    <script>
        function reservationDone(device) {
            $("#" + device + "mst_btn").css("display", "none");
            $("#" + device + "reservation_info").slideDown();
            fiyatGetir(device);
        }
    </script>
    @php
        if(isset($req) AND !empty($req->giris_tarih) AND !empty($req->cikis_tarih)){
          $req->giris_tarih=explode(" ",$req->giris_tarih)[0];
          $req->cikis_tarih=explode(" ",$req->cikis_tarih)[0];
          $req->giris_tarih=Carbon\Carbon::parse($req->giris_tarih)->format('d-m-Y');
          $req->cikis_tarih=Carbon\Carbon::parse($req->cikis_tarih)->format('d-m-Y');
          $gunlukFiyat=App\Helpers\Helper::gunlukFiyat($villa->id,$req->giris_tarih,$req->cikis_tarih);
          $gecelik_fiyat=$gunlukFiyat[1];
          $gece_sayisi=$gunlukFiyat[2];
          $temizlik_ucreti=$gunlukFiyat[3];
          $on_odeme=$gunlukFiyat[5];
          $kalan_odeme=$gunlukFiyat[6];
          $toplam_fiyat=$gunlukFiyat[0];
          $hesap_toplam=$gunlukFiyat[7];
          $gun_ve_fiyat="";
          if(!empty($gunlukFiyat[4])){
          foreach($gunlukFiyat[4] as $gunfiyat){
          $gun_ve_fiyat.=$gunfiyat[1]." - <b>".$gunfiyat[0]."</b> ₺<br>";
        }
        }
        $divdisplay="block";
        $btndisplay="none";
        }else{
        $gecelik_fiyat="";
        $gece_sayisi="";
        $temizlik_ucreti="";
        $on_odeme="";
        $kalan_odeme="";
        $toplam_fiyat="";
        $hesap_toplam="";
        $gun_ve_fiyat="";
        $divdisplay="none";
        $btndisplay="block";
        }
    @endphp
    @if(Agent::isDesktop())
        <div style="display: none">
            <input id="mgiris_tarih"
                   class="datepicker"
                   name="giris" data-page="detail"
                   type="text" autocomplete="off"
                   value="" data-value="">
            <input
                id="mcikis_tarih"
                class="datepicker"
                name="cikis" data-page="detail"
                type="text" autocomplete="off"
                value="" data-value="">
        </div>
      <div class="Villa_detay-menu ">
        <div class="Villa_detay-menu-name">
            <p>
                <span>{{$villa->name}}</span>
                {{ $website->prefix }}{{ $villa->code }}
            </p>
        </div>
        <div class="Villa_detay-menu-links">
            <ul>
                <li><a class="nav-menuX" href="#foto">FOTOĞRAFLAR</a></li>
                <li><a class="nav-menuX" href="#fiyat">FİYATLANDIRMALAR</a></li>
                <li><a class="nav-menuX" href="#genel">GENEL BAKIŞ</a></li>
                <li><a class="nav-menuX" href="#kat">KAT PLANI</a></li>
                <li><a class="nav-menuX" href="#harita">ULAŞIM</a></li>
                <li><a class="nav-menuX" href="#sss">MERAK EDİLENLER</a></li>
                <li><a class="nav-menuX" href="#extra">EXTRA</a></li>
            </ul>
        </div>
        <div id="UpTotop" class="flex-column a-i-c" style="display: none">
            <svg class="icon icon-chevron-right" data-original-title="" title="">
                <use xlink:href="#icon-chevron-right"></use>
            </svg>
            YUKARI ÇIK
        </div>
    </div>
        <section class="Villa_detay desktop">
            <div class="container">
                <div class="flex a-i-fs">
                    <div class="Rezervasyon  Rezervasyon-fixed-open">
                        <!-- //formun açık hali. open class ı silince kapalı hali oluyor-->
                        <div class="Rezervasyon-slogan">
                            <svg class="icon icon-wallet">
                                <use xlink:href="#icon-wallet">
                                </use>
                            </svg>
                            @php
                                $gune_ait_fiyat=floatval(str_replace(",",".",$pricesmin->daily_price_tl));
                            @endphp
                            <p>{{(isset($pricesmin->daily_price_tl)? number_format((float)$gune_ait_fiyat, 0, ',', '.') :'')}} ₺’DEN
                                <span>Başlayan Fiyatlarla(Gecelik)</span>
                            </p>
                        </div>
                                    @php
                                    $curl = curl_init();
                                    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    $event_id = random_int(1000000000000, 9999999999999);
                                    $value_final = (isset($pricesmin->daily_price_tl)? ceil($gune_ait_fiyat):'');

                                    curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://graph.facebook.com/v13.0/1757769984530411/events',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_POSTFIELDS => array('data' => '[{
                                        "event_name": "ViewContent",
                                        "event_id": "' . $event_id . '",
                                        "event_time": "' . time() .'",
                                        "event_source_url": "'. $actual_link .'",
                                        "action_source": "website",
                                        "user_data": {
                                            "client_ip_address": "' . $fb_ip . '",
                                            "client_user_agent": "' . $_SERVER['HTTP_USER_AGENT'] . '"
                                        },
                                        "custom_data": {
                                            "content_name": "' . $villa->name . '",
                                            "content_type": "product",
                                            "currency": "TRY",
                                            "value": "' . $value_final . '",
                                            "content_ids" : "' . $villa->id . '"
                                        }
                                    }]','access_token' => 'EAAHTPiGDALEBAEcNNXC1nNAXJDI4V2r1hnaSlKvSH0TgWcoFPBzKGtKGZABzUVuszLurTdQ9qZBSunk0PZCqzVI73s07w2s5ZA2YgVaFl6ZCREl8buwcpAwC3bgZAWiVVegefRultu8o3Bx5nEJe6WYZC0RyNpZCR1ZA7bZALHsF8SDMsAL6WQQVd9JEwVSRuhx58ZD','test_event_code' => 'TEST50377'),
                                    ));

                                    $response = curl_exec($curl);

                                    curl_close($curl);

                                    @endphp


                                <script>
                                    fbq('track', 'ViewContent', {
                                        value: {{(isset($pricesmin->daily_price_tl)? ceil($gune_ait_fiyat):'')}},
                                        currency: 'TRY',
                                        content_name:'{{$villa->name}}',
                                        content_type:'product',
                                        content_ids: ["{{ $villa->id }}"],
                                    }, {eventID: '{{ $event_id }}'});

                                    window.dataLayer = window.dataLayer || [];
                                    dataLayer.push({
                                    event: 'view_item',
                                    event_id: '{{ $event_id }}',
                                    value: {{(isset($pricesmin->daily_price_tl)? ceil($gune_ait_fiyat):'')}},
                                    currency: 'TRY',
                                    id: ["{{ $villa->id }}"],
                                    name:'{{$villa->name}}',
                                    type:'product',

                                    });
                                </script>

                        <div class="Rezervasyon-in">
                            <div class="Rezervasyon-availability">
                                <div class="Rezervasyon-availability-name">
                                    <p>REZERVASYON YAP
                                    </p>
                                </div>
                                <div class="Rezervasyon-availability-takvim">
                                    <button onclick="takvimGetirPriority()" type="button" data-toggle="modal"
                                            data-target="#doluluk-takvimi">Doluluk Takvimi
                                    </button>
                                </div>
                            </div>
                            <form action="{{ route('reservation', [$id])}}" id="rezervasyonForm" method="get">
                                <input type="hidden" name="villa" value="{{$villa->id}}">
                                <div class="Rezervasyon-search">
                                    <div class="Rezervasyon-search-date" id="two-inputs">
                                        <div class="Rezervasyon-search-item  ">
                                            <label for="dgiris_tarih" onclick="takvimGetir()">Giriş Tarihi
                                            </label>
                                            <input autocomplete="off" type="text" data-page="detail" id="dgiris_tarih"
                                                   class="villa_date-input"
                                                   @if(isset($req) AND !empty($req->giris_tarih)) value="{{$req->giris_tarih}}"
                                                   @endif
                                                   name="giris_tarih" data-datepicker="separateRange"/>
                                            <svg class="icon icon-date addon">
                                                <use xlink:href="#icon-calendar">
                                                </use>
                                            </svg>
                                        </div>
                                        <div class="Rezervasyon-search-item villa_date">
                                            <label for="dcikis_tarih" onclick="takvimGetir()">Çıkış Tarihi
                                            </label>
                                            <input autocomplete="off" type="text" data-page="detail" id="dcikis_tarih"
                                                   class="villa_date-input"
                                                   @if(isset($req) AND !empty($req->cikis_tarih)) value="{{$req->cikis_tarih}}"
                                                   @endif
                                                   name="cikis_tarih" data-datepicker="separateRange"/>
                                            <svg class="icon icon-date addon">
                                                <use xlink:href="#icon-calendar">
                                                </use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="Rezervasyon-search-item villa_tur">
                                        <label for="v_tur">Kişi Sayısı
                                        </label>
                                        <div class="Dropdown">
                                            <button class="Dropdown-buton" type="button">
                                                <b id="dtotal_person">1
                                                </b> Kişi
                                                <span class="Dropdown-buton-person">(
                                                    <b id="dtotal_adult">1
                                                    </b> Yetişkin,
                                                    <b id="dtotal_child">0
                                                    </b> Çocuk,
                                                    <b id="dtotal_baby">0
                                                    </b> Bebek )
                                                </span>
                                            </button>
                                            <div class="Dropdown-menu  Rezervasyon-search-person ">
                                                <div class="Dropdown-menu-item">
                                                    <p>Yetişkin
                                                    </p>
                                                    <div class="Dropdown-menu-item-spinner ">
                                                        <button type="button" onclick="eksilt(this,1,'d','adult')">
                                                            <svg class="icon icon-minus">
                                                                <use xlink:href="#icon-minus">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                        <input type="text" name="adult" value="1"
                                                               style="display: block;" readonly="readonly">
                                                        <button type="button" id="d-adult-button"
                                                                data-max="{{ $villa->max_adult }}"
                                                                data-max="{{ $villa->max_adult }}"
                                                                onclick="arttir(this,'{{$villa->max_adult}}','d','adult')">
                                                            <svg class="icon icon-plus">
                                                                <use xlink:href="#icon-plus">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="Dropdown-menu-item">
                                                    <p>Çocuk
                                                        <span>6-13 Yaş Arası</span>
                                                    </p>
                                                    <div class="Dropdown-menu-item-spinner ">
                                                        <button type="button" onclick="eksilt(this,0,'d','child')">
                                                            <svg class="icon icon-minus">
                                                                <use xlink:href="#icon-minus">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                        <input type="text" name="child" value="0"
                                                               style="display: block;" readonly="readonly">
                                                        <button type="button" id="d-child-button"
                                                                data-max="{{$villa->max_child}}"
                                                                onclick="arttir(this,'9{{$villa->max_child}}00','d','child')">
                                                            <svg class="icon icon-plus">
                                                                <use xlink:href="#icon-plus">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="Dropdown-menu-item">
                                                    <p>Bebek
                                                        <span>0-5 Yaş Arası</span>
                                                    </p>
                                                    <div class="Dropdown-menu-item-spinner ">
                                                        <button type="button" onclick="eksilt(this,0,'d','baby')">
                                                            <svg class="icon icon-minus">
                                                                <use xlink:href="#icon-minus">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                        <input type="text" name="baby" value="0" style="display: block;"
                                                               readonly="readonly">
                                                        <button type="button"
                                                                onclick="arttir(this,'{{$villa->max_baby}}','d','baby')">
                                                            <svg class="icon icon-plus">
                                                                <use xlink:href="#icon-plus">
                                                                </use>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="Dropdown-menu-item">
                                                    <button id="ZarazCustomize" class="Dropdown-close" type="button">
                                                        ONAYLA
                                                    </button>
                                                </div>
                                            </div>


                                        </div>
                                        <svg class="icon icon-caret-down addon">
                                            <use xlink:href="#icon-caret-down">
                                            </use>
                                        </svg>
                                    </div>
                                    <input class="Rezervasyon-gonder" id="dmst_btn" style="display: {{$btndisplay}}"
                                           type="button" value="MÜSAİTLİK SORGULA">
                                </div>
                                <div class="Rezervasyon-info" style="display: {{$divdisplay}}" id="dreservation_info">
                                    <h6 class="Rezervasyon-info-head">REZERVASYON DETAYLARI
                                    </h6>
                                    <div class="Rezervasyon-info-item">
                                            <span>
                                                <b id="dgecelik_fiyat">{{number_format((float)$gecelik_fiyat, 0, ',', '.')}} ₺
                                                </b> x
                                                <b id="dgece_sayisi">{{$gece_sayisi}}
                                                </b> Gece
                                            </span>
                                        <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true"
                                             id="dfiyat_tooltip" data-placement="top"
                                             title="{{$gun_ve_fiyat}}">
                                            <use xlink:href="#icon-unlem">
                                            </use>
                                        </svg>
                                        <span id="dtoplam_fiyat">{{number_format((float)$toplam_fiyat, 0, ',', '.')}} ₺</span>
                                    </div>
                                    <div class="Rezervasyon-info-item">
                                        <span>Temizlik Ücreti</span>
                                        <svg class="icon icon-unlem temizlik-tooltip" data-toggle="tooltip" data-html="true"
                                             data-placement="top"
                                             title="7 geceden az konaklamalardan temizlik ücreti alınır">
                                            <use xlink:href="#icon-unlem">
                                            </use>
                                        </svg>
                                        <span id="dtemizlik_ucreti">{{$temizlik_ucreti}}</span>
                                    </div>
                                    <h6 class="Rezervasyon-info-head">Ödeme Planı
                                    </h6>
                                    <div class="Rezervasyon-info-item">
                                            <span>Ön Ödeme</span>
                                        <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true"
                                             data-placement="top"
                                             title="Yerinizi ayırtmak için ödemeniz gereken tutar">
                                            <use xlink:href="#icon-unlem">
                                            </use>
                                        </svg>
                                        <span id="don_odeme">{{number_format((float)$on_odeme, 0, ',', '.')}} ₺</span>
                                    </div>
                                    <div class="Rezervasyon-info-item">
                                        <span> Kalan Ödeme</span>
                                        <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true"
                                             data-placement="top"
                                             title="Villaya Girişte Ödenecek Tutar">
                                            <use xlink:href="#icon-unlem">
                                            </use>
                                        </svg>
                                        <span id="dkalan_odeme">{{number_format((float)$kalan_odeme, 0, ',', '.')}} ₺</span>
                                    </div>
                                    <div class="Rezervasyon-info-toplam">
                                    <span>TOPLAM</span>     
                                     <p   id="dhesap_toplam">{{number_format((float)$hesap_toplam, 0, ',', '.')}} ₺</p>
                                      
                                    </div>
                                    <div id="kisi_uyari" class="text-danger" style="display: none">
                                        <small>Lütfen kişi sayısı seçiniz</small>
                                    </div>
                                    <small id='rezervasyon_uyari'
                                           style='display:none;margin:-5px;font-size:0.75em;color:#ff0000;'>Seçtiğiniz
                                        sezon için minimum konaklama süresi <b id="rezMinKonaklama"></b> gecedir siz <b
                                            id="rezGeceSayisi"></b> gece seçtiniz
                                    </small>
                                    <small id='rezervasyon_var_uyari'
                                           style='display:none;margin:-5px;font-size:0.75em;color:#ff0000;'>Seçtiğiniz
                                        tarihler doludur <b>lütfen doluluk takvimini kontrol ederek farklı bir tarih
                                            seçiniz</b></small>
                                    <small id='rezervasyon_uyari_fiyatsiz'
                                           style='display:none;margin:-5px;font-size:0.75em;color:#ff0000;'>Seçtiğiniz
                                        tarih aralıkları için villamızın fiyatları henüz belirlenmemiştir lütfen daha
                                        farklı bir tarih seçiniz
                                    </small>
                                    <input class="Rezervasyon-gonder-zaraz" id="Rezervasyon_gonderBtn"
                                           onclick="rezervasyonButtonControl('d')" type="button"
                                           value="ÜCRETSİZ TALEP GÖNDER">
                                    <div class="Rezervasyon-info-bilgi">
                                        <p>Henüz bir ödeme yapmayacaksınız
                                        </p>
                                        <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true"
                                             data-placement="top"
                                        >
                                            <use xlink:href="#icon-unlem">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="Rezervasyon-Question">
                                    <a id="tel_zaraz" href="tel:{{ $defaultContact->phone }}"  class="global_link">
                                    </a>
                                    <h6>SORU SOR
                                    </h6>
                                    <p>
                                        <span>MÜŞTERİ HİZMETLERİ
                                        </span> 0242 252 0032
                                    </p>
                                </div>
                        </div>
                        </form>
                    </div>
                    <div class="Villa_detay-in">

                    <section class="Detail-slider">
                        <div class="swiper-container gallery-top">
                            <span class="bigSizeIcon fa-expand"></span>
                            <button id="detail_prev_btn"><svg class="icon icon-chevron-right" data-original-title="" title=""><use xlink:href="#icon-chevron-right"></use></svg></button>
                            <button id="detail_next_btn"><svg class="icon icon-chevron-right" data-original-title="" title=""><use xlink:href="#icon-chevron-right"></use></svg></button>

                            <div class="swiper-wrapper">
                            @forelse($villa->photos as $photo)
                                <a href="{{ ImageProcess::getImageWatermarkedPath($photo) }}" data-fancybox data-title="{{$villa->name}}" class="swiper-slide " >
                                    <img class="swiper-lazy " data-src="{{ ImageProcess::getImageWatermarkedPath($photo) }}" alt="{{$villa->name}}" src="">
                                    <div class="swiper-lazy-preloader"></div>
                                </a>
                                @empty
                            &nbsp;
                        @endforelse
                            </div>

                        </div>
                        <div class="swiper-container gallery-thumbs "
                             id="gallery-thumbs" style="display: block;">
                            <div class="swiper-wrapper" style="">
                            @forelse($villa->photos as $photo)
                                <button class="swiper-slide">
                                    <img class="swiper-lazy "data-src="{{ ImageProcess::getImageWatermarkedPath($photo) }}" alt="{{$villa->name}}" src="" >
                                         <div class="swiper-lazy-preloader"></div>
                                </button>
                                @empty
                            &nbsp;
                        @endforelse
                                
                            </div>
                        </div>
                    </section>

                        <div class="Villa_detay-property">
                            <div class=" Villa_detay-property-name">
                                <span>VİLLA KODU</span>
                                <h6 class="header-lg">{{$villa->code}}
                                </h6>
                            </div>
                            <div class=" Villa_detay-property-in flex a-i-c justify-content-between">
                                <div class="Villa_detay-property-item">
                                    <svg class="icon icon-location">
                                        <use xlink:href="#icon-location">
                                        </use>
                                    </svg>
                                    <p>
                                <span>KONUM
                                </span>{{ isset($villa->area->name) ? $villa->area->name : '' }}  
                                    </p>
                                </div>
                                <div class="Villa_detay-property-item">
                                    <svg class="icon icon-user">
                                        <use xlink:href="#icon-user">
                                        </use>
                                    </svg>
                                    <p>
                                    <span>KİŞİ SAYISI
                                    </span>{{$villa->number_person}} Kişilik  
                                    </p>
                                </div>
                                <div class="Villa_detay-property-item">
                                    <svg width="40" height="32" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.401 7.734v-5.01A2.727 2.727 0 0 0 14.677 0H4.674A2.727 2.727 0 0 0 1.95 2.724v5.03a2.644 2.644 0 0 0-1.823 2.508v5.086a.31.31 0 1 0 .618 0v-2.163H18.67v2.163a.31.31 0 0 0 .618 0v-5.086a2.645 2.645 0 0 0-1.886-2.528zM2.568 7.623V2.725c0-1.162.944-2.107 2.106-2.107h10.002c1.162 0 2.107.945 2.107 2.107v4.898H15.34V3.605a.31.31 0 0 0-.31-.309H4.32a.31.31 0 0 0-.31.31v4.017H2.568zm2.06 0V3.915h4.738v3.708H4.628zm5.356-3.708h4.739v3.708H9.983V3.915zm-9.24 8.652v-2.304c0-1.115.908-2.022 2.022-2.022h13.88c1.116 0 2.022.907 2.022 2.022v2.304H.745z" fill="#490181"/>
                                    </svg>
                                    <p>
                                    <span>YATAK ODASI
                                    </span>{{$villa->number_bedroom}} Adet
                                    </p>
                                </div>
                                <div class="Villa_detay-property-item">
                                        <svg width="32" height="32" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M.55 0c.234 0 .424.183.424.41v1.463h6.43c1.46.002 2.695 1.049 2.887 2.45 2.397.216 4.232 2.158 4.238 4.487v.85c.37.167.604.527.598.921-.003.554-.464 1.003-1.036 1.01H5.619a1.036 1.036 0 0 1-1-.808 1.002 1.002 0 0 1 .591-1.122v-.85c0-2.327 1.83-4.271 4.224-4.488-.185-.945-1.037-1.63-2.03-1.63H.974V4.39c0 .226-.19.41-.423.41a.417.417 0 0 1-.424-.41V.41c0-.227.19-.41.424-.41zM5.62 10.771h8.472c.1 0 .181-.078.181-.175a.179.179 0 0 0-.181-.176H5.619c-.1 0-.182.079-.182.176 0 .097.081.175.182.175zm.438-1.17v-.79c0-2.038 1.707-3.689 3.813-3.689 2.105 0 3.812 1.651 3.812 3.688v.79H6.057zM12.15 14.574c-.17-.183-.42-.46-.42-.973v-.235c0-.227.164-.412.367-.412.202 0 .366.185.366.412v.235c0 .155.045.218.195.379.17.183.424.46.424.973 0 .513-.259.79-.43.973-.149.16-.201.224-.201.379 0 .154.051.218.2.378.17.183.428.46.428.974 0 .513-.25.79-.421.973-.15.16-.195.224-.195.379v.352c0 .228-.164.412-.366.412-.203 0-.367-.184-.367-.412v-.352c0-.514.25-.79.42-.974.15-.16.198-.224.198-.378 0-.155-.053-.218-.202-.38-.17-.182-.428-.459-.428-.972 0-.514.257-.79.427-.973.149-.161.204-.225.204-.38 0-.153-.049-.217-.198-.378zM8.742 14.574c-.17-.183-.421-.46-.421-.973v-.235c0-.227.164-.412.367-.412.202 0 .366.185.366.412v.235c0 .155.045.218.195.379.17.183.423.46.423.973 0 .513-.258.79-.428.973-.15.16-.202.224-.202.379 0 .154.051.218.2.378.17.183.427.46.427.974 0 .513-.25.79-.42.973-.15.16-.195.224-.195.379v.352c0 .228-.164.412-.366.412-.203 0-.367-.184-.367-.412v-.352c0-.514.25-.79.42-.974.15-.16.198-.224.198-.378 0-.155-.053-.218-.202-.38-.17-.182-.428-.459-.428-.972 0-.514.256-.79.426-.973.15-.161.204-.225.204-.38 0-.153-.048-.217-.197-.378z" fill="#490181"/>
                                        </svg>
                                    <p>
                                    <span>BANYO
                                    </span>{{$villa->number_bathroom}} Adet
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="fiyat" class="Villa_detay-price">
                            <div class="Villa_detay-header flex a-i-c">
                                <svg class="icon icon-card">
                                    <use xlink:href="#icon-card">
                                    </use>
                                </svg>
                                <h4 class="header-lg">FİYATLANDIRMALAR
                                </h4>
                            </div>
                            <div class="Villa_detay-price-info">
                                <div class="Villa_detay-price-info-head ">
                                    <p>
                                <span>DÖNEMSEL
                                </span>VİLLA FİYATLARI
                                    </p>
                                    <!-- <ul class="nav nav-tabs "  >
                                <li class="nav-item ">
                                <a href="#tab1" class="nav-link active "  data-toggle="tab">2018</a>
                                </li>
                                <li class="nav-item ">
                                <a href="#tab2" class="nav-link  "  data-toggle="tab">2019</a>
                                </li>
                                </ul>-->
                                </div>
                                <div class="Villa_detay-price-in flex">
                                    <div class="Villa_detay-price-left flex-column">
                                        <p class="thead">
                                            <span>Gecelik
                                            </span>
                                                <span>Haftalık
                                            </span>
                                        </p>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active opa" id="tab1">
                                                @forelse($prices as $price)
                                                    @php

                                                        $cikisYil=Carbon\Carbon::parse($req->end_date)->format('Y');
                                                    if(($price->start_date>="$cikisYil-06-01" && $price->start_date<="$cikisYil-09-30") || ($price->end_date>="$cikisYil-06-01" && $price->end_date<="$cikisYil-09-30")){
                                                            $villa_min_accommodation=(isset($villa->min_accommodation_season)?$villa->min_accommodation_season:0);
                                                        }else{
                                                            $villa_min_accommodation=(isset($villa->min_accommodation)?$villa->min_accommodation:0);
                                                        }
                                                    @endphp
                                                    <div class="Villa_detay-price-item">
                                                        <p class="Villa_detay-price-item-date">
                                                            <strong>{{ isset($price->start_date) ?  iconv('latin5','utf-8',\Carbon\Carbon::parse($price->start_date)->formatLocalized('%d %B %Y')) : 'Belirtilmedi'}}
                                                                -
                                                                {{isset($price->end_date) ? iconv('latin5','utf-8',\Carbon\Carbon::parse($price->end_date)->formatLocalized('%d %B %Y')): 'Belirtilmedi'}}
                                                            </strong>
                                                            <span>
                                                                @php
                                                                    if(isset($price->min_accommodation)){
                                                                    $min_acc=$price->min_accommodation;
                                                                    }else{
                                                                    $min_acc=$villa_min_accommodation;
                                                                    }
                                                                    if(isset($price->short_stay)){
                                                                    $cleaning_price=$price->short_stay;
                                                                    }else{
                                                                    $cleaning_price=$villa->default_cleaning_price;
                                                                    }
                                                                    $price_if_min_stay_cleaning = $price->min_stay_cleaning_price ?? 7;
                                                                @endphp
                                                            Minimum Kiralama : {{$min_acc}} Gece
                                                            @if(!empty($cleaning_price) && $cleaning_price!=0 && ($price_if_min_stay_cleaning > $min_acc))
                                                                    <svg class="icon icon-unlem" data-toggle="tooltip"
                                                                         data-html="true"
                                                                         data-placement="top"
                                                                         title="{{ $price->min_stay_cleaning_price ?? 7 }} gece altındaki konaklamalardan {{$cleaning_price}} ₺  Temizlik ücreti alınır">
                                                                            <use xlink:href="#icon-unlem">
                                                                            </use>
                                                                            @endif
                                                                            </svg>
                                                                        </span>
                                                        </p>

                                                        @php
                                                            $gune_ait_fiyat=floatval(str_replace(",",".",$price->daily_price_tl));
                                                            $haftalik_fiyat=ceil($gune_ait_fiyat*7);
                                                        @endphp
                                                        <span
                                                            class="Villa_detay-price-item-cash">{{ isset($price->daily_price_tl) ? number_format((float)$gune_ait_fiyat, 0, ',', '.'). ' ₺' : 'Belirtilmedi' }}
                                                                </span>
                                                                                                                    <span
                                                                                                                        class="Villa_detay-price-item-cash">{{ isset($price->daily_price_tl) ? number_format((float)$haftalik_fiyat, 0, ',', '.') . ' ₺' : 'Belirtilmedi' }}
                                                                </span>
                                                    </div>
                                                @empty
                                                    &nbsp;
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Villa_detay-price-right">
                                        @if(isset($paidins))
                                            <p class="Villa_detay-price-right-head">
                                                <span>{{$villa->name}}
                                                </span>
                                                ÜCRETE DAHİL OLANLAR
                                            </p>
                                            <ul>
                                                @foreach($paidins as $paidin)
                                                    <li>
                                                        {{$paidin->property}}
                                                        @if(isset($paidin->description))
                                                            <svg class="icon icon-unlem" data-toggle="tooltip"
                                                                 data-html="true"
                                                                 data-placement="top" title="{{$paidin->description}}">
                                                                <use xlink:href="#icon-unlem">
                                                                </use>
                                                            </svg>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if(isset($nonpaids))
                                            <p class="Villa_detay-price-right-head ">
                                                <span>{{$villa->name}}</span>
                                                ÜCRETE DAHİL OLMAYANLAR
                                            </p>
                                            <ul>
                                                @foreach($nonpaids as $nonpaid)
                                                    <li>
                                                        {{$nonpaid->property}}
                                                        @if(isset($nonpaid->description))
                                                            <svg class="icon icon-unlem" data-toggle="tooltip"
                                                                 data-html="true"
                                                                 data-placement="top" title="{{$nonpaid->description}}">
                                                                <use xlink:href="#icon-unlem">
                                                                </use>
                                                            </svg>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="genel" class="Villa_detay-info">
                            <div class="Villa_detay-header flex a-i-c">
                                <svg class="icon icon-target">
                                    <use xlink:href="#icon-target">
                                    </use>
                                </svg>
                                <h4 class="header-lg">GENEL BAKIŞ
                                </h4>
                            </div>
                            <h5 class="Villa_detay-info-head">VİLLA AÇIKLAMASI
                            </h5>
                            <p>@if($villa->panel_villa && $villa->panel_villa->description){!! $villa->panel_villa->description !!}@else {!! $villa->description !!}@endif
                            </p>
                            <h5 class="Villa_detay-info-head">VİLLANIN ÖNE ÇIKAN ÖZELLİKLERİ
                            </h5>
                            <ul>

                                @if(isset($prominents))
                                    @foreach($prominents as $prominent)
                                        <li class="text">{{$prominent->name}}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        @if(isset($vfloors) && !empty($vfloors))
                            {{-- desktop villa kat --}}
                            <div id="kat" class="Villa_detay-floor">
                                <div class="Villa_detay-header flex a-i-c">
                                    <svg class="icon icon-house">
                                        <use xlink:href="#icon-house">
                                        </use>
                                    </svg>
                                    <h4 class="header-lg">VİLLA KAT PLANI
                                    </h4>
                                    <a class="ml-auto galleryxyz">VİLLANIN TÜM FOTOĞRAFLARI
                                    </a>
                                </div>
                                <div class="Villa_detay-floor-head">
                                    <ul class="nav nav-tabs">
                                        @foreach($vfloors as $katustkey=>$floor)
                                            @php
                                                $kat =  \App\FloorPlan::where('id',$floor->floor_id)->first();
                                            @endphp
                                            <li class="nav-item ">
                                                <a href="#kat{{$kat->id}}"
                                                   class="nav-link {{($katustkey==0)? 'active show':''}} "
                                                   data-toggle="tab">{{$kat->name}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <span class="header-sm">{{$villa->name}}
                                        </span>
                                </div>
                                <div class="tab-content tab_oda">

                                    {{--@foreach($vfloors as $katickey=>$flooric)--}}
                                    @foreach($villa->floors as $katickey=>$flooric)

                                        @php
                                            #$kat =  \App\FloorPlan::where('id',$flooric->floor_id)->first();
                                            #$bolumler =  \App\VillaPart::where('villa_id',$villa->id)->where('floor_id',$flooric->id)->get();
                                            $kat = $flooric->floor;
                                            $bolumler = $flooric->parts;
                                        @endphp
                                        <div class="tab-pane fade {{($katickey==0)? 'active show':''}}"
                                             id="kat{{$kat->id}}">
                                            <ul class="nav nav-tabs " style="width: 100%">
                                                @foreach($bolumler as $odaustkey=>$bolumust)

                                                    @php #$part = App\Part::where('id',$bolumust->part_id)->first(); @endphp
                                                    @php $part = $bolumust->part; @endphp
                                                    <li class="nav-item kat-secenek">
                                                        <a href="#oda{{$katickey . $odaustkey}}"
                                                           class="nav-link {{($odaustkey==0)? 'active show':''}}"
                                                           data-toggle="tab">{{$part->name}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach($bolumler as $odakey=>$bolum)


                                                    @php
                                                        #$partic = App\Part::where('id',$bolum->part_id)->first();
                                                        #$materialler =  \App\VillaMaterial::select("material_id")->where("villa_id",$villa->villa_id)->where("floor_id",$flooric->id)->where("part_id",$bolum->id)->get();

                                                        #$resimler =  \App\VillaPartPhoto::select("photo_id")->where('villa_id',$villa->villa_id)->where('floor_id',$flooric->id)->where("part_id",$bolum->id)->get();
                                                        #$havuzbilgileri =  \App\VillaMaterialSpeacialInfo::where('villa_id',$villa->villa_id)->where('floor_id',$flooric->id)->where("part_id",$bolum->id)->first();
                                                        #$materials = App\Material::whereIn('id',$materialler)->get();
                                                        #$images = App\VillaPhoto::whereIn('id',$resimler)->orderBy('ranking')->get();

                                                        $partic = $bolum->part;
                                                        $materialler =  $bolum->materials;
                                                        $materials = $materialler;
                                                        $resimler =  $bolum->photos;
                                                        $images = $bolum->photos;
                                                        $havuzbilgileri = $bolum->special_info;


                                                    @endphp

                                                    <div class="tab-pane fade {{($odakey==0)? 'active':''}} opa"
                                                         id="oda{{$katickey . $odakey}}">
                                                        <div class="Villa_detay-floor-in flex">
                                                            <div class="col-md-9">
                                                                @if(is_null($images) || empty($images))

                                                                @else
                                                                    <div
                                                                        class="swiper-container swiper-container-floor {{ "s".$katickey."-".$odakey }}"
                                                                        data-id="{{ "s".$katickey."-".$odakey }}">
                                                                        <div class="swiper-wrapper">
                                                                            @foreach($images as $ikey=>$image)
                                                                                <div class="swiper-slide">
                                                                                    <img
                                                                                        data-src="{{  ImageProcess::getImageWatermarkedPath($image->photo) }}"
                                                                                        class="w-100 swiper-lazy"
                                                                                        alt="">
                                                                                </div>
                                                                            @endforeach

                                                                        </div>
                                                                        <!-- If we need navigation buttons -->
                                                                        <div class="swiper-button-next">
                                                                            <svg class="icon icon-chevron-right">
                                                                                <use
                                                                                    xlink:href="#icon-chevron-right"></use>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="swiper-button-prev">
                                                                            <svg class="icon icon-chevron-right">
                                                                                <use
                                                                                    xlink:href="#icon-chevron-right"></use>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="Villa_detay-floor-info col-md-3 pl-0">
                                                                <h6 class="Villa_detay-floor-info-head">{{$partic->name}}
                                                                </h6>
                                                                <p>
                                                                <span>İçindekiler
                                                                </span>:&nbsp;&nbsp;

                                                                    @foreach($materials as $material)&nbsp;-
                                                                    &nbsp;{{$material->material->name}}&nbsp;
                                                                    &nbsp;@endforeach
                                                                </p>
                                                                @if(isset($havuzbilgileri->special_info))
                                                                    <p>
                                                                    <span>Ek Bilgi
                                                                    </span>:&nbsp;&nbsp;{{$havuzbilgileri->special_info}}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        @endif
                        <div id="harita" class="Villa_detay-map">
                            <div class="Villa_detay-header flex a-i-c">
                                <svg class="icon icon-location2">
                                    <use xlink:href="#icon-location2">
                                    </use>
                                </svg>
                                <h4 class="header-lg">ULAŞIM
                                </h4>
                            </div>


                            <div class="Villa_detay-map-info">
                                <h6>MESAFELER
                                </h6>
                                <div class="Villa_detay-map-info-in flex a-i-c justify-content-around">
                                    <div class="Villa_detay-map-info-icons flex wrap">

                                        <div class="Villa_detay-map-item">
                                            <svg class="icon icon-airport">
                                                <use xlink:href="#icon-airport">
                                                </use>
                                            </svg>
                                            <p>Havaalanı Mesafesi
                                                <span>{{$villa->airport_distance}}
                                                    </span>
                                            </p>
                                        </div>
                                        <div class="Villa_detay-map-item">
                                            <svg class="icon icon-sea">
                                                <use xlink:href="#icon-sea">
                                                </use>
                                            </svg>
                                            <p>Deniz Mesafesi
                                                <span>{{$villa->sea_distance}}</span>
                                            </p>
                                        </div>
                                        <div class="Villa_detay-map-item">
                                            <svg class="icon icon-market">
                                                <use xlink:href="#icon-market">
                                                </use>
                                            </svg>
                                            <p>Market Mesafesi
                                                <span>{{$villa->shop_distance}}</span>
                                            </p>
                                        </div>
                                        <div class="Villa_detay-map-item">
                                            <svg class="icon icon-medicane">
                                                <use xlink:href="#icon-medicane">
                                                </use>
                                            </svg>
                                            <p>Hastane Mesafesi
                                                <span>{{$villa->hospital_distance}}</span>
                                            </p>
                                        </div>
                                        <div class="Villa_detay-map-item">
                                            <svg class="icon icon-restorant">
                                                <use xlink:href="#icon-restorant">
                                                </use>
                                            </svg>
                                            <p>Restaurant Mesafesi
                                                <span>{{$villa->restaurant_distance}}</span>
                                            </p>
                                        </div>
                                        <div class="Villa_detay-map-item">
                                            <svg class="icon icon-house2">
                                                <use xlink:href="#icon-house2">
                                                </use>
                                            </svg>
                                            <p>Merkez Mesafesi
                                                <span>{{$villa->center_distance}}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <a target="_blank"
                                       href="https://www.google.com/maps/place/{{ $villa->coordinate_x }},{{ $villa->coordinate_y }}"
                                       class="Villa_detay-map-info-link">
                                        <svg class="icon icon-location">
                                            <use xlink:href="#icon-location"></use>
                                        </svg>
                                        HARİTADA GÖSTER
                                    </a>
                                </div>
                            </div>
                            <h5 class="Villa_detay-info-head">BU VİLLAYA NASIL GİDERİM ?
                            </h5>
                            <div class="Villa_detay-map-road flex">
                                <div class="Villa_detay-map-road-item">
                                    <div class="Villa_detay-map-road-head">
                                        <svg class="icon icon-car">
                                            <use xlink:href="#icon-car">
                                            </use>
                                        </svg>
                                        <div class="Villa_detay-map-road-link">
                                            <h6>KARAYOLU
                                            </h6>
                                            <ul class="nav nav-tabs ">
                                                <li class="nav-item ">
                                                    <a href="#car" class="nav-link active " data-toggle="tab">Şahsi Araç
                                                    </a>
                                                </li>
                                                <li class="nav-item  ">
                                                    <a href="#bus" class="nav-link  " data-toggle="tab">Otobüs
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="car">
                                            <div class="accordion flex-column a-i-c " id="accordionExample">
                                                @php
                                                    if(!empty($villa->area->car)){
                                                     $carkisa=App\Helpers\Helper::bolumle($villa->area->car,25);
                                                    $cardevam=explode($carkisa,$villa->area->car);
                                                  }
                                                @endphp
                                                <p>{!! isset($villa->area->car) ? $carkisa : '' !!}
                                                </p>
                                                @if(isset($cardevam[1]) && !empty($cardevam[1]))
                                                    <div id="caraciklama" class="Information-content collapse "
                                                         data-parent="#accordionExample">
                                                        <p>{!! isset($villa->area->car) ? $cardevam[1] : '' !!}
                                                            <br>
                                                        </p>
                                                    </div>
                                                    <button class=" Information-buton" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#caraciklama" aria-expanded="true"
                                                            aria-controls="collapseOne">
                                                        Devamını Oku
                                                        <svg class="icon icon-angle-down">
                                                            <use xlink:href="#icon-angle-down">
                                                            </use>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="bus">
                                            <div class="accordion flex-column a-i-c " id="accordionExample">
                                                @php
                                                    if(!empty($villa->area->bus)){
                                                           $buskisa=App\Helpers\Helper::bolumle($villa->area->bus,25);
                                                          $busdevam=explode($buskisa,$villa->area->bus);
                                                        }
                                                @endphp
                                                <p>{!! isset($villa->area->bus) ? $buskisa : '' !!}
                                                </p>
                                                @if(isset($busdevam[1]) && !empty($busdevam[1]))
                                                    <div id="busaciklama" class="Information-content collapse "
                                                         data-parent="#accordionExample">
                                                        <p>{!! isset($villa->area->bus) ? $busdevam[1] : '' !!}
                                                            <br>
                                                        </p>
                                                    </div>
                                                    <button class=" Information-buton" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#busaciklama" aria-expanded="true"
                                                            aria-controls="collapseOne">
                                                        Devamını Oku
                                                        <svg class="icon icon-angle-down">
                                                            <use xlink:href="#icon-angle-down">
                                                            </use>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Villa_detay-map-road-item">
                                    <div class="Villa_detay-map-road-head">
                                        <svg class="icon icon-plane">
                                            <use xlink:href="#icon-plane">
                                            </use>
                                        </svg>
                                        <div class="">
                                            <h6>UÇAK
                                            </h6>
                                            <ul class="nav nav-tabs">
                                                @php
                                                    $sayac = 0;
                                                @endphp
                                                @foreach($villa->area->airportRel as $row)

                                                    <li class="nav-item ">
                                                        <a href="#road{{ $row->airport_id }}" class="nav-link {{ $sayac == 0 ? 'active  ' : '' }}" data-toggle="tab">{{ $row->airport->title }}</a>
                                                    </li>
                                                    @php
                                                        $sayac++;

                                                    @endphp
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        @php
                                            $sayac=0;
                                        @endphp
                                        @foreach($villa->area->airportRel as $row)
                                            <div class="tab-pane fade  {{ $sayac == 0 ? 'active opa' : '' }}" id="road{{ $row->airport_id }}">

                                                <div class="accordion flex-column a-i-c " id="accordionExample{{ $row->airport_id }}">
                                                    @php
                                                        if(!empty($row->content)){
                                                        $kisa =App\Helpers\Helper::bolumle($row->content,25);
                                                        $devam=explode($kisa,$row->content);
                                                      }
                                                    @endphp
                                                </div>
                                                <p>
                                                    {!! $kisa ?? null !!}
                                                </p>
                                                <div id="aciklama-{{$row->airport_id}}" class="Information-content collapse "
                                                     data-parent="#accordionExample{{ $row->airport_id }}">
                                                    <p>{!! $devam[1] ?? null !!}
                                                        <br>
                                                    </p>
                                                </div>
                                                @if(isset($devam[1]) && !empty($devam[1]))
                                                <button class=" Information-buton" type="button"
                                                        data-toggle="collapse"
                                                        data-target="#aciklama-{{$row->airport_id}}" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                    Devamını Oku
                                                    <svg class="icon icon-angle-down">
                                                        <use xlink:href="#icon-angle-down">
                                                        </use>
                                                    </svg>
                                                </button>
                                                @endif


                                            </div>
                                            @php
                                                $sayac++;
                                            @endphp
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sss" class="Villa_detay-sss">
                            <div class="flex a-i-c justify-content-between">
                                <div class="Villa_detay-header flex a-i-c">
                                    <svg class="icon icon-question">
                                        <use xlink:href="#icon-question">
                                        </use>
                                    </svg>
                                    <h4 class="header-lg">MERAK EDİLENLER
                                    </h4>
                                </div>
                                <div class="Villa_detay-sss-video">
                                    <a class="lightview Villa_detay-sss-video-link video-btn2" data-toggle="modal"
                                       data-toggle="modal" data-src="{{$nasil_kiralarim_video}}"
                                       data-target="#myModalSSS">
                                        <svg class="icon icon-play-button-2">
                                            <use xlink:href="#icon-play-button-2">
                                            </use>
                                        </svg>
                                        &nbsp;&nbsp;Nasıl
                                        <strong>&nbsp;Kiralarım ?
                                        </strong>
                                    </a>
                                </div>
                            </div>
                            <div class="accordion " id="accordionExample">
                                @forelse($website->how_articles as $article)
                                    <div class="A_sorular-sss-item">
                                        <button class="A_sorular-sss-item-head " type="button" data-toggle="collapse"
                                                data-target="#sss-{{$article->id}}" aria-expanded="true"
                                                aria-controls="collapseOne">
                                            <h6>
                                                {{$article->title}}
                                            </h6>
                                            <svg class="icon icon-angle-down">
                                                <use xlink:href="#icon-angle-down">
                                                </use>
                                            </svg>
                                        </button>
                                        <div id="sss-{{$article->id}}" class="A_sorular-sss-item-content collapse "
                                             data-parent="#accordionExample">
                                            <p>{!! $article->long_text !!}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    &nbsp;
                                @endforelse
                            </div>
                            <a href="{{ url('/nasil-kiralarim') }}">Tümünü Görüntüle
                            </a>
                        </div>

                        <div id="extra" class="Villa_detay-extra">
                            <div class=" Villa_detay-header flex a-i-fs">
                                <svg class="icon icon-cycling">
                                    <use xlink:href="#icon-cycling">
                                    </use>
                                </svg>
                                <div class="flex-column">
                                    <h4 class="header-lg">EKSTRA AKTİVİTELER
                                    </h4>
                                </div>
                            </div>
                            <div class="Villa_detay-extra-in flex">
                                @forelse($extras as $extra)
                                    <div class="Villa_detay-extra-item ">
                                        @if(isset($extra->seo) && !empty($extra->seo))
                                            <a href="{{ route('extra.detail',$extra->seo->seo_url) }}">
                                                <div class="Villa_detay-extra-item-image ">
                                                    <img src="{{ ImageProcess::getImageByPath($extra->list_image) }}"
                                                         class="w-100"
                                                         alt="{{ $extra->name }}">
                                                </div>
                                            </a>
                                        @else
                                            <div class="Villa_detay-extra-item-image ">
                                                <img src="{{ ImageProcess::getImageByPath($extra->list_image) }}"
                                                     class="w-100"
                                                     alt="{{ $extra->name }}">
                                            </div>
                                        @endif
                                        <h6>
                                            @if(isset($extra->seo) && !empty($extra->seo))
                                                <a href="{{ route('extra.detail',$extra->seo->seo_url) }}">
                                                    {{ $extra->name }}
                                                </a>
                                            @else
                                                {{ $extra->name }}
                                            @endif
                                        </h6>
                                        <p>{!! substr($extra->description,0,100) . "..." !!}
                                        </p>
                                    </div>
                                @empty
                                    Henüz aktivite eklenmedi...
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        {{-- MOBILE-START SLIDER ASAGIDA --}}
    @elseif(Agent::isMobile() || Agent::isTablet())
        <div id="two-inputs" style="display: none">
            <input autocomplete="off" type="text" data-page="detail" id="dgiris_tarih" class="villa_date-input"
                   name="giris_tarih" data-datepicker="separateRange"/>
            <input autocomplete="off" type="text" data-page="detail" id="dcikis_tarih" class="villa_date-input"
                   name="cikis_tarih" data-datepicker="separateRange"/>
        </div>
        <section class="Detail-slider">
                        <div class="swiper-container gallery-top">
                            <span class="bigSizeIcon fa-expand"></span>
                            <button id="detail_prev_btn"><svg class="icon icon-chevron-right" data-original-title="" title=""><use xlink:href="#icon-chevron-right"></use></svg></button>
                            <button id="detail_next_btn"><svg class="icon icon-chevron-right" data-original-title="" title=""><use xlink:href="#icon-chevron-right"></use></svg></button>

                            <div class="swiper-wrapper">
                            @forelse($villa->photos as $photo)
                                <a href="{{ ImageProcess::getImageWatermarkedPath($photo) }}" data-fancybox data-title="{{$villa->name}}" class="swiper-slide " >
                                    <img class="lazy " data-src="{{ ImageProcess::getImageWatermarkedPath($photo) }}" alt="{{$villa->name}}" src="">
                                </a>
                                @empty
                            &nbsp;
                        @endforelse
                            </div>

                        </div>
                        <div class="swiper-container gallery-thumbs "
                             id="gallery-thumbs" style="display: block;">
                            <div class="swiper-wrapper" style="">
                            @forelse($villa->photos as $photo)
                                <button class="swiper-slide">
                                    <img class="lazy "
                                         data-src="{{ ImageProcess::getImageWatermarkedPath($photo) }}"
                                         alt="{{$villa->name}}" src=""
                                         >
                                </button>
                                @empty
                            &nbsp;
                        @endforelse
                                
                            </div>
                        </div>
                    </section>
        <section class="Villa_detayM mobile">
            <div id="rez" class="RezervasyonM">
                <div class="RezervasyonM-head flex a-i-c justify-content-between ">

                    @php
                        $gune_ait_fiyat=floatval(str_replace(",",".",$pricesmin->daily_price_tl));
                    @endphp
                    <p>{{(isset($pricesmin->daily_price_tl)? number_format($gune_ait_fiyat, 0, ',', '.') :'')}} ₺’DEN 
                        <span> Başlayan Fiyatlarla(Gecelik)</span>
                    </p>
                    <a href="#myModal" class="{{ empty($video) ? 'hidden' : '' }} video-btn" data-toggle="modal"
                       data-src="{{$video}}">
                        <svg class="icon icon-play-button-2">
                            <use xlink:href="#icon-play-button-2">
                            </use>
                        </svg>
                        VİDEO İZLE
                    </a>
                </div>
                <div class="RezervasyonM-header flex a-i-c justify-content-between">
                    <div class="RezervasyonM-header-name">
                        <h6>{{$villa->code}}
                        </h6>
                        <p>{{$villa->name}}
                        </p>
                        <h5>REZERVASYON YAP
                        </h5>
                    </div>
                    <div onclick="takvimGetirPriority()" class="RezervasyonM-header-date">
                        <button type="button" data-toggle="modal" data-target="#doluluk-takvimi">Doluluk Takvimi
                        </button>
                    </div>
                </div>
                <form action="{{ route('reservation', [$id])}}" id="rezervasyonForm" method="get">
                    <input type="hidden" name="villa" value="{{$villa->id}}">
                    <div class="Rezervasyon-search-date">
                        <div class="Rezervasyon-search-item  ">
                            <input onclick="takvimGetir()"
                                   id="mgiris_tarih"
                                   class="datepicker" placeholder="Giriş Tarihi"
                                   name="giris" data-page="detail"
                                   type="text" autocomplete="off"
                                   @if(isset($req) AND !empty($req->giris_tarih)) value="{{$req->giris_tarih}}"
                                   data-value="{{$req->giris_tarih}}" @endif ">
                            <svg class="icon icon-date addon">
                                <use xlink:href="#icon-calendar">
                                </use>
                            </svg>
                        </div>
                        <div class="Rezervasyon-search-item villa_date">
                            <input onclick="takvimGetir()"
                                   id="mcikis_tarih"
                                   class="datepicker" placeholder="Çıkış Tarihi"
                                   name="cikis" data-page="detail"
                                   type="text" autocomplete="off"
                                   @if(isset($req) AND !empty($req->cikis_tarih)) value="{{$req->cikis_tarih}}"
                                   data-value="{{$req->cikis_tarih}}" @endif>
                            <svg class="icon icon-date addon">
                                <use xlink:href="#icon-calendar">
                                </use>
                            </svg>
                        </div>
                    </div>
                    <div class="Rezervasyon-search-item villa_tur">
                        <div class="Dropdown">
                            <button class="Dropdown-buton" type="button">
                                <b id="mtotal_person">1
                                </b> Kişi
                                <span class="Dropdown-buton-person">
                                        (
                                        <b id="mtotal_adult">1
                                        </b> Yetişkin,
                                        <b id="mtotal_child">0
                                        </b> Çocuk,
                                        <b id="mtotal_baby">0
                                        </b> Bebek )
                                        </span>
                            </button>
                            <div class="Dropdown-menu  Rezervasyon-search-person ">
                                <div class="Dropdown-menu-item">
                                    <p>Yetişkin
                                    </p>
                                    <div class="Dropdown-menu-item-spinner ">
                                        <button id="m-adult-button" data-max="{{ $villa->max_adult }}" type="button"
                                                onclick="eksilt(this,1,'m','adult')">
                                            <svg class="icon icon-minus">
                                                <use xlink:href="#icon-minus">
                                                </use>
                                            </svg>
                                        </button>
                                        <input type="text" value="1" name="adult" style="display: block;"
                                               readonly="readonly">
                                        <button type="button" id="m-adult-button" data-max="{{$villa->max_adult}}"
                                                onclick="arttir(this,'{{$villa->max_adult}}','m','adult')">
                                            <svg class="icon icon-plus">
                                                <use xlink:href="#icon-plus">
                                                </use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="Dropdown-menu-item">
                                    <p>Çocuk
                                        <span>6-13 Yaş Arası</span>
                                    </p>
                                    <div class="Dropdown-menu-item-spinner ">
                                        <button type="button" onclick="eksilt(this,0,'m','child')">
                                            <svg class="icon icon-minus">
                                                <use xlink:href="#icon-minus">
                                                </use>
                                            </svg>
                                        </button>
                                        <input type="text" value="0" name="child" style="display: block;"
                                               readonly="readonly">
                                        <button type="button" id="m-child-button" data-max="{{$villa->max_child}}"
                                                onclick="arttir(this,'9{{$villa->max_child}}00','m','child')">
                                            <svg class="icon icon-plus">
                                                <use xlink:href="#icon-plus">
                                                </use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="Dropdown-menu-item">
                                    <p>Bebek
                                        <span>0-5 Yaş Arası</span>
                                    </p>
                                    <div class="Dropdown-menu-item-spinner ">
                                        <button type="button" onclick="eksilt(this,0,'m','baby')">
                                            <svg class="icon icon-minus">
                                                <use xlink:href="#icon-minus">
                                                </use>
                                            </svg>
                                        </button>
                                        <input type="text" value="0" name="baby" style="display: block;"
                                               readonly="readonly">
                                        <button type="button" onclick="arttir(this,'{{$villa->max_baby}}','m','baby')">
                                            <svg class="icon icon-plus">
                                                <use xlink:href="#icon-plus">
                                                </use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="Dropdown-menu-item">
                                    <button id="ZarazCustomize" class="Dropdown-close" type="button">
                                        ONAYLA
                                    </button>
                                </div>
                            </div>
                            <div id="kisi_uyari" class="text-danger" style="display: none">
                                <small>Lütfen kişi sayısı seçiniz</small>
                            </div>
                        </div>
                        <svg class="icon icon-caret-down addon">
                            <use xlink:href="#icon-caret-down">
                            </use>
                        </svg>
                    </div>
                    <input class="Rezervasyon-gonder" style="display: {{$btndisplay}}" type="button" id="mmst_btn"
                           value="MÜSAİTLİK SORGULA">
                    <div class="Rezervasyon-info" style="display: {{$divdisplay}}" id="mreservation_info">
                        <h6 class="Rezervasyon-info-head">REZERVASYON DETAYLARI
                        </h6>
                        <div class="Rezervasyon-info-item">
                                <span>
                                    <b id="mgecelik_fiyat">{{$gecelik_fiyat}}
                                    </b> x
                                    <b id="mgece_sayisi">{{$gece_sayisi}}
                                    </b> Gece
                                </span>
                            <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true" id="mfiyat_tooltip"
                                 data-placement="top"
                                 title="{{$gun_ve_fiyat}}">
                                <use xlink:href="#icon-unlem">
                                </use>
                            </svg>
                            <span id="mtoplam_fiyat">{{$toplam_fiyat}}</span>
                        </div>
                        <div class="Rezervasyon-info-item">
                            <span>Temizlik Ücreti
                            </span>
                            <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true" data-placement="top"
                                 title="{{ $price->min_stay_cleaning_price ?? 7 }} geceden az konaklamalardan temizlik ücreti alınır">
                                <use xlink:href="#icon-unlem">
                                </use>
                            </svg>
                            <span id="mtemizlik_ucreti">{{$temizlik_ucreti}}</span>
                        </div>
                        <h6 class="Rezervasyon-info-head">Ödeme Planı
                        </h6>
                        <div class="Rezervasyon-info-item">
                                <span>Ön Ödeme
                                </span>
                            <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true" data-placement="top"
                                 title="Yerinizi ayırtmak için ödemeniz gereken tutar">
                                <use xlink:href="#icon-unlem">
                                </use>
                            </svg>
                            <span id="mon_odeme">{{$on_odeme}}</span>
                        </div>
                        <div class="Rezervasyon-info-item">
                                <span> Kalan Ödeme
                                </span>
                            <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true" data-placement="top"
                                 title="Villaya Girişte Ödenecek Tutar">
                                <use xlink:href="#icon-unlem">
                                </use>
                            </svg>
                            <span id="mkalan_odeme">{{$kalan_odeme}}</span>
                        </div>
                        <div class="Rezervasyon-info-toplam">
                            <span>TOPLAM
                            </span>
                            <p id="mhesap_toplam">{{$hesap_toplam}}
                            </p>
                        </div>
                        <small id='rezervasyon_uyari' style='display:none;margin:-5px;font-size:0.75em;color:#ff0000;'>
                            Seçtiğiniz sezon için minimum konaklama süresi <b id="rezMinKonaklama"></b> gecedir siz <b
                                id="rezGeceSayisi"></b> gece seçtiniz
                        </small>
                        <small id='rezervasyon_var_uyari'
                               style='display:none;margin:-5px;font-size:0.75em;color:#ff0000;'>Seçtiğiniz tarihler
                            doludur <b>lütfen doluluk takvimini kontrol ederek farklı bir tarih seçiniz</b></small>
                        <small id='rezervasyon_uyari_fiyatsiz'
                               style='display:none;margin:-5px;font-size:0.75em;color:#ff0000;'>Seçtiğiniz tarih
                            aralıkları için villamızın fiyatları henüz belirlenmemiştir lütfen daha farklı bir tarih
                            seçiniz
                        </small>
                        <input class="Rezervasyon-gonder-zaraz" id="Rezervasyon_gonderBtn"
                               onclick="rezervasyonButtonControl('m')" type="button" value="REZERVASYON YAP">
                        <div class="Rezervasyon-info-bilgi">
                            <p>Henüz bir ödeme yapmayacaksınız
                            </p>
                            <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true" data-placement="top">
                                <use xlink:href="#icon-unlem">
                                </use>
                            </svg>
                        </div>
                    </div>
                </form>
            </div>
            <div class="Villa_detay-property">
                <div class=" Villa_detay-property-name">
                        <span>VİLLA KODU
                        </span>
                    <h6 class="header-lg">{{$villa->code}}
                    </h6>
                </div>
                <div class=" Villa_detay-property-in flex a-i-c justify-content-between">
                    <div class="Villa_detay-property-item">
                        <svg class="icon icon-location">
                            <use xlink:href="#icon-location">
                            </use>
                        </svg>
                        <p>
                    <span>KONUM
                    </span>{{ isset($villa->area->name) ? $villa->area->name : '' }}
                        </p>
                    </div>
                    <div class="Villa_detay-property-item">
                        <svg class="icon icon-user">
                            <use xlink:href="#icon-user">
                            </use>
                        </svg>
                        <p>
                        <span>KİŞİ SAYISI
                        </span>{{$villa->number_person}} Kişilik
                        </p>
                    </div>
                    <div class="Villa_detay-property-item">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.401 7.734v-5.01A2.727 2.727 0 0 0 14.677 0H4.674A2.727 2.727 0 0 0 1.95 2.724v5.03a2.644 2.644 0 0 0-1.823 2.508v5.086a.31.31 0 1 0 .618 0v-2.163H18.67v2.163a.31.31 0 0 0 .618 0v-5.086a2.645 2.645 0 0 0-1.886-2.528zM2.568 7.623V2.725c0-1.162.944-2.107 2.106-2.107h10.002c1.162 0 2.107.945 2.107 2.107v4.898H15.34V3.605a.31.31 0 0 0-.31-.309H4.32a.31.31 0 0 0-.31.31v4.017H2.568zm2.06 0V3.915h4.738v3.708H4.628zm5.356-3.708h4.739v3.708H9.983V3.915zm-9.24 8.652v-2.304c0-1.115.908-2.022 2.022-2.022h13.88c1.116 0 2.022.907 2.022 2.022v2.304H.745z" fill="#fff"/>
                        </svg>
                        <p>
                            <span>YATAK ODASI
                            </span>{{$villa->number_bedroom}} Adet
                        </p>
                    </div>
                    <div class="Villa_detay-property-item">
                        <svg class="icon icon-shower">
                            <use xlink:href="#icon-shower">
                            </use>
                        </svg>
                        <p>
                        <span>BANYO
                        </span>{{$villa->number_bathroom}} Adet
                        </p>
                    </div>
                </div>
            </div>
            <div class="Villa_detay-price">
                <div class="Villa_detay-header flex a-i-c">
                    <svg class="icon icon-card">
                        <use xlink:href="#icon-card">
                        </use>
                    </svg>
                    <h4 class="header-lg">FİYATLANDIRMALAR
                    </h4>
                </div>
                <div class="Villa_detay-price-info">
                    <div class="Villa_detay-price-info-head ">
                        <p>
          <span>{{$villa->name}}
          </span>VİLLA FİYATLARI
                        </p>
                      
                    </div>
                    <div class="Villa_detay-price-in ">
                        <div class="Villa_detay-price-left flex-column">
                            <p class="thead">
        <span>Gecelik
        </span>
                                <span>Haftalık
        </span>
                            </p>
                            <div class="tab-content">
                                <div class="tab-pane fade active opa" id="tab1">
                                    @forelse($prices as $price)
                                        @php

                                            $cikisYil=Carbon\Carbon::parse($req->end_date)->format('Y');
                                        if(($price->start_date>="$cikisYil-06-01" && $price->start_date<="$cikisYil-09-30") || ($price->end_date>="$cikisYil-06-01" && $price->end_date<="$cikisYil-09-30")){
                                                $villa_min_accommodation=(isset($villa->min_accommodation_season)?$villa->min_accommodation_season:0);
                                            }else{
                                                $villa_min_accommodation=(isset($villa->min_accommodation)?$villa->min_accommodation:0);
                                            }
                                        @endphp
                                        <div class="Villa_detay-price-item">
                                            <p class="Villa_detay-price-item-date">
                                                <strong>{{ isset($price->start_date) ?  iconv('latin5','utf-8',\Carbon\Carbon::parse($price->start_date)->formatLocalized('%d %B %Y')) : 'Belirtilmedi'}}
                                                    -
                                                    {{isset($price->end_date) ? iconv('latin5','utf-8',\Carbon\Carbon::parse($price->end_date)->formatLocalized('%d %B %Y')): 'Belirtilmedi'}}
                                                </strong>
                                                <span>

                                            @php
                                                if(isset($price->min_accommodation)){
                                                $min_acc=$price->min_accommodation;
                                                }else{
                                                $min_acc=$villa_min_accommodation;
                                                }

                                                if(isset($price->short_stay)){
                                                $cleaning_price=$price->short_stay;
                                                }else{
                                                $cleaning_price=$villa->default_cleaning_price;
                                                }
                                                $price_if_min_stay_cleaning = $price->min_stay_cleaning_price ?? 7;
                                            @endphp
                                            Minimum Kiralama : {{$min_acc}} Gece
                                        @if(!empty($cleaning_price) && $cleaning_price!=0 && ($price_if_min_stay_cleaning > $min_acc))
                                                        <svg class="icon icon-unlem temizlik-tooltip" data-toggle="tooltip"
                                                             data-html="true"
                                                             data-placement="top"
                                                             title="7 gece altındaki konaklamalardan {{$cleaning_price}} ₺  Temizlik ücreti alınır">
                                                        <use xlink:href="#icon-unlem">
                                                        </use>
                                                        @endif
                                                    </svg>
                                                    </span>
                                            </p>

                                            @php
                                                $gune_ait_fiyat=floatval(str_replace(",",".",$price->daily_price_tl));
                                                $haftalik_fiyat=ceil($gune_ait_fiyat*7);
                                            @endphp
                                            <span
                                                class="Villa_detay-price-item-cash">{{ isset($price->daily_price_tl) ? number_format($gune_ait_fiyat, 0, ',', '.'). ' ₺' : 'Belirtilmedi' }} </span>
                                            <span
                                                class="Villa_detay-price-item-cash">{{ isset($price->daily_price_tl) ? number_format($haftalik_fiyat, 0, ',', '.') . ' ₺' : 'Belirtilmedi' }}</span>
                                        </div>
                                    @empty
                                        &nbsp;
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="Villa_detay-price-right">
                        <ul class="nav nav-tabs ">
                            <li class="nav-item ">
                                <a href="#mpaidin" class="nav-link active " data-toggle="tab">
                                    ÜCRETE DAHİL OLANLAR
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="#mnonpaid" class="nav-link  " data-toggle="tab">
                                    ÜCRETE DAHİL OLMAYANLAR
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active opa" id="mpaidin">
                                <ul>
                                    @if(isset($paidins))
                                        @foreach($paidins as $paidin)
                                            <li>
                                                {{$paidin->property}}
                                                @if(isset($paidin->description))
                                                    <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true"
                                                         data-placement="top" title="{{$paidin->description}}">
                                                        <use xlink:href="#icon-unlem">
                                                        </use>
                                                    </svg>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-pane fade " id="mnonpaid">
                                <ul>
                                    @if(isset($nonpaids))
                                        @foreach($nonpaids as $nonpaid)
                                            <li>
                                                {{$nonpaid->property}}
                                                @if(isset($nonpaid->description))
                                                    <svg class="icon icon-unlem" data-toggle="tooltip" data-html="true"
                                                         data-placement="top" title="{{$nonpaid->description}}">
                                                        <use xlink:href="#icon-unlem">
                                                        </use>
                                                    </svg>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Villa_detay-info">
                <div class="Villa_detay-header flex a-i-c">
                    <svg class="icon icon-target">
                        <use xlink:href="#icon-target">
                        </use>
                    </svg>
                    <h4 class="header-lg">GENEL BAKIŞ
                    </h4>
                </div>
                <h5 class="Villa_detay-info-head">VİLLA AÇIKLAMASI
                </h5>
                <p>@if($villa->panel_villa && $villa->panel_villa->description){!! $villa->panel_villa->description !!}@else {!! $villa->description !!}@endif
                </p>
                <h5 class="Villa_detay-info-head">VİLLANIN ÖNE ÇIKAN ÖZELLİKLERİ
                </h5>
                <ul>
                    @if(isset($prominents))
                        @foreach($prominents as $prominent)
                            <li class="text">{{$prominent->name}}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            @if(isset($vfloors) && !empty($vfloors))
                <div id="kat" class="Villa_detay-floor">
                    <div class="Villa_detay-header flex a-i-c">
                        <svg class="icon icon-house">
                            <use xlink:href="#icon-house">
                            </use>
                        </svg>
                        <h4 class="header-lg">VİLLA KAT PLANI
                        </h4>
                        <a class="ml-auto galleryxyz">VİLLANIN TÜM FOTOĞRAFLARI
                        </a>
                    </div>
                    <div class="Villa_detay-floor-head">
                        <ul class="nav nav-tabs">
                            @foreach($vfloors as $katustkey=>$floor)
                                @php
                                    $kat =  \App\FloorPlan::where('id',$floor->floor_id)->first();
                                @endphp
                                <li class="nav-item ">
                                    <a href="#kat{{$kat->id}}"
                                       class="nav-link {{($katustkey==0)? 'active show':''}} "
                                       data-toggle="tab">{{$kat->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        {{--<span class="header-sm">{{$villa->name}}--}}
                        {{--</span>--}}
                    </div>
                    <div class="tab-content tab_oda">
                        @foreach($vfloors as $katickey=>$flooric)
                            @php
                                #$kat =  \App\FloorPlan::where('id',$flooric->floor_id)->first();
                                #$bolumler =  \App\VillaPart::where('villa_id',$villa->id)->where('floor_id',$flooric->id)->get();
                                $kat = $flooric->floor;
                                $bolumler = $flooric->parts;
                            @endphp
                            <div class="tab-pane fade {{($katickey==0)? 'active show':''}}" id="kat{{$kat->id}}">
                                <ul class="nav nav-tabs " style="width: 100%">
                                    @foreach($bolumler as $odaustkey=>$bolumust)
                                        @php #$part = App\Part::where('id',$bolumust->part_id)->first(); @endphp
                                        @php $part = $bolumust->part; @endphp
                                        <li class="nav-item kat-secenek">
                                            <a href="#oda{{$katickey . $odaustkey}}"
                                               class="nav-link {{($odaustkey==0)? 'active show':''}}"
                                               data-toggle="tab">{{$part->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach($bolumler as $odakey=>$bolum)
                                        @php
                                            #$partic = App\Part::where('id',$bolum->part_id)->first();
                                            #$materialler =  \App\VillaMaterial::select("material_id")->where("villa_id",$villa->villa_id)->where("floor_id",$flooric->id)->where("part_id",$bolum->id)->get();
                                            #$resimler =  \App\VillaPartPhoto::select("photo_id")->where('villa_id',$villa->villa_id)->where('floor_id',$flooric->id)->where("part_id",$bolum->id)->get();
                                            #$havuzbilgileri =  \App\VillaMaterialSpeacialInfo::where('villa_id',$villa->villa_id)->where('floor_id',$flooric->id)->where("part_id",$bolum->id)->first();
                                            #$materials = App\Material::whereIn('id',$materialler)->get();
                                            #$images = App\VillaPhoto::whereIn('id',$resimler)->orderBy('ranking')->get();

                                            $partic = $bolum->part;
                                            $materialler =  $bolum->materials;
                                            $materials = $materialler;
                                            $resimler =  $bolum->photos;
                                            $images = $bolum->photos;
                                            $havuzbilgileri = $bolum->special_info;
                                        @endphp

                                        <div class="tab-pane fade {{($odakey==0)? 'active':''}} opa"
                                             id="oda{{$katickey . $odakey}}">
                                            <div class="swiper-container-detay">
                                                @if(is_null($images) || empty($images))

                                                @else
                                                    <div class="swiper-container swiper-container-floor {{ "s".$katickey."-".$odakey }}" data-id="{{ "s".$katickey."-".$odakey }}">
                                                        <div class="swiper-wrapper">
                                                            @foreach($images as $ikey=>$image)
                                                                <div {{--data-background="{{ asset('images/default.jpg') }}"--}} class="swiper-slide ">
                                                                    <img class="swiper-lazy w-100" data-src="{{ ImageProcess::getImageWatermarkedPath($image->photo, true) }}">
                                                                    <div class="swiper-lazy-preloader"></div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <!-- If we need navigation buttons -->
                                                        <div class="swiper-button-next">
                                                            <svg class="icon icon-chevron-right">
                                                                <use xlink:href="#icon-chevron-right"></use>
                                                            </svg>
                                                        </div>
                                                        <div class="swiper-button-prev">
                                                            <svg class="icon icon-chevron-right">
                                                                <use xlink:href="#icon-chevron-right"></use>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="Villa_detay-floor-info">
                                                <h6 class="Villa_detay-floor-info-head">{{$partic->name}}</h6>
                                                <p><span>İçindekiler </span>:&nbsp;&nbsp;
                                                    @foreach($materials as $material)&nbsp;-
                                                    &nbsp;{{$material->material->name}}&nbsp;&nbsp;@endforeach
                                                </p>
                                                @if(isset($havuzbilgileri->special_info))
                                                    <p>
                                                        <span>Ek Bilgi
                                                        </span>:&nbsp;&nbsp;{{$havuzbilgileri->special_info}}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="Villa_detay-map">
                <div class="Villa_detay-header flex a-i-c">
                    <svg class="icon icon-location2">
                        <use xlink:href="#icon-location2">
                        </use>
                    </svg>
                    <h4 class="header-lg">ULAŞIM
                    </h4>
                </div>
                <div class="Villa_detay-map-in ">
                    <div class="Villa_detay-map-info">
                        <h6>MESAFELER
                        </h6>
                        <div class="flex wrap">
                            <div class="Villa_detay-map-item">
                                <svg class="icon icon-airport">
                                    <use xlink:href="#icon-airport">
                                    </use>
                                </svg>
                                <p>Havaalanı Mesafesi
                                    <span>{{$villa->airport_distance}}
              </span>
                                </p>
                            </div>
                            <div class="Villa_detay-map-item">
                                <svg class="icon icon-sea">
                                    <use xlink:href="#icon-sea">
                                    </use>
                                </svg>
                                <p>Deniz Mesafesi
                                    <span>{{$villa->sea_distance}}
              </span>
                                </p>
                            </div>
                            <div class="Villa_detay-map-item">
                                <svg class="icon icon-market">
                                    <use xlink:href="#icon-market">
                                    </use>
                                </svg>
                                <p>Market Mesafesi
                                    <span>{{$villa->shop_distance}}
              </span>
                                </p>
                            </div>
                            <div class="Villa_detay-map-item">
                                <svg class="icon icon-medicane">
                                    <use xlink:href="#icon-medicane">
                                    </use>
                                </svg>
                                <p>Hastane Mesafesi
                                    <span>{{$villa->hospital_distance}}
              </span>
                                </p>
                            </div>
                            <div class="Villa_detay-map-item">
                                <svg class="icon icon-restorant">
                                    <use xlink:href="#icon-restorant">
                                    </use>
                                </svg>
                                <p>Restaurant Mesafesi
                                    <span>{{$villa->restaurant_distance}}
              </span>
                                </p>
                            </div>
                            <div class="Villa_detay-map-item">
                                <svg class="icon icon-house2">
                                    <use xlink:href="#icon-house2">
                                    </use>
                                </svg>
                                <p>Merkez Mesafesi
                                    <span>{{$villa->center_distance}}
              </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <a target="_blank"
                       href="https://www.google.com/maps/place/{{ $villa->coordinate_x }},{{ $villa->coordinate_y }}"
                       class="Villa_detay-map-info-link">
                        <svg class="icon icon-location">
                            <use xlink:href="#icon-location"></use>
                        </svg>
                        HARİTADA GÖSTER
                    </a>
                </div>
                <div class="Villa_detay-map-Mheader">
                    <h5 class="Villa_detay-info-head">BU VİLLAYA NASIL GİDERİM ?
                    </h5>
                    <ul class="nav nav-tabs " style="width: 100%">
                        <li class="nav-item ">
                            <a href="#roadm1" class="nav-link active " data-toggle="tab">KARAYOLU
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="#roadm2" class="nav-link  " data-toggle="tab">UÇAK
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="Villa_detay-map-road flex ">
                    <div class="tab-content">
                        <div class="tab-pane fade active opa" id="roadm1">
                            <div class="Villa_detay-map-road-item">
                                <div class="Villa_detay-map-road-head">
                                    <div class="Villa_detay-map-road-link">
                                        <ul class="nav nav-tabs ">
                                            <li class="nav-item ">
                                                <a href="#mcar" class="nav-link active " data-toggle="tab">Şahsi Araç
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="#mbus" class="nav-link  " data-toggle="tab">Otobüs
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="mcar">
                                        <div class="accordion flex-column a-i-c " id="accordionExample">
                                            @php if(!empty($villa->area->car)){ $carkisa=App\Helpers\Helper::bolumle($villa->area->car,10);
                  $cardevam=explode($carkisa,$villa->area->car);
                }
                                            @endphp
                                            <p>{!! isset($villa->area->car) ? $carkisa : ''  !!}
                                            </p>
                                            <div id="mcaraciklama" class="Information-content collapse "
                                                 data-parent="#accordionExample">
                                                <p>{!! isset($villa->area->car) ? $cardevam[1] : ''  !!}
                                                    <br>
                                                </p>
                                            </div>
                                            <button class=" Information-buton" type="button" data-toggle="collapse"
                                                    data-target="#mcaraciklama" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                Devamını Oku
                                                <svg class="icon icon-angle-down">
                                                    <use xlink:href="#icon-angle-down">
                                                    </use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="mbus">
                                        <div class="accordion flex-column a-i-c " id="accordionExample">
                                            @php
                                                if(!empty($villa->area->bus)){  $buskisa=App\Helpers\Helper::bolumle($villa->area->bus,10);
                                                  $busdevam=explode($buskisa,$villa->area->bus);
                                                }
                                            @endphp
                                            <p>{!!  isset($villa->area->bus) ? $buskisa :'' !!}
                                            </p>
                                            <div id="mbusaciklama" class="Information-content collapse "
                                                 data-parent="#accordionExample">
                                                <p>{!!  isset($villa->area->bus) ? $busdevam[1] :'' !!}
                                                    <br>
                                                </p>
                                            </div>
                                            <button class=" Information-buton" type="button" data-toggle="collapse"
                                                    data-target="#mbusaciklama" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                Devamını Oku
                                                <svg class="icon icon-angle-down">
                                                    <use xlink:href="#icon-angle-down">
                                                    </use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="roadm2">
                            <div class="Villa_detay-map-road-item">
                                <div class="Villa_detay-map-road-head">
                                    <div class="">
                                        <ul class="nav nav-tabs ">
                                            <li class="nav-item ">
                                                <a href="#mfly_dalaman" class="nav-link active " data-toggle="tab">DALAMAN
                                                    H. L
                                                </a>
                                            </li>
                                            <li class="nav-item  ">
                                                <a href="#mfly_antalya" class="nav-link  " data-toggle="tab">ANTALYA H.
                                                    L.
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active opa" id="mfly_dalaman">
                                        <div class="accordion flex-column a-i-c " id="accordionExample">
                                            @php
                                                if(!empty($villa->area->fly_dalaman)){
                                                 $dalamankisa=App\Helpers\Helper::bolumle($villa->area->fly_dalaman,10);
                                                $dalamandevam=explode($dalamankisa,$villa->area->fly_dalaman);
                                              }
                                            @endphp
                                            <p>{!! isset($villa->area->fly_dalaman) ? $dalamankisa : '' !!}
                                            </p>
                                            <div id="mdalamanaciklama" class="Information-content collapse "
                                                 data-parent="#accordionExample">
                                                <p>{!! isset($villa->area->fly_dalaman) ? $dalamandevam[1] : '' !!}
                                                    <br>
                                                </p>
                                            </div>
                                            <button class=" Information-buton" type="button" data-toggle="collapse"
                                                    data-target="#mdalamanaciklama" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                Devamını Oku
                                                <svg class="icon icon-angle-down">
                                                    <use xlink:href="#icon-angle-down">
                                                    </use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="mfly_antalya">
                                        <div class="accordion flex-column a-i-c " id="accordionExample">
                                            @php
                                                if(!empty($villa->area->fly_antalya)){
                                                     $antalyakisa=App\Helpers\Helper::bolumle($villa->area->fly_antalya,10);
                                                    $antalyadevam=explode($antalyakisa,$villa->area->fly_antalya);
                                                  }
                                            @endphp
                                            <p>{!! isset($villa->area->fly_antalya) ? $antalyakisa : '' !!}
                                            </p>
                                            <div id="mantalyaaciklama" class="Information-content collapse "
                                                 data-parent="#accordionExample">
                                                <p>{!! isset($villa->area->fly_antalya) ? $antalyadevam[1] : '' !!}
                                                    <br>
                                                </p>
                                            </div>
                                            <button class=" Information-buton" type="button" data-toggle="collapse"
                                                    data-target="#mantalyaaciklama" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                Devamını Oku
                                                <svg class="icon icon-angle-down">
                                                    <use xlink:href="#icon-angle-down">
                                                    </use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Villa_detay-sss">
                <div class="Villa_detay-header flex a-i-c">
                    <svg class="icon icon-question">
                        <use xlink:href="#icon-question">
                        </use>
                    </svg>
                    <h4 class="header-lg">MERAK EDİLENLER
                    </h4>
                </div>
                <div class="accordion " id="msss">
                    @forelse($website->how_articles as $article)
                        <div class="A_sorular-sss-item">
                            <button class="A_sorular-sss-item-head " type="button" data-toggle="collapse"
                                    data-target="#msss-{{$article->id}}" aria-expanded="true"
                                    aria-controls="collapseOne">
                                <h6>
                                    {{$article->title}}
                                </h6>
                                <svg class="icon icon-angle-down">
                                    <use xlink:href="#icon-angle-down">
                                    </use>
                                </svg>
                            </button>
                            <div id="msss-{{$article->id}}" class="A_sorular-sss-item-content collapse "
                                 data-parent="#msss">
                                <p>{!!$article->long_text!!}
                                </p>
                            </div>
                        </div>
                    @empty
                        &nbsp;
                    @endforelse
                </div>
                <div class="Villa_detay-sss-bottom flex a-i-c mt-4">
                    <a href="{{ url('/nasil-kiralarim') }}" class="Villa_detay-sss-bottom-tum">Tümünü Görüntüle
                    </a>
                    <div class="Villa_detay-sss-video">
                        <a class="lightview Villa_detay-sss-video-link video-btn2"
                           data-toggle="modal"
                           data-toggle="modal" data-src="{{$nasil_kiralarim_video}}" data-target="#myModalSSS">
                            <svg class="icon icon-play-button-2">
                                <use xlink:href="#icon-play-button-2">
                                </use>
                            </svg>
                            &nbsp;&nbsp;Nasıl
                            <strong>&nbsp;Kiralarım ?
                            </strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="Villa_detay-extra">
                <div class=" Villa_detay-header flex a-i-c">
                    <svg class="icon icon-cycling">
                        <use xlink:href="#icon-cycling">
                        </use>
                    </svg>
                    <h4 class="header-lg">EXTRA
                    </h4>
                </div>
                <p class="mt-3">
                    {!! $website->general_setting->general_description !!}
                </p>
                <div class="Villa_detay-extra-in flex wrap">

                    @forelse($extras as $extra)
                        <div class="Villa_detay-extra-item ">
                            @if(isset($extra->seo) && !empty($extra->seo))
                                <a href="{{ route('extra.detail',$extra->seo->seo_url) }}">
                                    <div class="Villa_detay-extra-item-image ">
                                        <img src="{{ImageProcess::getImageByPath( $extra->list_image) }}"
                                             class="w-100 hvr-float-shadow"
                                             alt="{{ $extra->name }}">
                                    </div>
                                </a>
                            @else
                                <div class="Villa_detay-extra-item-image ">
                                    <img src="{{ImageProcess::getImageByPath( $extra->list_image) }}"
                                         class="w-100 hvr-float-shadow"
                                         alt="{{ $extra->name }}">
                                </div>
                            @endif
                            <h6>
                                @if(isset($extra->seo) && !empty($extra->seo))
                                    <a href="{{ route('extra.detail',$extra->seo->seo_url) }}">
                                        {{ $extra->name }}
                                    </a>
                                @else
                                    {{ $extra->name }}
                                @endif
                            </h6>
                            <p>{!! substr($extra->description,0,100) . "..." !!}
                            </p>
                        </div>
                    @empty
                        Henüz aktivite eklenmedi...
                    @endforelse

                </div>
            </div>
            <a href="#rez" class="Villa_detayM-rez_fix">REZERVASYON YAP
            </a>
        </section>
        {{-- MOBILE-END --}}
    @endif




    <div class=" modal n_Modal fade " id="OnRezervasyonM1" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="n_Modal-in">
                <div class="n_Modal-left">
                    <button type="button" class="close mobile" data-dismiss="modal" aria-label="Close">

                    </button>
                    <h6>{{$villa->name}} İÇİN</h6>
                    <h5>
                        Rezervasyon <br>
                        Talebi Gönder
                    </h5>
                    <p>
                        Satış ekibimiz tesisle ilgili son kontrolleri yapıp sms veya telefonla size geri dönüş
                        sağlayacaktır.
                    </p>
                </div>
                <div class="n_Modal-right">
                    <button type="button" class="close desktop" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Kapat</span>
                    </button>
                    <form action="" id="OnRezervasyonM1Form">
                        <h5>Bilgileriniz</h5>
                        <div class="n_Modal-form">
                            <div class="Rez-left-item">
                                <input type="text" required="required" name="name" class="form-control"
                                       placeholder="Ad Soyad" id="name">
                            </div>
                            <div class="Rez-left-item">
                                <input type="email" required="required" name="email" class="form-control"
                                       placeholder="E-posta Adresiniz" id="email">
                            </div>
                            <div class="Rez-left-item" style="z-index: 999">
                                <input type="tel"   required="required"
                                       id="phone" name="phone" class="form-control"   placeholder="Telefon Numaranız">
                            </div>


                            <div class="nCheckbox">
                                <input id="kvkk" type="checkbox">
                                <label for="kvkk">

                                    <a href="{{route('kvkk')}}" target="_blank">KVKK Aydınlatma Metni</a>’ni okudum kabul ediyorum.
                                </label>
                            </div>
                            <input type="submit" class="Rez-left-gonder" id="checkout-zaraz"  value="ÜCRETSİZ TALEP GÖNDER">
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
