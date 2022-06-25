<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelContactNotification extends Model
{
    protected $fillable = [
        'website_id',
        'name',
        'surname',
        'phone',
        'email',
        'message'
    ];
}
