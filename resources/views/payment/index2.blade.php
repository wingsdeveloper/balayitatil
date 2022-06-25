<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

</head>


{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"> --}}

<link rel="stylesheet" href="css/card.css">

<div class="container" style="padding-top: 50px;">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tr">TR</a></li>
        <li><a data-toggle="tab" href="#en">EN</a></li>
    </ul>
    <div class="tab-content">
        <div id="tr" class="tab-pane fade in active">
          <h3>Villa Kalkan Manual Ödeme Formu</h3>
            <form action="{{ action('PaymentController@post2') }}" method="POST">
                <input type="hidden" value="{{ request('code') }}" name="code">
                <div class="row">
                    <div class="col-md-6">
                        <div class="payment-form">
                            <div class="form-group">
                                <input class="form-control"  type="text" name="name" placeholder="Kart Sahibi Adı ve Soyadı" />
                            </div>
                            <div class="form-group">
                                <section class="cnoo">
                                    <span>Kart Numarası</span><input class="form-control"  type="tel" name="number" class="card-no" placeholder="---- ---- ---- ----" />
                                </section>
                            </div>
                            <div class="form-group" style="width: 100%">
                                <div style="display: flex;width: 100%" style="">
                                    <select class="form-control" name="month">
                                        <option value="••">Ay</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    <select class="form-control" name="year">
                                        <option value="••">Yıl</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                        <option value="2032">2032</option>
                                        <option value="2033">2033</option>
                                        <option value="2034">2034</option>
                                    </select>
                                    <input class="form-control"  type="tel" name="cvc" placeholder="CVC" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fr">
                                    <div style="display: flex;">
                                        <input class="form-control"  type="tel" name="total" style="width: 80%" placeholder="Ödenecek Tutar" />
                                        <select name="currency_code" class="form-control" style="width: 20%!important">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->code }}">{{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-area">
                            <div class="demo-container">
                                <div class="card-wrapper card-wrapper-tr" data-container-id="card-wrapper-tr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="form-control" style="color: white;background-color: skyblue; border: 1px solid skyblue; padding: 5px;">Ödemeyi Tamamla</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="en" class="tab-pane fade">
            <h3>Villa Kalkan Manual Payment Form</h3>
            <form action="{{ action('PaymentController@post2') }}" method="POST">
                <input type="hidden" value="{{ request('code') }}" name="code">
                <div class="row">
                    <div class="col-md-6">
                        <div class="payment-form">
                            <div class="form-group">
                                <input class="form-control"  type="text" name="name" placeholder="Cardholder Name & Surname" />
                            </div>
                            <div class="form-group">
                                <section class="">
                                    {{--<span>Card Number</span><input class="form-control"  type="" name="number" class="card-no" placeholder="---- ---- ---- ----" />--}}
                                    <input name="number" placeholder="cardno">
                                </section>
                            </div>
                            <div class="form-group">
                                <div style="display: flex;width: 100%" style="">
                                    <select class="form-control month" name="month">
                                        <option value="••">Exp Month</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                    <select class="form-control year" name="year">
                                        <option value="••">Exp Year</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                    </select>

                                    <input class="form-control"  type="tel" name="cvc" placeholder="CVC" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="fr">
                                    <div style="display: flex;">
                                        <input class="form-control"  type="tel" name="total" style="width: 80%" placeholder="Total Amount" />
                                        <select name="currency_code" class="form-control" style="width: 20%!important">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->code }}">{{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-area">
                            <div class="demo-container">
                                <div class="card-wrapper card-wrapper-en" data-container-id="card-wrapper-en"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="form-control" type="submit" style="color: white;background-color: skyblue; border: 1px solid skyblue; padding: 5px;">Complete Payment</button>

                    </div>


                </div>
            </form>
        </div>
    </div>




</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> --}}

<script src="js/jquery.card.js"></script>
<script>

    $('form').each(function(index, el) {
        name = $(this).find('.card-wrapper').data('container-id');
        console.log(name);
        $(this).card({
            container: '.' + name,
        });
    });


    year_selector = 'select[name="data[Source][exp_year]"]';
    month_selector = 'select[name="data[Source][exp_month]"]';
    $(month_selector).change(function() {
        year = $(year_selector).val() == '' ? '••' : $(year_selector).val();
        $('.jp-card-expiry').text($(this).val() + '/' + year);
    });
    $(year_selector).change(function() {
        month = $(month_selector).val() == '' ? '••' : $(month_selector).val();
        $('.jp-card-expiry').text(month + '/' + $(this).val());
    });
    $(month_selector).add(year_selector).on('focus', function() {
        $('.jp-card-expiry').addClass('jp-card-focused');
    }).on('blur', function() {
        $('.jp-card-expiry').removeClass('jp-card-focused');
    });
</script>
