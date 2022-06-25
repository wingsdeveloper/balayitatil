<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePage extends Model
{
    protected $guarded = [
        'website_id',
        'page_name',
        'type',
        'link',
        'status',
        'static_seo_keywords',
        'static_seo_title',
        'static_seo_description',
        'dynamic_seo_title',
        'dynamic_seo_keywords',
        'dynamic_seo_description',
        'dynamic_description',
        'dynamic_banner_size',
        'dynamic_image_thumb',
        'another_link'
    ];

    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    public function menus()
    {
        return $this->hasOne('App\WebsiteMenu','page_id');
    }

    public function seo()
    {
        return $this->hasOne('App\WebsitePanelSeo','item_id','id');
    }
}
