<?php

namespace App\Http\Controllers;

use App\Website;
use App\WebsitePanelSeo;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function villaNotFound()
    {
        $meta_seo = WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,'seo_url' => 'villa-bulunamadi'])->firstOrFail();
        return view('villa.notfound.index', ['meta_seo' => $meta_seo]);
    }
}
