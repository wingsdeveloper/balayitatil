<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelVillaCategory extends Model
{
    public $timestamps = false;
    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id')->where('status', 1);
    }
}
