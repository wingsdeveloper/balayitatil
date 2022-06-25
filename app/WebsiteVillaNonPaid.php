<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteVillaNonPaid extends Model
{
    protected $fillable = [
        'villa_id',
        'website_id',
        'nonpaid_id'
    ];

    public function villa()
    {
        return $this->belongsTo('App\WebsitePanelVilla', 'villa_id', 'website_id');
    }
}
