@extends('layouts.app')
@push('extrahead')
<!-- Criteo Homepage Tag -->
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
window.criteo_q.push(
    { event: "setAccount", account: 46955 },
    { event: "setEmail", email: "", hash_method: "" },
    { event: "setSiteType", type: deviceType},
    { event: "setZipcode", zipcode: "" },
    { event: "viewHome" }
);
</script>
<!-- END Criteo Homepage Tag -->

@endpush

@section('content')
    @include('home.banner')
    @include('home.popular')
    @include('home.sss')
    @include('home.opportunity')
    @include('home.temporary')
    @include('home.description')
    @push('javascripts')

    
    	{{-- <script>
    		$('title').text('Kiralık Villa - Kiralık Yazlık | Villa Kalkan');
    		$('meta[name=description]').remove();
    		$('head').append( '<meta name="description" content="Kalkan kiralık villa ve yazlık,kaş,fethiye kiralık villa,özel havuzlu villa,muhafazakar villa ve balayı villaları seçenekleri için sitemizi ziyaret edin.">' );
    	</script> --}}

    @endpush

@endsection
