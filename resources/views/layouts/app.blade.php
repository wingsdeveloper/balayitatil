<!DOCTYPE html>
<html @yield('itemscope')>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KK37GCW');</script>
<!-- End Google Tag Manager -->

    @include('layouts.meta')
    @include('layouts.head')
    @yield('head')

    {{-- @push('extrahead')

    {{-- @endpush     --}}
    <style>
        .disabled-button {
            opacity: 0.3 !important;
        }
    </style>
</head>

<body>
<main id="main">
    @if($view_name != "blog-category-index" && $view_name != "blog-detail-index" && $view_name != "blog-list-index")
        @include('layouts.header')
        @if(Agent::isMobile())
            @include('layouts.mobileHeader')
        @endif
    @endif
    @yield('content')
    @if($view_name != "villa-reservation-index" && $view_name != "villa-reservation-kredikart_index" && $view_name != "villa-reservation-prereservationdone" && $view_name != "villa-reservation-done" && $view_name != "villa-reservation-error" && $view_name != "villa-notfound-index" && $view_name != "offer-offer" && $view_name != "offer-offers" && $view_name != "offer-getOffer" && $view_name != "offer-done")
        @include('layouts.footer')
    @endif
    @include('layouts.plugin')
</main>

@stack('before_jquery')
<script src="{{ asset('js/jquery.min.js') }}"></script>

@stack('search_app_js')
<script src="{{ asset('js/selectpicker.min.js') }}"></script>
<script src="{{ asset('js/theme.min.js?v=1.21vk') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="{{ asset('js/main-new.js?v=1.21vk') }}" type="text/javascript"></script>

@stack('after_theme')

@if(($view_name == "villa-list-index") || $view_name == 'villa-search-no-price' || ($view_name == "villa-search-index") || ($view_name == "villa-search-index_new") || ($view_name == "villa-category-detail") || ($view_name == "area-detail-index") || ($view_name == "villa-detail-index") || ($view_name == "home-index") || ($view_name == "offer-offer"))
    @if(Agent::isDesktop())
        <script src="{{ asset('js/desktoppicker.js') }}" async></script>
    @elseif(Agent::isMobile())
        <script src="{{ asset('js/mobilepicker.js') }}"></script>
    @endif
@endif

@stack('javascripts')
@include('layouts.svg')

<script type="text/javascript">
    let selectedCategories = $(document).find('.Dropdown-menu-item').find('input.category_check:checked');
    let selectedValues = [];
    $.each(selectedCategories, function () {
        selectedValues.push($(this).val());
    });
    $(document).find('#selected-categories').val(selectedValues.join('_'));

    var myArray = $(selectedCategories).map(function () {
        return $(this).data('id');
    }).get();
    if (myArray.length >= 5) {
        $(".Dropdown-menu-in-warning").addClass('enabled');
        $(".Dropdown-menu-item input:not(:checked)").prop('disabled', true).parent('div').addClass('disabled-button');
    } else {
        $(".Dropdown-menu-in-warning").removeClass('enabled');
        $(".Dropdown-menu-item input").prop('disabled', false).parent('div').removeClass('disabled-button');
    }
    $(document).on('click', '.Dropdown-menu-item input', function () {
        let selectedCategories = $(document).find('.Dropdown-menu-item').find('input.category_check:checked');
        let selectedValues = [];
        $.each(selectedCategories, function () {
            selectedValues.push($(this).val());
        });
        $(document).find('#selected-categories').val(selectedValues.join('_'));

        var myArray = $(selectedCategories).map(function () {
            return $(this).data('id');
        }).get();
        if (myArray.length >= 5) {
            $(".Dropdown-menu-in-warning").addClass('enabled');
            $(".Dropdown-menu-item input:not(:checked)").prop('disabled', true).parent('div').addClass('disabled-button');
        } else {
            $(".Dropdown-menu-in-warning").removeClass('enabled');
            $(".Dropdown-menu-item input").prop('disabled', false).parent('div').removeClass('disabled-button');
        }
    });
    $(document).on('change', '#v_filter', function () {
        console.log($(this).val());

        let route = "https://villakalkan.com.tr/ajax-get/#id#/districts";
        route = route.replaceAll('#id#', $(this).val());
        $.ajax({
            url: route,
            dataType: 'json',
            type: 'post',
            data: {_token: 'Na3GRLSuTyYt7vcVzzg9CJReELadTbtVDi1jLzvK'},
            success: function (data) {
                var options = [];
                options.push('<option value="0">Alt Bölge Seçiniz</option>')
                $(data).each(function (index, value) {
                    var option = '<option value="' + value.id + '">' + value.name + '</option>';
                    options.push(option);
                })
                console.log(options);
                $('#filter_area').html(options);
                $("#filter_area").selectpicker('refresh');
            },
            error: function (jqXhr, textStatus, errorThrown) {
            }
        });
    })
</script>

@if(Agent::isDesktop())

<script type="text/javascript">
    $('.lazy-load').Lazy();
    $(document).mouseup(function (e) {
        if ($(e.target).closest(".Dropdown-menu").attr('style', 'display: block').length ===
            0) {
            $(".Dropdown-menu").slideUp(400);
            $(".Dropdown-buton").removeClass("pointernone");
        }
    });
    $(document).ready(function () {

        $(".Dropdown-buton ").click(function () {
            $(".Dropdown-buton").toggleClass("pointernone");
        })

      

        $(".Navtop-discount-close ").click(function () {
            $(".Navtop-discount").slideUp(400);
        })


    });
</script>

@elseif(Agent::isMobile())
<script type="text/javascript">
    $('.lazy-load').Lazy();
    $(document).mouseup(function (e) {
        if ($(e.target).closest(".Dropdown-menu").attr('style', 'display: block').length ===
            0) {
            $(".Dropdown-menu").slideUp(400);
            $(".Dropdown-buton").removeClass("pointernone");
        }
    });
    $(document).ready(function () {

        $(".Dropdown-buton ").click(function () {
            $(".Dropdown-menu").slideToggle(400);
            $(".Dropdown-buton").toggleClass("pointernone");
        })

        $(".Dropdown-close ").click(function () {
            $(".Dropdown-menu").slideUp(400);
        })

      
        $(".Navtop-discount-close ").click(function () {
            $(".Navtop-discount").slideUp(400);
        })


    });
</script>

@endif
<div id="async"></div>

@stack('pro_js')

</body>
</html>
