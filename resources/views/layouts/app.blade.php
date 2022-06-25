<!DOCTYPE html>
<html @yield('itemscope')>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NTRMKWM');</script>
<!-- End Google Tag Manager -->
<!-- Criteo Loader File -->
<script type="text/javascript" src="//dynamic.criteo.com/js/ld/ld.js?a=46955" async="true"></script>
<!-- END Criteo Loader File -->
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
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NTRMKWM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
{{--<script src="{{ asset('js/bundle.min.js') }}"></script>--}}
@stack('before_jquery')
<script src="{{ asset('js/jquery.min.js') }}"></script>

@stack('search_app_js')
<script src="{{ asset('js/selectpicker.min.js') }}"></script>
<script src="{{ asset('js/theme.min.js?v=1.09vk') }}"></script>
{{--<script src="{{ asset('js/theme.js?v=1.09vk') }}"></script>--}}
@stack('after_theme')

{{--<script src="{{ asset('js/library/jquery-3.2.1.slim.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/popper.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/bootstrap.min.js') }}"></script>--}}

{{--<script src="{{ asset('js/library/swiper.js') }}"></script>--}}

{{--<script src="{{ asset('js/library/picker.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/picker.date.js') }}"></script>--}}
{{--<script src="{{ asset('js/picker.date.js') }}"></script>--}}

{{--<script src="{{ asset('js/main.js?v=' . ImageProcess::anti_cache('css/main.js')) }}124"></script>--}}

@if(($view_name == "villa-list-index") || $view_name == 'villa-search-no-price' || ($view_name == "villa-search-index") || ($view_name == "villa-search-index_new") || ($view_name == "villa-category-detail") || ($view_name == "area-detail-index") || ($view_name == "villa-detail-index") || ($view_name == "home-index") || ($view_name == "offer-offer"))
    @if(Agent::isDesktop())
        <script src="{{ asset('js/desktoppicker.js') }}" async></script>
    @elseif(Agent::isMobile())
        <script src="{{ asset('js/mobilepicker.js') }}"></script>
    @endif
@endif

{{--<script src="{{ asset('js/library/lightview.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/slick.js') }}"></script>--}}

{{--<script src="{{ asset('js/library/legacy.js') }}"></script>--}}


{{--<script src="{{ asset('js/library/bootstrap-fullscreen-select.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/bootstrap-select.js') }}"></script>--}}


{{--<script src="{{ asset('js/library/moment.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/jquery.daterangepicker.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/photoswipe.min.js') }}"></script>--}}
{{--<script src="{{ asset('js/library/photoswipe-ui-default.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>--}}
{{--<script type="text/javascript"--}}
{{--        src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>--}}
@stack('javascripts')
@include('layouts.svg')

<script>
    let selectedCategories = $(document).find('.Dropdown-menu-item').find('input.category_check:checked');
    let selectedValues = [];
    $.each(selectedCategories, function() {
        selectedValues.push($(this).val());
    });
    $(document).find('#selected-categories').val(selectedValues.join('_'));

    var myArray = $(selectedCategories).map(function () {
        return $(this).data('id');
    }).get();
    if(myArray.length >= 5) {
        $(".Dropdown-menu-in-warning").addClass('enabled');
        $(".Dropdown-menu-item input:not(:checked)").prop('disabled', true).parent('div').addClass('disabled-button');
    } else {
        $(".Dropdown-menu-in-warning").removeClass('enabled');
        $(".Dropdown-menu-item input").prop('disabled', false).parent('div').removeClass('disabled-button');
    }
    $(document).on('click', '.Dropdown-menu-item input', function () {
        let selectedCategories = $(document).find('.Dropdown-menu-item').find('input.category_check:checked');
        let selectedValues = [];
        $.each(selectedCategories, function() {
            selectedValues.push($(this).val());
        });
        $(document).find('#selected-categories').val(selectedValues.join('_'));

        var myArray = $(selectedCategories).map(function () {
            return $(this).data('id');
        }).get();
        if(myArray.length >= 5) {
            $(".Dropdown-menu-in-warning").addClass('enabled');
            $(".Dropdown-menu-item input:not(:checked)").prop('disabled', true).parent('div').addClass('disabled-button');
        } else {
            $(".Dropdown-menu-in-warning").removeClass('enabled');
            $(".Dropdown-menu-item input").prop('disabled', false).parent('div').removeClass('disabled-button');
        }
    });
    $(document).on('change', '#v_filter', function () {
        console.log($(this).val());

        let route = "{{ route('search.get-districts', '#id#') }}";
        route = route.replaceAll('#id#', $(this).val());
        $.ajax({
            url: route,
            dataType: 'json',
            type: 'post',
            data: {_token: '{{ csrf_token() }}'},
            success: function( data ){
                var options = [];
                options.push('<option value="0">Alt Bölge Seçiniz</option>')
                $(data).each(function (index, value) {
                    var option = '<option value="'+value.id+'">'+value.name+'</option>';
                    options.push(option);
                })
                console.log(options);
                $('#filter_area').html(options);
                $("#filter_area").selectpicker('refresh');
            },
            error: function( jqXhr, textStatus, errorThrown ){
            }
        });
    })
</script>
<script>
    $('.lazy-load').Lazy();
</script>
<script>
$(document).mouseup(function (e) {
    if ($(e.target).closest(".Dropdown-menu").attr('style','display: block').length
        === 0) {
        $(".Dropdown-menu").attr('style','display: none');
    }
});
 </script>
<div id="async"></div>

@stack('pro_js')


</body>
</html>
