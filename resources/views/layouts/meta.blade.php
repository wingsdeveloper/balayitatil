<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="facebook-domain-verification" content="07ir5h4mhnnlk1ncyug0xlrrvwvqju" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
<meta name="title"
      content="{{ isset($meta_seo->seo_title) && !empty($meta_seo->seo_title) ? $meta_seo->seo_title : '' }}">
<meta name="keywords"
      content="{{ isset($meta_seo->seo_keywords) && !empty($meta_seo->seo_keywords) ? $meta_seo->seo_keywords  : ''}}">
<meta name="description"
      content="{{ isset($meta_seo->seo_description) && !empty($meta_seo->seo_description) ? $meta_seo->seo_description : ''}}">
@if($view_name == "blog-detail-index")
    <meta name="author" content="{{ isset($meta_author) && !empty($meta_author) ? $meta_author->fullname : '' }}">
@endif
@if(isset($website->company) && !empty($website->company))
    <meta name="owner" content="{{ $website->company->name }}">
@endif
<meta name="copyright" content="Copyright © {{ date('Y') }} Tüm Hakları Saklıdır.">
@if(isset($website->company) && !empty($website->company))
    <meta name="distribution" content="{{ $website->company->name }}">
@endif
@if(isset($website->lang) && !empty($website->lang))
    <meta http-equiv="Content-Language" content="{{ $website->lang }}">
@endif
@if(request()->has('page') && (request()->page > 1))
    <meta name='robots' content='noindex'>
@endif
@if(request()->has('sayfa') && (request()->sayfa > 1))
    <meta name='robots' content='noindex'>
@endif
<!--Social: Twitter / Card-->
<meta name="twitter:card"
      content="{{ isset($meta_seo->seo_description) && !empty($meta_seo->seo_description) ? $meta_seo->seo_description : ''}}">
<meta name="twitter:site"
      content="{{ isset($website->general_setting) && !empty($website->general_setting)  ? $website->general_setting->twitter : '' }}">
<meta name="twitter:creator"
      content="{{ isset($website->general_setting) && !empty($website->general_setting) ? $website->general_setting->twitter : '' }}">
<meta name="twitter:title"
      content="{{ isset($meta_seo->seo_title) && !empty($meta_seo->seo_title) ? $meta_seo->seo_title : '' }}">
<meta name="twitter:description" content="{{ isset($meta_seo->seo_description) && !empty($meta->seo_description) ? $meta_seo->seo_description: ''}}">
@if($view_name == "blog-detail-index")
    <meta name="twitter:image:src" content="{{ isset($blog) && !empty($blog) ? asset($blog->image) : '' }}">
@endif
<!--Social: Facebook / Open Graph -->
<meta property="og:url" content="{{ Request::url() }}">
@if(isset($meta_seo->seo_title) && !empty($meta_seo->seo_title))
<meta property="og:title"
      content="{{ isset($meta_seo->seo_title) && !empty($meta_seo->seo_title) ? $meta_seo->seo_title : '' }}">
@endif
@if(isset($meta_seo->seo_description) && !empty($meta_seo->seo_description))
<meta property="og:description"
      content="{{ isset($meta_seo->seo_description) && !empty($meta_seo->seo_description) ? $meta_seo->seo_description: ''}}">
@endif
@if($view_name == "blog-detail-index")
    <meta property="og:image" content="{{ isset($blog) && !empty($blog) ? asset($blog->image) : '' }}"/>
@endif
<meta property="og:site_name" content="{{ isset($website->name) && !empty($website->name) ? $website->name : '' }}">
<meta property="og:type" content="website">
@if($view_name == "blog-detail-index")
    <meta property="article:author"
          content="{{ isset($meta_author) && !empty($meta_author) ? $meta_author->fullname : '' }}">
@endif
<!-- Social: Google+ / Schema.org  -->
<meta itemprop="name"
      content="{{ isset($meta_seo->seo_title) && !empty($meta_seo->seo_title) ? $meta_seo->seo_title : '' }}">
<meta itemprop="description"
      content="{{ isset($meta_seo->seo_description) && !empty($meta_seo->seo_description) ? $meta_seo->seo_description: ''}}">
@if($view_name == "blog-detail-index")
    <meta itemprop="image" content="{{ isset($blog) && !empty($blog) ? asset($blog->image) : '' }}">
@endif
@if($view_name == "villa-category-detail")
    @if(isset($website->categories[0]))
        <meta itemprop="image" content="{{ asset($website->categories[0]->image_mobile) }}">
        <meta property="og:image" content="{{ asset($website->categories[0]->image_mobile) }}">

    @endif
@endif
<meta name="csrf-token" content="{{ csrf_token() }}">
@if($view_name == "villa-search-index" || $view_name == "villa-search-index_new")

    @if(isset($kiralik))
    <meta itemprop="image" content="{{ asset($kiralik->static_banner_image_mobile) }}">
    <meta property="og:image" content="{{ asset($kiralik->static_banner_image_mobile) }}">

    <meta property="og:title" content="{{ isset($meta_seo->seo_title) && !empty($meta_seo->seo_title) ? $meta_seo->seo_title : '' }}">
    <meta property="og:description" content="{{ isset($meta_seo->seo_description) && !empty($meta_seo->seo_description) ? $meta_seo->seo_description: ''}}">

    <meta property="og:site_name" content="{{ isset($website->name) && !empty($website->name) ? $website->name : '' }}">
    <meta property="og:type" content="website">
    @endif

@endif
@if($view_name == 'faq-index')
    <meta itemprop="image" content="{{ asset($sss->static_banner_image_mobile) }}">
    <meta property="og:image" content="{{ asset($sss->static_banner_image_mobile) }}">
@endif
<meta name="apple-mobile-web-app-title" content="">



<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon180x180.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon16x16.png') }}">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="{{ asset('images/favicon.svg') }}" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<title>{{ isset($meta_seo->site_title) && !empty($meta_seo->site_title) ? $meta_seo->site_title : '' }}</title>
<meta name="base_url" content="{{ URL::to('/') }}">
<meta name="page" content="{{$view_name}}">
<meta name="google-site-verification" content="7cNZS94d0cpuS9gdG7mrnpHKSltUQrhCL0B55wA0C8w"/>
<meta name="theme-color" content="#102754">

<link rel="canonical" href="{{ URL::current() }}" />
