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
                    <h6>VİLLA KALKAN</h6>
                    <h1>{{ $conversationId }}</h1>
                    <p>
                        {!! isset($about->description) ? $about->description : '' !!}
                    </p>
                </div>
            </div>
        </div>

        <div class="Hakkimizda-person w-100">
            <div class="container">
                <div class="Hakkimizda-person-head" style="width: 100%">

                    <div id="iyzipay-checkout-form" class="responsive">
                        {!! ($checkoutFormInitialize->getCheckoutFormContent()) !!}
                        {!! ($checkoutFormInitialize->getErrorMessage()) !!}
                    </div>

                </div>

            </div>
        </div>

    </section>



@endsection
@push('javascripts')

    <script>
        $(document).ready(function () {
            // Handler for .ready() called.
            $('html, body').animate({
                scrollTop: $('#iyzipay-checkout-form').offset().top - 100
            }, 'slow');
        });
    </script>
@endpush

