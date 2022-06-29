var takvimvarmi = false;
function getTodayString() {
    var strNow = "It is now: " + new Date().toLocaleDateString() + ", ";
    strNow += new Date().toLocaleTimeString();
    return strNow;
}
var arrWeekdays = new Array("PZT", "SAL", "ÇAR", "PER", "CUM", "CMT", "PAZ");
var arrMonths = new Array(["Ocak", 31], ["Şubat", 28], ["Mart", 31], ["Nisan", 30], ["Mayıs", 31], ["Haziran", 30], ["Temmuz", 31], ["Ağustos", 31], ["Eylül", 30], ["Ekim", 31], ["Kasım", 30], ["Aralık", 31]);
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
    if (isNaN(calendarYear) || calendarYear.toString().length != 4) {
        return "bad year number";
    }
    if (isNaN(monthIndex) || monthIndex < 0 || monthIndex > 11) {
        return "bad month number";
    }
    var start_date = new Date(calendarYear, monthIndex, 0);
    var start_weekday = start_date.getDay();
    var endDay = arrMonths[monthIndex][1];
    if (monthIndex == 1 && isLeapYear(calendarYear)) {
        endDay = 29;
    }
    strMonthTable = "<div class='is_fulltable-item'>\n";
    strMonthTable += "<h5 class='is_fulltable-header'>" + arrMonths[monthIndex][0].toUpperCase() + " " + calendarYear + "</h5> ";
    strMonthTable += "<table class='table'><thead><tr>";
    for (var i = 0; i < 7; i++) {
        strMonthTable += "<th scope='col'><span>" + arrWeekdays[i].toUpperCase() + "</span></th>";
    }
    strMonthTable += "</tr></thead><tbody>\n";
    var day = 1;
    var count = 0;
    while (day <= endDay) {
        strMonthTable += "<tr>";
        for (var i = 0; i < 7; i++) {
            var strId = "";
            var strDayNumber = "";
            var strClass = "";
            if (count >= start_weekday && day <= endDay) {
                console.log(new Date().getFullYear() + "/" + new Date().getMonth() + "/" + new Date().getDate());
                if (Date.parse(new Date().getFullYear() + "/" + parseInt(new Date().getMonth() + 1) + "/" + new Date().getDate()) > Date.parse(calendarYear + "/" + (parseInt(monthIndex) + 1) + "/" + day)) {
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
                    monthnumber = "0" + parseInt(monthIndex + 1);
                } else {
                    monthnumber = parseInt(monthIndex + 1);
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
            var divCalendar = document.getElementById("calendar");
            divCalendar.innerHTML =
                '<div style="position: absolute;color:#fff;background: rgba(0,0,0,0.7);font-weight:bold;font-size:1.2em;width: 100%;height: 100%;padding: 10%;z-index: 99;" class="doluluk_loading"><center>Lütfen Bekleyiniz...</center></div>';
            divCalendar.innerHTML += makeYearCalendar(currentYear);
            if (currentYearFull == currentYear) {
                $nextYear = $(makeYearCalendar(currentYear + 1));
                $(divCalendar).append($nextYear);
            }
            highlightDay(today, "today");
            highlightDay(birthday, "birthday");
            var villa_id = parseInt($("#data_villa").text());
            var status;
            var tarihler = [];
            var from_$input = $("#mgiris_tarih").pickadate(),
                from_picker = from_$input.pickadate("picker");
            var to_$input = $("#mcikis_tarih").pickadate(),
                to_picker = to_$input.pickadate("picker");
            $.ajax({
                type: "GET",
                url: url + "/villa_status/" + villa_id + "/" + currentYear,
                success: function (sonc) {
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
                },
            });
            if (currentYearFull == currentYear) {
                if (ilkTiklama == true) {
                    $(document)
                        .find("#doluluk-takvimi")
                        .find(".is_fulltable-item:lt(" + monthCount + ")")
                        .remove();
                    $(document)
                        .find("#doluluk-takvimi")
                        .find(".is_fulltable-item:gt(" + -(12 - monthCount + 1) + " )")
                        .remove();
                }
            }
        }
    }
}

function initSwiper(e, t) {
    $("#" + e)
        .find(".swiper-pagination,.swiper-button-next,.swiper-button-prev,.swiper-scrollbar")
        .addClass("active" + e), new Swiper("." + e, {
        loop: !1,
        lazy: !0,
        preloadImages: !1,
        speed: 400,
        pagination: ".swiper-pagination.active" + e,
        nextButton: ".swiper-button-next.active" + e,
        prevButton: ".swiper-button-prev.active" + e,
        scrollbar: ".swiper-scrollbar.active" + e,
        preventClicksPropagation: !1,
    });
}

function rezervasyonButtonControl(e) {
    if (parseInt($("#" + e + "total_person").text()) <= 1) return $(".Dropdown").css("border", "1px solid red"), $("#kisi_uyari").show(), !1;
    $(".Dropdown").css("border", "none"), $("#kisi_uyari").hide(), $("#OnRezervasyonM1").modal("show");
}

function arttir(e, t, i, n) {
    var s = $("#" + i + "-adult-button").data("max"),
        s = parseInt(s),
        a = $('input[name="child"]').val(),
        o = $('input[name="adult"]').val(),
        r = parseInt(a) + parseInt(o);
    t = parseInt(t);
    var l = parseInt($("#" + i + "total_person").text()),
        a = parseInt($("#" + i + "total_" + n).text()),
        o = parseInt($(e).prev().val());
    if ("baby" == n) {
        if (o < t) {
            if ((o++, $(e).prev().attr("value", o), "baby" != n && (l++, $("#" + i + "total_person").text(l)), a++, $("#" + i + "total_" + n).text(a), l <= 1)) return $(".Dropdown").css("border", "1px solid red"), $("#kisi_uyari").show(), !1;
            $(".Dropdown").css("border", "none"), $("#kisi_uyari").hide();
        }
    } else if (r < s) {
        if ((o++, $(e).prev().attr("value", o), "baby" != n && (l++, $("#" + i + "total_person").text(l)), a++, $("#" + i + "total_" + n).text(a), l <= 1)) return $(".Dropdown").css("border", "1px solid red"), $("#kisi_uyari").show(), !1;
        $(".Dropdown").css("border", "none"), $("#kisi_uyari").hide();
    }
}

function eksilt(e, t, i, n) {
    t = parseInt(t);
    var s = parseInt($(e).next().val()),
        a = parseInt($("#" + i + "total_person").text()),
        o = parseInt($("#" + i + "total_" + n).text());
    if (t < s) {
        if ((s--, $(e).next().attr("value", s), "baby" != n && (a--, $("#" + i + "total_person").text(a)), o--, $("#" + i + "total_" + n).text(o), a <= 1)) return $(".Dropdown").css("border", "1px solid red"), $("#kisi_uyari").show(), !1;
        $(".Dropdown").css("border", "none"), $("#kisi_uyari").hide();
    }
}

function searchControl() {
    if ($('.category_check:input[type="checkbox"]').filter(":checked").length < 1) return $(".Dropdown").css("border", "1px solid red"), !1;
    $(".Dropdown").css("border", "none"), $("#searchForm").submit();
}

function searchCheck() {
    var e = $('.category_check:input[type="checkbox"]').filter(":checked").length;
    return (0 < e ? ($(".Dropdown").css("border", "none"), $(".turaciklama").text("Tür Seçildi"), $(".tursay").css("display", ""), $(".tursay").text(e)) : ($(".tursay").css("display", "none"), $(".turaciklama").text("Villa türü seçiniz")), !1);
}

function yazi(e, t) {
    var i = $("#yazi").text(),
        n = i.substr(0, 50),
        s = null,
        a = null;
    "gizle" == t ? ((s = "Devamını göster"), (a = n), $(e).attr("onclick", "yazi(this,'goster')")) : ((s = "Devamını Gizle"), (a = i), $(e).attr("onclick", "yazi(this,'gizle')")), $(e).html(s), $("#yazigoster").text(a);
}

function searchClose() {
    $("#searchinput").val(""), $("#villaListele").css("display", "none").html("");
}

$(".arttir").click(function () {
    var e = $(this).parent().find("input"),
        t = e.val();
    (t = parseInt(t)) < 20 && (t += 1), e.val(t);
}),

    $(".eksilt").click(function () {
        var e = $(this).parent().find("input"),
            t = e.val();
        0 < (t = parseInt(t)) && --t, e.val(t);
    }),

    $(document).ready(function () {

        $(".Villa_Search_M-G-buton").click(function () {
            $(".Villa_Search_M-G").slideToggle();
        });

        var t = new Swiper(".swiper-container-floor", {
            observer: !0,
            observeParents: !0,
            loop: !1,
            nested: !0,
            lazy: !0,
            init: !0,
            preloadImages: !1,
            speed: 400,
            initialSlide: 0,
            updateOnWindowResize: !0,
            touchEventsTarget: ".swiper-container-floor",
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            on: {
                activeIndexChange: function () {
                },
                orientationchange: function () {
                    this.navigation.update();
                },
                slideChange: function () {
                    0;
                },
                reachEnd: function () {
                },
                touchEnd: function () {
                    this.realIndex, this.slides.length;
                    var e,
                        t = $(document).find(".Villa_detay-floor-head").find(".selected-zemin").find("a").attr("href"),
                        i = $(document).find(t).find(".selected-kat").find("a").attr("href");
                    $(document).find(t).find(i).find(".swiper-button-next").hasClass("swiper-button-disabled") && (($next = $(document)
                        .find('a[href="' + i + '"]')
                        .closest(".kat-secenek")
                        .next(".kat-secenek")),
                        0 == $next.length ? (($next_zemin = $(document).find(".selected-zemin").next(".nav-item")),

                            0 == $next_zemin.length ? ($(document).find(".Villa_detay-floor-head").find(".nav-item").removeClass("selected-zemin"),
                                $(document).find(".Villa_detay-floor-head").find(".nav-item:first-child").find("a").trigger("click"),
                                $(document).find(".Villa_detay-floor-head").find(".nav-item:first-child").addClass("selected-zemin"),
                                (e = $(document).find(".Villa_detay-floor-head").find(".nav-item:first-child").find("a").attr("href")),
                                $(document).find(e).find(".kat-secenek").removeClass("selected-kat"),
                                $(document).find(e).find(".kat-secenek:first-child").addClass("selected-kat"),
                                $(document).find(e).find(".kat-secenek:first-child").find("a").trigger("click")) : ($(document).find(".Villa_detay-floor-head").find(".nav-item").removeClass("selected-zemin"),
                                $next_zemin.addClass("selected-zemin"), (e = $next_zemin.find("a").attr("href")),
                                $(document).find(e).find(".kat-secenek").removeClass("selected-kat"),
                                $(document).find(e).find(".kat-secenek:first").addClass("selected-kat"),
                                $next_zemin.find("a").trigger("click"))) : ($next.find("a").trigger("click"),
                            $(document).find(".selected-kat").removeClass("kat-secenek"), $next.addClass("kat-secenek")));
                },
                imagesReady: function () {
                    0;
                },
                touchStart: function () {
                },
                fromEdge: function () {
                },
            },
        });

        $("ul.nav-tabs a").click(function (e) {
            e.preventDefault(), ($tabPane = $($(this).attr("href"))), setTimeout(function () {
                try {
                    $($tabPane.find(".kat-secenek").first().find("a").attr("href")).find(".swiper-container")[0].swiper.update();
                } catch (e) {
                }
            }, 200), $(this).tab("show");
        }),

        $(".kat-secenek").on("shown.bs.tab", function (e) {
            (e = $(e.target).attr("href")), (e = $(".tab-pane" + e)), e.index();
            e.find(".swiper-container")[0].swiper.update(), 0 < e.find(".swiper-container").length && e.find(".swiper-slide-active").length;
        }),
        $(document).find(".kat-secenek:first-child").addClass("selected-kat"),
        $(document).find(".Villa_detay-floor-head").find(".nav-item:first-child").addClass("selected-zemin"),
        $(document).on("click", ".kat-secenek", function () {
            $(document).find(".kat-secenek").removeClass("selected-kat"), $(this).addClass("selected-kat");
        }),
        $(document).on("click", ".Villa_detay-floor-head .nav-item", function () {
            $(document).find(".Villa_detay-floor-head").find(".nav-item").removeClass("selected-zemin"), $(this).addClass("selected-zemin");
        }),
        $(".swiper-container-floor-x").each(function () {
            $(this).on({
                mouseenter: function (e) {
                    initSwiper($(this).attr("data-id"), t);
                },
            });
        }),
        $(".swiper-button-next").on("click", function () {
        });


        var i, n = $(window).width();
        $(window).height();

        var w = $(window).width(), h = $(window).height();
         $('.selectpicke').selectpicker();
    if (w < 769) {
    } else {
        $('.selectpicke').selectpicker();
    }

        $(window).resize(function () {
            $(window).width(), $(window).height();
        }),
        

            $(".video-btn").click(function () {
                i = $(this).data("src");
            }),
            $(".video-btn2").click(function () {
                i = $(this).data("src");
            }),
            $("#myModal").on("shown.bs.modal", function (e) {
                $("#video").attr("src", i + "?rel=0&showinfo=0&modestbranding=1&autoplay=1");
            }),
            $("#myModal").on("hide.bs.modal", function (e) {
                $("#video").attr("src", i);
            }),
            $("#myModalSSS").on("shown.bs.modal", function (e) {
                $("#videoSSS").attr("src", i + "?rel=0&showinfo=0&modestbranding=1&autoplay=1");
            }),
            $("#myModalSSS").on("hide.bs.modal", function (e) {
                $("#videoSSS").attr("src", i);
            }),

            $("#villaListele").css("display", "none");

        var s = $('meta[name="base_url"]').attr("content"),
            a = ($('meta[name="page"]').attr("content"), 0);

        $("#searchinput").on("propertychange  input paste", function (e) {
            clearTimeout(a);
            let t = $(this);
            var i = t.val(),
                n = $("#villaListele");
            n.html(""), "" != i && 2 < i.length ? ($(document).find(".icon.icon-search.blinking_icon").length || $(document).find(".icon.icon-search").addClass("blinking_icon"), (a = setTimeout(function () {
                "" != i && 2 < i.length && (n.css("display", "block"), $.ajax({
                    type: "GET",
                    url: s + "/realtime_search/" + i,
                    success: function (e) {
                        n.html(e.view), n.addClass("Navtop-livesearch"), $("#villaListele").parent().fadeIn();
                    },
                }).always(function () {
                    $(document).find(".icon.icon-search").removeClass("blinking_icon");
                }));
            }, 250))) : n.css("display", "none");
        }),

            $("#searchinput").on("keydown", function (e) {
                13 == e.which && (e.preventDefault(), 1 === (e = $("#villaListele a")).children().length && e.children(0).addClass("Navtop-livesearch-focus").click());
            });


        var e = $(document).height() - $(window).height() - $(window).scrollTop();


        230 < $(document).scrollTop() ? ($(".Rezervasyon").addClass("Rezervasyon-fixed"),
            $(".Rezervasyon-slogan").slideUp(),
        e < 500 && $(".Rezervasyon").removeClass("Rezervasyon-fixed")) : ($(".Rezervasyon").removeClass("Rezervasyon-fixed"),
            $(".Rezervasyon-slogan").slideDown()),

            $(window).scroll(function () {
            991 < n && (150 < $(document).scrollTop() ? $(".Rez-right").addClass("Rez-right-fix") : $(".Rez-right").removeClass("Rez-right-fix"));
            }),

        991 < n && (50 < $(document).scrollTop() ? (
            $(".Villa_detay-menu").addClass("Villa_detay-menu-active"),

            $(".Navtop-detay").slideUp(10)) : ($(".Navtop-detay").removeClass("Navtop-search-active"),

            $(".Navtop-detay").slideDown(10))),

            n < 992 && (new Swiper(".swiper-container-belgeler", {
            loop: !1,
            slidesPerView: 2.3,
            speed: 1e3,
            spaceBetween: 10,
            keyboard: {
                enabled: !0
            },
            clickable: !0,
            grabCursor: !0,
            navigation: !1
        }),

            new Swiper(".swiper-container-teklif", {
                loop: !1,
                slidesPerView: 1,
                speed: 1e3,
                draggable: !1,
                onlyExternal: !0,
                allowTouchMove: !1,
                simulateTouch: !1,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
            })),
            new Swiper(".swiper-container-belgeler", {
                loop: !1,
                on: {
                    click: function () {
                        this.slideToClickedSlide();
                    },
                },
                slidesPerView: 4,
                speed: 1e3,
                spaceBetween: 50,
                autoHeight: !0,
                autoWidth: !0,
                keyboard: {
                    enabled: !0
                },
                clickable: !0,
                grabCursor: !0,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
            }),
            new Swiper(".swiper-container-pv", {
                loop: !1,
                spaceBetween: 15,
                slidesPerView: 1.04,
                keyboard: {
                    enabled: !0
                },
                clickable: !0,
                grabCursor: !0,
                pagination: {
                    el: ".swiper-pagination"
                }
            }),
            new Swiper(".swiper-container-fv", {
                loop: !1,
                spaceBetween: 20,
                slidesPerView: 1.04,
                keyboard: {
                    enabled: !0
                },
                clickable: !0,
                grabCursor: !0,
                pagination: {
                    el: ".swiper-pagination"
                }
            }),
            new Swiper(".swiper-container-kv", {
                loop: !1,
                spaceBetween: 15,
                slidesPerView: 2.1,
                keyboard: {
                    enabled: !0
                },
                clickable: !0,
                grabCursor: !0,
                pagination: {
                    el: ".swiper-pagination"
                }
            }),

            $(".Villa_detay-menu a , .Villa_detayM-rez_fix, .Rez-right .Rez-left-gonder, .scrollTop").click(function (e) {
                var t;
                "" !== this.hash && (e.preventDefault(), (t = this.hash),
                    $("div").removeClass("focus"),
                    $(".nav-menuX").removeClass("active"),
                    $(t).addClass("focus"),
                    $(this).addClass("active"),
                    setTimeout(function () {
                        $(t).removeClass("focus");
                    }, 2e3),
                    $("html").animate({
                        scrollTop: $(t).offset().top - 100
                    }, 1e3),
                    $(".navbar-collapse").collapse("hide"));
            }),

            $(window).scroll(function () {
                540 < $(document).scrollTop() ? ($(".Villa_detayM-rez_fix").addClass("flex"),
                    $(".Villa_detayM-whatsapp").addClass("Villa_detayM-whatsapp-active")) : ($(".Villa_detayM-rez_fix").removeClass("flex"),
                    $(".Villa_detayM-whatsapp").removeClass("Villa_detayM-whatsapp-active")),

                    50 < $(document).scrollTop() ? ($(".Navtop").addClass("Navtop-back"),$(".Villa_Search").addClass("Villa_Search-z")) : ($(".Navtop").removeClass("Navtop-back"),$(".Navtop").removeClass("Villa_Search-z"));

                var e = $(document).height() - $(window).height() - $(window).scrollTop();

                230 < $(document).scrollTop() ? ($(".Rezervasyon").addClass("Rezervasyon-fixed"),
                    $(".Rezervasyon-slogan").slideUp(),
                e < 750 && $(".Rezervasyon").removeClass("Rezervasyon-fixed")) : ($(".Rezervasyon").removeClass("Rezervasyon-fixed"),
                    $(".Rezervasyon-slogan").slideDown()),
                    (e = $(document).height() - $(window).height() - $(window).scrollTop()) < 580 ? $(".Favoriler-right").addClass("Favoriler-right-absu") : $(".Favoriler-right").removeClass("Favoriler-right-absu"),

                991 < n && (230 < $(document).scrollTop() ? ($(".Villa_detay-menu").slideDown(),
                    $(".Villa_detay-menu").addClass("Villa_detay-menu-active"),
                    $(".Navtop-detay").slideUp()) : ($(".Navtop-detay").slideDown(),
                    $(".Villa_detay-menu").removeClass("Villa_detay-menu-active"))),

                    500 < $(document).scrollTop() ? $(".Rez-right .Rez-left-gonder ").slideUp() : $(".Rez-right .Rez-left-gonder ").slideDown();
            }),

            $("#slick").slick({
                autoplay: !0,
                autoplaySpeed: 6e3,
                speed: 1500,
                fade: !0,
                arrows: !0
            }),
            $("svg").tooltip(), $(".btn-menu ").click(function () {
            $(".overlay").fadeToggle(200), $(this).toggleClass("btn-menu-open").toggleClass("btn-menu-close"), $(".vsecenek ").removeClass("vsecenek-active"), $(".overlay ").removeClass("overlay-pasif"), $(".vsecenek-geri").removeClass("Close"), $(".Navtop ").toggleClass("laci"), $("body ").toggleClass("ov"), $("#main").toggleClass("ov"), $(".Villa_detayM-whatsapp").fadeToggle(200), setTimeout(function () {
            }, 400);


            if ($(e.target).closest(".Navtop-discount").attr('style', 'display: block')) {
                $(".Navtop-discount").slideUp(400);
            }
        }),

            $(".Search-icon ").click(function () {
                $(".Search-menu").slideToggle(200), $(this).toggleClass("Search-icon-open"), $(".btn-menu ").toggleClass("Close");
                if ($(e.target).closest(".Navtop-discount").attr('style', 'display: block')) {
                    $(".Navtop-discount").slideUp(400);
                }
            }),

            $(".G_search-buton ").click(function () {
                $(".G_search-menu").slideDown(), $(".G_search-buton").slideUp();
            }),

            $(".G_search-menu-buton").click(function () {
                $(".G_search-menu").slideUp(), $(".G_search-buton").slideDown();
            }),

            $(".Search-button a").click(function () {
                $(".Search-overlay").fadeToggle(200), $(this).toggleClass("Search-open").toggleClass("Search-close");
            }),

            $("#secenek").click(function () {
                $(".vsecenek ").toggleClass("vsecenek-active"), $(".overlay ").toggleClass("overlay-pasif"), $(".vsecenek-geri").removeClass("Close");
            }),

            $(".vsecenek-geri").click(function () {
                $(".vsecenek ").removeClass("vsecenek-active"), $(".overlay ").removeClass("overlay-pasif"), $(this).addClass("Close");
            }),

            $(".nav-item div.dropdown").hover(function () {
                    $(this).find(".dropdown-menu").stop(!0, !0).delay(0).slideDown(400);
                },

                function () {
                    $(this).find(".dropdown-menu").stop(!0, !0).delay(0).slideUp(400);
                }),
            $(".Teklif-item-property-in input").click(function () {
                $(this).is(":checked") ? $(this).parent().parent().addClass("Teklif-item-property-active") : $(this).parent().parent().removeClass("Teklif-item-property-active");
            }),
            $(".step").click(function () {
                if (("aile" == $(this).attr("data-tur") ? ($(".balayi").css("display", "none"),
                    $(".aile").css("display", "block")) : ($(".aile").css("display", "none"),
                    $(".balayi").css("display", "block")), "undefined" != $(this).attr("data-climate") && null != $(this).attr("data-climate") && null !== $(this).attr("data-climate") && "" != $(this).attr("data-climate"))) switch (($(".climate").css("display", "none"),
                    $(this).attr("data-climate"))) {
                    case "spring":
                        $(".spring").css("display", "flex");
                        break;
                    case "summer":
                        $(".summer").css("display", "flex");
                        break;
                    case "winter":
                        $(".winter").css("display", "flex");
                        break;
                    case "autumn":
                        $(".autumn").css("display", "flex");
                }
                "undefined" != $(this).attr("data-date") && null != $(this).attr("data-date") && null !== $(this).attr("data-date") && "" != $(this).attr("data-date") ? "tarih_var" == $(this).attr("data-date") ? ($(this).parent().parent().parent().removeClass("part-active").addClass("part-passive"),
                    $(".part3").prependTo("form"),
                    $(".part3").addClass("part-passive").removeClass("part-active"),
                    $(".part4").prependTo("form"),
                    $(".part4").addClass("part-passive").removeClass("part-active"),
                    $(".part5").before($(".part2")),
                    $(".part2").addClass("part-active").removeClass("part-middle_active").removeClass("part-passive")) : ($(this).parent().parent().parent().removeClass("part-active").addClass("part-passive"),
                    $(".part2").prependTo("form"),
                    $(".part2").addClass("part-passive").removeClass("part-active"),
                    $(".part5").before($(".part3")),
                    $(".part3").after($(".part4")),
                    $(".part3").removeClass("part-middle_active").removeClass("part-passive").addClass("part-active"),
                    $(".part4").removeClass("part-passive").addClass("part-middle_active")) : ($(this).parent().parent().parent().removeClass("part-active").addClass("part-passive"),
                    $(this).parent().parent().parent().next().addClass("part-active").removeClass("part-middle_active"),
                    $(this).parent().parent().parent().next().next().addClass("part-middle_active").removeClass("part-passive"));
            }),
            $(".step-back").click(function () {
                $(this).parent().parent().parent().removeClass("part-active").addClass("part-middle_active"),
                    $(this).parent().parent().parent().prev().addClass("part-active").removeClass("part-passive");
            });

        moment().add(1, "days"), moment().add(359, "days");

        $(window).scroll(function () {
            100 < $(this).scrollTop() ? $("#UpTotop").fadeIn() : $("#UpTotop").fadeOut();
        }),

            $("#UpTotop").click(function () {
                $("body,html").animate({
                    scrollTop: 0
                }, 800);
            });

        var o, r, l, d;
        $("body");
        (o = jQuery), (r = []), o("#gallery")
            .find("figure")
            .each(function () {
                var e = o(this).find("a"),
                    e = {
                        src: e.attr("href"),
                        w: e.data("width"),
                        h: e.data("height"),
                        title: e.data("caption")
                    };
                r.push(e);
            }),

            o("#gallery a, .galleryxyz").click(function (e) {
                e.preventDefault();
                var t = o(".pswp")[0],
                    e = {
                        index: o(this).parent("figure").index(),
                        bgOpacity: 0.85,
                        showHideOpacity: !0
                    };
                new PhotoSwipe(t, PhotoSwipeUI_Default, r, e).init();
            }),

            (l = jQuery), (d = []), l("#gallerybelgeler")
            .find("figure")
            .each(function () {
                var e = l(this).find("a"),
                    e = {
                        src: e.attr("href"),
                        w: e.data("width"),
                        h: e.data("height"),
                        title: e.data("caption")
                    };
                d.push(e);
            }),

            l("#gallerybelgeler a").click(function (e) {
                e.preventDefault();
                var t = l(".pswp")[0],
                    e = {
                        index: l(this).parent("figure").data("index"),
                        bgOpacity: 0.85,
                        showHideOpacity: !0
                    };
                new PhotoSwipe(t, PhotoSwipeUI_Default, d, e).init();
            });

        $("#yazi").text().substr(0, 50);
        searchCheck(), $('input[type="checkbox"]').change(function () {
            searchCheck();
        });


    });

var slideKonum = 0;

function teklifIleri() {
    var e;
    0 === slideKonum && ("true" == (e = document.querySelector('input[name="net_date"]:checked').value) ? $(".mpart5").before($(".mpart2")).css("display", "block") : "false" == e ? ($(".mpart5").before($(".mpart3")).css("display", "block"), $(".mpart3").after($(".mpart4")).css("display", "block")) : $(".swiper-button-next").attr("disabled", "disabled")), slideKonum++;
}

function teklifGeri() {
    slideKonum--;
}

$(document).on("click", "#searchfocus", function (e) {
    return e.preventDefault(), $("#searchinput").click(), $("#searchinput").focus(), !1;
});