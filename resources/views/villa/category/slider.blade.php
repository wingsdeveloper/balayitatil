<!--style="background-image: url(
@if($view_name == "villa-category-index")
        {{ Agent::isDesktop() ? ImageProcess::getImageByPath($secenek->static_banner_image_pc) :ImageProcess::getImageByPath($secenek->static_banner_image_mobile)}}
@else
    {{ImageProcess::getImageByPath(Agent::isDesktop() ?$website->categories[0]->image:$website->categories[0]->image_mobile)}}
@endif
    )" >-->

<section class="Home-banner Home-banner-detail" style="background-image: url({{ asset('images/banner-detail.jpg') }});">
        <div class="container">
            <div class="Home-banner-in">
                <div class="Home-banner-text">
                    <div class="Home-banner-text-left">
                        <h1>@if($view_name == "villa-category-index")
                                {{ $secenek->static_banner_subtitle }}
                            @else
                                {{$website->categories[0]->name}}
                            @endif
                        </h1>
                    </div>
                    <div class="Home-banner-text-right">
                        @if($view_name == "villa-category-index")
                            <p>
                                {{ $secenek->static_banner_description }}
                            </p>
                        @endif
                    </div>
                </div>

                @include('layouts.searchMenu')

                <div class="Home-banner-contact">
                    <div class="Home-banner-contact-social">
                        <a href=""><i class="fa fa-facebook"></i></a>
                        <a href=""><i class="fa fa-instagram"></i></a>
                        <a href=""><i class="fa fa-twitter"></i></a>
                    </div>

                    <div class="Contact-support Contact-support-white">
                        <a href="">
                            <p><span>Yardım & Destek</span>+90 252 606 0 876</p>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('layouts.homeInfo') 