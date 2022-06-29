@php
    try {
    $whatsapp_number = $website->whatsapp_phones->random()->number;
} catch(\Exception $e) {
    $whatsappErr = true;
}


@endphp
{{--@php--}}

{{--    $whatsapp_number = $website->whatsapp_phones->random()->number;--}}

{{--@endphp--}}
@if($view_name != "offer-getOffer")
    @if(!$whatsappErr)
    
    <a id="whatapp_click_zaraz" style="right: 10px; bottom: 20px; z-index: 999999999999999" onclick="gtag('event', 'whatsapp', {'event_category' : 'click'});"
           href="https://api.whatsapp.com/send?phone=902526060669" class="float" target="_blank">
            <svg class="icon icon-whatsapp">
                <use xlink:href="#icon-whatsapp"></use>
            </svg>
        </a>
    @endif

@endif

