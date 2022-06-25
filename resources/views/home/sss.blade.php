
<section class="A_sorular back_b">

    <div class=" containerindex">

        <div class="A_sorular-in flex">
            <div class="A_sorular-video bg_f" style="background-image: url( {{ImageProcess::getImageByPath( $website->general_setting->video_image) }});">
                <a class="lightview global_link video-btn"
                data-toggle="modal" data-src="{{$video}}" data-target="#myModal">
                </a>
                <svg class="icon icon-play-button pos-ab-xy-center ">
                    <use xlink:href="#icon-play-button"></use>
                </svg>
                <div class="item-text flex a-i-c w-100">
                    <h5>NASIL <strong>KİRALARIM?</strong></h5>
                    <svg class="icon icon-logo ml-auto">
                        <use xlink:href="#logo_vk_w"></use>
                    </svg>
                </div>
            </div>
            <div class="A_sorular-sss ">

                <div class="A_sorular-sss-head">
                    <h3>
                        <svg class="icon icon-question">
                            <use xlink:href="#icon-question"></use>
                        </svg>
                        SIKÇA SORULAN SORULAR
                    </h3>
                    <a href="{{ url('/nasil-kiralarim') }}">Tümünü Görüntüle</a>
                </div>

                <div class="accordion " id="accordionExample">
                    @forelse($website->how_articles as $faqArt)
                    <div class="A_sorular-sss-item">
                        <button class="A_sorular-sss-item-head " type="button" data-toggle="collapse"
                                data-target="#sss-{{$faqArt->id}}" aria-expanded="true" aria-controls="collapseOne">
                            <h6 >{{$faqArt->title}}</h6>
                            <svg class="icon icon-angle-down">
                                <use xlink:href="#icon-angle-down"></use>
                            </svg>
                        </button>
                        <div id="sss-{{$faqArt->id}}" class="A_sorular-sss-item-content collapse "  data-parent="#accordionExample">
                            <p>{!! $faqArt->short_text !!}</p>
                        </div>
                    </div>
                    @empty
                        &nbsp;
                    @endforelse
                </div>

            </div>
            <a href="{{ url('/nasil-kiralarim') }}" class="buton mx-auto mobile-f ">
                DİĞER MERAK EDİLENLER
                <svg class="icon icon-right-arrow">
                    <use xlink:href="#icon-right-arrow"></use>
                </svg>
            </a>
        </div>
    </div>
</section>

 <!-- Modal -->
<div class="modal fade guttert" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">


      <div class="modal-body">

       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>


      <!-- 16:9 aspect ratio -->
      <div class="embed-responsive embed-responsive-16by9">
        @if(empty($video))
        {{(!empty($website->general_setting->video_url) ? $website->general_setting->video_url : 'Villamızın videosu hazırlanmaktadır')}}
        @else
        <iframe class="embed-responsive-item"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen src="" id="video"  allowscriptaccess="always"></iframe>
        @endif
    </div>



</div>

</div>
</div>
</div>
