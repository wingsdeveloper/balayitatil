<?php

namespace App\Http\Controllers;

use App\Villa;
use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Artisan;

class VillaBotController extends Controller
{
    protected $websiteId;
    public function __construct()
    {
        $this->websiteId = 15/*APP_WEBSITE_ID*/;
    }
    public function crawlVillaUri()
    {
        $villas = Villa::whereHas('panel_villa')->with(['seo','panel_villa'])->where('status',1)->get();
        ini_set("allow_url_fopen", 1);
        foreach($villas as $key => $row):
            try {
                file_get_contents(route('static', $row->seo->seo_url));
            } catch (\Exception $e) {
                echo  'id: ' . $row->id . ' url : {' . $row->seo->seo_url . '}' . '<br>';
            }
        endforeach;
    }
    public function setVillaUrl()
    {
        $villas = Villa::whereHas('panel_villa')->with(['seo','panel_villa'])->get();
        foreach($villas as $key => $row):
            try {
                DB::table('website_panel_villas')->where('id', $row->panel_villa->id)->where('website_id',15/*APP_WEBSITE_ID*/)->update(['real_url' => route('static', $row->seo->seo_url)]);
            } catch (\Exception $e) {

            }
        endforeach;

    }

    public function updateVillaLinks()
    {
        $reservations = DB::table('pre_reservations')->whereNull('cc_link')->get();
        foreach($reservations as $row):
            DB::table('pre_reservations')->where('id', $row->id)->update(['cc_link' => 'http://www.balayivillasi.com.tr/odeme-yap?code=' . $row->code]);
        endforeach;

    }
    /*CacheTemizle*/
    public function cacheTemizle()
    {
        Artisan::call("cache:clear");
        Artisan::call("view:clear");
    }
}
