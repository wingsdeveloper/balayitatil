<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelAboutOfficePhoto extends Model
{
    protected $fillable = [
        'website_id',
        'about_id',
        'office_photo_name',
        'office_photo_size',
        'office_photo_type',
        'office_photo_ranking',
        'office_photo',
        'office_photo_thumb',
        'is_vertical',
    ];
    public function about()
    {
        return $this->belongsTo('App\WebsitePanelAbout');
    }
}
