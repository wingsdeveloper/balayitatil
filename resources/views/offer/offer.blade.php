@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    <link rel="stylesheet" href="{{ asset('css/library/intlTelInput.min.css') }}">
    <section class="Teklif ">
        <div class="container">
            {{-- @if(Agent::isDesktop())--}}
            <form>
                <div class="Teklif-item part2 part-passive">
                    <h5 class="header-md">BİZİMLE TARİH PAYLAŞIN
                    </h5>
                    <div class="Teklif-in flex j-c-c">
                        <div class="Teklif-item-date flex a-i-c" id="two-inputs">
            <span>Giriş Tarihi
            </span>
                            <input
                                @if(Agent::isDesktop())
                                autocomplete="off" type="text" id="dgiris_tarih" class="villa_date-input"
                                data-datepicker="separateRange"
                                name="start_date"
                                @else
                                id="mgiris_tarih" class="datepicker" placeholder="Giriş Tarihi" name="giris"
                                data-page="detail" type="text" autocomplete="off"
                                @endif/>
                            <svg class="icon icon-date addon">
                                <use xlink:href="#icon-calendar">
                                </use>
                            </svg>
                        </div>
                        <div class="Teklif-item-date flex a-i-c">
            <span>Çıkış Tarihi
            </span>
                            <input
                                @if(Agent::isDesktop())
                                autocomplete="off" type="text" id="dcikis_tarih" class="villa_date-input"
                                data-datepicker="separateRange"
                                name="end_date"
                                @else
                                id="mcikis_tarih" class="datepicker" placeholder="Çıkış Tarihi" name="cikis"
                                data-page="detail" type="text" autocomplete="off"
                                @endif/>
                            <svg class="icon icon-date addon">
                                <use xlink:href="#icon-calendar">
                                </use>
                            </svg>
                        </div>
                    </div>
                    <div class="Teklif-item-date-musait flex-column a-i-c j-c-c mt-4">
                        <label for="m" class="text-laci text-center flex a-i-c">
                            <input autocomplete="off" type="checkbox" class="mr-2" id="m" name="three_days_available">
                            Giriş tarihinden 3 gün önce ve sonraki müsait villalar olabilir.
                        </label>
                    </div>
                    <div class="step-buton">
                        <div class=" flex j-c-c a-i-c">
                            <button type="button" class="step-back">
                                <svg class="icon icon-right-arrow">
                                    <use xlink:href="#icon-right-arrow">
                                    </use>
                                </svg>
                                Geri
                            </button>
                            <button type="button" data-picker="picker" class="step step-onay">
                                İleri
                                <svg class="icon icon-right-arrow">
                                    <use xlink:href="#icon-right-arrow">
                                    </use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="Teklif-item part3 part-passive">
                    <h5 class="header-md text-center">Ne Zaman Gelmek İstersiniz
                    </h5>
                    <div class="Teklif-in flex">
                        <div class="Teklif-item-in">
                            <input autocomplete="off" id="tspring" class="radio" type="radio" value="spring"
                                   name="season">
                            <label for="tspring" data-climate="spring" class="global_label step">
                            </label>
                            <svg class="icon icon-bahar">
                                <use xlink:href="#icon-bahar">
                                </use>
                            </svg>
                            <p>İlkbahar
                                <span>Mart,Nisan,Mayıs
              </span>
                            </p>
                            <p>{{ $general->spring }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in">
                            <input autocomplete="off" id="tsummer" class="radio" type="radio" value="summer"
                                   name="season">
                            <label for="tsummer" data-climate="summer" class="global_label step">
                            </label>
                            <svg class="icon icon-yaz">
                                <use xlink:href="#icon-yaz">
                                </use>
                            </svg>
                            <p>Yaz
                                <span>Haziran,Temmuz,Ağustos
              </span>
                            </p>
                            <p>{{ $general->summer }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in">
                            <input autocomplete="off" id="tautumn" class="radio" type="radio" value="autumn"
                                   name="season">
                            <label for="tautumn" data-climate="autumn" class="global_label step">
                            </label>
                            <svg class="icon icon-bahar">
                                <use xlink:href="#icon-bahar">
                                </use>
                            </svg>
                            <p>Sonbahar
                                <span>Eylül, Ekim, Kasım
              </span>
                            </p>
                            <p>{{ $general->autumn }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in">
                            <input autocomplete="off" id="twinter" class="radio" type="radio" value="winter"
                                   name="season">
                            <label for="twinter" data-climate="winter" class="global_label step">
                            </label>
                            <svg class="icon icon-kis">
                                <use xlink:href="#icon-kis">
                                </use>
                            </svg>
                            <p>Kış
                                <span>Aralık, Ocak, Şubat
              </span>
                            </p>
                            <p>{{ $general->winter }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                    </div>
                    <div class="step-buton">
                        <div class=" flex j-c-c a-i-c">
                            <button type="button" class="step-back">
                                <svg class="icon icon-right-arrow">
                                    <use xlink:href="#icon-right-arrow">
                                    </use>
                                </svg>
                                Geri
                            </button>
                        </div>
                    </div>
                </div>
                <div class="Teklif-item part4 part-passive">
                    <h5 class="header-md">Tercih Ettiğiniz Bir Ay Var mı ?
                    </h5>
                    <div class="Teklif-in flex">
                        <div class="Teklif-item-in winter climate" style="display: none">
                            <input autocomplete="off" id="tdecember" class="radio" type="radio" name="month"
                                   value="december">
                            <label for="tdecember" class="global_label step">
                            </label>
                            <p>Aralık
                            </p>
                            <p>{{ $general->december }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in winter climate" style="display: none">
                            <input autocomplete="off" id="tjanuary" class="radio" type="radio" name="month"
                                   value="january">
                            <label for="tjanuary" class="global_label step">
                            </label>
                            <p>Ocak
                            </p>
                            <p>{{ $general->january }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in winter climate" style="display: none">
                            <input autocomplete="off" id="tfebruary" class="radio" type="radio" name="month"
                                   value="february">
                            <label for="tfebruary" class="global_label step">
                            </label>
                            <p>Şubat
                            </p>
                            <p>{{ $general->february }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in spring climate" style="display: none">
                            <input autocomplete="off" id="tmarch" class="radio" type="radio" name="month" value="march">
                            <label for="tmarch" class="global_label step">
                            </label>
                            <p>Mart
                            </p>
                            <p>{{ $general->march }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in spring climate" style="display: none">
                            <input autocomplete="off" id="tapril" class="radio" type="radio" name="month" value="april">
                            <label for="tapril" class="global_label step">
                            </label>
                            <p>Nisan
                            </p>
                            <p>{{ $general->april }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in spring climate" style="display: none">
                            <input autocomplete="off" id="tmay" class="radio" type="radio" name="month" value="may">
                            <label for="tmay" class="global_label step">
                            </label>
                            <p>Mayıs
                            </p>
                            <p>{{ $general->may }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in summer climate" style="display: none">
                            <input autocomplete="off" id="tjune" class="radio" type="radio" name="month" value="june">
                            <label for="tjune" class="global_label step">
                            </label>
                            <p>Haziran
                            </p>
                            <p>{{ $general->june }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in summer climate" style="display: none">
                            <input autocomplete="off" id="tjuly" class="radio" type="radio" name="month" value="july">
                            <label for="tjuly" class="global_label step">
                            </label>
                            <p>Temmuz
                            </p>
                            <p>{{ $general->july }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in summer climate" style="display: none">
                            <input autocomplete="off" id="taugust" class="radio" type="radio" name="month"
                                   value="august">
                            <label for="taugust" class="global_label step">
                            </label>
                            <p>Ağustos
                            </p>
                            <p>{{ $general->august }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in autumn climate" style="display: none">
                            <input autocomplete="off" id="tseptember" class="radio" type="radio" name="month"
                                   value="september">
                            <label for="tseptember" class="global_label step">
                            </label>
                            <p>Eylül
                            </p>
                            <p>{{ $general->september }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in autumn climate" style="display: none">
                            <input autocomplete="off" id="toctober" class="radio" type="radio" name="month"
                                   value="october">
                            <label for="toctober" class="global_label step">
                            </label>
                            <p>Ekim
                            </p>
                            <p>{{ $general->october }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                        <div class="Teklif-item-in autumn climate" style="display: none">
                            <input autocomplete="off" id="tnovember" class="radio" type="radio" name="month"
                                   value="november">
                            <label for="tnovember" class="global_label step">
                            </label>
                            <p>Kasım
                            </p>
                            <p>{{ $general->november }} TL'den
                                <span>BAŞLAYAN FİYATLARLA
              </span>
                            </p>
                        </div>
                    </div>
                    <div class="step-buton">
                        <div class=" flex j-c-c a-i-c">
                            <button type="button" class="step-back">
                                <svg class="icon icon-right-arrow">
                                    <use xlink:href="#icon-right-arrow">
                                    </use>
                                </svg>
                                Geri
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <form action="" autocomplete="off" method="POST">
                @csrf
                {{-- @if(Agent::isDesktop())--}}
                <div class="Teklif-main @if(Agent::isDesktop()) desktop @endif flex-column a-i-c">
                    <h1 class="header-lg">TEKLİF İSTE
                    </h1>
                    @if(Agent::isDesktop())
                        <p class="text-gri">Formu doldurun, size en uygun tarihte en uygun villaları listeleyip sunalım.
                        </p>
                    @endif
                    <div class="Teklif-item part1 part-active">
                        <h5 class="header-md">Net Tarihiniz Var mı ?
                        </h5>
                        <div class="Teklif-item-question flex  j-c-c">
                            <div class="Teklif-item-in">
                                Evet
                                <input autocomplete="off" id="t11" class="radio" type="radio" value="true"
                                       name="net_date">
                                <label for="t11" data-date="tarih_var" class="global_label step">
                                </label>
                            </div>
                            <div class="Teklif-item-in">
                                Hayır
                                <input autocomplete="off" id="t12" class="radio" type="radio" value="false"
                                       name="net_date">
                                <label for="t12" data-date="tarih_yok" class="global_label step">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="Teklif-item part5 part-middle-active">
                        <h5 class="header-md">NASIL BİR VİLLADA TATİL YAPMAK İSTERSİNİZ ?
                        </h5>
                        <div class="Teklif-in flex">
                            @forelse($villa_types as $type)
                                <div class="Teklif-item-type">
                                    <input autocomplete="off" id="type{{ $type->id }}" value="{{ $type->id }}"
                                           class="radio" type="radio" name="villa_type">
                                    <label for="type{{ $type->id }}" class="global_label step">
                                    </label>
                                    <img src="{{ ImageProcess::getImageByPath($type->villa_type_image) }}" class="w-100"
                                         alt="{{ $type->villa_type_name }}" title="{{ $type->villa_type_name }}">
                                    <h6>{{ $type->villa_type_name }}
                                    </h6>
                                    <p>
                                        {{ $type->villa_type_price }} TL’DEN
                                        <span>BAŞLAYAN FİYATLARLA
                </span>
                                    </p>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <div class="step-buton">
                            <div class=" flex j-c-c a-i-c">
                                <button type="button" class="step-back">
                                    <svg class="icon icon-right-arrow">
                                        <use xlink:href="#icon-right-arrow">
                                        </use>
                                    </svg>
                                    Geri
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="Teklif-item part6 part-passive">
                        <h5 class="header-md">TATİLİNİZİ NE İÇİN PLANLIYORSUNUZ ?
                        </h5>
                        <div class="Teklif-in flex a-i-c j-c-c">
                            <div class="Teklif-item-why">
              <span>TATİL TİPİ
              </span>
                                <p>Balayı Veya
                                    <br> Özel Gün Tatili
                                </p>
                                <input autocomplete="off" id="t61" class="radio" type="radio" value="balayi"
                                       name="category_type">
                                <label for="t61" class="global_label step" data-tur="balayi">
                                </label>
                            </div>
                            <div class="Teklif-item-why">
              <span>TATİL TİPİ
              </span>
                                <p>Aile Veya
                                    <br> Arkadaşlarla Tatil
                                </p>
                                <input autocomplete="off" id="t62" class="radio" type="radio" value="aile"
                                       name="category_type">
                                <label for="t62" class="global_label step" data-tur="aile">
                                </label>
                            </div>
                        </div>
                        <div class="step-buton ">
                            <div class="flex j-c-c a-i-c">
                                <button type="button" class="step-back">
                                    <svg class="icon icon-right-arrow">
                                        <use xlink:href="#icon-right-arrow">
                                        </use>
                                    </svg>
                                    Geri
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="Teklif-item part7 part-passive">
                        <h5 class="header-md">VİLLANIZDA OLMASINI İSTEDİĞİNİZ ÖZELLİKLER
                        </h5>
                        <div class="Teklif-in flex wrap">
                            @if(count($villa_category) > 0)
                                @foreach($villa_category as $category)
                                    <div class="Teklif-item-property {{ $category->villa_category_type }}">
                                        <div class="Teklif-item-property-in">
                    <span>{{ $category->villa_category_name }}
                    </span>
                                            <input autocomplete="off"
                                                   id="{{ $category->villa_category_type }}{{ $category->id }}"
                                                   name="features[]" value="{{ $category->id }}" type="checkbox">
                                            <label for="{{ $category->villa_category_type }}{{ $category->id }}"
                                                   class="global_label">
                                            </label>
                                        </div>
                                        <input autocomplete="off"
                                               id="{{ $category->villa_category_type }}m{{ $category->id }}"
                                               name="absolutes[]" value="{{ $category->id }}" class="check-input"
                                               type="checkbox">
                                        <label for="{{ $category->villa_category_type }}m{{ $category->id }}"
                                               class="check-label">Mutlaka İstiyorum
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="step-buton">
                            <div class=" flex j-c-c a-i-c">
                                <button type="button" class="step-back">
                                    <svg class="icon icon-right-arrow">
                                        <use xlink:href="#icon-right-arrow">
                                        </use>
                                    </svg>
                                    Geri
                                </button>
                                <button type="button" class="step step-onay">
                                    İleri
                                    <svg class="icon icon-right-arrow">
                                        <use xlink:href="#icon-right-arrow">
                                        </use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- bilgilerinizi baglayacaz --}}
                    <div class="Teklif-item part8 Teklif-bilgi part-passive ">
                        <h5 class="header-md">BİLGİLERİNİZ
                        </h5>
                        <div class="Teklif-bilgi-item w-100 flex wrap justify-content-between">
                            <div class="Iletisim-form-item col-md-6">
                                <input id="i" type="text" minlength="2" name="name" class="form-control" required>
                                <label for="i">İsim Soyisim
                                </label>
                            </div>
                            <div class="Iletisim-form-item col-md-6">
                                <input id="e" type="email" minlength="2" name="email" class="form-control" required>
                                <label for="e">E-Posta Adresiniz
                                </label>
                            </div>
                        </div>
                        <div class="Teklif-bilgi-item w-100 flex wrap justify-content-between">
                            <div class="Iletisim-form-item col-md-6">
                                <div class="Rez-left-item dropdown-flag">
                                    <input type="hidden" name="prephone" id="prephone">
                                    <input type="tel" pattern="\d+" minlength="9" maxlength="15" required="required"
                                           id="phone" name="phone" class="form-control" placeholder="Telefon Numaranız">

                                </div>
                            </div>
                            <div class=" col-md-6">
                                @if(count($areas) > 0)
                                    @foreach($areas as $area)
                                        <label
                                            style="position: relative;padding:10px;margin: 0px 0px 5px 5px;border:1px solid #eee!important;border-radius: 20px;">{{ $area->name }}
                                            <input type="checkbox" value="{{ $area->id }}" name="area_id[]"
                                                   id="v_filter">
                                        </label>
                                    @endforeach
                                @endif
                                {{--<select class="selectpicke" name="area_id" id="v_filter">--}}
                                {{-- <option value="0">Bölge Seçiniz</option> --}}
                                {{--@if(count($areas) > 0)--}}
                                {{--@foreach($areas as $area)--}}
                                {{--<option value="{{ $area->id }}">{{ $area->name }}--}}
                                {{--</option>--}}
                                {{--@endforeach--}}
                                {{--@endif--}}
                                {{--</select>--}}
                            </div>
                        </div>
                        <div class="Teklif-bilgi-item w-100 flex wrap justify-content-between"
                             style="margin-top: 20px;">
                            <div class=" Teklif-bilgi-item-person flex">
                                <div class="col-md-6">
                                    <p>Kişi Sayısı
                                    </p>
                                </div>
                                <div class="Teklif-bilgi-item-person-right col-md-6 flex">
                                    <select class="selectpicke" name="adult" id="v_filter">
                                        @for($a=1;$a
                                        <=10;$a++)
                                            <option value="{{ $a }}">{{ $a }} Yetişkin
                                            </option>
                                        @endfor
                                    </select>
                                    <select class="selectpicke" name="child" id="v_filter">
                                        @for($c=0;$c
                                        <=10;$c++)
                                            <option value="{{ $c }}">{{ $c }} Çocuk
                                            </option>
                                        @endfor
                                    </select>
                                    <select class="selectpicke" name="baby" id="v_filter">
                                        @for($b=0;$b
                                        <=10;$b++)
                                            <option value="{{ $b }}">{{ $b }} Bebek
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="step-buton mb-5">
                            <div class=" flex j-c-c a-i-c">
                                <button type="button" class="step-back">
                                    <svg class="icon icon-right-arrow">
                                        <use xlink:href="#icon-right-arrow">
                                        </use>
                                    </svg>
                                    Geri
                                </button>
                            </div>
                        </div>
                        <button class="buton_orange mx-auto mt-5" type="submit">
                            GÖNDER
                            <svg class="icon icon-right-arrow">
                                <use xlink:href="#icon-right-arrow">
                                </use>
                            </svg>
                        </button>
                    </div>
            </form>
        </div>
    </section>

@endsection
@push('javascripts')
    <script src="{{ asset('js/library/intlTelInput-jquery.min.js') }}"></script>
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

    <script type="text/javascript">
        $("form").submit(function () {
                $('button[type="submit"]').attr('disabled', true);
            $('button[type="submit"]').addClass('hidden');
                $("#prephone").val($("#phone").intlTelInput("getSelectedCountryData").dialCode);
            }
        );
        $("#phone").intlTelInput({
            formatOnDisplay: false,
            nationalMode: false,
            autoPlaceholder: 'aggressive',
            separateDialCode: true,
            preferredCountries: ['TR', 'DE', 'FR', 'AT', 'NL', 'BE', 'CH', 'GB', 'RU'],
        });
    </script>
@endpush
