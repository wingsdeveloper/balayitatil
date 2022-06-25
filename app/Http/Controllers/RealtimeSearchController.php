<?php

namespace App\Http\Controllers;

use App\Villa;
use App\Helpers\Helper;
use App\WebsitePanelCategory;
use App\WebsitePanelVilla;
use App\WebsitePanelSeo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Area;
use Illuminate\Support\Facades\DB;

class RealtimeSearchController extends Controller
{
    public function search(Request $req)
    {
        $villas = Villa::whereHas('seo')->with('panel_villa')->where('status', 1)->
            where(function($query) use($req) {
                $query->where('name', 'LIKE', '%' . $req->search . '%')
                    ->orWhere('code', 'LIKE', '%' . $req->search . '%');
            })->limit(10)->get();

        foreach ($villas as $villa) {
           /* if(empty($villa->list_image)){
                $resim="uploads/villa/gallery/$villa->orjlist_image/$villa->list_image_name";
            }else{
                $resim=$villa->list_image;
            }*/

            $seo = isset($villa->seo) ? $villa->seo->seo_url : '';

            $array[]=array(
                "villa_id"=>$villa->villa_id,
                "name"=>$villa->name,
                "code"=>$villa->code,
                "seo"=>$seo,
                "area_id"=>$villa->area_id,
               /* "image"=>$resim*/
                );
        }

        if(isset($villa)){
           $array=array('status'=>true,'data'=>$array);
       }else{

           $array=array('status'=>false,'data'=>'');
       }


       echo json_encode($array);

   }
    public function searchAlt(Request $req)
    {

        $villa_ids = WebsitePanelVilla::where('website_id',15)->pluck('villa_id');


        $villas = Villa::with('panel_villa', 'area', 'seo')->whereIn("id",$villa_ids)->where('status', 1)->where(function ($query) use ($req) {
            $query->where('name', 'LIKE', '%' . $req->search . '%')
                ->orWhere('code', 'LIKE', '%' . $req->search . '%');
        })->limit(10)->get();

        $areas = Area::where('name', 'LIKE', '%' . $req->search . '%')->with('seo', 'websitePanelAreaContent')->limit(5)->get();
        $category = WebsitePanelCategory::with('panel_seo')->where('website_id', 15/*APP_WEBSITE_ID*/)->where('name', 'LIKE', '%' . $req->search . '%')->where('status', '1')->limit(10)->get();

        foreach ($villas as $villa) {
            /* if(empty($villa->list_image)){
                 $resim="uploads/villa/gallery/$villa->orjlist_image/$villa->list_image_name";
             }else{
                 $resim=$villa->list_image;
             }*/
            $resim = !empty($villa->list_image)?$resim="uploads/villa/gallery/".$villa->list_image."/".$villa->list_image_name:$resim=$villa->panel_villa->list_image;

            $seo = isset($villa->seo) ? $villa->seo->seo_url : '';
            $array[]=array(
                "villa_id"=>$villa->id,
                "name"=>$villa->name,
                "code"=>$villa->code,
                "seo"=>$seo,
                "area_id"=>$villa->area_id,
                "resim" => $resim
                /* "image"=>$resim*/
            );
        }

       $view = view('ux.realtimeSearch.content', ['villas' => $array, 'areas' => $areas, 'categories' => $category ])->render();

        if(!empty($villas) || !empty($areas)):
            $status = true;
        else:
            $status = false;
        endif;

        return response()->json(['view' => $view, 'status' => $status]);
   }
}
