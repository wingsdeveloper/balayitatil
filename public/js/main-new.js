var takvimvarmi = !1;

function getTodayString() {
    var e = "It is now: " + new Date().toLocaleDateString() + ", ";
    return (e += new Date().toLocaleTimeString());
}

var arrWeekdays = new Array("PZT", "SAL", "ÇAR", "PER", "CUM", "CMT", "PAZ"),
    arrMonths = new Array(["Ocak", 31], ["Şubat", 28], ["Mart", 31], ["Nisan", 30], ["Mayıs", 31], ["Haziran", 30], ["Temmuz", 31], ["Ağustos", 31], ["Eylül", 30], ["Ekim", 31], ["Kasım", 30], ["Aralık", 31]);

function isLeapYear(e) {
    return (endvalue = !1), isNaN(e) || (e % 4 == 0 && (endvalue = e % 100 != 0 || e % 400 == 0)), endvalue;
}

function makeMonthTable(e, t) {
    if (isNaN(e) || 4 != e.toString().length) return "bad year number";
    if (isNaN(t) || t < 0 || 11 < t) return "bad month number";
    var i = new Date(e, t, 0).getDay(),
        n = arrMonths[t][1];
    1 == t && isLeapYear(e) && (n = 29), (strMonthTable = "<div class='is_fulltable-item'>\n"), (strMonthTable += "<h5 class='is_fulltable-header'>" + arrMonths[t][0].toUpperCase() + " " + e + "</h5> "), (strMonthTable += "<table class='table'><thead><tr>");
    for (var s = 0; s < 7; s++) strMonthTable += "<th scope='col'><span>" + arrWeekdays[s].toUpperCase() + "</span></th>";
    strMonthTable += "</tr></thead><tbody>\n";
    for (var a = 1, o = 0; a <= n;) {
        strMonthTable += "<tr>";
        for (s = 0; s < 7; s++) {
            var r, l = "",
                d = "",
                c = "";
            i <= o && a <= n && (console.log(new Date().getFullYear() + "/" + new Date().getMonth() + "/" + new Date().getDate()), Date.parse(new Date().getFullYear() + "/" + parseInt(new Date().getMonth() + 1) + "/" + new Date().getDate()) > Date.parse(e + "/" + (parseInt(t) + 1) + "/" + a) && (c = " class='is_fulltable-d'"), (r = ""), (r = (d = a) < 10 ? "0" + a : a), (l = " id='" + e + "-" + (parseInt(t + 1) < 10 ? "0" + parseInt(t + 1) : parseInt(t + 1)) + "-" + r + "'"), a++), (strMonthTable += "<td " + l + " " + c + "><span>" + d + "</span></td>"), o++;
        }
        strMonthTable += "</tr>\n";
    }
    return (strMonthTable += "</tbody></table></div>\n"), strMonthTable;
}

function highlightDay(e, t) {
    var i = e.getDate(),
        n = e.getMonth(),
        i = e.getFullYear() + "_" + n + "_" + i,
        i = document.getElementById(i);
    i && (i.className = t);
}

function makeYearCalendar(e) {
    strYearCalendar = "";
    for (var t = 0; t < 12; t++) strYearCalendar += makeMonthTable(e, t);
    return strYearCalendar;
}

function takvimGetirPriority(e) {
    var t, i, n, s, a, o, r, l, d, c;
    "detail" == $("#dgiris_tarih").attr("data-page") && ((0 != takvimvarmi && !1 !== takvimvarmi) || ((t = new Date()).getDate(), t.getDay(), t.getMonth(), (i = (o = new Date()).getMonth()), (n = o.getFullYear()), (a = "" === e || isNaN(e) || 4 != e.toString().length ? ((s = t.getFullYear()), !0) : ((s = e), !1)), (o = parseInt(s - 1)), (e = parseInt(parseInt(s) + 1)), 0 < t.getFullYear() - o && (o = parseInt(t.getFullYear())), 2 <= e - t.getFullYear() && (e = parseInt(parseInt(t.getFullYear()) + 2)), $("#gecmistarih").attr("onclick", "takvimGetirPriority('" + o + "')"), $("#gelecektarih").attr("onclick", "takvimGetirPriority('" + e + "')"), (o = new Date(s, 3, 2)), ((e = document.getElementById("calendar")).innerHTML = '<div style="position: absolute;color:#fff;background: rgba(0,0,0,0.7);font-weight:bold;font-size:1.2em;width: 100%;height: 100%;padding: 10%;z-index: 99;" class="doluluk_loading"><center>Lütfen Bekleyiniz...</center></div>'), (e.innerHTML += makeYearCalendar(s)), n == s && (($nextYear = $(makeYearCalendar(s + 1))), $(e).append($nextYear)), highlightDay(t, "today"), highlightDay(o, "birthday"), (o = parseInt($("#data_villa").text())), (l = []), (d = $("#mgiris_tarih").pickadate().pickadate("picker")), (c = $("#mcikis_tarih").pickadate().pickadate("picker")), $.ajax({
        type: "GET",
        url: url + "/villa_status/" + o + "/" + s + "?priority=true",
        success: function (e) {
            $(".doluluk_loading").remove();
            e = $.parseJSON(e);
            "" != e && e.forEach(function (e) {
                var t;
                "2" == e.status && 1 != e.start && 1 != e.end && ((o = e.tarih.split("-")), (t = parseInt(parseInt(o[1]) - 1)), l.push([o[0], t, o[2]]));
                var i, n, s, a, o = $("#" + e.tarih);
                o.hasClass("is_fulltable-d") || ("3" == e.status ? ((r = "is_fulltable-o"), (i = "is_fulltable-left-o"), (n = "is_fulltable-right-o")) : "2" == e.status && ((r = "is_fulltable-f"), (s = "is_fulltable-left-f"), (a = "is_fulltable-right-f")), o.addClass(r), 1 == e.start && (o.addClass("is_fulltable-left"), o.hasClass("is_fulltable-right") && o.hasClass("is_fulltable-f") && o.addClass(a), o.hasClass("is_fulltable-right") && o.hasClass("is_fulltable-o") && o.addClass(n)), 1 == e.end && (o.addClass("is_fulltable-right"), o.hasClass("is_fulltable-left") && o.hasClass("is_fulltable-f") && o.addClass(s), o.hasClass("is_fulltable-left") && o.hasClass("is_fulltable-o") && o.addClass(i)));
            }), d.set("disable", l), c.set("disable", l);
        },
    }), n == s && 1 == a && ($(document)
        .find("#doluluk-takvimi")
        .find(".is_fulltable-item:lt(" + i + ")")
        .remove(), $(document)
        .find("#doluluk-takvimi")
        .find(".is_fulltable-item:gt(" + -(12 - i + 1) + " )")
        .remove())));
}

function takvimGetir(e) {
    var t, i, n, s, a, o, r, l, d, c;
    "detail" == $("#dgiris_tarih").attr("data-page") && ((0 != takvimvarmi && !1 !== takvimvarmi) || ((t = new Date()).getDate(), t.getDay(), t.getMonth(), (i = (o = new Date()).getMonth()), (n = o.getFullYear()), (a = "" === e || isNaN(e) || 4 != e.toString().length ? ((s = t.getFullYear()), !0) : ((s = e), !1)), (o = parseInt(s - 1)), (e = parseInt(parseInt(s) + 1)), 0 < t.getFullYear() - o && (o = parseInt(t.getFullYear())), 2 <= e - t.getFullYear() && (e = parseInt(parseInt(t.getFullYear()) + 2)), $("#gecmistarih").attr("onclick", "takvimGetirPriority('" + o + "')"), $("#gelecektarih").attr("onclick", "takvimGetirPriority('" + e + "')"), (o = new Date(s, 3, 2)), ((e = document.getElementById("calendar")).innerHTML = '<div style="position: absolute;color:#fff;background: rgba(0,0,0,0.7);font-weight:bold;font-size:1.2em;width: 100%;height: 100%;padding: 10%;z-index: 99;" class="doluluk_loading"><center>Lütfen Bekleyiniz...</center></div>'), (e.innerHTML += makeYearCalendar(s)), n == s && (($nextYear = $(makeYearCalendar(s + 1))), $(e).append($nextYear)), highlightDay(t, "today"), highlightDay(o, "birthday"), (o = parseInt($("#data_villa").text())), (l = []), (d = $("#mgiris_tarih").pickadate().pickadate("picker")), (c = $("#mcikis_tarih").pickadate().pickadate("picker")), $.ajax({
        type: "GET",
        url: url + "/villa_status/" + o + "/" + s,
        success: function (e) {
            $(".doluluk_loading").remove();
            e = $.parseJSON(e);
            "" != e && e.forEach(function (e) {
                var t;
                "2" == e.status && 1 != e.start && 1 != e.end && ((o = e.tarih.split("-")), (t = parseInt(parseInt(o[1]) - 1)), l.push([o[0], t, o[2]]));
                var i, n, s, a, o = $("#" + e.tarih);
                o.hasClass("is_fulltable-d") || ("3" == e.status ? ((r = "is_fulltable-o"), (i = "is_fulltable-left-o"), (n = "is_fulltable-right-o")) : "2" == e.status && ((r = "is_fulltable-f"), (s = "is_fulltable-left-f"), (a = "is_fulltable-right-f")), o.addClass(r), 1 == e.start && (o.addClass("is_fulltable-left"), o.hasClass("is_fulltable-right") && o.hasClass("is_fulltable-f") && o.addClass(a), o.hasClass("is_fulltable-right") && o.hasClass("is_fulltable-o") && o.addClass(n)), 1 == e.end && (o.addClass("is_fulltable-right"), o.hasClass("is_fulltable-left") && o.hasClass("is_fulltable-f") && o.addClass(s), o.hasClass("is_fulltable-left") && o.hasClass("is_fulltable-o") && o.addClass(i)));
            }), d.set("disable", l), c.set("disable", l);
        },
    }), n == s && 1 == a && ($(document)
        .find("#doluluk-takvimi")
        .find(".is_fulltable-item:lt(" + i + ")")
        .remove(), $(document)
        .find("#doluluk-takvimi")
        .find(".is_fulltable-item:gt(" + -(12 - i + 1) + " )")
        .remove())));
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
                e < 500 && $(".Rezervasyon").removeClass("Rezervasyon-fixed")) : ($(".Rezervasyon").removeClass("Rezervasyon-fixed"),
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