@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@push('extrahead')
    <link rel="stylesheet" href="{{ asset('css/library/intlTelInput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css')}}">

    @if(isset($req['giris_tarih']) && isset($req['cikis_tarih']) && isset($villa))
       
        <style>
            .hidden {
                display: none
            }
        </style>
      
        <style>
            .payment_type_desc {
                display: none;
            }
        </style>


    @endif
@endpush
@push('javascripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/card/1.3.1/js/card.min.js"></script>
<script>
    new Card({
        form: 'form',
        container: '.card',
        formSelectors: {
            numberInput: 'input[name=number]',
            expiryInput: 'input[name=expiry]',
            cvcInput: 'input[name=cvv]',
            nameInput: 'input[name=cart_name]'
        },

        width: 390, // optional — default 350px
        formatting: true,

        placeholders: {
            number: '•••• •••• •••• ••••',
            name: 'Ad Soyad',
            expiry: '••/••',
            cvc: '•••'
        }
    })
</script>

<script>
    $(function () {
        $('.nav-pills').on('click', 'a[data-toggle="tab"] input[type=radio]', function(event) {
            event.stopPropagation();
            $(this).parent().tab('show');
        });
        $('.nav-pills .nav-link').click(function () {
        $('.nav-link').find('input[type=radio]').attr('checked',true);
        $('.nav-link.active').find('input[type=radio]').attr('checked',false);
    });
    });
</script>
    <script>
        (function($) {
            $.fn.inputFilter = function(inputFilter) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            };
        }(jQuery));
        $(document).ready(function() {
            $('input[name="idnumber"]').inputFilter(function(value) {
                return /^\d*$/.test(value);    // Allow digits only, using a RegExp
            });
        });
    </script>

    <script src="{{ asset('js/library/intlTelInput-jquery.min.js') }}">
    </script>
    <script src="{{asset('js/loadingoverlay.min.js')}}"></script>
    <script type="text/javascript">
        function checkle(x) {
            $(".rezonay").prop('checked', true);
            $(".rezonay").attr('onchange', 'checksil(this)');
        }

        function checksil(x) {
            $(".rezonay").prop('checked', false);
            $(".rezonay").attr('onchange', 'checkle(this)');
        }

        function ulkeKoduSec(x) {
            $(x).val();
        }

        $("form").submit(function () {
            $("#prephone").val($("#phone").intlTelInput("getSelectedCountryData").dialCode);
            //$("body").LoadingOverlay("show");
        });
        $("#phone").intlTelInput({
            formatOnDisplay: false,
            nationalMode: false,
            autoPlaceholder: 'aggressive',
            separateDialCode: true,
            preferredCountries: ['TR', 'DE', 'FR', 'AT', 'NL', 'BE', 'CH', 'GB', 'RU'],
        });

        @if(Agent::isMobile())
        $("input[type='radio']").change(function () {
            var type = $(this).val();
            $(".payment_type_desc").hide();
            $("#payment_type_" + type).show();
        });
        @endif
        $(document).on('click', '#tckontrol', function () {
            var checked = $(this).prop('checked');
            if (checked == true) {
                /*tcvatandasi degilim*/
                $('input[name="idnumber"]').prop('disabled', true)
            } else {
                $('input[name="idnumber"]').prop('disabled', false)
            }
        })
        $(document).on('click', '#faturabilgi_kontrol', function () {

            if ($(this).prop('checked') == true) {
                /*fatura[] formunda yer alan butun hepsini disabled edelim*/

                $(document).find('input[name="fatura_kesilecek"]').val('1');
                $(document).find('.fatura-aciklama').removeClass('hidden');
                $(document).find("input[name^='fatura']").attr('disabled', false);
                $(document).find("input[name^='fatura']").attr('disabled', false);
                $(document).find("select[name^='fatura']").attr('disabled', false);
                $(document).find("input[name^='fatura']").closest('.Rez-left-price_type-item').removeClass('hidden');
                $(document).find("input[name^='fatura']").removeClass('hidden');
                $(document).find("select[name^='fatura']").removeClass('hidden');

                $(document).find('div[data-group]').addClass('hidden');
                $(document).find('div[data-group]').find('input').attr('disabled', true);

                $(document).find('div[data-group="' + 0 + '"]').removeClass('hidden');
                $(document).find('div[data-group="' + 0 + '"]').find('input').attr('disabled', false);

                $(document).find('#billing_type1').trigger('click');

            } else {
                $(document).find('input[name="fatura_kesilecek"]').val('0');
                $(document).find('.fatura-aciklama').addClass('hidden');
                $(document).find("input[name^='fatura']").attr('disabled', true);
                $(document).find("input[name^='fatura']").attr('disabled', true);
                $(document).find("select[name^='fatura']").attr('disabled', true);
                $(document).find("input[name^='fatura']").closest('.Rez-left-price_type-item').addClass('hidden');
                $(document).find("input[name^='fatura']").addClass('hidden');
                $(document).find("select[name^='fatura']").addClass('hidden');
            }
        })
        $(document).on('change', '#tckontrol', function () {
            var checked = $(this).prop('checked');
            if (checked == true) {
                $('input[name="tc"]').val('0')
            } else {
                $('input[name="tc"]').val('1')
            }
        })
    </script>

    <script>
        $("#phone").on("keypress keyup blur", function (event) {

            if ($(".selected-dial-code").html() === "+90") {
                $("#phone").attr('minlength', '10');
                $("#phone").attr('maxlength', '10');
            } else {
                $("#phone").attr('minlength', '9');
                $("#phone").attr('maxlength', '15');
            }

            if ($(".selected-dial-code").html() === "+90" && $(this).val() === "" && event.which === 48) {
                event.preventDefault();
                return false;
            }


            $(this).val($(this).val().replace(/[^\d].+/, ""));

            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    </script>


    <script>



        $(document).on('change', 'input[name="fatura[billing_type]"]', function () {
            $(document).find('div[data-group]').addClass('hidden');
            $(document).find('div[data-group]').find('input').attr('disabled', true);

            $(document).find('div[data-group="' + $(this).val() + '"]').removeClass('hidden');
            $(document).find('div[data-group="' + $(this).val() + '"]').find('input').attr('disabled', false);
        })
        $(document).on('change', '#ulke_id', function () {

            let ulke_id = $(this).val();

            let route = "{{ route('search.il-getir', '#ULKE_ID#') }}";
            route = route.replace('#ULKE_ID#', ulke_id);

            $.ajax({
                url: route,
                type: 'POST',
                dataType: 'json',
                data: {_token: "{{ csrf_token() }}"},
            })
                .done(function (data) {
                    /*TODO gelen verilerin hepsini illere ekleyecegiz.*/
                    let options = '<option>İl Seçiniz</option>';
                    $.each(data.data, function (index, value) {
                        options = options + '<option value="' + value.id + '">' + value.ad + '</option>';
                    })
                    $(document).find('#il_id').html(options);
                })
                .fail(function () {
                    console.log("error");
                })
                .always(function () {
                    console.log("complete");
                });
        })
        $(document).on('change', '#il_id', function () {

            let il_id = $(this).val();

            let route = "{{ route('search.ilce-getir', '#IL_ID#') }}";
            route = route.replace('#IL_ID#', il_id);

            $.ajax({
                url: route,
                type: 'POST',
                dataType: 'json',
                data: {_token: "{{ csrf_token() }}"},
            })
                .done(function (data) {
                    /*TODO gelen verilerin hepsini illere ekleyecegiz.*/
                    let options = '<option>İlçe Seçiniz</option>';
                    $.each(data.data, function (index, value) {
                        options = options + '<option value="' + value.id + '">' + value.ad + '</option>';
                    })
                    $(document).find('#ilce_id').html(options);
                })
                .fail(function () {
                    console.log("error");
                })
                .always(function () {
                    console.log("complete");
                });
        })

        $(document).on('change', '#ulke_id_ikamet', function () {

let ulke_id = $(this).val();

let route = "{{ route('search.il-getir', '#ULKE_ID#') }}";
route = route.replace('#ULKE_ID#', ulke_id);

$.ajax({
    url: route,
    type: 'POST',
    dataType: 'json',
    data: {_token: "{{ csrf_token() }}"},
})
    .done(function (data) {
        /*TODO gelen verilerin hepsini illere ekleyecegiz.*/
        let options = '<option>İl Seçiniz</option>';
        $.each(data.data, function (index, value) {
            options = options + '<option value="' + value.id + '">' + value.ad + '</option>';
        })
        $(document).find('#il_id_ikamet').html(options);
    })
    .fail(function () {
        console.log("error");
    })
    .always(function () {
        console.log("complete");
    });
})
$(document).on('change', '#il_id_ikamet', function () {

let il_id = $(this).val();

let route = "{{ route('search.ilce-getir', '#IL_ID#') }}";
route = route.replace('#IL_ID#', il_id);

$.ajax({
    url: route,
    type: 'POST',
    dataType: 'json',
    data: {_token: "{{ csrf_token() }}"},
})
    .done(function (data) {
        /*TODO gelen verilerin hepsini illere ekleyecegiz.*/
        let options = '<option>İlçe Seçiniz</option>';
        $.each(data.data, function (index, value) {
            options = options + '<option value="' + value.id + '">' + value.ad + '</option>';
        })
        $(document).find('#ilce_id_ikamet').html(options);
    })
    .fail(function () {
        console.log("error");
    })
    .always(function () {
        console.log("complete");
    });
})

    </script>
@endpush

@section('content')
@php
$re = $_GET["code"];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.infoset.app/v1/deals?Name='. $re .'&additionalProp1[op]=0&additionalProp1[val]=string&additionalProp2[op]=0&additionalProp2[val]=string&additionalProp3[op]=0&additionalProp3[val]=string');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'X-Api-Key: 418a190c-ebae-4d1c-bee3-cf9395b141ee';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$result=json_decode($result);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$infosetID = ($result->items)[0]->id;
$status =($result->items)[0]->status;
echo $status;
if($ipsonuc == 1){
    if($status <= 2){

  
    $tarayici = $_SERVER['HTTP_USER_AGENT'];
        $sonuc="Müşteri Ödeme Yap Sayfasını Görüntüledi  -  $tarayici  - $fb_ip";


$postData2=[
                   'notes' => $sonuc,
                   
                   'dealId' => $infosetID,
                   ];    
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.infoset.app/v1/deals/logs');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData2));

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'X-Api-Key: 418a190c-ebae-4d1c-bee3-cf9395b141ee';
$headers[] = 'Content-Type: application/json-patch+json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
}
}

@endphp
    <section class="Progress desktop">
        <div class="container">
            <ol class="progress ">
                <li class="is-active">
        <span>
        </span>
                    <p>Villanı Seç
                    </p>
                </li>
                <li>
        <span>
        </span>
                    <p>Rezervasyonu Tamamla
                    </p>
                </li>
                <li class="progress__last">
        <span>
        </span>
                    <p>Tatile Başla
                    </p>
                </li>
            </ol>
        </div>
    </section>

    <section class="Rez">
        <div class="container">
            <div class="Rez-in flex justify-content-between">
                <div class="Rez-left">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Eksik veya Hatalı bilgi girdiniz.
                        </div>
                    @endif

                    <form action="{{route('preRezGuncelle')}}" method="post" autocomplete="off" id="preRezG">
                        @csrf
                        <input type="hidden" name="preID" value="{{$req[preID]}}">
                        <input type="hidden" name="villa" value="{{$req[villa]}}">
                        <input type="hidden" name="giris_tarih" value="{{$req[giris_tarih]}}">
                        <input type="hidden" name="cikis_tarih" value="{{$req[cikis_tarih]}}">
                        <div class="Rez-left-group">
                            <div class="Rez-left-header  ">
                                <h5>
                <span>1
                </span> Kişisel Bilgiler
                                </h5>
                                <p>
                                </p><label for="tckontrol">
                                    <input id="tckontrol" type="checkbox">
                                    <input type="hidden" name="tc" value="1">
                                    T.C. Vatandaşı Değilim
                                </label>
                            </div>
                            <div class="Rez-left-in flex wrap">
                                <div class="Rez-left-item">
                                    <input type="text" minlength="2" required="required" name="name"
                                           class="form-control" value="{{$req[c_name]}}" placeholder="Adınız ve Soyadınız">
                                </div>
                                <div class="Rez-left-item" style="z-index: 999">
                                    <input type="hidden" name="prephone" id="prephone">
                                    <input type="tel" pattern="\d+" minlength="9" maxlength="15" required="required"
                                           id="phone" name="phone" value="{{$req[c_phone]}}" class="form-control" placeholder="Telefon Numaranız">

                                </div>
                                <div class="Rez-left-item">
                                    <input type="email" minlength="2" required="required" name="email"
                                           class="form-control" placeholder="E-mail adresiniz" value="{{$req[c_email]}}">
                                </div>
                                <div class="Rez-left-item">
                                    <input type="text" minlength="11" maxlength="11" required="required" name="idnumber"
                                           class="form-control" placeholder="T.C. Kimlik Numaranız" value="{{$req[c_tckn]}}">
                                </div>
                                <div class="Rez-left-item" style="width: 100%;">
                                    <input autocomplete="off" style="padding-left: 3%;" type="text" required="required"
                                           name="address"
                                           class="form-control" placeholder="İkamet Adresi" value="{{$req[c_address]}}">
                                </div>

                                <div class="Rez-left-item-3">
                                    <select  name="ikamet[ulke_id]" id="ulke_id_ikamet" class="form-control">
                                        @foreach(\App\Ulke::get() as $ulke)
                                            <option @if($ulke->id == 223) selected
                                                    @endif value="{{ $ulke->id }}">{{ $ulke->ad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="Rez-left-item-3">
                                    <select  name="ikamet[il_id]" id="il_id_ikamet" class="form-control" required>
                                        <option value="">İl Seçin</option>
                                        @foreach(\App\Iller::where('ulke_id', '223')->get() as $il)
                                            <option value="{{ $il->id }}">{{ $il->ad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="Rez-left-item-3">
                                    <select  name="ikamet[ilce_id]" id="ilce_id_ikamet" class="form-control" >
                                        <option value="">İlçe Seçin</option>
                                    </select>
                                </div>

                                <label for="faturabilgi_kontrol" style="width: 100%">
                                    <input id="faturabilgi_kontrol" type="checkbox">
                                    <input type="hidden" name="fatura_kesilecek" value="0">
                                    Fatura bilgilerimi girmek istiyorum.
                                </label>

                                <div class="Rez-left-price_type-item flex hidden"
                                     style="width: 100%; align-items: center; justify-content: center">
                                    <div style="width: 33%">
                                        <input checked id="billing_type1" type="radio" value="0"
                                               name="fatura[billing_type]">
                                        <label for="price_type1">Bireysel
                                        </label>
                                    </div>
                                    <div style="width: 33%">

                                        <input id="billing_type2" type="radio" value="1"
                                               name="fatura[billing_type]">
                                        <label for="price_type1">Şirket / Şahıs Şirketi
                                        </label>
                                    </div>


                                </div>

                                {{--BIREYSEL--}}

                                <div data-group="0" class="Rez-left-item-3">
                                    <input type="text" minlength="2" required="required" name="fatura[name]"
                                           class="form-control hidden" disabled placeholder="Adınız">
                                </div>
                                <div data-group="0" class="Rez-left-item-3">
                                    <input type="text" minlength="2" required="required" name="fatura[surname]"
                                           class="form-control hidden" disabled placeholder="Soyadınız">
                                </div>
                                <div data-group="0" class="Rez-left-item-3">
                                    <input type="text" minlength="2" required="required" name="fatura[identification]"
                                           class="form-control hidden" disabled placeholder="Tc Kimlik Numaranız">
                                </div>
                                {{--KURUMSAL--}}
                                <div data-group="1" class="Rez-left-item-3 hidden">
                                    <input disabled type="text" minlength="2" required="required" name="fatura[name]"
                                           class="form-control hidden" placeholder="Şirket Ünvanı">
                                </div>
                                <div data-group="1" class="Rez-left-item-3 hidden">
                                    <input disabled type="text" minlength="2" required="required" name="fatura[surname]"
                                           class="form-control hidden" placeholder="Vergi Dairesi">
                                </div>
                                <div data-group="1" class="Rez-left-item-3 hidden">
                                    <input disabled type="text" minlength="2" required="required"
                                           name="fatura[identification]"
                                           class="form-control hidden" placeholder="Vergi Numarası">
                                </div>
                                {{--KURUMSAL--}}
                                <div class="Rez-left-item" style="width: 100%">
                                    <input disabled type="text" minlength="2" required="required" name="fatura[email]"
                                           class="form-control hidden" placeholder="E-POSTA">
                                </div>
                                <div class="Rez-left-item" style="width: 100%">
                                    <input disabled type="text" minlength="2" required="required"
                                           name="fatura[billing_address]"
                                           class="form-control hidden" placeholder="Fatura Adresi">
                                </div>

                                <div class="Rez-left-item-3">
                                    <select disabled name="fatura[ulke_id]" id="ulke_id" class="form-control hidden">
                                        @foreach(\App\Ulke::get() as $ulke)
                                            <option @if($ulke->id == 223) selected
                                                    @endif value="{{ $ulke->id }}">{{ $ulke->ad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="Rez-left-item-3">
                                    <select disabled name="fatura[il_id]" id="il_id" class="form-control hidden">
                                        <option value="">İl Seçin</option>
                                        @foreach(\App\Iller::where('ulke_id', '223')->get() as $il)
                                            <option value="{{ $il->id }}">{{ $il->ad }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="Rez-left-item-3">
                                    <select disabled name="fatura[ilce_id]" id="ilce_id" class="form-control hidden">
                                        <option value="">İlçe Seçin</option>
                                    </select>
                                </div>
                                {{--SIRKET/SAHIS SIRKETI--}}
                            </div>

                            <p class="Rez-left-alert fatura-aciklama hidden">
                                Firmamız kazancı tutarında komisyon bedeli faturası kesmektedir. Kalan tutar için villa girişinde villa sahibiyle görüşebilirsiniz.

                            </p>


                        </div>

                        <div class="Rez-left-group">
                            <div class="Rez-left-header flex justify-content-between ">
                                <h5>
                <span>2
                </span> Onay Sonrası Ödeme Şekli
                                </h5>
                                {{--<p>Henüz bir ödeme yapmayacaksınız.--}}
                                {{--<svg class="icon icon-unlem" data-toggle="tooltip" data-placement="top" title="Tooltip on top">--}}
                                {{--<use xlink:href="#icon-unlem">--}}
                                {{--</use>--}}
                                {{--</svg>--}}
                                {{--</p>--}}

                            </div>



                            <div class=" Rez-left-advance_pay-in">

<div class="Rez-left-advance_pay-price">
    <h6>Yapmanız gereken <strong>ön ödeme</strong> tutarı {{number_format((float)$req['odeme'], 0, ',', '.')}} ₺</h4>
    <span style="font-size:20px;"><span>
</div>
<div class="Rez-left-price_type flex  wrap">

    <ul class="nav nav-pills " style="width: 100%">
        <li class="nav-item ">
            <a href="#tab1"
               class="nav-link Rez-left-price_type-item flex-column active "
               data-toggle="tab">
               <input id="price_type1" required="required" type="radio" value="0"
                                               name="payment_type" checked >
                <svg class="icon icon-credi_card">
                    <use xlink:href="#icon-credi_card"></use>
                </svg>

                <label for="price_type1">Kredi Kartı İle Ödeme
                </label>
                <p>Bu Rezervasyonun ödemesini <b>Kredi Kartı</b> ile gerçekleştirmek
                    istiyorum.
                </p>
            </a>
        </li>
        <li class="nav-item  ">
            <a href="#tab2" class="nav-link Rez-left-price_type-item flex-column  "
               data-toggle="tab">
               <input id="price_type2" required="required" type="radio" value="1"
                                               name="payment_type">
                <svg class="icon icon-bank_transfer">
                    <use xlink:href="#icon-bank_transfer">
                    </use>
                </svg>

                <label for="price_type2">Havale ya da EFT ile ödeme
                </label>
                <p>Bu Rezervasyonun ödemesini <b>Havale</b> veya <b>Eft</b> ile
                    gerçekleştirmek
                    istiyorum.
                </p>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade active show  " id="tab1">
            <div class="Rez-left-price_type-in">
                <div class="Rez-left-payment">
                @if($req['payment_method']=="teb" )
                    <div class="card">

                        <div class="Rez-left-payment-item">
                           <div class="Rez-left-payment-item-left">
                               <label for="">Kart Numarası
                                   <span>16 haneli kart numaranız</span>
                               </label>
                           </div>
                           <div class="Rez-left-payment-item-right">
                               <input type="text" name="number" class="form-control" placeholder="0000-0000-0000-0000"/>
                           </div>
                        </div>
                        <div class="Rez-left-payment-item">
                            <div class="Rez-left-payment-item-left">
                              <label for="">Ad Soyad
                                  <span>Kart Sahibinin adı soyadı</span>
                              </label>
                          </div>
                            <div class="Rez-left-payment-item-right">
                             <input type="text" name="cart_name"
                                    class="form-control"/>
                         </div>
                        </div>
                        <div class="Rez-left-payment-item">
                            <div class="Rez-left-payment-item-left">
                               <label for="">SKT
                                   <span>Son kullanma tarihi</span>
                               </label>
                           </div>

                            <div class="Rez-left-payment-item-right">
                               <input type="text" placeholder="MM/YY" name="expiry"
                                      class="form-control" />
                           </div>

                        </div>
                        <div class="Rez-left-payment-item">

                            <div class="Rez-left-payment-item-left">
                             <label for="">CVV
                                 <span>Kartın arka yüzündeki güvelik kodu</span>
                             </label>
                         </div>

                            <div class="Rez-left-payment-item-right">
                               <input type="text" name="cvv"
                                      class="form-control" />
                           </div>
                        </div>
                        <div class="Rez-left-payment-item">

                            <div class="Rez-left-payment-item-left">
                            <label for="">ÖDENECEK TUTAR
                                <span>Yerinizi ayırtmak için ödenecek tutar</span>
                            </label>
                            </div>

                                <div class="Rez-left-payment-item-right">
                                <div class="form-row">
                                <div class="form-group col-md-9">
                                <input type="number" name="total"
                                        class="form-control" />
                                </div>
                                    <div class="form-group col-md-3">
                                    <select name="currency_code" class="form-control">
                                                        @foreach($currencies as $currency)
                                                            <option value="{{ $currency->code }}">{{ $currency->name }}</option>
                                                        @endforeach
                                                    </select>
                                </div>
                            </div>

                                    </div>

                        </div>


                    </div>
                    <div id="odemeFormu" style="hidden"></div>
                    @endif

                </div>





                <div class="Rez-left-danger1">
                    <div class="Rez-left-danger1-left">
                        <img src="images/n_icon-info.svg" alt="">
                        <p>
                            Farklı ödeme yöntemleri için lütfen rezervasyon danışmanı
                            ile irtibata geçiniz.
                        </p>
                    </div>
                    <div class="Rez-left-danger1-right">
                        <h6>
                            <span>Rezervasyon Danışmanı</span>
                            <a href="tel:+902526060669">+90 252 606 06 69</a>
                        </h6>
                    </div>
                </div>

            </div>

        </div>
        <div class="tab-pane fade " id="tab2">

            <div class="Rez-left-price_type-in">
               -

                <div class="Rez-left-danger1">
                    <div class="Rez-left-danger1-left">
                        <img src="images/n_icon-info.svg" alt="">
                        <p>
                            Farklı ödeme yöntemleri için lütfen rezervasyon danışmanı
                            ile irtibata geçiniz.
                        </p>
                    </div>
                    <div class="Rez-left-danger1-right">
                        <h6>
                            <span>Rezervasyon Danışmanı</span>
                      <a href="tel:+902526060669">+90 252 606 06 69</a>
                        </h6>
                    </div>
                </div>
                <div class="Rez-left-danger2">
                    <img src="images/n_icon-danger.svg" alt="">
                    <p>
                        Rezervasyonunuzu tamamladıktan sonra verilen opsiyon süresi
                        içinde ödeme yaptığınız takdirde rezervasyonunuz onaylanacaktır.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

</div>

                        </div>
                        <div id="rez" class="Rez-left-group">
                            <div class="Rez-left-header flex justify-content-between ">
                                <h5>
                <span>3
                </span> Villaya Girişte Dikkat Edilmesi Gerekenler
                                </h5>
                            </div>
                            <div class="Rez-left-danger">
                                @if(!empty($villa->damage_deposit_amount))
                                    <div class="Rez-left-danger-item">
                                        <div class=" flex a-i-c">
                                            <svg class="icon icon-unlem2">
                                                <use xlink:href="#icon-unlem2">
                                                </use>
                                            </svg>
                                            <h6>Hasar depozitosu
                                            </h6>
                                            <span>{{number_format((float)$villa->damage_deposit_amount, 0, ',', '.')}} ₺
                  </span>
                                        </div>
                                        <p>Villaya girişte ödenecek olan hasar depozitosu
                                            ({{number_format((float)$villa->damage_deposit_amount, 0, ',', '.')}}) ₺, villada herhangi
                                            bir hasar olmaması halinde çıkışta iade edilecektir.
                                        </p>
                                    </div>
                                @endif
                                @if(isset($paidins) && !empty($paidins))
                                    <div class="Rez-left-danger-item">
                                        <div class=" flex a-i-c">
                                            <svg class="icon icon-khome">
                                                <use xlink:href="#icon-khome">
                                                </use>
                                            </svg>
                                            <h6>
                                                @foreach($paidins as $paidin)
                                                    - {{$paidin->property}}
                                                @endforeach
                                            </h6>
                                            <span>Ücrete Dahil
                  </span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($villa->checkin_time))
                                    <div class="Rez-left-danger-item">
                                        <div class=" flex a-i-c">
                                            <svg class="icon icon-unlem2">
                                                <use xlink:href="#icon-unlem2">
                                                </use>
                                            </svg>
                                            <h6>Giriş Saati
                                            </h6>
                                            <span>{{$villa->checkin_time}}
                  </span>
                                        </div>
                                    </div>
                                @endif
                                @if(!empty($villa->checkout_time))
                                    <div class="Rez-left-danger-item">
                                        <div class=" flex a-i-c">
                                            <svg class="icon icon-unlem2">
                                                <use xlink:href="#icon-unlem2">
                                                </use>
                                            </svg>
                                            <h6>Çıkış Saati
                                            </h6>
                                            <span>{{$villa->checkout_time}}
                  </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="Rez-left-item-onay  flex a-i-c">
                                <input id="onay" class="rezonay" onchange="checkle(this)" required="required"
                                       type="checkbox">
                                <label for="onay">
                                    <a href="" data-toggle="modal" data-target="#kosullar">Rezervasyon Koşullarını
                                    </a>
                                    okudum, onaylıyorum.
                                </label>
                            </div>
                        </div>
                        <p class="Rez-left-alert">Rezervazyonu tamamlamak için rezervazyon koşullarını onaylamanız
                            gerekmektedir.
                        </p>
                        <input type="submit" class="Rez-left-gonder" value="REZERVASYONU TAMAMLA">
                    </form>
                </div>
                <div class="Rez-right">
                    <div class="Rez-right-f">
                        @php
                            if(empty($villa->panel_villa->list_image)){
                            $resim="uploads/villa/gallery/$villa->list_image/$villa->list_image_name";
                            }else{
                            $resim=$villa->panel_villa->list_image;
                            }
                        @endphp
                        <div class="Rez-right-banner" style="background-image: url({{asset($resim)}});">
                            <div class="Rez-right-banner-text">
                                <div class="flex a-i-c justify-content-between">
                                    <p>{{ $villa->name }} ({{ $website->prefix }}{{ $villa->code }}
                                        ) @if(isset($villa->area->name))
                                            <span>{{$villa->area->name}} bölgesinde
                  </span>@endif
                                    </p>
                                    <span class="Rez-right-banner-text-icon desktop">
                  <svg class="icon icon-right-arrow">
                    <use xlink:href="#icon-right-arrow">
                    </use>
                  </svg>
                </span>
                                </div>
                            </div>
                        </div>
                        <div class="Rez-right-in">
                            <div class="Rez-right-person flex a-i-c justify-content-between">
                                <p>
                                    <svg class="icon icon-user">
                                        <use xlink:href="#icon-user">
                                        </use>
                                    </svg>
                                    {{$req['adult']}} Yetişkin, {{$req['child']}} Çocuk, {{$req['baby']}} Bebek
                                </p>

                            </div>
                            <div class="Rez-right-date flex a-i-c justify-content-between">
                                <div class="Rez-right-date-item">
                                    <p class="Rez-right-date-item-left">
                                        @php
                                            if(isset($req['giris_tarih'])){
                                            $gdt = \Carbon\Carbon::parse($req['giris_tarih']);
                                            $giris_ay=$gdt->formatLocalized('%b');
                                            $giris_gun=$gdt->formatLocalized('%d');
                                            $giris_gun_yazi=iconv('latin5','utf-8',$gdt->localeDayOfWeek);
                                            }else{
                                            $giris_ay="";
                                            $giris_gun="";
                                            $giris_gun_yazi="";
                                            }
                                            if(isset($req['cikis_tarih'])){
                                            $cdt = \Carbon\Carbon::parse($req['cikis_tarih']);
                                            $cikis_ay=$cdt->formatLocalized('%b');
                                            $cikis_gun=$cdt->formatLocalized('%d');
                                            $cikis_gun_yazi=iconv('latin5','utf-8',$cdt->localeDayOfWeek);
                                            }else{
                                            $cikis_ay="";
                                            $cikis_gun="";
                                            $cikis_gun_yazi="";
                                            }
                                        @endphp
                                        <span>{{$giris_ay}}
                  </span>
                                        {{$giris_gun}}
                                    </p>
                                    <p class="Rez-right-date-item-right">
                  <span>{{$req['giris_tarih']}}
                  </span>
                                        {{$giris_gun_yazi}}
                                    </p>
                                </div>
                                <svg class="icon icon-right-arrow">
                                    <use xlink:href="#icon-right-arrow">
                                    </use>
                                </svg>
                                <div class="Rez-right-date-item">
                                    <p class="Rez-right-date-item-left">
                  <span>{{$cikis_ay}}
                  </span>
                                        {{$cikis_gun}}
                                    </p>
                                    <p class="Rez-right-date-item-right">
                  <span>{{$req['cikis_tarih']}}
                  </span>
                                        {{$cikis_gun_yazi}}
                                    </p>
                                </div>
                            </div>
                            <div class="Rez-right-info">
                                <p class="Rez-right-info-item flex justify-content-between">
                                <span>{{number_format((float)$gunlukFiyat[1], 0, ',', '.')}} ₺ x {{$gunlukFiyat[2]}} Gece</span>
                                <span>{{number_format((float)$gunlukFiyat[0], 0, ',', '.')}} ₺</span>
                @php
                                $on_odeme=$gunlukFiyat[5];
                                $kalan_odeme=$gunlukFiyat[6];
                                $toplam_fiyat=$gunlukFiyat[0];
                                $hesap_toplam=$gunlukFiyat[7];
                                $gun_ve_fiyat=$gunlukFiyat[4];
                                $sonuc_fiyat=$req['total'];
                                
                                $indirim = $hesap_toplam - $sonuc_fiyat;
                            @endphp
                                </p>
                              
                                <p class="Rez-right-info-item flex justify-content-between">
                                <span>İndirim </span>
                                <span class="Rez-right-info-item-indirim">- {{number_format((float)$indirim, 0, ',', '.')}} ₺</span>
                                </p>
                              
                                @if(($gunlukFiyat[3]) != "0 ₺")
                                    <p class="Rez-right-info-item flex justify-content-between">
                <span>
                  Temizlik bedeli
                  <svg class="icon icon-unlem" data-toggle="tooltip"
                       data-placement="top" title="7 geceden az konaklamalardan temizlik ücreti alınır">
                    <use xlink:href="#icon-unlem">
                    </use>
                  </svg>
                </span>
                                        <span>{{$gunlukFiyat[3]}}
                </span>
                                    </p>
                                @endif
                            </div>
                        
                            <div class="Rez-right-info">
                                <p class="Rez-right-info-item flex justify-content-between">
                <span>Ön Ödeme
                  <svg class="icon icon-unlem" data-toggle="tooltip"
                       data-placement="top" title="Yerinizi ayırtmak için ödemeniz gereken tutar">
                    <use xlink:href="#icon-unlem">
                    </use>
                  </svg>
                </span>
                                    <span>{{number_format((float)$req['odeme'], 0, ',', '.')}} ₺
                </span>
                                </p>
                                <p class="Rez-right-info-item flex justify-content-between">
                <span>Girişte Ödeme
                </span>
                                    <span>{{number_format((float)$req['kalan'], 0, ',', '.')}} ₺
                </span>
                                </p>
                           
                                <p class="Rez-right-info-item  flex justify-content-between">
                <span>Toplam
                </span>
                                    <span class="Rez-right-info-item-toplam">{{number_format((float)$req['total'], 0, ',', '.')}} ₺
                </span>
                                </p>
                            </div>


                        </div>
                        <div class="Rez-right-contact">
                            <div class="Rez-right-contact-head">
                                <h6>Aklınıza Takılan Konular için</h6>
                                <h5>Rezervasyon Danışmanınız</h5>
                                <p>
                                    Rezervasyonunuzla ilgili tüm işlemler için telefon veya whatsapp  yoluyla bizimle iletişime geçebilirsiniz.
                                </p>
                            </div>
                            <div class="Rez-right-contact-in">
                                <a href="tel:02422520032" class="Rez-right-contact-item">
                                    <img src="{{ asset('images/n_icon-phone.svg')}}" alt="">
                                    <p>0 252
                                        <span>606 06 69</span>
                                    </p>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone=902526060669 &"
                                   class="Rez-right-contact-item">
                                    <img src="{{asset('images/n_icon-whatsapp.svg')}}" alt="">
                                    <p>0 252
                                        <span>606 06 69</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        $sozlesme = Illuminate\Support\Facades\DB::table('website_pages')->where(['website_id' => 15/*APP_WEBSITE_ID*/,'id' => '103'])->first();
    @endphp
    <div class="modal modal-kosullar moda fade" id="kosullar" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;
        </span>
                </button>
                <div class="modal-body">
                    <h3 class="modal-kosullar-header">{{ (isset($sozlesme->page_name)?$sozlesme->page_name:'') }}
                    </h3>
                    @if(isset($sozlesme->page_name)){!! $sozlesme->dynamic_description !!}@endif
                </div>
            </div>
        </div>
    </div>
    <div id="iyzico_responses" style="display:none;"></div>
    <div id="iyzipay-checkout-form" class="popup"></div>
@endsection
