<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelAboutDocument extends Model
{
    public function about()
    {
        return $this->belongsTo('App\WebsitePanelAbout');
    }
}
