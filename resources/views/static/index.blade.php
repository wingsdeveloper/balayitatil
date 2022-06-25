@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    <section class="G_soz">
        <div class="Global_header"><h1>{{ isset($page->page_name) ? $page->page_name : '' }}</h1></div>
        <div class="container">
            <div class="G_soz-in">
                {!! isset($page->dynamic_description) ? $page->dynamic_description : '' !!}
            </div>
        </div>
    </section>
@endsection
