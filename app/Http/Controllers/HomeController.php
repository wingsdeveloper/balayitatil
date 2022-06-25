<?php

namespace App\Http\Controllers;

use App\Website;
use App\WebsitePanelHomepage;
use App\WebsitePanelOpportunity;
use App\Helpers\Helper;
use Carbon\Carbon;
use Cache, DB;

use ImageProcess;

class HomeController extends Controller
{


    public function index()
    {


        $meta_seo = $home = WebsitePanelHomepage::where('website_id', 15/*APP_WEBSITE_ID*/)->first();
//            cache()->remember('home.meta_seo', 60*24, function() {
//                return WebsitePanelHomepage::where('website_id',2/*APP_WEBSITE_ID*/)->first();
//            });
        $website = Website::with(array('how_articles', 'general_setting'))->where('id', 15/*APP_WEBSITE_ID*/)->first();

//            cache()->remember('home.website', 60*24, function() {
//                return Website::with(array('how_articles','general_setting'))->where('id', 2/*APP_WEBSITE_ID*/)->first();
//            });

//        $populars =
//            cache()->remember('home.populars', 60*24, function() {
//            return Website::with(['homepage_villas','homepage_villatypes'])->where('id',2/*APP_WEBSITE_ID*/)->first();
//        });
        $populars = Website::with(['homepage_villas', 'homepage_villatypes'])->where('id', 15/*APP_WEBSITE_ID*/)->first();
     

      //return $populars->homepage_villas[0]->villa->id;
     //  return Helper::nPrice($populars->homepage_villas[0]->villa->id);
      // return Helper::gunlukFiyat(181,Carbon::now(),Carbon::now()->addDay(1))[1];

        //Tarihi geçen fırsatları siler
        Helper::opportunityHistoryClear();#bunu burdan cikaracak yontem gelistir


        $opportunities = WebsitePanelOpportunity::whereHas('villa.panel_villa', function ($q) {
            $q->where('status', 1);
        })->where('website_id', 15/*APP_WEBSITE_ID*/)
            ->whereDate('end_date', '>', Carbon::now())
            ->orderBy("start_date")->paginate(3);
        $aylar = ['01' => 'Ocak',
            '02' => 'Şubat',
            '03' => 'Mart',
            '04' => 'Nisan',
            '05' => 'Mayıs',
            '06' => 'Haziran',
            '07' => 'Temmuz',
            '08' => 'Ağustos',
            '09' => 'Eylül',
            '10' => 'Ekim',
            '11' => 'Kasım',
            '12' => 'Aralık'];
        $transAylar = array_flip($aylar);

        //SELECT count(DATEDIFF(end_date, start_date)), DATEDIFF(end_date, start_date) AS DateDiff FROM `website_panel_opportunities` GROUP BY DateDiff;
        foreach ($aylar as $i => $ay) {
            $tarihbas = date("Y") . "-" . $i . "-01";
            $tarihson = date("Y") . "-" . $i . "-31";

            $tarihbasNext = date("Y")+1 . "-" . $i . "-01";
            $tarihsonNext = date("Y")+1 . "-" . $i . "-31";

            $raw = "DATEDIFF(end_date, start_date)>2 AND DATEDIFF(end_date, start_date)<7";

            if (strtotime(date("Y-m-01")) <= strtotime($tarihbas)) {
                $temporaries[$ay] = WebsitePanelOpportunity::whereHas('villa')->selectRaw('count(DATEDIFF(end_date, start_date)) as count, DATEDIFF(end_date, start_date) AS geceFarki')->where('website_id', 15/*APP_WEBSITE_ID*/)
                    ->whereDate('end_date', '>', Carbon::now())
                    ->where(function ($query) use ($tarihbas, $tarihson, $raw) {
                        $query->where('website_id', 15/*APP_WEBSITE_ID*/);
                        $query->whereRaw($raw);
                        $query->where('start_date', '>=', $tarihbas);
                        $query->where('start_date', '<=', $tarihson);
                    })->orWhere(function ($query) use ($tarihbas, $tarihson, $raw) {
                        $query->where('website_id', 15/*APP_WEBSITE_ID*/);
                        $query->whereRaw($raw);
                        $query->where('end_date', '>=', $tarihbas);
                        $query->where('end_date', '<=', $tarihson);
                    })
//                ->whereDate('start_date', '>=', $tarihbas)
//                ->whereDate('start_date', '<=', $tarihson)

                    ->groupBy("geceFarki")->get();
            }

            if (strtotime(date('Y-01-01',strtotime(date("Y-m-d", mktime()) . " + 365 day"))) <= strtotime($tarihbasNext)) {

                $temporariesNext[$ay] = WebsitePanelOpportunity::whereHas('villa')->selectRaw('count(DATEDIFF(end_date, start_date)) as count, DATEDIFF(end_date, start_date) AS geceFarki')->where('website_id', 15/*APP_WEBSITE_ID*/)
                    ->whereDate('end_date', '>', Carbon::now())
                    ->where(function ($query) use ($tarihbasNext, $tarihsonNext, $raw) {
                        $query->where('website_id', 15/*APP_WEBSITE_ID*/);
                        $query->whereRaw($raw);
                        $query->where('start_date', '>=', $tarihbasNext);
                        $query->where('start_date', '<=', $tarihsonNext);
                    })->orWhere(function ($query) use ($tarihbasNext, $tarihsonNext, $raw) {
                        $query->where('website_id', 15/*APP_WEBSITE_ID*/);
                        $query->whereRaw($raw);
                        $query->where('end_date', '>=', $tarihbasNext);
                        $query->where('end_date', '<=', $tarihsonNext);
                    })
//                ->whereDate('start_date', '>=', $tarihbas)
//                ->whereDate('start_date', '<=', $tarihson)

                    ->groupBy("geceFarki")->get();
            }
        }



        $video = Helper::video($website->general_setting->video_url);
//            cache()->remember('home.video', 60*24, function() use($website) {
//                return Helper::video($website->general_setting->video_url);
//            });
        $pop_content = DB::table('website_homepage_contents')->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'id' => config("app.HOMEPAGE_POPULAR_VILLAS")])->first();
        $short_villas_content = DB::table('website_homepage_contents')->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'id' => config("app.HOMEPAGE_SHORT_TIME_VILLAS")])->first();
//            cache()->remember('home.pop_content', 60*24, function() use($website) {
//                return DB::table('website_homepage_contents')->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'id' => 7])->first();
//            });
        $compact = ['website', 'populars', 'campaigns', 'opportunities',
            'temporaries', 'temporariesNext', 'popular_name',
            'temporary_name', 'opportunity_name', 'home', 'video', 'meta_seo', 'pop_content', 'transAylar', 'short_villas_content'];

        $view = 'home.index';
        return view($view, compact($compact));
    }
}
