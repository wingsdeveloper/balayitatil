<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelAboutManager extends Model
{
    public function about()
    {
        return $this->belongsTo('App\WebsitePanelAbout');
    }
}
