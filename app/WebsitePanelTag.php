<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelTag extends Model
{
    protected $fillable = [
        'website_id',
        'name',
        'color'
    ];
}
