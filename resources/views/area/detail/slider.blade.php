<section  class="Banner Banner_xmd Banner-back " style="background-image: url({{(isset($content->banner_image))? ImageProcess::getImageByPath($content->banner_image):''}});">

    <div class="container">
        <div class=" Banner_md-text   pos-ab-x-center ">
            <h1 class="animated fadeInDown flex-column ">{{ isset($area->name) ? $area->name : '' }}</h1>
            <div class="Bolgeler-icons">
                <div class="Bolgeler-icons-item">
                    <svg class="icon icon-bplane"><use xlink:href="#icon-house4"></use></svg>
                    <span>VİLLA SAYISI <strong>{{$villas->total()}}</strong></span>
                </div>
                <div class="Bolgeler-icons-item">
                    <svg class="icon icon-sunset"><use xlink:href="#icon-sunset"></use></svg>
                    <span>HAVA DURUMU <strong>{{ isset($hava_durumu[$req->link]) ? $hava_durumu[$req->link] : rand(15, 25) . 'C' }} <!--°--></strong></span>
                </div>
                <div class="Bolgeler-icons-item">
                    <svg class="icon icon-bplane"><use xlink:href="#icon-bplane"></use></svg>
                    <span>HAVA LİMANI<strong>{{(isset($content->airport_distance))? $content->airport_distance:''}}</strong></span>
                </div>
            </div>
        </div>
    </div>
    {{--test--}}

    @include('layouts.searchMenu')

</section>

@include('layouts.searchMenuMobile')

<section class="Information">
    <div class="container">
        <div class="Information-in flex-column a-i-c">
            <div class="Information-head">
                <h6>TANIYALIM</h6>
                <h5>{{ isset($area->name) ? $area->name : '' }}</h5>
            </div>
            @if(isset($content->description))
            <div class="accordion flex-column a-i-c " id="accordionExample">
                @php
                $kisa=App\Helpers\Helper::bolumle($content->description,40);
                $devam=explode($kisa,$content->description);
                @endphp
                <p>{!! $kisa !!}</p>
                @if(!empty($devam[1]))
                <div id="mcaraciklama" class="Information-content collapse "
                data-parent="#accordionExample">
                <p style="text-align: justify">{!! $devam[1] !!}<br></p>
                </div>

            <button class=" Information-buton" type="button" data-toggle="collapse"
            data-target="#mcaraciklama" aria-expanded="true"
            aria-controls="collapseOne">
            Devamını Oku
            <svg class="icon icon-angle-down">
                <use xlink:href="#icon-angle-down"></use>
            </svg>
        </button>
         @endif
    </div>
    @endif
</div>
</div>
</section>
