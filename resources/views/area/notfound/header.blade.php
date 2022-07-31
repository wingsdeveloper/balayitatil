<header class="Navtop ic ">

    <div class="container ">
        <nav class="navbar  navbar-expand-lg">

            <a href="#" class="navbar-brand  ">
                <svg class="icon navbar-brand-logo "><use xlink:href="#logo_vk_w"></use></svg>
            </a>

            <div class="  navbar-collapse navbar-collapse-menu  " id="ac">

                <div class="Navtop-top flex a-i-c ml-auto">

                    <div class="Navtop-top-login">
                        <a href="" class="global_link"></a>
                        <svg class="icon icon-user"><use xlink:href="#icon-person"></use></svg>
                        Müşteri Girişi
                    </div>

                    <div class="Navtop-top-favoriler">
                        <a href="" class="global_link"></a>
                        <span class="Navtop-top-favoriler-badge">12</span><svg class="icon icon-heart"><use xlink:href="#icon-heart"></use></svg>
                        Favorilerim
                    </div>

                    <div class="Navtop-top-search">
                        <input type="text" class="form-control" placeholder="Villa Ara">
                        <svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg>
                        <input type="submit" class="Navtop-top-search-buton">
                    </div>

                </div>

                <ul class="navbar-nav  ml-auto">
                    <li class="nav-item"><a href="" class="nav-link"> KİRALIK VİLLA</a></li>
                    <li class="nav-item"><a href="" class="nav-link">BÖLGELER</a></li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                VİLLA SEÇENEKLERİ
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <div class=" flex Ekonomik Kiralık Villalarj-c-c">
                                    <div class="dropdown-menu-in">
                                        <h5 class="dropdown-menu-header">VİLLA SEÇENEKLERİ</h5>
                                        <ul class="dropdown-menu-links">
                                            <a id="m1"  href="" class="dropdown-item">Ekonomik Kiralık Villalar</a>
                                            <a id="m2" href="" class="dropdown-item">Ekonomik Kiralık Villalar</a>
                                            <a id="m3" href="" class="dropdown-item">Ekonomik Kiralık Villalar</a>
                                            <a id="m4" href="" class="dropdown-item">Ekonomik Kiralık Villalar</a>
                                            <a id="m5" href="" class="dropdown-item">Ekonomik Kiralık Villalar</a>
                                            <a id="m6" href="" class="dropdown-item">Ekonomik Kiralık Villalar</a>
                                            <a id="m7" href="" class="dropdown-item">Ekonomik Kiralık Villalar</a>
                                            <a id="m8" href="" class="dropdown-item">5 Gece Konuklamaya Uygun Villalar</a>
                                            <a id="m9" href="" class="dropdown-item">5 Gece Konuklamaya Uygun Villalar</a>
                                            <a id="m10" href="" class="dropdown-item">5 Gece Konuklamaya Uygun Villalar</a>
                                            <a id="m11" href="" class="dropdown-item">5 Gece Konuklamaya Uygun Villalar</a>
                                        </ul>
                                    </div>
                                    <div class="dropdown-image">
                                        <img  src="{{ asset('images/nav.jpg') }}" class="w-100 nav-image" alt="Balayı Sepeti - Menü">
                                        <script>
                                            var degisken='h';

                                            $('.dropdown-item').hover(
                                                function(id) {
                                                    degisken=(this.id);

                                                    if(degisken=='m1'){$('.nav-image').attr("src","{{ asset('images/nav.jpg') }}");}
                                                    if(degisken=='m2'){$('.nav-image').attr("src","{{ asset('images/villa.jpg') }}");}
                                                    if(degisken=='m3'){$('.nav-image').attr("src","{{ asset('images/nav.jpg') }}");}
                                                    if(degisken=='m4'){$('.nav-image').attr("src","{{ asset('images/villa.jpg') }}");}
                                                    if(degisken=='m5'){$('.nav-image').attr("src","{{ asset('images/nav.jpg') }}");}
                                                    if(degisken=='m6'){$('.nav-image').attr("src","{{ asset('images/villa.jp') }}g");}
                                                    if(degisken=='m7'){$('.nav-image').attr("src","{{ asset('images/nav.jpg') }}");}
                                                    if(degisken=='m8'){$('.nav-image').attr("src","{{ asset('images/villa.jpg') }}");}
                                                    if(degisken=='m9'){$('.nav-image').attr("src","{{ asset('images/nav.jpg') }}");}
                                                    if(degisken=='m10'){$('.nav-image').attr("src","{{ asset('images/villa.jpg') }}");}
                                                    if(degisken=='m11'){$('.nav-image').attr("src","{{ asset('images/nav.jp') }}g");}




                                                },function() {
                                                    $('.resim-nav').css("background-image", "url(img/menu_resim.png)");
                                                });
                                        </script>
                                    </div>
                                </div>

                            </div>
                    </li>
                    <li class="nav-item"><a href="" class="nav-link">NASIL KİRALARIM</a></li>
                    <li class="nav-item active"><a href="" class="nav-link ">BLOG</a></li>
                    <li class="nav-item"><a href="" class="nav-link">HAKKIMIZDA</a></li>
                    <li class="nav-item"><a href="" class="nav-link">İLETİŞİM</a></li>
                </ul>


            </div>

            <div class="Mobil_menu mobile-f">
                <div class="Search-icon">
                    <svg class="icon icon-search"><use xlink:href="#icon-search"></use></svg>
                    <svg class="icon icon-close"><use xlink:href="#icon-close"></use></svg>
                </div>

                <div class="btn-menu btn-menu-open">
                    <a class="" href="#"></a>
                    <svg class="icon icon-menu"><use xlink:href="#icon-menu"></use></svg>
                    <svg class="icon icon-close"><use xlink:href="#icon-close"></use></svg>
                </div>

            </div>

        </nav>

        <div class="Search-menu">
            <form action="">
                <div class="Search-menu-in flex a-i-c">
                    <input type="text">
                    <input type="submit">
                </div>
            </form>
        </div>

        <div class="overlay">
            <div class="wra">
                <ul class="wra-nav">
                    <li><a href="#" class="active">KİRALIK VİLLA</a></li>
                    <li><a href="#">BÖLGELER</a></li>

                    <li>
                        <a href="#v" data-toggle="collapse">VİLLA SEÇENEKLERİ</a>
                        <div class=" collapse" id="v">
                            <ul class="wra-nav-in">
                                <li><a href="#">BÖLGELER</a></li>
                                <li><a href="#">BÖLGELER</a></li>
                                <li><a href="#">BÖLGELER</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a href="#">NASIL KİRALARIM</a></li>
                    <li><a href="#">HAKKIMIZDA</a></li>
                    <li><a href="#">BLOG</a></li>
                    <li><a href="#">İLETİŞİM</a></li>
                    <a href=""> <i class="fa fa-facebook mr-3"></i></a>
                    <a href="">   <i class="fa fa-instagram"></i></a>
                </ul>




            </div>
        </div>

    </div>
</header>