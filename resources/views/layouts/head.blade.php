@php
$curl = curl_init();
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$event_id_pageview = random_int(100000000000000000, 999999999999999999);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v13.0/1757769984530411/events',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('data' => '[{
      "event_name": "PageView",
      "event_id": "'. $event_id_pageview .'",
      "event_time": "' . time() .'",
      "event_source_url": "'. $actual_link .'",
      "user_data": {
          "external_id": "' . $external_id . '",
          "client_ip_address": "' . $fb_ip . '",
          "client_user_agent": "' . $user_agent . '"
        } }]',
       'access_token' => 'EAAHTPiGDALEBAEcNNXC1nNAXJDI4V2r1hnaSlKvSH0TgWcoFPBzKGtKGZABzUVuszLurTdQ9qZBSunk0PZCqzVI73s07w2s5ZA2YgVaFl6ZCREl8buwcpAwC3bgZAWiVVegefRultu8o3Bx5nEJe6WYZC0RyNpZCR1ZA7bZALHsF8SDMsAL6WQQVd9JEwVSRuhx58ZD','test_event_code' => 'TEST50377'),
));

$response = curl_exec($curl);

curl_close($curl);

@endphp

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet" rel="preload" as="style">
    <link rel="stylesheet" href="{{ asset('css/library/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/bootstrap-fullscreen-select.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="{{ asset('css/library/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/hover.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/intl-tel-input.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/library.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/lv_window.css') }}">
    <link rel="stylesheet" href="{{ asset('css/library/global.css?v=1.20vk') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.20vk') }}">
    <link rel="stylesheet" href="{{ asset('css/library/theme-old.css?v=1.20vk') }}">
    


@stack('extrahead')
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1757769984530411' );
fbq('track', 'PageView',{}, {eventID : '{{ $event_id_pageview }}' });
</script>

<!-- End Meta Pixel Code -->



<style>
    .blinking_icon {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/lazyload/2.0.3/lazyload-min.js"></script>--}}
