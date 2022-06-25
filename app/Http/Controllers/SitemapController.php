<?php

namespace App\Http\Controllers;

use App\Villa;
use App\WebsitePage;
use App\WebsitePanelSeo;
use Illuminate\Http\Request;
use DB;
class SitemapController extends Controller
{
    public function main()
    {
        $view = view('sitemap.main');
        return response($view)->header('Content-Type', 'text/xml');
    }

    public function detail($url)
    {
        $pivot = [];
        switch($url) {
            case 'bolgeler':
                $pivot['website_panel_areas'] = WebsitePanelSeo::where('website_id',config('app.website.id'))->where('pivot', 'website_panel_area_contents')->get();
                break;
            case 'kategoriler':
                $ana_kategori = WebsitePage::where('page_type', 'kategori_liste')->where('website_id',config('app.website.id'))->first();

                if(!empty($ana_kategori)) {
                    $alt_kategoriler = WebsitePanelSeo::where(['website_id' => config('app.website.id')/*APP_WEBSITE_ID*/, 'pivot' => 'website_panel_categories'])->get();
                    $pivot['website_panel_blog_category_ana_kategori'] = $ana_kategori;
                    $pivot['website_panel_blog_category_pages'] = [];
                    foreach($alt_kategoriler as $alt_kategori):
                        $pivot['website_panel_blog_category_pages'][] = $alt_kategori;
                    endforeach;
                }
                break;
            case 'villa-detaylari':
                $pivot['website_panel_villas'] = cache()->remember('website_panel_villas', 24*60, function() {
                    return Villa::whereHas('seo')->where('status', '1')->get()->pluck('seo');
                });

                break;
            case 'diger-sayfalar':
                $pivot['website_pages'] = WebsitePanelSeo::whereHas('page', function($q){$q->where('status', '1');})->where('website_id',config('app.website.id'))->where('pivot', 'website_pages')->get();
                break;
            case 'blog-kategorileri':
                $pivot['website_panel_blog_categories'] = WebsitePanelSeo::where('website_id',config('app.website.id'))->where('pivot', 'website_panel_blog_categories')->get();
                break;
            case 'blog-sayfalari':
                $pivot['website_panel_blogs'] = WebsitePanelSeo::where('website_id',config('app.website.id'))->where('pivot', 'website_panel_blogs')->get();
                break;
            case 'aktiviteler':
                $pivot['website_panel_extras'] = WebsitePanelSeo::whereHas('page', function($q){$q->where('status', '1');})->where('website_id',config('app.website.id'))->where('pivot', 'website_panel_extras')->get();
                break;
        }



        $view = view('sitemap.index', ['pivot' => $pivot ]);
        return response($view)->header('Content-Type', 'text/xml');
    }
}
