<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteHomepageContent extends Model
{
    protected $fillable = [
        'website_id',
        'content_type',
        'content_name',
        'content_description'
    ];
}
