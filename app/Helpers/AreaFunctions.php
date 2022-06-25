<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;
use App\{Villa, WebsitePage, Area, WebsitePanelAreaContent, WebsitePanelVilla};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cache;
class AreaFunctions
{

	public static function areaList($req)
	{
		$seo = Helper::getSeo($req->link);
        $meta_seo = $seo;
		$bolge = WebsitePage::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'id' => $seo->item_id])->first();
		$areas = Area::with(['seo' => function($q){
		    $q->where('website_id',15/*APP_WEBSITE_ID*/);
		    $q->where('pivot','website_panel_area_contents');
        },'websitePanelAreaContent' => function($qu){
            $qu->where('website_id',15/*APP_WEBSITE_ID*/);
        }])->paginate(20);

        return view('area.list.index', compact('areas', 'bolge', 'meta_seo'));
	}

	public static function areaDetail($req)
	{

		$seo = Helper::getSeo($req->link);
        $meta_seo = $seo;




                $content = WebsitePanelAreaContent::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'area_id' => $seo->item_id])->first();

//                $villas = Villa::with(['websitePanelVillas' => function($q){
//                        $q->where('website_id',15/*APP_WEBSITE_ID*/);
//                        $q->where('status',1);
//                        $q->select('website_panel_villas.*');
//                    }])
//                    ->select('villas.list_image as orjlist_image','villas.*')
//                    ->when(!empty($req->siralama) && $req->siralama == "artan", function ($query) {
//                        return $query->orderByRAW("CAST(villas.starting_price as DECIMAL(10,2)) ASC");
//                    })->when(!empty($req->siralama) && $req->siralama == "azalan", function ($query) {
//                        return $query->orderByRaw('CAST(villas.starting_price as DECIMAL(10,2)) DESC');
//                    })
//                    ->where(['area_id' => $seo->item_id,'status' => 1])
//                    ->whereNotNull('starting_price')
//                    ->whereNotNull('list_price')
//                    ->paginate(18)
//                    ->appends(['siralama' => $req->siralama]);

//                dd($villas);
//
//

//            $villas = Villa::with(['seo', 'area', 'panel_villa.panel_tag'])->join('website_panel_villas', function ($join) {
//                $join->on('villas.id', '=', 'website_panel_villas.villa_id')
//                    ->where('website_panel_villas.website_id', '=', 15/*APP_WEBSITE_ID*/)
//                    ->where('website_panel_villas.status', '=', 1);
//            })
//                ->when(!empty($req->siralama) && $req->siralama == "artan", function ($query) {
//                    return $query->orderByRAW("CAST(starting_price as DECIMAL(10,2)) ASC");
//                })->when(!empty($req->siralama) && $req->siralama == "azalan", function ($query) {
//                    return $query->orderByRaw('CAST(starting_price as DECIMAL(10,2)) DESC');
//                })
//                ->where('villas.status', 1)->whereNotNull('starting_price')->whereNotNull('list_price')
//                ->where("villas.area_id",$seo->item_id)->where('villas.status', 1)->paginate(18)->appends(['siralama' => $req->siralama]);
//
            $defaultOrder = Cache::remember('website_panel_villa_by_ranking', 72000, function () {
                return WebsitePanelVilla::select('villa_id')->where('website_id', '15')->where('status', '1')->orderBy('ranking')->get()->pluck('villa_id')->toArray();
            });

            $defaultVillas = Cache::remember("villas_by_area" . $seo->item_id, 72000, function () use($seo) {
                return Villa::where('status', '1')
                    ->
                    whereHas('panel_villa')
                    ->where('status', 1)->whereNotNull('list_price')
                    ->where('area_id', $seo->item_id)
                    ->get();
            });

            $villas = Villa::with(['seo', 'area', 'panel_villa.panel_tag', 'panel_villa' => function ($q) {
                    $q->where('website_id', 15)->where('status', 1);
                }])->whereIn('id', $defaultVillas->pluck('id'))
                ->when(!empty($req->siralama) && $req->siralama == "artan", function ($query) {
                    return $query->orderByRAW("CAST(starting_price as DECIMAL(10,2)) ASC");
                })->when(!empty($req->siralama) && $req->siralama == "azalan", function ($query) {
                    return $query->orderByRaw('CAST(starting_price as DECIMAL(10,2)) DESC');
                })->where('status', 1)->whereNotNull('list_price')
                ->when(empty($req->siralama), function ($query) use($defaultOrder) {
                    $ids_ordered= implode(',', $defaultOrder);
                    return
                    $query->orderByRaw("FIELD(id, $ids_ordered)");

                })
                ->paginate(18)
                ->appends(['siralama' => $req->siralama]);


//                $villas = Villa::with(['seo','area','panel_villa.panel_tag'])->where('villas.area_id', $seo->item_id)->
//                when(!empty($req->siralama) && $req->siralama == "artan", function ($query) {
//                    return $query->orderByRAW("CAST(starting_price as DECIMAL(10,2)) ASC");
//                })->when(!empty($req->siralama) && $req->siralama == "azalan", function ($query) {
//                    return $query->orderByRaw('CAST(starting_price as DECIMAL(10,2)) DESC');
//                })->where('status', 1)->whereNotNull('starting_price')->whereNotNull('list_price')
//                    ->paginate(18)->appends(['siralama' => $req->siralama]);
                $area = Area::where('id', $seo->item_id)->first();

                return view('area.detail.index', compact('villas', 'req', 'area', 'content', 'meta_seo'));
	}
}
