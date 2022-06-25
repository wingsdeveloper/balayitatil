<style>
    #gallery figure:first-child {
        height: 50%;
    }

    #gallery figure:not(:first-child) {
        display: none;
    }
</style>
<section id="foto" class="Banner Banner_lg Banner-back-dark">

    <div class="Banner_blur" style="background-image:url(
        @if(Agent::isDesktop())
    @if(!empty($villa->panel_villa) && !empty($villa->panel_villa->banner_image))
    {{ImageProcess::getImageByPath( $villa->panel_villa->banner_image) }}
    @elseif(!empty($villa->banner_image))
    {{ImageProcess::getImageByPath( $villa->banner_image) }}
    @else
    {{ ImageProcess::getImageByPath('images/slider.jpg') }}
    @endif
    @else
    @if(!empty($villa->panel_villa) && !empty($villa->panel_villa->banner_image_mobile))
    {{ImageProcess::getImageByPath( $villa->panel_villa->banner_image_mobile) }}
    @elseif(!empty($villa->banner_image_mobile))
    {{ImageProcess::getImageByPath( $villa->banner_image_mobile) }}
    @else
    {{ ImageProcess::getImageByPath('images/slider.jpg') }}
    @endif
    @endif">

    </div>
    <div class="container">
        <div class=" Banner_lg-text   pos-ab-xy-center ">
            <h6 class="animated fadeInDown desktop">{{$villa->name}}</h6>
            <h1 class="animated fadeInDown desktop">{{ $website->prefix }}{{ $villa->code }}</h1>
            <div class="Villa_detay-images flex"
                 @if(empty($video) || ($video == '')) style="justify-content: center!important" @endif>
                <div class="Villa_detay-images-item pl-4">
                    <div id="gallery" class="gallery">
                        @forelse($villa->photos as $photo)
                            <figure itemprop="associatedMedia" itemscope itemtype="">
                                <!-- Büyük Resim linki -->

                                @if(Agent::isMobile() || Agent::isTablet())
                                    <a href="{{ ImageProcess::getImageWatermarkedPath($photo, true) }}"
                                       data-caption="{{$villa->name}}"
                                       data-width="1920" data-height="1080"
                                       itemprop="contentUrl">
                                        <!-- Küçük Resim -->

                                        <img data-src="{{ ImageProcess::getImageWatermarkedPath($photo, true) }}"
                                             itemprop="thumbnail" alt="{{$villa->name}}">
                                    </a>
                                @else
                                    <a style="display: block; width: 100%; height: 100%"
                                       href="{{ ImageProcess::getImageWatermarkedPath($photo) }}"
                                       data-caption="{{$villa->name}}"
                                       data-width="1920" data-height="1080"
                                       itemprop="contentUrl">
                                        <!-- Küçük Resim -->

                                        <img data-src="{{ ImageProcess::getImageWatermarkedPath($photo) }}"
                                             itemprop="thumbnail" alt="{{$villa->name}}">
                                    </a>

                                @endif
                            </figure>
                        @empty
                            &nbsp;
                        @endforelse
                    </div>
                    <svg class="icon icon-image">
                        <use xlink:href="#icon-image"></use>
                    </svg>
                    <p class="desktop" style="z-index: 9999; cursor: pointer"
                       onclick="$('#gallery').find('figure a:first').click();">Fotoğrafları Gör <span>({{count($villa->photos)}})</span>
                    </p>
                    <p class="mobile" style="z-index: 9999" onclick="$('#gallery').find('figure a:first').click();">
                        FOTOĞRAFLARI <br> GÖRÜNTÜLE<span>({{count($villa->photos)}})</span></p>
                </div>

                <div class="Villa_detay-images-item {{ empty($video) ? 'hidden' : '' }}"
                     style="display: {{ empty($video) ? 'none' : '' }}">
                    <a class="global_link  video-btn"
                       data-toggle="modal" data-src="{{$video}}" data-target="#myModal">
                    </a>
                    <svg class="icon icon-play-button-2">
                        <use xlink:href="#icon-play-button-2"></use>
                    </svg>
                    <p>Videoyu İzle</p>
                </div>


            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">


                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        @if(empty($video))
                            {{(!empty($villa->panel_villa->video_url) ? $villa->panel_villa->video_url : 'Villamızın videosu hazırlanmaktadır')}}
                        @else
                            <iframe class="embed-responsive-item" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen src="" id="video" allowscriptaccess="always"></iframe>
                        @endif
                    </div>


                </div>

            </div>
        </div>
    </div>

    <!-- Modal SSS -->
    <div class="modal fade" id="myModalSSS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">


                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">

                        @if(empty($nasil_kiralarim_video))
                            {{(!empty($website->general_setting->video_url) ? $$website->general_setting->video_url : 'Videomuz hazırlanmaktadır')}}
                        @else
                            <iframe class="embed-responsive-item" frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen src="" id="videoSSS" allowscriptaccess="always"></iframe>
                        @endif
                    </div>


                </div>

            </div>
        </div>
    </div>


    <div class="Villa_detay-menu ">
        <div class="Villa_detay-menu-name">
            <p>
                <span>{{$villa->name}}</span>
                {{ $website->prefix }}{{ $villa->code }}
            </p>
        </div>
        <div class="Villa_detay-menu-links">
            <ul>
                <li><a class="nav-menuX" href="#foto">FOTOĞRAFLAR</a></li>
                <li><a class="nav-menuX" href="#fiyat">FİYATLANDIRMALAR</a></li>
                <li><a class="nav-menuX" href="#genel">GENEL BAKIŞ</a></li>

                @if(isset($vfloors) && !empty($vfloors))
                    <li><a class="nav-menuX" href="#kat">KAT PLANI</a></li>
                @endif
                <li><a class="nav-menuX" href="#harita">ULAŞIM</a></li>
                <li><a class="nav-menuX" href="#sss">MERAK EDİLENLER</a></li>
                <li><a class="nav-menuX" href="#extra">EXTRA</a></li>
            </ul>
        </div>

        <div id='UpTotop' class="flex-column a-i-c">
            <svg class="icon icon-chevron-right">
                <use xlink:href="#icon-chevron-right"></use>
            </svg>
            YUKARI ÇIK
        </div>

    </div>


</section>


<!-- Modal -->
<div class="modal modal_date fade" id="doluluk-takvimi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header modal_date-head flex-column">
                <div class="modal_date-head-header">
                    <h6>{{ $website->prefix }}{{ $villa->code }} İÇİN</h6>
                    <h3>DOLULUK TAKVİMİ</h3>
                </div>
                <div class="modal_date-head-info flex a-i-c">
                    <span class="modal_date-head-info-item modal_date-full">Dolu</span>
                    <span class="modal_date-head-info-item modal_date-wait">Onay Bekleniyor</span>
                    <span class="modal_date-head-info-item modal_date-late">Geçmiş</span>
                    <div class="modal_date-arrow ml-auto">
                        <button id="gecmistarih" onclick="takvimGetirPriority('{{date("Y")-1}}')" type="button">
                            <svg class="icon icon-right-arrow">
                                <use xlink:href="#icon-right-arrow"></use>
                            </svg>
                        </button>
                        <button id="gelecektarih" onclick="takvimGetirPriority('{{date("Y")+1}}')" type="button">
                            <svg class="icon icon-right-arrow">
                                <use xlink:href="#icon-right-arrow"></use>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="calendar" class="is_fulltable flex j-c-c wrap w-100">

                    @php
                        /*
                        $aylar = array(1=>"Ocak",2=>"Şubat",3=>"Mart",4=>"Nisan",5=>"Mayıs",6=>"Haziran",7=>"Temmuz",8=>"Ağustos",9=>"Eylül",10=>"Ekim",11=>"Kasım",12=>"Aralık");
                        $year=2019; // change this to another year
                        $row=0; // to set the number of rows and columns in yearly calendar
                         // Outer table
                        ////// Starting of for loop///
                        ///  Creating calendars for each month by looping 12 times ///
                        for($m=1;$m<=12;$m++){
                            $prevm=$m-1;
                            if($prevm==0){$prevm=12;}
                        $month =date($m);  // Month
                        $prevmonth =date($prevm);  // Month
                        $dateObject = DateTime::createFromFormat('!m', $m);
                        $monthName = $aylar[date($m)]; // Month name to display at top
                        $d= 2; // To Finds today's date
                        //$no_of_days = date('t',mktime(0,0,0,$month,1,$year)); //This is to calculate number of days in a month
                        $no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);//calculate number of days in a month
                        $prev_no_of_days = cal_days_in_month(CAL_GREGORIAN, $prevmonth, $year);//calculate number of days in a month
                        $j= date('w',mktime(0,0,0,$month,1,$year)); // This will calculate the week day of the first day of the month
                        //echo $j;// Sunday=0 , Saturday =6
                        //// if starting day of the week is Monday then add following two lines ///
                        $j=$j-1;
                        if($j<0){$j=6;}  // if it is Sunday //
                        //// end of if starting day of the week is Monday ////
                        $adj="";
                        for($bas=$prev_no_of_days-$j;$bas<$prev_no_of_days;$bas++){
                            $adj.="<td class='is_fulltable-d'><span>".($bas+1)."</span></td>";
                        }
                        $blank_at_end=42-$j-$no_of_days; // Days left after the last day of the month
                        if($blank_at_end >= 7){$blank_at_end = $blank_at_end - 7 ;}
                         // Blank ending cells of the calendar
                        $adj2="";
                        /*for($son=1;$son<=$blank_at_end;$son++){
                            $adj2.="<td bgcolor='#ffff00'>".($son)."</td>";
                        }*/
                        /// Starting of top line showing year and month to select ///////////////
                        /*echo "<div class='is_fulltable-item'>
                        <h5 class='is_fulltable-header'>$monthName $year</h5>";
                        //echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";
                        echo '
                        <table class="table">
                           <thead>
                            <tr>
                                <th scope="col"><span>PZT</span></th>
                                <th scope="col"><span>SAL</span></th>
                                <th scope="col"><span>ÇAR</span></th>
                                <th scope="col"><span>PER</span></th>
                                <th scope="col"><span>CUM</span></th>
                                <th scope="col"><span>CTS</span></th>
                                <th scope="col"><span>PAZ</span></th>
                            </tr>
                        </thead><tbody>
                        <tr>';
                        ////// End of the top line showing name of the days of the week//////////
                        //////// Starting of the days//////////
                            for($i=1;$i<=$no_of_days;$i++){
                                $pv="'$month'".","."'$i'".","."'$year'";
                        echo $adj."<td id='$year-$month-$i'><span>$i</span></td>"; // This will display the date inside the calendar cell
                        $adj='';
                        $j ++;
                        if($j==7){echo "</tr><tr>"; // start a new row
                        $j=0;}
                        }
                        echo $adj2;   // Blank the balance cell of calendar at the end
                        echo "</tr></tbody></table></div>";
                        $row=$row+1;
                        }*/
                    @endphp


                </div>
            </div>

        </div>
    </div>
</div>
