<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteHomepageVilla extends Model
{
    protected $fillable = [
        'website_id',
        'villa_type_id',
        'villa_id'
    ];

    public function month_of_villa()
    {
        return $this->hasOne('App\Villa','id','villa_id');
    }

    public function villa()
    {
        return $this->hasOne('App\Villa','id','villa_id')->with(['area','panel_villa','seo']);
    }
}
