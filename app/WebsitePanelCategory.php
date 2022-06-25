<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelCategory extends Model
{
    protected $fillable = ['name', 'description', 'image', 'seo_url', 'seo_title', 'seo_description', 'seo_keywords'];

    public function website()
    {
        return $this->belongsTo('App\Website', 'website_id');
    }
    public function panel_seo()
    {
        return $this->hasOne('App\WebsitePanelSeo', 'item_id', 'id')->where('pivot', 'website_panel_categories');
    }

}
