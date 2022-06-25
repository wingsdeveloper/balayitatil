<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteVillaPaidIn extends Model
{
    protected $fillable = [
        'villa_id',
        'website_id',
        'paidin_id'
    ];

    public function villa()
    {
        return $this->belongsTo('App\WebsitePanelVilla', 'website_id', 'villa_id');
    }
}
