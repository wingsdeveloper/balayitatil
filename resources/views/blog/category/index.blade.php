@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    @include('blog.layouts.header')
    <section class="Blog">
        <div class="container">
            <div class="Blog-in flex">
                <div class="Blog-inner">
                @forelse($blogs as $blog)
                            @php
                                $category_name = Request::segment(2);
                            @endphp
                            <div class="Blog-item flex">
                                <div class="Blog-item-in  flex a-i-fs">
                                <span class="Blog-item-date">
                                    <strong>
                                        {{ iconv('latin5','utf-8',\Carbon\Carbon::parse($blog->created_at)->formatLocalized('%d')) }}
                                    </strong>
                                    {{ iconv('latin5','utf-8',\Carbon\Carbon::parse($blog->created_at)->formatLocalized('%b %Y')) }}
                                </span>
                                    <div class="Blog-item-text flex-column">
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
                                        @if(isset($blog->seo) && !empty($blog->seo))
                                            <a href="{{ route('blog.category.detail',[$category_name,$blog->seo->seo_url]) }}"></a>
                                        @else
                                            <a href="#"></a>
                                        @endif

                                        <h1>{{ $blog->title }}</h1>
                                        </a>
                                        <div class="text-gri" id="blogparagraf_{{ $blog->id }}">
                                            {!! App\Helpers\Helper::bolumle($blog->description,100) !!}
                                        </div>
                                        @if(isset($blog->seo) && !empty($blog->seo))
                                            <a href="{{ route('blog.category.detail',[$category_name,$blog->seo->seo_url]) }}" class="buton_orange">
                                                Devamını Oku
                                                <svg class="icon icon-right-arrow">
                                                    <use xlink:href="#icon-right-arrow"></use>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="#" class="buton_orange">
                                                Devamını Oku
                                                <svg class="icon icon-right-arrow">
                                                    <use xlink:href="#icon-right-arrow"></use>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="Blog-item-image ">
                                    @if(isset($blog->seo) && !empty($blog->seo))
                                        <a href="{{ route('blog.category.detail',[$category_name,$blog->seo->seo_url]) }}"></a>
                                    @else
                                        <a href="#"></a>
                                    @endif
                                    <img src="{{ImageProcess::getImageByPath( $blog->image) }}" class="w-100" alt="{{ $blog->title }}">
                                </div>
                            </div>
                    @empty
                        Henüz bu kategoriye ait blog eklenmemiştir.
                    @endforelse
                </div>
                @include('blog.layouts.sidebar')
            </div>
            <nav class="flex j-c-c">
                {{ $blogs->links() }}
            </nav>
        </div>
    </section>
@endsection
