<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteHomepageVillatype extends Model
{
    protected $fillable = ['website_id','type_name','type_slug'];

    public function villas()
    {
        return $this->hasMany('App\WebsitePanelHomepageVilla','villa_type_id','id');
    }
}
