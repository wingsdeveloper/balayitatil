@if(!isset($temporaries) || empty($temporaries))
    <style type="text/css">.A_firsat:before {
            background-image: none !important;
        }</style>
@else
    <section class="K_villalar">
        <div class=" containerindex">
            <div class="Head flex-column a-i-c j-c-c">
                <h6>KISA SÜRELİ</h6>
                <h5>VİLLALAR</h5>
                <p>
                    {{ isset($short_villas_content->content_description) ? $short_villas_content->content_description : '' }} </p>
            </div>
            @if(Agent::isDesktop())
                <div class="K_villalar-in flex a-i-fs" style="align-items: unset; justify-content: center;">
                    @foreach($temporaries as $ay=>$temporary)
                        @continue(count($temporary) == 0)
                        <div class="K_villalar-item">
                            <p>{{$ay}}</p>
                            @forelse($temporary as $item)
                                <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') }}">{{$item->geceFarki}}
                                    Gecelik <span>({{$item->count}})</span></a>
                            @empty
                            @endforelse
                        </div>
                    @endforeach
                    @foreach($temporariesNext as $ay=>$temporary)
                        @continue(count($temporary) == 0)
                        <div class="K_villalar-item">
                            <p>{{$ay}}</p>
                            @forelse($temporary as $item)
                                <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') + 1 }}">{{$item->geceFarki}}
                                    Günlük <span>({{$item->count}})</span></a>
                            @empty
                            @endforelse
                        </div>
                    @endforeach
                </div>
            @else
                <div class="swiper-container-kv mobile">
                    <div class="swiper-wrapper">

                        @foreach($temporaries as $ay=>$temporary)
                            @continue(count($temporary) == 0)
                            <div class="swiper-slide">
                                <div class="K_villalar-item">
                                    <p>{{$ay}}</p>
                                    @forelse($temporary as $item)
                                        <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') }}">{{$item->geceFarki}}
                                            Günlük <span>({{$item->count}})</span></a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                        @endforeach
                        @foreach($temporariesNext as $ay=>$temporary)
                            @continue(count($temporary) == 0)
                            <div class="swiper-slide">
                                <div class="K_villalar-item">
                                    <p>{{$ay}}</p>
                                    @forelse($temporary as $item)
                                        <a href="{{url('yaklasan-firsatlar')}}?gece={{$item->geceFarki}}&ay={{$transAylar[$ay]}}&yil={{ date('Y') + 1 }}">{{$item->geceFarki}}
                                            Günlük <span>({{$item->count}})</span></a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            @endif
        </div>
    </section>
@endif

