@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    @include('blog.layouts.header')

    <section class="Blog-detay Blog-slider">
        <div class="container">
            <div class="Blog-in flex">
                <div class="Blog-inner Blog-detay-inner">
                    <h6 class="Blog-detay-inner-header">
                        @if(isset($blog->blog_category) && !empty($blog->blog_category))
                        {{ isset($blog->blog_category->area) && !empty($blog->blog_category->area) ? $blog->blog_category->area->name : 'GENEL' }}
                        / {{ $blog->blog_category->name }}
                        @endif
                    </h6>
                    <div class="Blog-item flex">
                        <div class="Blog-item-in col-md-7 pl-0 flex a-i-fs">
                            <span class="Blog-item-date">
                                <strong>{{ iconv('latin5','utf-8',\Carbon\Carbon::parse($blog->created_at)->formatLocalized('%d')) }}</strong>
                            {{ iconv('latin5','utf-8',\Carbon\Carbon::parse($blog->created_at)->formatLocalized('%b %Y')) }}
                            </span>
                            <div class="Blog-item-text flex-column">

                                <h1>{{ isset($blog) && !empty($blog) ? $blog->title : '' }}</h1>
                                <p class="text-gri">
                                    {!! isset($blog) && !empty($blog) ? $blog->description : '' !!}
                                </p>

                                <p class="Blog-item-info ">
                                    @if($blog->blog_category->seo)
                                    <a class="Blog-item-info-type" href="{{ route('blog.control',$blog->blog_category->seo->seo_url) }}">
                                        {{ isset($blog->blog_category) && !empty($blog->blog_category) ? $blog->blog_category->name : ''}}
                                    </a>
                                    @else
                                        <a class="Blog-item-info-type" href="#">
                                            {{ isset($blog->blog_category) && !empty($blog->blog_category) ? $blog->blog_category->name : ''}}
                                        </a>
                                    @endif

                                    <span>
                                    {{--<svg class="icon icon-eye">--}}
                                        {{--<use xlink:href="#icon-eye"></use>--}}
                                    {{--</svg>--}}
                                     {{--425--}}
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="Blog-item-image col-md-5 pr-0">
                            <img src="{{ImageProcess::getImageByPath( isset($blog) && !empty($blog) ? $blog->image : '' )}}" class="w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
            @if(count($interests) > 0)
                <div class="Blog-detay-like">
                    <h5 class="Blog-detay-like-header">İlginizi Çekebilir</h5>
                    <div class="Blog-detay-like-in flex wrap">
                        @forelse($interests as $interest)
                            <div class="Blog-detay-like-item hover_zoom1">
                                @if(isset($interest->seo) && !empty($interest->seo))
                                    <a href="{{ route("blog.control",$interest->seo->seo_url) }}" class="global_link"></a>
                                @else
                                    <a href="#"></a>
                                @endif
                                <img src="{{ImageProcess::getImageByPath( $interest->image )}}" class="w-100" alt="{{ $interest->title }}">
                                <p>{{ $interest->title }}</p>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
