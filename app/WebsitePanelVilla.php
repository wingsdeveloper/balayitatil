<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelVilla extends Model
{
  protected $fillable = [
        'villa_id',
        'list_image',
        'video_url'
    ];

    public function villa()
    {
        return $this->belongsTo('App\Villa','villa_id');
    }

    public function paidin()
    {
        return $this->hasMany('App\WebsiteVillaPaidIn', 'villa_id','villa_id')->where('website_id',15/*APP_WEBSITE_ID*/);
    }

    public function nonpaid()
    {
        return $this->hasMany('App\WebsiteVillaNonPaid', 'villa_id','villa_id')->where('website_id',15/*APP_WEBSITE_ID*/);
    }

    public function prices()
    {
        return $this->hasMany('App\villaPrice', 'id', 'villa_id');
    }

    public function panel_tag()
    {
        return $this->hasOne('App\WebsitePanelTag', 'id', 'tag_id')->where('website_id',15/*APP_WEBSITE_ID*/);
    }


}
