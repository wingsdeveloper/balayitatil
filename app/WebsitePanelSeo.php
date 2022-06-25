<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelSeo extends Model
{
    protected $fillable = ['website_id','seo_url','item_id','pivot'];
    
    public function page()
    {
        return $this->hasOne('App\WebsitePage','id','item_id');
    }
}
