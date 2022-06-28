@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    <section class="G_soz">
        <div class="container">
            <div class="G_soz-in ">
                <h1 class="Content-title">{{ isset($page->page_name) ? $page->page_name : '' }}</h3>
                {!! isset($page->dynamic_description) ? $page->dynamic_description : '' !!}
            </div>
        </div>
    </section>
@endsection
