<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillaPriceNew extends Model
{


    protected $table='villa_prices_new';

    protected $fillable = ['daily_price_tl',  'date', 'villa_id'];
    public $timestamps = false;

    public $dates = ['date'];

    
}
