var takvimvarmi = false;

function getTodayString() {
    var strNow = "It is now: " + new Date().toLocaleDateString() + ", ";
    strNow += new Date().toLocaleTimeString();
    return strNow;
}

var arrWeekdays = new Array('PZT', 'SAL', 'ÇAR', 'PER', 'CUM', 'CMT', 'PAZ');
var arrMonths = new Array(['Ocak', 31], ['Şubat', 28], ['Mart', 31], ['Nisan', 30], ['Mayıs', 31], ['Haziran', 30], ['Temmuz', 31], ['Ağustos', 31], ['Eylül', 30], ['Ekim', 31], ['Kasım', 30], ['Aralık', 31]);

function isLeapYear(year) {
    endvalue = false;
    if (!isNaN(year)) {
        if (year % 4 === 0) {
            endvalue = true;
            if (year % 100 === 0) {
                endvalue = false;
                if (year % 400 === 0) {
                    endvalue = true;
                }
            }
        }
    }
    return endvalue;
}

function makeMonthTable(calendarYear, monthIndex) {
    if (isNaN(calendarYear) || (calendarYear.toString().length != 4)) {
        return "bad year number";
    }
    if (isNaN(monthIndex) || (monthIndex < 0) || (monthIndex > 11)) {
        return "bad month number";
    }
    var start_date = new Date(calendarYear, monthIndex, 0);
    var start_weekday = start_date.getDay();
    var endDay = arrMonths[monthIndex][1];
    if ((monthIndex == 1) && (isLeapYear(calendarYear))) {
        endDay = 29
    }
    strMonthTable = "<div class='is_fulltable-item'>\n";
    strMonthTable += "<h5 class='is_fulltable-header'>" + arrMonths[monthIndex][0].toUpperCase() + " " + calendarYear + "</h5> ";
    strMonthTable += "<table class='table'><thead><tr>";
    for (var i = 0; i < 7; i++) {
        strMonthTable += "<th scope='col'><span>" + arrWeekdays[i].toUpperCase() + "</span></th>";
    }
    strMonthTable += "</tr></thead><tbody>\n"
    var day = 1;
    var count = 0;
    while (day <= endDay) {
        strMonthTable += "<tr>";
        for (var i = 0; i < 7; i++) {
            var strId = '';
            var strDayNumber = '';
            var strClass = '';
            if ((count >= start_weekday) && (day <= endDay)) {
                console.log(new Date().getFullYear() + '/' + new Date().getMonth() + '/' + new Date().getDate());
                if (Date.parse(new Date().getFullYear() + '/' + parseInt(new Date().getMonth() + 1) + '/' + new Date().getDate()) > Date.parse(calendarYear + '/' + (parseInt(monthIndex) + 1) + '/' + day)) {
                    strClass = " class='is_fulltable-d'";
                }
                strDayNumber = day;
                var monthnumber = "";
                var daynumber = "";
                if (day < 10) {
                    daynumber = "0" + day;
                } else {
                    daynumber = day;
                }
                if (parseInt(monthIndex + 1) < 10) {
                    monthnumber = "0" + parseInt(monthIndex + 1)
                } else {
                    monthnumber = parseInt(monthIndex + 1)
                }
                strId = " id='" + calendarYear + "-" + monthnumber + "-" + daynumber + "'";
                day++;
            }
            strMonthTable += "<td " + strId + " " + strClass + "><span>" + strDayNumber + "</span></td>";
            count++;
        }
        strMonthTable += "</tr>\n";
    }
    strMonthTable += "</tbody></table></div>\n";
    return strMonthTable;
}

function highlightDay(oDate, CSS_Class) {
    var dDay = oDate.getDate();
    var dMonth = oDate.getMonth();
    var dYear = oDate.getFullYear();
    var strId = dYear + "_" + dMonth + "_" + dDay;
    var dCel = document.getElementById(strId);
    if (dCel) {
        dCel.className = CSS_Class;
    }
}

function makeYearCalendar(calendarYear) {
    strYearCalendar = "";
    for (var i = 0; i < 12; i++) {
        strYearCalendar += makeMonthTable(calendarYear, i);
    }
    return strYearCalendar;
}

function takvimGetir(yil) {
    if ($("#dgiris_tarih").attr("data-page") == "detail") {
        if (takvimvarmi == false || takvimvarmi === false) {
            var today = new Date();
            var currentDay = today.getDate();
            var currentWeekDay = today.getDay();
            var currentMonth = today.getMonth();
            var d = new Date();
            var monthCount = d.getMonth();
            var currentYearFull = d.getFullYear();
            if (yil === "" || isNaN(yil) || yil.toString().length != 4) {
                var currentYear = today.getFullYear();
                var ilkTiklama = true;
            } else {
                var currentYear = yil;
                var ilkTiklama = false;
            }
            var eksiyil = parseInt(currentYear - 1);
            var yeniyil = parseInt(parseInt(currentYear) + 1);
            if (today.getFullYear() - eksiyil > 0) {
                eksiyil = parseInt(today.getFullYear());
            }
            if (yeniyil - today.getFullYear() >= 2) {
                yeniyil = parseInt(parseInt(today.getFullYear()) + 2);
            }
            $("#gecmistarih").attr("onclick", "('" + eksiyil + "')");
            $("#gelecektarih").attr("onclick", "takvimGetir('" + yeniyil + "')");
            var birthday = new Date(currentYear, 3, 2);
            var divCalendar = document.getElementById('calendar');
            divCalendar.innerHTML = '<div style="position: absolute;color:#fff;background: rgba(0,0,0,0.7);font-weight:bold;font-size:1.2em;width: 100%;height: 100%;padding: 10%;z-index: 99;" class="doluluk_loading"><center>Lütfen Bekleyiniz...</center></div>';
            divCalendar.innerHTML += makeYearCalendar(currentYear);
            if (currentYearFull == currentYear) {
                $nextYear = $(makeYearCalendar(currentYear + 1));
                $(divCalendar).append($nextYear);
            }
            highlightDay(today, 'today');
            highlightDay(birthday, 'birthday');
            var villa_id = parseInt($("#data_villa").text());
            var status;
            var tarihler = [];
            var from_$input = $('#mgiris_tarih').pickadate(), from_picker = from_$input.pickadate('picker')
            var to_$input = $('#mcikis_tarih').pickadate(), to_picker = to_$input.pickadate('picker');
            $.ajax({
                type: "GET", url: url + "/villa_status/" + villa_id + "/" + currentYear, success: function (sonc) {
                    $(".doluluk_loading").remove();
                    var data = $.parseJSON(sonc);
                    if (data != "") {
                        data.forEach(function (date) {
                            if (date.status == "2") {
                                if (date.start != true && date.end != true) {
                                    var res = date.tarih.split("-");
                                    var ay = parseInt(parseInt(res[1]) - 1);
                                    tarihler.push([res[0], ay, res[2]]);
                                }
                            }
                            var item = $("#" + date.tarih);
                            if (!item.hasClass("is_fulltable-d")) {
                                if (date.status == "3") {
                                    status = "is_fulltable-o";
                                    var yazilacakstartbeklemede = "is_fulltable-left-o";
                                    var yazilacakendbeklemede = "is_fulltable-right-o";
                                } else if (date.status == "2") {
                                    status = "is_fulltable-f";
                                    var yazilacakstartdolu = "is_fulltable-left-f";
                                    var yazilacakenddolu = "is_fulltable-right-f";
                                }
                                item.addClass(status);
                                if (date.start == true) {
                                    item.addClass("is_fulltable-left");
                                    if (item.hasClass("is_fulltable-right") && item.hasClass("is_fulltable-f")) {
                                        item.addClass(yazilacakenddolu);
                                    }
                                    if (item.hasClass("is_fulltable-right") && item.hasClass("is_fulltable-o")) {
                                        item.addClass(yazilacakendbeklemede);
                                    }
                                }
                                if (date.end == true) {
                                    item.addClass("is_fulltable-right");
                                    if (item.hasClass("is_fulltable-left") && item.hasClass("is_fulltable-f")) {
                                        item.addClass(yazilacakstartdolu);
                                    }
                                    if (item.hasClass("is_fulltable-left") && item.hasClass("is_fulltable-o")) {
                                        item.addClass(yazilacakstartbeklemede);
                                    }
                                }
                            }
                        });
                    }
                    from_picker.set("disable", tarihler);
                    to_picker.set("disable", tarihler);
                }
            });
            if (currentYearFull == currentYear) {
                if (ilkTiklama == true) {
                    $(document).find('#doluluk-takvimi').find('.is_fulltable-item:lt(' + monthCount + ')').remove();
                    $(document).find('#doluluk-takvimi').find('.is_fulltable-item:gt(' + -(12 - monthCount + 1) + ' )').remove();
                }
            }
        }
    }
}

function initSwiper(data_id, mySwiper) {
    $("#" + data_id).find('.swiper-pagination,.swiper-button-next,.swiper-button-prev,.swiper-scrollbar').addClass('active' + data_id);
    mySwiper = new Swiper('.' + data_id, {
        loop: false,
        lazy: true,
        preloadImages: false,
        speed: 400,
        pagination: '.swiper-pagination.active' + data_id,
        nextButton: '.swiper-button-next.active' + data_id,
        prevButton: '.swiper-button-prev.active' + data_id,
        scrollbar: '.swiper-scrollbar.active' + data_id,
        preventClicksPropagation: false
    });
}

function rezervasyonButtonControl(device) {
    var total = parseInt($("#" + device + "total_person").text());
    if (total <= 1) {
        $(".Dropdown").css("border", "1px solid red");
        $("#kisi_uyari").show();
        return false;
    } else {
        $(".Dropdown").css("border", "none");
        $("#kisi_uyari").hide();
         // $("#rezervasyonForm").submit();
         $("#OnRezervasyonM1").modal('show');
    }
}

$(".arttir").click(function () {

    var input = $(this).parent().find('input');
    var degisken = input.val();
    degisken = parseInt(degisken);
    if (degisken < 20) {
        degisken += 1;
    }
    input.val(degisken);
});


$(".eksilt").click(function () {

    var input = $(this).parent().find('input');
    var degisken = input.val();
    degisken = parseInt(degisken);
    if (degisken > 0) {
        degisken -= 1;
    }
    input.val(degisken);
});


function arttir(x, max, device, pos) {

    var allTotal = $('#' + device + '-adult-button').data('max');
    allTotal = parseInt(allTotal);

    var child = $('input[name="child"]').val();
    var adult = $('input[name="adult"]').val();

    var eklenen = parseInt(child) + parseInt(adult);

    max = parseInt(max);


    var total = parseInt($("#" + device + "total_person").text());
    var postotal = parseInt($("#" + device + "total_" + pos).text());

    var sayi = parseInt($(x).prev().val());


    if(pos == "baby") {
        if (sayi < max) {
            sayi++;
            $(x).prev().attr("value", sayi);
            if (pos != "baby") {
                total++;
                $("#" + device + "total_person").text(total);
            }
            postotal++;
            $("#" + device + "total_" + pos).text(postotal);

            if (total <= 1) {
                $(".Dropdown").css("border", "1px solid red");
                $("#kisi_uyari").show();
                return false;
            } else {
                $(".Dropdown").css("border", "none");
                $("#kisi_uyari").hide();
            }
        }
    } else {
        if (eklenen < allTotal) {
            sayi++;
            $(x).prev().attr("value", sayi);
            if (pos != "baby") {
                total++;
                $("#" + device + "total_person").text(total);
            }
            postotal++;
            $("#" + device + "total_" + pos).text(postotal);

            if (total <= 1) {
                $(".Dropdown").css("border", "1px solid red");
                $("#kisi_uyari").show();
                return false;
            } else {
                $(".Dropdown").css("border", "none");
                $("#kisi_uyari").hide();
            }
        }
    }

}

function eksilt(x, min, device, pos) {
    min = parseInt(min);
    var sayi = parseInt($(x).next().val());
    var total = parseInt($("#" + device + "total_person").text());
    var postotal = parseInt($("#" + device + "total_" + pos).text());
    if (sayi > min) {
        sayi--;
        $(x).next().attr("value", sayi);
        if (pos != "baby") {
            total--;
            $("#" + device + "total_person").text(total);
        }
        postotal--
        $("#" + device + "total_" + pos).text(postotal);
        if (total <= 1) {
            $(".Dropdown").css("border", "1px solid red");
            $("#kisi_uyari").show();
            return false;
        } else {
            $(".Dropdown").css("border", "none");
            $("#kisi_uyari").hide();
        }
    }
}

$(document).ready(function () {
    $(".Villa_Search_M-G-buton").click(function () {
        $(".Villa_Search_M-G").slideToggle();
    });
    var mySwiper, sliders = [], reachedEnd = false, slideChanged = false;
    var mySwiper = new Swiper('.swiper-container', {
        observer: true,
        observeParents: true,
        loop: false,
        nested: true,
        lazy: true,
        init: true,
        speed: 400,
        initialSlide: 0,
        touchEventsTarget: '.swiper-container',
        navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev',},
        on: {
            slideChange: function () {
                slideChanged = true;
            }, reachEnd: function () {
            }, touchEnd: function () {
                if (this.realIndex + 2 >= this.slides.length) {
                }
            }, slideChange: function () {
                reachedEnd = true;
            }, imagesReady: function () {
                reachedEnd = false;
            }, touchStart: function () {
            }, fromEdge: function () {
            }
        }
    });
    $("ul.nav-tabs a").click(function (e) {
        e.preventDefault();
        reachedEnd = false;
        $tabPane = $($(this).attr('href'));
        setTimeout(function () {
            try {
                $($tabPane.find('.kat-secenek').first().find('a').attr('href')).find('.swiper-container')[0].swiper.update();
            } catch (err) {
            }
        }, 200);
        $(this).tab('show');
    });
    $('.kat-secenek').on('shown.bs.tab', function (e) {
        var paneTarget = $(e.target).attr('href');
        var $thePane = $('.tab-pane' + paneTarget);
        var paneIndex = $thePane.index();
        $thePane.find('.swiper-container')[0].swiper.update()
        if ($thePane.find('.swiper-container').length > 0 && 0 === $thePane.find('.swiper-slide-active').length) {
        }
    });
    $('.swiper-container-floor-x').each(function () {
        $(this).on({
            mouseenter: function (e) {
                var data_id = $(this).attr("data-id");
                initSwiper(data_id, mySwiper);
            }
        });
    });
    var swiper2, swiper3, swiper4, swiper5, swiper8;
    var w = $(window).width(), h = $(window).height();
    $('.selectpicke').selectpicker();
    if (w < 769) {
    } else {
        $('.selectpicke').selectpicker();
    }
    $(window).resize(function () {
        var w = $(window).width(), h = $(window).height();
    });
    var $videoSrc, $videoSrc2;
    $('.video-btn').click(function () {
        $videoSrc = $(this).data("src");
    });
    $('.video-btn2').click(function () {
        $videoSrc = $(this).data("src");
    });
    $('#myModal').on('shown.bs.modal', function (e) {
        $("#video").attr('src', $videoSrc + "?rel=0&showinfo=0&modestbranding=1&autoplay=1");
    })
    $('#myModal').on('hide.bs.modal', function (e) {
        $("#video").attr('src', $videoSrc);
    })
    $('#myModalSSS').on('shown.bs.modal', function (e) {
        $("#videoSSS").attr('src', $videoSrc + "?rel=0&showinfo=0&modestbranding=1&autoplay=1");
    })
    $('#myModalSSS').on('hide.bs.modal', function (e) {
        $("#videoSSS").attr('src', $videoSrc);
    })
    $("#villaListele").css("display", "none");
    var url = $('meta[name="base_url"]').attr('content');
    var page = $('meta[name="page"]').attr('content');
    $('#searchinput').on('propertychange  input paste', function (e) {
        e.stopImmediatePropagation();
        var textString = $(this).val();
        var listelenecek = $("#villaListele");
        listelenecek.html("");
        if (textString != "" && textString.length > 2) {
            listelenecek.css("display", "block");
            $.ajax({
                type: "GET", url: url + "/realtime_search/" + textString, success: function (sonc) {
                    listelenecek.html(sonc.view);
                    listelenecek.addClass("Navtop-livesearch");
                    $("#villaListele").parent().fadeIn();
                }
            });
        } else {
            listelenecek.css("display", "none");
        }
    });
    $('#searchinput').on('keydown', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            var liste = $("#villaListele a");
            if (liste.children().length === 1) {
                liste.children(0).addClass("Navtop-livesearch-focus").click();
            }
        }
    });
    var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
    if ($(document).scrollTop() > 530) {
        $(".Rezervasyon").addClass('Rezervasyon-fixed');
        $(".Rezervasyon-slogan").slideUp();
        if (scrollBottom < 500) {
            $(".Rezervasyon").removeClass('Rezervasyon-fixed');
        }
    } else {
        $(".Rezervasyon").removeClass('Rezervasyon-fixed');
        $(".Rezervasyon-slogan").slideDown();
    }
    $(window).scroll(function () {
        if (w > 991) {
            if ($(document).scrollTop() > 150) {
                $(".Rez-right").addClass('Rez-right-fix');
            } else {
                $(".Rez-right").removeClass('Rez-right-fix');
            }
        }
    });
    if (w > 991) {
        if ($(document).scrollTop() > 250) {
            $(".Villa_detay-menu").slideDown();
            $(".Villa_detay-menu").addClass('Villa_detay-menu-active');
            $(".Navtop-detay").slideUp(10);
        } else {
            $(".Navtop-detay").removeClass('Navtop-search-active');
            $(".Villa_detay-menu").slideUp();
            $(".Navtop-detay").slideDown(10);
        }
    }
    if (w < 992) {
        swiper2 = new Swiper('.swiper-container-belgeler', {
            loop: false,
            slidesPerView: 2.3,
            speed: 1000,
            spaceBetween: 10,
            keyboard: {enabled: true},
            clickable: true,
            grabCursor: true,
            navigation: false
        });
        swiper2 = new Swiper('.swiper-container-teklif', {
            loop: false,
            slidesPerView: 1,
            speed: 1000,
            draggable: false,
            onlyExternal: true,
            allowTouchMove: false,
            simulateTouch: false,
            spaceBetween: 10,
            navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev'}
        });
    }
    swiper2 = new Swiper('.swiper-container-belgeler', {
        loop: false,
        on: {
            click: function () {
                this.slideToClickedSlide()
            }
        },
        slidesPerView: 4,
        speed: 1000,
        spaceBetween: 50,
        autoHeight: true,
        autoWidth: true,
        keyboard: {enabled: true},
        clickable: true,
        grabCursor: true,
        navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev'}
    });
    swiper3 = new Swiper('.swiper-container-pv', {
        loop: false,
        spaceBetween: 15,
        slidesPerView: 1.04,
        keyboard: {enabled: true},
        clickable: true,
        grabCursor: true,
        pagination: {el: '.swiper-pagination',},
    });
    swiper4 = new Swiper('.swiper-container-fv', {
        loop: false,
        spaceBetween: 20,
        slidesPerView: 1.04,
        keyboard: {enabled: true},
        clickable: true,
        grabCursor: true,
        pagination: {el: '.swiper-pagination'}
    });
    swiper5 = new Swiper('.swiper-container-kv', {
        loop: false,
        spaceBetween: 15,
        slidesPerView: 2.1,
        keyboard: {enabled: true},
        clickable: true,
        grabCursor: true,
        pagination: {el: '.swiper-pagination',},
    });
    $('.Villa_detay-menu a  , .Villa_detayM-rez_fix, .Rez-right .Rez-left-gonder, .scrollTop').click(function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('div').removeClass("focus");
            $(".nav-menuX").removeClass('active');
            $(hash).addClass("focus");
            $(this).addClass('active');
            setTimeout(function () {
                $(hash).removeClass("focus");
            }, 2000);
            $('html').animate({scrollTop: $(hash).offset().top - 100}, 1000);
            $(".navbar-collapse").collapse('hide');
        }
    });
    $(window).scroll(function () {
        if ($(document).scrollTop() > 540) {
            $(".Villa_detayM-rez_fix").addClass('flex');
            $(".Villa_detayM-whatsapp").addClass('Villa_detayM-whatsapp-active');
        } else {
            $(".Villa_detayM-rez_fix").removeClass('flex');
            $(".Villa_detayM-whatsapp").removeClass('Villa_detayM-whatsapp-active');
        }
        if ($(document).scrollTop() > 50) {
            $(".Navtop").addClass('Navtop-back');
        } else {
            $(".Navtop").removeClass('Navtop-back');
        }
        if (w > 991) {
            if ($(document).scrollTop() > 400) {
                $(".Villa_Search").addClass('Villa_Search-fixed');
                $(".Navtop-search").addClass('Navtop-search-active');
                if ($('#dgiris_tarih').val() != "" || $('#dcikis_tarih').val() != "") {
                    $(".desktop_takvim_label").css("visibility", "hidden");
                }
            } else {
                $(".desktop_takvim_label").css("visibility", "visible");
                $(".Villa_Search").removeClass('Villa_Search-fixed');
                $(".Navtop-search").removeClass('Navtop-search-active')
            }
        }
        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
        if ($(document).scrollTop() > 530) {
            $(".Rezervasyon").addClass('Rezervasyon-fixed');
            $(".Rezervasyon-slogan").slideUp();
            if (scrollBottom < 500) {
                $(".Rezervasyon").removeClass('Rezervasyon-fixed');
            }
        } else {
            $(".Rezervasyon").removeClass('Rezervasyon-fixed');
            $(".Rezervasyon-slogan").slideDown();
        }
        var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
        if (scrollBottom < 580) {
            $(".Favoriler-right").addClass('Favoriler-right-absu');
        } else {
            $(".Favoriler-right").removeClass('Favoriler-right-absu');
        }
        if (w > 991) {
            if ($(document).scrollTop() > 500) {
                $(".Villa_detay-menu").slideDown();
                $(".Villa_detay-menu").addClass('Villa_detay-menu-active');
                $(".Navtop-detay").slideUp();
            } else {
                $(".Navtop-detay").slideDown();
                $(".Villa_detay-menu").slideUp();
                $(".Villa_detay-menu").removeClass('Villa_detay-menu-active');
            }
        }
        if ($(document).scrollTop() > 500) {
            $(".Rez-right .Rez-left-gonder ").slideUp();
        } else {
            $(".Rez-right .Rez-left-gonder ").slideDown();
        }
    });
    $('#slick').slick({autoplay: true, autoplaySpeed: 6000, speed: 1500, fade: true, arrows: true});
    $('svg').tooltip();
    $(".btn-menu ").click(function () {
        $(".overlay").fadeToggle(200);
        $(this).toggleClass('btn-menu-open').toggleClass('btn-menu-close');
        $(".vsecenek ").removeClass('vsecenek-active');
        $(".overlay ").removeClass('overlay-pasif');
        $(".vsecenek-geri").removeClass('Close');
        $(".Navtop ").toggleClass('laci');
        $("body ").toggleClass('ov');
        $("#main").toggleClass('ov');
        $(".Villa_detayM-whatsapp").fadeToggle(200);
        setTimeout(function () {
        }, 400);
    });
    $(".Search-icon ").click(function () {
        $(".Search-menu").slideToggle(200);
        $(this).toggleClass('Search-icon-open');
        $(".btn-menu ").toggleClass('Close');
    });
    $(".G_search-buton ").click(function () {
        $(".G_search-menu").slideDown();
        $(".G_search-buton").slideUp();
    });
    $(".G_search-menu-buton").click(function () {
        $(".G_search-menu").slideUp();
        $(".G_search-buton").slideDown();
    });
    $(".Search-button a").click(function () {
        $(".Search-overlay").fadeToggle(200);
        $(this).toggleClass('Search-open').toggleClass('Search-close');
    });
    $("#secenek").click(function () {
        $(".vsecenek ").toggleClass('vsecenek-active');
        $(".overlay ").toggleClass('overlay-pasif');
        $(".vsecenek-geri").removeClass('Close');
    });
    $(".vsecenek-geri").click(function () {
        $(".vsecenek ").removeClass('vsecenek-active');
        $(".overlay ").removeClass('overlay-pasif');
        $(this).addClass('Close');
    });
    $('.nav-item div.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).slideDown(400);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).slideUp(400);
    });
    $(".Teklif-item-property-in input").click(function () {
        if ($(this).is(":checked")) {
            $(this).parent().parent().addClass("Teklif-item-property-active");
        } else {
            $(this).parent().parent().removeClass("Teklif-item-property-active");
        }
    });
    $(".step").click(function () {
        if ($(this).attr("data-tur") == "aile") {
            $(".balayi").css("display", "none");
            $(".aile").css("display", "block");
        } else {
            $(".aile").css("display", "none");
            $(".balayi").css("display", "block");
        }
        if ($(this).attr('data-climate') != "undefined" && $(this).attr('data-climate') != null && $(this).attr('data-climate') !== null && $(this).attr('data-climate') != "") {
            $(".climate").css("display", "none");
            switch ($(this).attr('data-climate')) {
                case"spring":
                    $(".spring").css("display", "flex");
                    break;
                case"summer":
                    $(".summer").css("display", "flex");
                    break;
                case"winter":
                    $(".winter").css("display", "flex");
                    break;
                case"autumn":
                    $(".autumn").css("display", "flex");
                    break;
            }
        }
        if ($(this).attr('data-date') != "undefined" && $(this).attr('data-date') != null && $(this).attr('data-date') !== null && $(this).attr('data-date') != "") {
            if ($(this).attr("data-date") == "tarih_var") {
                $(this).parent().parent().parent().removeClass("part-active").addClass("part-passive");
                $(".part3").prependTo("form");
                $(".part3").addClass('part-passive').removeClass("part-active");
                $(".part4").prependTo("form");
                $(".part4").addClass('part-passive').removeClass("part-active");
                $(".part5").before($(".part2"));
                $(".part2").addClass("part-active").removeClass("part-middle_active").removeClass('part-passive');
            } else {
                $(this).parent().parent().parent().removeClass("part-active").addClass("part-passive");
                $(".part2").prependTo('form');
                $(".part2").addClass('part-passive').removeClass("part-active");
                $(".part5").before($(".part3"));
                $(".part3").after($(".part4"));
                $(".part3").removeClass("part-middle_active").removeClass('part-passive').addClass("part-active");
                $(".part4").removeClass('part-passive').addClass("part-middle_active");
            }
        } else {
            $(this).parent().parent().parent().removeClass("part-active").addClass("part-passive");
            $(this).parent().parent().parent().next().addClass("part-active").removeClass("part-middle_active");
            $(this).parent().parent().parent().next().next().addClass("part-middle_active").removeClass("part-passive");
        }
    });
    $(".step-back").click(function () {
        $(this).parent().parent().parent().removeClass("part-active").addClass("part-middle_active");
        $(this).parent().parent().parent().prev().addClass("part-active").removeClass("part-passive");
    });
    var separator = ' - ', dateFormat = 'YYYY/MM/DD';
    var options = {
        autoUpdateInput: false,
        autoApply: true,
        locale: {format: dateFormat, separator: separator, applyLabel: 'tamam', cancelLabel: 'iptal'},
        minDate: moment().add(1, 'days'),
        maxDate: moment().add(359, 'days'),
        opens: "right"
    };
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#UpTotop').fadeIn();
        } else {
            $('#UpTotop').fadeOut();
        }
    });
    $('#UpTotop').click(function () {
        $('body,html').animate({scrollTop: 0}, 800)
    });
    var $elem = $('body');
    'use strict';
    (function ($) {
        var container = [];
        $('#gallery').find('figure').each(function () {
            var $link = $(this).find('a'), item = {
                src: $link.attr('href'),
                w: $link.data('width'),
                h: $link.data('height'),
                title: $link.data('caption')
            };
            container.push(item);
        });
        $('#gallery a, .galleryxyz').click(function (event) {
            event.preventDefault();
            var $pswp = $('.pswp')[0],
                options = {index: $(this).parent('figure').index(), bgOpacity: 0.85, showHideOpacity: true};
            var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
            gallery.init();
        });
    }(jQuery));
    (function ($) {
        var container = [];
        $('#gallerybelgeler').find('figure').each(function () {
            var $link = $(this).find('a'), item = {
                src: $link.attr('href'),
                w: $link.data('width'),
                h: $link.data('height'),
                title: $link.data('caption')
            };
            container.push(item);
        });
        $('#gallerybelgeler a').click(function (event) {
            event.preventDefault();
            var $pswp = $('.pswp')[0],
                options = {index: $(this).parent('figure').data('index'), bgOpacity: 0.85, showHideOpacity: true};
            var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
            gallery.init();
        });
    }(jQuery));
    var str = $("#yazi").text();
    var res = str.substr(0, 50);
    searchCheck();
    var $checkboxes = $('input[type="checkbox"]');
    $checkboxes.change(function () {
        searchCheck();
    });
});

function searchControl() {
    var $checkboxes = $('.category_check:input[type="checkbox"]');
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
    if (countCheckedCheckboxes < 1) {
        $(".Dropdown").css("border", "1px solid red");
        return false;
    } else {
        $(".Dropdown").css("border", "none");
        $("#searchForm").submit();
    }
}

function searchCheck() {
    var $checkboxes = $('.category_check:input[type="checkbox"]');
    var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
    if (countCheckedCheckboxes > 0) {
        $(".Dropdown").css("border", "none");
        $(".turaciklama").text("Tür Seçildi");
        $(".tursay").css("display", "");
        $(".tursay").text(countCheckedCheckboxes);
    } else {
        $(".tursay").css("display", "none");
        $(".turaciklama").text("Villa türü seçiniz");
    }
    return false;
}

function yazi(x, islem) {
    var str2 = $("#yazi").text();
    var res2 = str2.substr(0, 50);
    var buton = null;
    var yaziX = null;
    var icon = null;
    if (islem == "gizle") {
        buton = "Devamını göster";
        yaziX = res2;
        $(x).attr("onclick", "yazi(this,'goster')");
    } else {
        buton = "Devamını Gizle";
        yaziX = str2;
        $(x).attr("onclick", "yazi(this,'gizle')");
    }
    $(x).html(buton);
    $("#yazigoster").text(yaziX);
}

function searchClose() {
    $("#searchinput").val("");
    $("#villaListele").css("display", "none").html("");
}

var slideKonum = 0;

function teklifIleri() {
    switch (slideKonum) {
        case 0:
            var net_date = document.querySelector('input[name="net_date"]:checked').value;
            if (net_date == "true") {
                $(".mpart5").before($(".mpart2")).css("display", "block");
            } else if (net_date == "false") {
                $(".mpart5").before($(".mpart3")).css("display", "block");
                $(".mpart3").after($(".mpart4")).css("display", "block");
            } else {
                $(".swiper-button-next").attr("disabled", "disabled");
            }
            break;
    }
    slideKonum++;
}

function teklifGeri() {
    slideKonum--;
}

$(document).on("click", "#searchfocus", function (e) {
    e.preventDefault();
    $("#searchinput").click();
    $("#searchinput").focus();
    return false;
})
