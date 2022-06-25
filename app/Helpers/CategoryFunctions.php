<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;

use App\{
    WebsitePanelSeo, WebsitePage, Website, WebsitePanelCategory, WebsitePanelVillaCategory
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryFunctions
{

    public static function categoryList($req)
    {
        $seo = Helper::getSeo($req->link);
        $meta_seo = $seo;
        $link = $req->link;
        $secenek = WebsitePage::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'id' => $seo->item_id])->first();
        $categories = WebsitePanelCategory::orderBy('ranking', 'ASC')->where('website_id', 15/*APP_WEBSITE_ID*/)->where('status', '1')->get();
        return view('villa.category.index', compact('website', 'secenek', 'categories', 'meta_seo', 'link'));
    }

    public static function categoryDetail($req)
    {
        $seo = Helper::getSeo($req->link);
        $meta_seo = $seo;
        $website = Website::with(['categories' => function ($query) use ($req, $seo) {
            $query->where('id', $seo->item_id);
        }])->where('id', 15/*APP_WEBSITE_ID*/)->first();


        $relations = WebsitePanelVillaCategory::select('villa_id')->where('website_id', 15/*APP_WEBSITE_ID*/)->where('villa_category_id', $seo->item_id)->pluck('villa_id');

        $villas = DB::table('villas')->select('villas.list_image as orjlist_image', 'villas.*', 'website_panel_villas.*')->
        whereIn('villas.id', $relations)->
        join('website_panel_villas', function ($join) {
            $join->on('villas.id', '=', 'website_panel_villas.villa_id')
                ->where('website_panel_villas.website_id', '=', 15/*APP_WEBSITE_ID*/)
                ->where('website_panel_villas.status', '=', 1);
        })->when(!empty($req->siralama) && $req->siralama == "artan", function ($query) {
            return $query->orderByRAW("CAST(villas.starting_price as DECIMAL(10,2)) ASC");
        })->when(!empty($req->siralama) && $req->siralama == "azalan", function ($query) {
            return $query->orderByRaw('CAST(villas.starting_price as DECIMAL(10,2)) DESC');
        })->orderBy('website_panel_villas.ranking', 'ASC')->where('villas.status', 1)->whereNotNull('villas.starting_price')->whereNotNull('villas.list_price')->paginate(18)->appends(['siralama' => $req->siralama]);

        $title = 'Kategoriye Ait Villalar';
        return view('villa.category.detail', compact('website', 'villas', 'req', 'title', 'meta_seo'));
    }
}
