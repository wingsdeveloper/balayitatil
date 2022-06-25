<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name','fly_dalaman','fly_antalya','bus','car','image','description'];

    public function districts()
    {
        return $this->hasMany('App\District');
    }

    public function blog_categories()
    {
        return $this->hasMany('App\WebsitePanelBlogCategory');
    }

    public function seo()
    {
        return $this->hasOne('App\WebsitePanelSeo','item_id','id')->where('pivot', 'website_panel_area_contents');
    }

    public function websitePanelAreaContent()
    {
        return $this->hasOne('App\WebsitePanelAreaContent','area_id','id');
    }

    public function villa()
    {
        return $this->hasMany(Villa::class, 'area_id', 'id');
    }

    public function airportRel()
    {
        return $this->hasMany(AirportAreaRel::class, 'area_id', 'id')->where('status', '1');

    }
}
