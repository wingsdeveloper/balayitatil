<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteWhatsappPhone extends Model
{
    protected $fillable = [
        'number', 'website_id', 'status'
    ];
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id', 'id');
    }
}
