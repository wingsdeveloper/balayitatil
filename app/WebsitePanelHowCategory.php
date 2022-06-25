<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelHowCategory extends Model
{
    protected $fillable = ['name'];

    public function website()
    {
        return $this->belongsTo('App\Website', 'website_id');
    }

    public function articles()
    {
        return $this->hasMany('App\WebsitePanelHowArticle','category_id','id');
    }
}
