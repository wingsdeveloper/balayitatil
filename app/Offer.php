<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //

    protected $fillable = ['start_date','end_date','villas','website_id','note','customer_id','type','uid','offer_ids'];

    public function customer(){
        return $this->belongsTo('App\Customer');
    }

    public function website(){
        return $this->belongsTo('App\Website');
    }


}
