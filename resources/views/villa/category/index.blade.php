@extends('layouts.app')
@push('extrahead')
@include('layouts.criteo_view')
@endpush
@section('content')
    @include('villa.category.slider')

    <section class="V_secenekler">

        <div class="containerindex">
            <div class="V_secenekler-in flex wrap">

                @foreach($categories as $category)
                    @php
                        $seo = App\WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,'item_id' => $category->id,'pivot' => 'website_panel_categories'])->first();

                        $seo_url = isset($seo->seo_url) ? $seo->seo_url : '';
                      $villacategory = cache()->remember('remember-category-count-' . $category->id, 1*60, function() use ($website, $category) {
                            return App\WebsitePanelVillaCategory::whereHas('villa')->where('website_id', $website->id)->where('villa_category_id', $category->id)->get();
                        });
                        /*   $villa= DB::table('villas')->join('website_panel_villas', function ($join)use ($website) {
                        $join->on('villas.id', '=', 'website_panel_villas.villa_id')
                        ->where('website_panel_villas.website_id', '=', $website->id)
                        ->where('website_panel_villas.status', '=', 1);
                        })->join('website_panel_categories', function ($join) use ($website,$category){
                        $join
                        ->where('website_panel_categories.id', '=', $category->id)
                        ->where('website_panel_categories.website_id', '=', $website->id);

                        })->select("villas.list_image")->select("villas.list_image_name")->where('villas.status','1')->orderBy('villas.id','desc')->limit(1)->get();
                        */
                    @endphp
                    <div class="V_secenekler-item">
                        <div class="V_secenekler-item-image hover_zoom2">

                            <a href="{{ route('category.detail',[$link,$seo_url]) }}" class="global_link"></a>
                            <img
                                src="{{ImageProcess::getImageByPath($category->list_image)}}"
                                class="w-100" alt="">

                        </div>
                        <div class="V_secenekler-item-text">
                            <p>{{$category->name}} <span>({{count($villacategory)}})</span></p>
                            <span class="V_secenekler-item-icon">
                            <svg class="icon icon-chevron-right">
                                <use xlink:href="#icon-chevron-right"></use>
                            </svg>
                        </span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </section>
@endsection
