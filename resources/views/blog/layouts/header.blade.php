<header class="Navtop Navtop-blog" >
    <div class="container">
        <nav class="navbar  navbar-expand-lg">

            <a href="{{ url('/') }}" class="navbar-brand  ">
                <svg class="icon navbar-brand-logo"><use xlink:href="#logo_vk"></use></svg>
                <span>BLOG</span>
            </a>

            <div class="  navbar-collapse navbar-collapse-menu  " id="ac">

                <ul class="navbar-nav  ml-auto">
                    <li class="nav-item nav-item-master">
                        <a href="{{ url('/') }}" class="nav-link">
                            <span>
                                    ANASAYFA
                                <svg class="icon icon-right-long-arrow"><use xlink:href="#icon-right-long-arrow"></use></svg>
                            </span>
                            VİLLA KALKAN
                        </a>
                    </li>
                    <li class="nav-item"><a href="{{ url('/hakkimizda') }}" class="nav-link">HAKKIMIZDA</a></li>
                    <li class="nav-item"><a href="{{ url('/iletisim') }}" class="nav-link">İLETİŞİM</a></li>
                </ul>


            </div>

            <div class="Mobil_menu mobile-f">

                <div class="btn-menu btn-menu-open">
                    <a class="" href="#"></a>
                    <svg class="icon icon-menu"><use xlink:href="#icon-menu"></use></svg>
                    <svg class="icon icon-close"><use xlink:href="#icon-close"></use></svg>
                </div>

            </div>

        </nav>

    </div>
</header>
<div class="overlay">
    <div class="wra">
        <ul class="wra-nav">
            <li><a href="{{ url('/') }}" class="active">VİLLA KALKAN</a></li>
            <li><a href="{{ url('/hakkimizda') }}">HAKKIMIZDA</a></li>
            <li><a href="{{ url('/iletisim') }}">İLETİŞİM</a></li>
        </ul>
    </div>
</div>