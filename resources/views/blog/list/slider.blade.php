<section class=" Slider Blog-slider">
    <div id="carousel1" class="carousel slide " data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @forelse($slider_blogs as $key => $value)

            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" >
                <div class="container ">
                    <div class="Blog-slider-in flex j-c-c a-i-c">
                        <div class=" slide_text ">

                            <h6>{{ isset($value->blog_category) ? $value->blog_category->name : '' }}</h6>
                            <h1 class="animated fadeInDown flex-column ">{{ $value->title }}</h1>
                            <div class="animated fadeInUp slide_text-in" >
                                {!! App\Helpers\Helper::bolumle($value->description ,50) !!}
                            </div>
                            @if(isset($value->seo) && !empty($value->seo))
                                <a href="{{ route('blog.control',$value->seo->seo_url) }}" class="buton_orange">
                                    Devamını Oku
                                    <svg class="icon icon-right-arrow">
                                        <use xlink:href="#icon-right-arrow"></use>
                                    </svg>
                                </a>
                            @else
                                <a href="#" class="buton_orange">
                                    Devamını Oku
                                    <svg class="icon icon-right-arrow">
                                        <use xlink:href="#icon-right-arrow"></use>
                                    </svg>
                                </a>
                            @endif


                        </div>
                        <div class="Blog-slider-img" style="background-image: url({{ImageProcess::getImageByPath( $value->image) }})">
                            <img src="{{ImageProcess::getImageByPath( $value->image) }}" class="w-100" alt="{{ $value->title }}">
                        </div>

                    </div>
                </div>
            </div>
            @empty
            @endforelse
           @if(isset($slider_blogs) && count($slider_blogs) > 1)
                <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
                    <svg class="icon icon-right-long-arrow">
                        <use xlink:href="#icon-right-long-arrow"></use>
                    </svg>
                </a>
                <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
                    <svg class="icon icon-right-long-arrow">
                        <use xlink:href="#icon-right-long-arrow"></use>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</section>
