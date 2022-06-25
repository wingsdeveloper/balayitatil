<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelAreaContent extends Model
{
    protected $fillable = [
        'website_id',
        'area_id',
        'description',
        'airport_distance',
        'x_coordinate',
        'y_coordinate',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'banner_image',
        'banner_image_thumb',
        'list_image',
        'list_image_thumb',
    ];
}
