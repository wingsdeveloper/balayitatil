<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;

use App\{
    WebsitePanelSeo, WebsitePanelOpportunity, WebsitePage
};
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OpportunityFunctions
{

    public static function opportunities($req)
    {

        Helper::opportunityHistoryClear();
        $seo = Helper::getSeo($req->link);
        $meta_seo = $seo;
        $tarihbas = "";
        $tarihson = "";
        $raw = "";
        if (!empty($req->ay) && !empty($req->gece) ) {
            $ay = ($req->ay < 10 && strlen($req->ay) == 1) ? "0" . $req->ay : $req->ay;
            $raw = "DATEDIFF(end_date, start_date)=" . $req->gece;
            $yil = isset($req->yil) ? $req->yil : date('y');
            $tarihbas = $yil . "-" . $ay . "-01";
            $tarihson = $yil . "-" . $ay . "-31";
        }

        $opportunities = WebsitePanelOpportunity::whereHas('villa')->where('website_id', 15/*APP_WEBSITE_ID*/)
            ->whereDate('end_date', '>', Carbon::now())
            ->when(!empty($req->ay_filtrele), function($q) {
                $q->whereMonth('start_date', request()->ay_filtrele);
            })
            ->when(!empty($req->ay) && !empty($req->gece), function ($q) use ($tarihbas, $tarihson, $raw) {
                $q->where(function ($query) use ($tarihbas, $tarihson, $raw) {
                    $query->where('website_id', 15/*APP_WEBSITE_ID*/);
                    $query->whereRaw($raw);
                    $query->where('start_date', '>=', $tarihbas);
                    $query->where('start_date', '<=', $tarihson);
                })->orWhere(function ($query) use ($tarihbas, $tarihson, $raw) {
                    $query->where('website_id', 15/*APP_WEBSITE_ID*/);
                    $query->whereRaw($raw);
                    $query->where('end_date', '>=', $tarihbas);
                    $query->where('end_date', '<=', $tarihson);
                });
            })
            ->orderBy("start_date")->get();


        foreach ($opportunities as $villa) {
            $fiyat = Helper::gunlukFiyat($villa->villa_id, $villa->start_date, $villa->end_date);
            $villa->toplam = (int)$fiyat[0];
            $villa->gece_sayisi = (int)$fiyat[2];
        }
        $opportunities = $opportunities->where('toplam', '!=', ' ₺');
        $opportunities = $opportunities->where('villa.panel_villa.status', 1);

        if (isset($req->siralama) && !empty($req->siralama)) {
            if ($req->siralama == "azalan") {
                $opportunities = $opportunities->sortByDesc('toplam');
            } else {
                $opportunities = $opportunities->SortBy('toplam');
            }
        }



        $count = count($opportunities);
        $pagination = view('parts.pagination', ['totalCount' => !is_null($opportunities) ? count($opportunities) : 0, 'perPage' => 18, 'page' => $seo->seo_url])->render();
        // dd($pagination);

        if (!isset($_GET['sayfa'])):
            $opportunities = $opportunities->take(18);
        else:

            $opportunities = $opportunities->slice(18 * ($_GET['sayfa'] - 1))->take(18);
        endif;
        $opp = WebsitePage::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'id' => $seo->item_id])->first();
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
        return view('villa.opportunity.index', compact('opportunities', 'opp', 'req', 'count', 'pagination', 'meta_seo', 'aylar'));
    }
}
