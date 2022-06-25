<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;

use App\{WebsitePanelExtra,
    WebsitePanelSeo,
    Villa,
    villaOwner,
    VillaFloor,
    villaPrice,
    Website,
    PaidIn,
    NonPaid,
    Prominent,
    WebsitePage,
    WebsitePanelVilla};
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VillaFunctions
{

    public static function villaDetail($req)
    {
//        Artisan::call('cache:clear');


        $meta_seo = $seo = WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'seo_url' => $req->link, 'pivot' => 'website_panel_villas'])->first();
//            cache()->remember('villa.' . $req->link . '.seo', 60 * 24, function () use ($req) {
//                return WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'seo_url' => $req->link, 'pivot' => 'website_panel_villas'])->first();
//            });

        $villa = Villa::where('id', $seo->item_id)->where('villas.status', 1)
            ->with(['floors.floor', 'floors.parts.photos.photo', 'floors.parts.part',
                'floors.parts.materials.material',
                'panel_villa', 'area.airportRel.airport' ])->first();

        if(empty($villa->panel_villa)) {
            $exists = WebsitePanelVilla::where('website_id', 15)->where('villa_id', $seo->item_id)->where('status', '0')->first();
            if(!empty($exists)) {
                return redirect()->route('home');
            }
            abort(404);
        }

        if(empty($villa)):
            abort(404);
        endif;
        if($villa->status == 0):
            return redirect()->route('home');
        endif;

        if(!empty($villa->panel_villa)) {
            if($villa->panel_villa->status == 0) {
                return abort(404);
            }
        }
//        $villa = cache()->remember('villa.' . $req->link . '.link', 60 * 24, function () use ($seo) {
//            return Villa::where('id', $seo->item_id)->where('villas.status', 1)
//                ->with(['floors.floor', 'floors.parts.photos.photo', 'floors.parts.part',
//                    'floors.parts.materials.material',
//                    'panel_villa' ])->firstOrFail();
//
////            return Villa::with(['floors.floor', 'floors.parts' => function($q) use($seo) {
////
////            }])->where("id", $seo->item_id)->where('villas.status', 1)->firstOrFail();
//        });

        if (!isset($villa)) {
//            cache()->forget('villa.' . $req->link . '.link');
//            cache()->forget('villa.' . $req->link . '.seo');
            return redirect()->to('/villa-secenekleri')->with('error', 'Villa Bulunamadı');
        }




//        $owners = villaOwner::orderBy('name', 'ASC')->get();
        $vfloors = VillaFloor::where('villa_id', $villa->id)->get();
//        $vfloors = cache()->remember('villa.' . $req->link . '.vfloors', 60 * 24, function () use ($villa) {
//            return VillaFloor::where('villa_id', $villa->id)->get();
//        });


        $prices = villaPrice::where('villa_id', $villa->id)->whereDate('end_date', '>', Carbon::now())->whereNotNull("start_date")->whereNotNull("end_date")->orderBy('start_date', 'ASC')->get();
        $orderbyraw = "CAST(daily_price_tl AS DECIMAL(10,2)) ASC";
        $pricesmin = villaPrice::select("daily_price_tl")->where('villa_id', $villa->id)->where("daily_price_tl", ">", 0)->whereDate('end_date', '>', Carbon::now())->whereNotNull("start_date")->whereNotNull("end_date")->
        orderByRaw($orderbyraw)->first();

        $website = Website::with(array('how_articles' => function ($query) {
            $query->where('show_villa', 1);
        }, 'general_setting'))->where('id', 15/*APP_WEBSITE_ID*/)->first();

//            = cache()->remember('villa.' . $req->link . '.website', 60 * 24, function () use ($villa) {
//            return Website::with(array('how_articles' => function ($query) {
//                $query->where('show_villa', 1);
//            }, 'general_setting'))->where('id', 2/*APP_WEBSITE_ID*/)->first();
//        });

        $prominentids = $villa->prominents->pluck('prominent_id')->toArray();

        if (count($villa->panel_villa->paidin)>0){
            $villapaidin_ids = $villa->panel_villa->paidin->pluck('paidin_id')->toArray();
        }else{
            $villapaidin_ids = $villa->paidin->pluck('paidin_id')->toArray();
        }

        if (count($villa->panel_villa->nonpaid)>0){
            $villanonpaid_ids = $villa->panel_villa->nonpaid->pluck('nonpaid_id')->toArray();
        }else{
            $villanonpaid_ids = $villa->nonpaid->pluck('nonpaid_id')->toArray();
        }

        if (isset($prominentids))
            $prominents = Prominent::whereIn('id', $prominentids)->get();

        if (isset($villapaidin_ids)):
            $paidins = PaidIn::whereIn('id', $villapaidin_ids)->get();
//                cache()->rememberForever('villa.' . $req->link . '.paidin', function () use ($villapaidin_ids) {
//                return PaidIn::whereIn('id', $villapaidin_ids)->get();
//            });
        endif;

        if (isset($villanonpaid_ids)):
            $nonpaids = NonPaid::whereIn('id', $villanonpaid_ids)->get();

//                cache()->rememberForever('villa.' . $req->link . '.nonpaidin', function () use ($villanonpaid_ids) {
//                return NonPaid::whereIn('id', $villanonpaid_ids)->get();
//            });
        endif;
        if (isset($prominentids)):
            $prominent = Prominent::whereIn('id', $prominentids)->get();
//                cache()->rememberForever('villa.' . $req->link . '.nonpaidin', function () use ($prominentids) {
//                return Prominent::whereIn('id', $prominentids)->get();
//            });
        endif;

        $video = Helper::video($villa->panel_villa->video_url);
//            cache()->rememberForever('villa.' . $req->link . '.video', function () use ($villa) {
//            return Helper::video($villa->panel_villa->video_url);
//        });
        $nasil_kiralarim_video = Helper::video($website->general_setting->video_url);
//            cache()->rememberForever('nasil-kiralarim-video', function () use ($website) {
//            return Helper::video($website->general_setting->video_url);
//        });

        $extras = WebsitePanelExtra::with(['extra_galleries' => function ($qu) {
            $qu->where('website_id', 15/*APP_WEBSITE_ID*/);
        }, 'seo' => function ($q) {
            $q->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'pivot' => 'website_panel_extras']);
        }])->where('website_id', 15/*APP_WEBSITE_ID*/)->oldest()->take(2)->get();

//            cache()->remember('extras', 60 * 48, function () use ($villa) {
//            return WebsitePanelExtra::with(['extra_galleries' => function ($qu) {
//                $qu->where('website_id', 2/*APP_WEBSITE_ID*/);
//            }, 'seo' => function ($q) {
//                $q->where(['website_id' => 2/*APP_WEBSITE_ID*/, 'pivot' => 'website_panel_extras']);
//            }])->where('website_id', 2/*APP_WEBSITE_ID*/)->oldest()->take(2)->get();
//        });

        return view('villa.detail.index', compact('panelVilla', 'website',
            'prices', 'pricesmin', 'paidins', 'nonpaids', 'prominentids',
            'prominents', 'paidins', 'nonpaids', 'categories', 'villa', 'title', 'vfloors'
            , 'parts', 'req',
            'extras', 'video', 'nasil_kiralarim_video', 'seo', 'meta_seo'));

    }

    public static function villaList($req)
    {

        $meta_seo = $seo = Helper::getSeo($req->link);
        $kiralik = WebsitePage::where(['page_type' => 'villa_liste', 'website_id' => 15/*APP_WEBSITE_ID*/, 'id' => $seo->item_id])->first();
        $villas = DB::table('villas')->select('villas.list_image as orjlist_image', 'villas.*', 'website_panel_villas.*')->
        join('website_panel_villas', function ($join) {
            $join->on('villas.id', '=', 'website_panel_villas.villa_id')
                ->where('website_panel_villas.website_id', '=', 15/*APP_WEBSITE_ID*/)
                ->where('website_panel_villas.status', '=', 1);
        })->when(!empty($req->siralama) && $req->siralama == "artan", function ($query) {
            return $query->orderByRAW("CAST(villas.starting_price as DECIMAL(10,2)) ASC");
        })->when(!empty($req->siralama) && $req->siralama == "azalan", function ($query) {
            return $query->orderByRaw('CAST(villas.starting_price as DECIMAL(10,2)) DESC');
        })->when(empty($req->siralama), function ($query) {
            return $query->orderBy('website_panel_villas.ranking', 'ASC');
        })
            ->where('villas.status', 1)->whereNotNull('starting_price')->whereNotNull('list_price')->paginate(18)->appends(['siralama' => $req->siralama]);
        return view('villa.list.index', compact('villas', 'req', 'kiralik', 'meta_seo'));
    }
}
