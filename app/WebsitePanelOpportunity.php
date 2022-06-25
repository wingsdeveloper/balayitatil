<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WebsitePanelOpportunity extends Model
{
    protected $fillable = [
        'website_id',
        'villa_id',
        'start_date',
        'end_date',
        'ranking'
    ];
    public function villa(){
        return $this->hasOne('\App\Villa','id','villa_id')->with(['area','panel_villa','seo'])->where('status',1);
    }
    public function tarihPara($x){
        if(!empty($x->start_date)){
            $start=iconv('latin5','utf-8',\Carbon\Carbon::parse($x->start_date)->formatLocalized('%d %b'));
        }else{$start="";}
        if(!empty($x->end_date)){
            $end=iconv('latin5','utf-8',\Carbon\Carbon::parse($x->end_date)->formatLocalized('%d %b'));
        }else{$end="";}

        $giris = Carbon ::parse($x->start_date);
        $cikis = Carbon ::parse($x->end_date);
        $gun_farki    = $giris -> diffInDays($cikis, false);
        $gunlukFiyat=Helper::gunlukFiyat($x->villa_id,$giris,$cikis);

        $collection =collect(array('gunlukFiyat'=>$gunlukFiyat,'gun_farki'=>$gun_farki,'start'=>$start,'end'=>$end));
        return $collection;
    }
}
