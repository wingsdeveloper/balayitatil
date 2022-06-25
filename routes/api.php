<?php

use App\Models\Api\Villa;
use Illuminate\Http\Request;
use App\Models\VillaPriceNew;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('kampanya-villadetay/{id}',function($id) {
    $villa = Villa::where('id', $id)->where('villas.status', 1)
    ->with(['panel_villa','photos','area','seo'])->with(['prices'=>function($query)  {
        return $query->whereYear('start_date','=',date('Y'));

    }])->first();
/** aylara göre en düşük fiyat */
$pricenews=VillaPriceNew::select(DB::raw('min(CAST(daily_price_tl AS decimal(18,0))) as price'), DB::raw("DATE_FORMAT(date, '%m-%Y') new_date"),  DB::raw('YEAR(date) year, MONTH(date) month'))->where('villa_id',$id)
->whereYear('date',date('Y'))
->groupby('year','month')
->get();
      

      if (isset($villa->prices->first()->min_accommodation) && ($villa->prices->first()->min_accommodation>0)) {
        $min_accommodation = $villa->prices->first()->min_accommodation;
    } else {
       
         $min_accommodation = (isset($villa->min_accommodation) ? $villa->min_accommodation : 0);
       
    }
    $villaDetail['name']=$villa->name;
    $villaDetail['code']=$villa->code;
    $villaDetail['night']=$villa->starting_price;
    $villaDetail['gece']=(isset($pricesmin->daily_price_tl)? ceil($gune_ait_fiyat):'');
    $villaDetail['number_person']=$villa->number_person;
    $villaDetail['number_bathroom']=$villa->number_bathroom;
    $villaDetail['number_bedroom']=$villa->number_bedroom;
    $villaDetail['min_accommodation']= $min_accommodation;
    $villaDetail['area']=$villa->area->name;
    $villaDetail['link']='https://villakalkan.com.tr/'.$villa->seo->seo_url;
    /* fiyat */
    foreach($pricenews as $price) {
        $villaDetail['prices'][$price->month]=$price->price;
      }
/* resim */
      foreach($villa->photos as $photo) {
        $villaDetail['photos'][]= 'https://villakalkan.com.tr/villa/'.$photo->path.'/'.$photo->name;
      }
      return $villaDetail;
});