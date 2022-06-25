<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelGeneralsettingVillatype extends Model
{
    protected $fillable = [
        'website_id',
        'generalsetting_id',
        'villa_type_name',
        'villa_type_image',
        'villa_type_image_thumb'
    ];

    public function general_setting()
    {
        return $this->belongsToMany('App\WebsitePanelGeneralsetting');
    }
}
