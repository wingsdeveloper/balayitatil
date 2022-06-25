<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelGeneralsetting extends Model
{
    protected $fillable = [
        'website_id',
        'general_description',
        'spring',
        'summer',
        'autumn',
        'winter',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'offer_successfull_message',
        'video_url',
        'video_image',
        'video_image_thumb',
        'address_1',
        'address_2',
        'address_1_coordinate',
        'address_2_coordinate',
        'phone_1',
        'phone_2',
        'fax',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'pinterest',
        'vimeo',
        'youtube',
        'google_verification_code',
        'google_analytical_code',
        'yandex_metrica_code',
        'prepayment_rate'
    ];

    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    public function villa_types()
    {
        return $this->hasMany('App\WebsitePanelGeneralsettingVillatype', 'generalsetting_id');
    }
}
