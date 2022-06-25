@if(isset($type) && $type == 'iyzico')

@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>


@endsection
@section('content')
    <section  class="Banner Banner_md Banner-back"
              style="background-image: url();">
    </section>


    <section class="Hakkimizda">
        <div class="Hakkimizda-text">
            <div class="container">
                <div class="Hakkimizda-text-in flex-column a-i-c">
                    <svg class="icon icon-logo">
                        <use xlink:href="#icon-logo"></use>
                    </svg>
                    <h6>ÖN ÖDEME TALEBİNİZ ALINMIŞTIR</h6>
                    <h1>{{ $conversationId }}</h1>
                    <p>
                        {!! isset($about->description) ? $about->description : '' !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="Hakkimizda-person w-100">
            <div class="container">
                <div class="Hakkimizda-person-head text-center" style="width: 100%">
                    <p>
                        Ödeme talebiniz başarıyla sisteme kaydedilmiştir. Ödeme onayı alındıktan sonra tarafınıza bilgi verilecektir. Bizi tercih ettiğiniz için teşekkürler.
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection




@else
    @php $currency = $currencies->where('code', $data->currency_code)->first(); @endphp
    Islem Basarili
    <br>
    Ödemeniz başarıyla alınmıştır
    <br>
    Kart Sahibi: {{$data->name}}
    <br>
    Toplam Tutar: {{$data->total}} {{!empty($currency) ? $currency->name : 'TL'}}
    <br>
    İşlem Numarası: {{ unserialize(session()->get('payment'))['order_id'] }}

@endif

