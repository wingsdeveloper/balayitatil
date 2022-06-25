<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelContact extends Model
{
    protected $fillable = [
        'website_id',
        'location',
        'address',
        'x_coordinate',
        'y_coordinate',
        'phone',
        'email',
        'facebook',
        'twitter',
        'instagram'
    ];
}
