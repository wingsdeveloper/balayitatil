<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelHomepage extends Model
{
    protected $fillable = [
        'website_id',
        'banner_title',
        'banner_subtitle',
        'banner_description',
        'banner_image_pc',
        'banner_image_pc_thumb',
        'banner_image_mobile',
        'banner_image_mobile_thumb',
    ];
}
