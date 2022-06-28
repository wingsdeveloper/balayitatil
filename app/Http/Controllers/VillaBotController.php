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
        $villas = Villa::whereHas('panel_villa')->with(['seo', 'panel_villa'])->where('status', 1)->get();
        if(request()->isMethod('POST')) {

            $villa = Villa::with('seo')->find(request()->id);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,route('static', $villa->seo->seo_url));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = [
                'User-agent: Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3',
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_exec($ch);

            if (!curl_errno($ch)) {
                switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                    case 200:  # OK
                        cache()->put('ev-villa-mobile-' . $villa->id, true, 60000);
                        return response()->json(['success' => true]);
                        break;
                    default:
                        if(cache()->has('ev-villa-mobile-' . $villa->id)) {
                            cache()->forget('ev-villa-mobile-' . $villa->id);
                        }
                        return response()->json(['success' => false, 'aciklama' => $villa->name . ' acilamadi']);
                }
            }
            curl_close ($ch);
            return response()->json(['success' => false, 'aciklama' => $villa->name . ' acilamadi']);
        }
        return view('crawl.index', ['villas' => $villas]);
    }
    public function crawlVillaUriDesktop()
    {
        $villas = Villa::whereHas('panel_villa')->with(['seo', 'panel_villa'])->where('status', 1)->get();
        if(request()->isMethod('POST')) {

            $villa = Villa::with('seo')->find(request()->id);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,route('static', $villa->seo->seo_url));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = [
                #'User-agent: Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3',
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_exec($ch);

            if (!curl_errno($ch)) {
                switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                    case 200:  # OK
                        cache()->put('ev-villa-desktop-' . $villa->id, true, 60000);
                        return response()->json(['success' => true]);
                        break;
                    default:
                        if(cache()->has('ev-villa-desktop-' . $villa->id)) {
                            cache()->forget('ev-villa-desktop-' . $villa->id);
                        }
                        return response()->json(['success' => false, 'aciklama' => $villa->name . ' acilamadi']);
                }
            }
            curl_close ($ch);
            return response()->json(['success' => false, 'aciklama' => $villa->name . ' acilamadi']);
        }
        return view('crawl.desktop', ['villas' => $villas]);
    }
    public function setVillaUrl()
    {
        $villas = Villa::whereHas('panel_villa')->with(['seo','panel_villa'])->get();
        foreach($villas as $key => $row):
            try {
                DB::table('website_panel_villas')->where('id', $row->panel_villa->id)->where('website_id',5/*APP_WEBSITE_ID*/)->update(['real_url' => route('static', $row->seo->seo_url)]);
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
        Artisan::call('cache:clear');
    }
}
