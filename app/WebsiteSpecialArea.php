<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteSpecialArea extends Model
{
    protected $fillable = ['website_id','content_type','content_name','content_description'];

    public function website()
    {
        return $this->belongsTo('App\Website');
    }
}
