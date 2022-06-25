<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelAboutWorker extends Model
{
    public function about()
    {
        return $this->belongsTo('App\WebsitePanelAbout');
    }
}
