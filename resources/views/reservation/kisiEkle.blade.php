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
    <link rel="stylesheet" href="/reservation_assets/css/main.css">

    <script src="/reservation_assets/js/library/jquery-3.2.1.slim.min.js"></script>
</head>

<body>

<main>
    <header class="Navbar">

        <div class="Navbar-inner">
            <div class="Navbar-top">
                <a href="" class="Navbar-logo"></a>
                <a href="" class="Navbar-top-phone mobile"></a>
            </div>
            <div class="Navbar-info">
                <p class="Navbar-info-name">SN. {{$reservation->customer->name}}</p>
                <p class="Navbar-info-day">TATİLNİZE <br>
                    SON {{Carbon\Carbon::parse($reservation->start_date)->diffInDays(Carbon\Carbon::now())}} GÜN</p>
            </div>
        </div>

    </header>

    <section class="Form">
        <div class="container">
            @if(session()->has("message"))
            <div class="alert alert-{{session()->get("type")}}">{{session()->get("message")}}</div>
            @endif
            <form action="{{route("kisiListesiEkle.post",$code)}}" method="post">
                {{csrf_field()}}
                <div class="Form-inner">
                    <?php $index = 0; ?>

                        @foreach($people as $person)
                            <div class="Form-item">
                                <h3 class="Form-item-header">{{$loop->iteration}}. KİŞİ BİLGİLERİ</h3>
                                <select name="uyruk[{{$index}}]" id="adult_{{$loop->iteration}}" class="selectpicker w-100"
                                        data-live-search="true">
                                    <option selected disabled value="">UYRUK SEÇİNİZ</option>
                                    <option value="TC Vatandaşı" @if($person->document_type == "TC Vatandaşı") selected @endif>TC Vatandaşı</option>
                                    <option value="Diğer" @if($person->document_type != "TC Vatandaşı") selected @endif>Diğer</option>
                                </select>
                                <input name="isim[{{$index}}]" type="text" value="{{$person->name}}" class="form-control" placeholder="İSİM">
                                <input name="soyisim[{{$index}}]" type="text" value="{{$person->surname}}" class="form-control" placeholder="SOYİSİM">
                                <input name="tc[{{$index++}}]" id="adult_tc_{{$i}}" value="{{$person->document_no}}" type="text" class="form-control"
                                       placeholder="TC KİMLİK NO">
                            </div>

                            <script>
                                $("#adult_{{$loop->iteration}}").change(function () {
                                    if ($("#adult_{{$loop->iteration}}").val() !== "Diğer") {
                                        $("#adult_tc_{{$loop->iteration}}").show();
                                    } else {
                                        $("#adult_tc_{{$loop->iteration}}").hide();
                                    }
                                });
                            </script>
                        @endforeach

                    @for($i = count($people)  + 1   ; $i <= $totalPeople ; $i++)
                        <div class="Form-item">
                            <h3 class="Form-item-header">{{$i}}. KİŞİ BİLGİLERİ</h3>
                            <select name="uyruk[{{$index}}]" id="adult_{{$i}}" class="selectpicker w-100"
                                    data-live-search="true">
                                <option selected disabled value="">UYRUK SEÇİNİZ</option>
                                <option value="TC Vatandaşı">TC Vatandaşı</option>
                                <option value="Diğer">Diğer</option>
                            </select>
                            <input name="isim[{{$index}}]" type="text" class="form-control" placeholder="İSİM">
                            <input name="soyisim[{{$index}}]" type="text" class="form-control" placeholder="SOYİSİM">
                            <input name="tc[{{$index++}}]" id="adult_tc_{{$i}}" type="text" class="form-control"
                                   placeholder="TC KİMLİK NO">
                        </div>

                        <script>
                            $("#adult_{{$i}}").change(function () {
                                if ($("#adult_{{$i}}").val() !== "Diğer") {
                                    $("#adult_tc_{{$i}}").show();
                                } else {
                                    $("#adult_tc_{{$i}}").hide();
                                }
                            });
                        </script>
                    @endfor




                </div>
                <button type="submit" class="Form-item-buton" style="width: 100%">KAYDET</button>
            </form>
        </div>
    </section>

</main>


<script src="/reservation_assets/js/library/popper.min.js"></script>
<script src="/reservation_assets/js/library/bootstrap.min.js"></script>
<script src="/reservation_assets/js/library/swiper.js"></script>
<script src="/reservation_assets/js/library/slick.js"></script>
<script src="/reservation_assets/js/library/bootstrap-select.min.js"></script>
<script src="/reservation_assets/js/main.js"></script>


</body>
</html>