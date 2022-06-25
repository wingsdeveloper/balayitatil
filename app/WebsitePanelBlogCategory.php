<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelBlogCategory extends Model
{
    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    public function blog()
    {
        return $this->belongsTo('App\WebsitePanelBlog');
    }

    public function blogs()
    {
        return $this->hasMany('App\WebsitePanelBlog','category_id')->orderBy('id', 'DESC');
    }

    public function area()
    {
        return $this->hasOne('App\Area','id','area_id');
    }

    public function seo()
    {
        return $this->hasOne('App\WebsitePanelSeo','item_id','id');
    }
}
