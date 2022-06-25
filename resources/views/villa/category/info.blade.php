<section class="Information">
    <div class="container">
        <div class="Information-in flex-column a-i-c">
            <div class="Information-head">
                <h5>{{$website->categories[0]->name}}</h5>
            </div>
 @if(isset($website->categories[0]->description))
            <div class="accordion flex-column a-i-c " id="accordionExample">
                @php 
                $kisa=App\Helpers\Helper::bolumle($website->categories[0]->description,40);
                $devam=explode($kisa,$website->categories[0]->description);
                @endphp
                <p>{!! $kisa !!}</p>
                @if(!empty($devam[1]))
                <div id="mcaraciklama" class="Information-content collapse "
                data-parent="#accordionExample">
                <p>{!! $devam[1] !!}<br></p>
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
