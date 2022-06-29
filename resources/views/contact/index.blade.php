@extends('layouts.app')

@push('extrahead')
@include('layouts.criteo_view')
<script src="https://api-maps.yandex.ru/2.1/?lang=en_RU&amp;
    apikey=pdct.1.1.20181214T083432Z.2bcd0a02f483369f.3cd3c8d894ee489b74391bb86bca99a576cd511f
" type="text/javascript"></script>

@endpush
@section('content')
    @include('contact.map')
        <section class="Iletisim">
            <div class="container">
                <div class="Iletisim-in flex">
                    <div class="Iletisim-left">
                        <div class="Iletisim-left-header flex a-i-c">
                            <svg class="icon icon-mail2">
                                <use xlink:href="#icon-mail2"></use>
                            </svg>
                            <h1>
                                YAZMAYA BAŞLA!
                            </h1>
                        </div>
                        <form action="{{action('ContactFormController@submit')}}" method="POST">
                            <input type="hidden" value="{{csrf_token()}}" name="_token">
                            <div class="Iletisim-form flex wrap">
                                <div class="Iletisim-form-item col-md-6">
                                    <input name="form[name]" id="i" type="text" class="form-control" required>
                                    <label for="i">Adınız</label>
                                </div>
                                <div class="Iletisim-form-item col-md-6">
                                    <input name="form[surname]" id="s" type="text" class="form-control" required>
                                    <label for="s">Soyadınız</label>
                                </div>
                                <div class="Iletisim-form-item col-md-6">
                                    <input name="form[phone]" id="t" type="text" class="form-control" required>
                                    <label for="t">Telefon Numaranız</label>
                                </div>
                                <div class="Iletisim-form-item col-md-6">
                                    <input name="form[email]" id="e" type="text" class="form-control" required>
                                    <label for="e">E-Posta Adresiniz</label>
                                </div>
                                <div class="Iletisim-form-item col-md-12 flex a-i-c " >
                                    <textarea name="form[icerik]" id="m" rows="2" class="form-control"  required></textarea>
                                    <label for="m">Mesajınız</label>
                                    <div class="Iletisim-form-send">
                                        <input type="submit" class="" value="Gönder">
                                        <svg class="icon icon-send">
                                            <use xlink:href="#icon-send"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="Iletisim-right">
                        <div class="Iletisim-right-header">
                            <ul class="nav nav-tabs " style="width: 100%" >
                                <li class="nav-item ">
                                    <a href="#tab1" class="nav-link active " onclick="changeMap('{{ $defaultContact->x_coordinate }}','{{ $defaultContact->y_coordinate }}')" data-toggle="tab">
                                        {{ $defaultContact->location }}
                                    </a>
                                </li>
                                @forelse($anotherContacts as $another)
                                    <li class="nav-item  ">
                                        <a href="#tab{{$another->id}}" class="nav-link" onclick="changeMap('{{ $another->x_coordinate }}','{{ $another->y_coordinate }}')" data-toggle="tab">
                                            {{ $another->location }}
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
@php
$curl = curl_init();
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$event_id_contact = random_int(10000000000000, 99999999999999);


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v13.0/1757769984530411/events',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('data' => '[{"event_name": "Contact","event_id": "' . $event_id_contact . '","event_time": "' . time() .'","event_source_url": "'. $actual_link .'", "user_data": {"client_ip_address": "' . $fb_ip . '","client_user_agent": "' . $_SERVER['HTTP_USER_AGENT'] . '"} }]','access_token' => 'EAAHTPiGDALEBANKENo2ZAPSKmLeN0opQJsrrQdmeUyANnci2JKxLdpi7ZAPnfwwZA1VLWdP6UVf48N1MWo9l2fQ5CbZA0ZAJ487F18aZCsTpo5Mgpy6hZCiq0E6mZCuLLEnrCvSm2vty3KKQPFHUasZBLWqmsLi6SWZCsUg0mQr98ne7G9WvojsLUc','test_event_code' => 'TEST50377'),
));

$response = curl_exec($curl);

curl_close($curl);



@endphp
<script>
fbq('track', 'Contact',{}, {eventID : '{{ $event_id_contact }}' });
window.dataLayer = window.dataLayer || [];
dataLayer.push({
 event: 'contact',
 event_id: '{{ $event_id_contact }}',
 
});
</script>
                        <div class="Iletisim-right-in">
                            <div class="tab-content">
                                <div class="tab-pane fade active opa" id="tab1">
                                    <div class="Iletisim-info">
                                        <div class="Iletisim-info-head desktop">
                                            <h6>VİLLA KALKAN</h6>
                                            <h2>{{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->location : '' }}</h2>
                                        </div>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_locasyon">
                                                <use xlink:href="#icon-i_locasyon"></use>
                                            </svg>
                                            {{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->address : ''}}
                                        </p>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_no">
                                                <use xlink:href="#icon-i_no"></use>
                                            </svg>
                                            {{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->email : '' }}

                                        </p>

                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_phone">
                                                <use xlink:href="#icon-i_phone"></use>
                                            </svg>
                                          <a id="tel_zaraz" href="tel:{{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->phone : ''}}">  {{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->phone : ''}}</a>
                                        </p>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_phone">
                                                <image class="change-my-color" xlink:href="{{ asset('svg/clock.svg') }}" width="20" height="20" />
                                                {{--<use xlink:href="#icon-clock"></use>--}}
                                            </svg>
                                            <span style="min-width: 90px;display: inline-block"><b>Hafta içi</b> </span> 09:00 - 22:00
                                        </p>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_phone">
                                                <image class="change-my-color" xlink:href="{{ asset('svg/clock.svg') }}" width="20" height="20" />
                                                {{--<use xlink:href="#icon-clock"></use>--}}
                                            </svg>
                                            <br><span style="min-width: 90px;display: inline-block"><b>Hafta sonu </b></span> 09:00 - 22:00
                                        </p>
                                        <div class="Iletisim-info-sosyal desktop">
                                            <p>TAKİBE BAŞLA!</p>
                                            <div class="Iletisim-info-sosyal-link">
                                                <a href="{{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->facebook : '' }}">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                                <a href="{{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->instagram : '' }}">
                                                    <i class="fa fa-instagram"></i>
                                                </a>
                                                <a href="{{ isset($defaultContact) && !empty($defaultContact) ? $defaultContact->twitter : ''}}">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @forelse($anotherContacts as $another)
                                <div class="tab-pane fade " id="tab{{$another->id}}">
                                    <div class="Iletisim-info">
                                        <div class="Iletisim-info-head desktop">
                                            <h6>VİLLA KALKAN</h6>
                                            <h2>{{ $another->location }}</h2>
                                        </div>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_locasyon">
                                                <use xlink:href="#icon-i_locasyon"></use>
                                            </svg>
                                            {{ $another->address }}
                                        </p>
                                        <p class="Iletisim-info-item ">
                                            <svg class="icon icon-i_no">
                                                <use xlink:href="#icon-i_no"></use>
                                            </svg>
                                            {{ $another->email }}

                                        </p>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_phone">
                                                <use xlink:href="#icon-i_phone"></use>
                                            </svg>
                                            <a id="tel_zaraz" href="tel:{{ $another->phone }}">   {{ $another->phone }}</a> 
                                        </p>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_phone">
                                                <image class="change-my-color" xlink:href="{{ asset('svg/clock.svg') }}" width="20" height="20" />
                                                {{--<use xlink:href="#icon-clock"></use>--}}
                                            </svg>
                                            <span style="min-width: 90px;display: inline-block"><b>Hafta içi</b> </span> 09:00 - 22:00
                                        </p>
                                        <p class="Iletisim-info-item">
                                            <svg class="icon icon-i_phone">
                                                <image class="change-my-color" xlink:href="{{ asset('svg/clock.svg') }}" width="20" height="20" />
                                                {{--<use xlink:href="#icon-clock"></use>--}}
                                            </svg>
                                            <br><span style="min-width: 90px;display: inline-block"><b>Hafta sonu </b></span> 09:00 - 22:00
                                        </p>
                                        <div class="Iletisim-info-sosyal desktop">
                                            <p>TAKİBE BAŞLA!</p>
                                            <div class="Iletisim-info-sosyal-link">
                                                <a href="{{ $another->facebook }}">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                                <a href="{{ $another->instagram }}">
                                                    <i class="fa fa-instagram"></i>
                                                </a>
                                                <a href="{{ $another->twitter }}">
                                                    <i class="fa fa-twitter"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@push('javascripts')
    <script>
        $('.icon-send').on('click', function() {
            $('form').find('[type="submit"]').trigger('click');
        });
    </script>
@endpush
