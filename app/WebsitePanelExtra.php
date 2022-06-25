<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelExtra extends Model
{
    public function extra_galleries()
    {
        return $this->hasMany('App\WebsitePanelExtraGallery','extra_id')->orderBy('ranking','ASC');
    }

    public function seo()
    {
        return $this->hasOne('App\WebsitePanelSeo','item_id','id');
    }
}
