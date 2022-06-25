@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('itemscope')itemscope itemtype="https://schema.org/FAQPage"@endsection
@section('content')
    @include('faq.slider')

    <section class="Sss">
        <div class="container">
            <div class="Sss-in flex-column a-i-c">
                <div class="Global_header  desktop flex-column a-i-c">
                    <div class="flex a-i-c">
                        <svg class="icon icon-question">
                            <use xlink:href="#icon-question"></use>
                        </svg>
                        <h1 class="header-lg">MERAK EDİLENLER</h1>
                    </div>
                    <p class="desktop">
                        Web sayfamızda yer alan villaların kiralama süreci ve sonrası hakkında merak ettiklerinize dair derlenmiş soruların cevaplarına aşağıdaki sekmelere tıklayarak ulaşabilirsiniz. Farklı sorularınız için bizlere <a href="mailto:info@villakalkan.com.tr">info@villakalkan.com.tr</a> mail adresimizden veya <a href="tel:02422520032">0242 252 00 32</a> numaralı telefonumuzdan ulaşabilirsiniz.
                    </p>
                </div>
        @if(Agent::isDesktop())
                <div class="Sss-video desktop">
                    <a href="#myModal" class="global_link  video-btn" data-toggle="modal"
                       data-src="{{ isset($video) && !empty($video) ? $video : '' }}">
                    </a>
                    <svg class="icon icon-play-button-2">
                        <use xlink:href="#icon-play-button-2"></use>
                    </svg>
                    <p>Nasıl <strong>Kiralarım ?</strong></p>
                </div>
        @elseif(Agent::isMobile())
                <div class="Sss-mobile mobile-f flex-column a-i-c">
                    <div class="Sss-video ">
                        <a href="#myModal" class="global_link  video-btn" data-toggle="modal" data-src="{{ isset($video) && !empty($video) ? $video : '' }}">
                        </a>
                        <svg class="icon icon-play-button-2">
                            <use xlink:href="#icon-play-button-2"></use>
                        </svg>
                        <p>Nasıl <strong>Kiralarım ?</strong></p>
                    </div>
                    <div class="Global_header mobile-f flex-column a-i-c">
                        <div class="flex a-i-c">
                            <svg class="icon icon-question">
                                <use xlink:href="#icon-question"></use>
                            </svg>
                            <h2 class="header-lg">MERAK EDİLENLER</h2>
                        </div>
                        <p class="desktop">
                            Nefes kesici doğa manzarası, muhteşem plajları, begonvillerin süslediği beyaz
                            badanalı taş evleri ve yıldız yağmuru altındaki teraslarıyla bir Akdeniz rüyası…
                        </p>
                    </div>


                    <ul class="nav nav-tabs  ">
                        @if(count($faqCats) > 0)
                            @foreach($faqCats as $mCatKey=>$mfaqCat)
                                <li class="nav-item ">
                                    <a href="#faqcat{{$mfaqCat->id}}" class="nav-link {{($mCatKey==0)?'active':''}}"
                                       data-toggle="tab">{{$mfaqCat->name}}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
        @endif
                <ul class="nav nav-tabs desktop ">
                    @if(count($faqCats) > 0)
                        @foreach($faqCats as $dCatKey=>$dfaqCat)
                            <li class="nav-item ">
                                <a href="#faqcat{{$dfaqCat->id}}" class="nav-link {{($dCatKey==0)?'active':''}}"
                                   data-toggle="tab">{{$dfaqCat->name}}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content w-100">
                    @if(count($faqCats) > 0)
                        @foreach($faqCats as $catKey=>$faqCat)
                        <div class="tab-pane opa {{($catKey==0)?'fade active':''}}" id="faqcat{{$faqCat->id}}">
                            <div class="accordion " id="accordionExample">
                                @if(count($faqCat->articles) > 0)
                                    @foreach($faqCat->articles as $artKey=>$faqArt)
                                        <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" class="A_sorular-sss-item">
                                            <button class="A_sorular-sss-item-head " type="button" data-toggle="collapse"
                                                    data-target="#sss-{{$faqArt->id}}" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                <h6 itemprop="name">{{$faqArt->title}}</h6>
                                                <svg class="icon icon-angle-down">
                                                    <use xlink:href="#icon-angle-down"></use>
                                                </svg>
                                            </button>

                                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" id="sss-{{$faqArt->id}}" class="A_sorular-sss-item-content collapse "
                                                 data-parent="#accordionExample">
                                                <div itemprop="text">{!! $faqArt->long_text !!}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <!-- 16:9 aspect ratio -->
                        <div class="embed-responsive embed-responsive-16by9">
                            @if(empty($video))
                                {{(isset($website->general_setting) && !empty($website->general_setting) ? $website->general_setting->video_url : 'Villamızın videosu hazırlanmaktadır')}}
                            @else
                                <iframe class="embed-responsive-item"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen src="" id="video"  allowscriptaccess="always"></iframe>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
