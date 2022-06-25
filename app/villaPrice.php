<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class villaPrice extends Model
{
    //

    protected $fillable = ['daily_price_tl', 'daily_price_usd', 'start_date', 'end_date', 'villa_id', 'special_comission', 'short_stay', 'less_price', 'highest_price'];
    public $timestamps = false;

    public $dates = ['start_date', 'end_date'];

    public function villa()
    {
        return $this->belongsTo('App\Villa');
    }
}
