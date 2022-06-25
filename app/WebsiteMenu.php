<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteMenu extends Model
{
    protected $fillable = ['website_id','menu_name'];

    public function website()
    {
        return $this->belongsTo('App\Website');
    }
}
