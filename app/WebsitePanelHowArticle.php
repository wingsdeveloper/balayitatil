<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelHowArticle extends Model
{
    protected $fillable = ['id', 'category_id', 'title', 'short_text', 'long_text', 'show_website', 'show_villa'];

    public function website()
    {
        return $this->belongsTo('App\Website', 'website_id');
    }


}
