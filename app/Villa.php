<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{

    protected $fillable = [
        'name',
        'code',
        'owner_id',
        'comission_rate',
        'category_id',
        'prepayment_rate',
        'min_accommodation',
        'min_accommodation_season',
        'max_adult',
        'max_child',
        'max_baby',
        'area_id',
        'district_id',
        'slogan',
        'number_person',
        'number_bathroom',
        'number_bedroom',
        'coordinate_x',
        'coordinate_y',
        'airport_distance',
        'sea_distance',
        'hospital_distance',
        'restaurant_distance',
        'center_distance',
        'shop_distance',
        'video_url',
        'villa_seo_url',
        'description',
        'damage_deposit_amount_required',
        'damage_deposit_receiver',
        'damage_deposit_amount',
        'accommodation_time',
        'calendar_manager_name',
        'calendar_manager_phone',
        'calendar_management',
        'whatssap_group',
        'maintaner_name',
        'maintaner_phone',
        'key_box_password',
        'wifi_password',
        'customer_welcome_status',
        'private_customer_welcome_status',
        'identity_notification',
        'payment_note',
        'status',
        'list_price',
        'starting_price',
        'list_image',
        'list_image_thumb',
        'list_image_name',
        'whatsapp_group_name',
        'checkin_time',
        'checkout_time',
        'banner_image',
        'banner_image_thumb',
        'enterance_manager',
        'enterance_manager_phone'
    ];

    public function owner()
    {
        return $this->belongsTo('App\villaOwner', 'owner_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\villaCategory', 'villa_category', 'villa_id', 'villa_category_id');
    }

    public function websiteCategories()
    {
        return $this->belongsToMany('App\villaWebsiteCategory', 'villa_website_category', 'website_id', 'villa_id', 'villa_category_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public function paidin()
    {
        return $this->hasMany('App\VillaPaidIn');
    }

    public function nonpaid()
    {
        return $this->hasMany('App\VillaNonPaid');
    }

    public function prominents()
    {
        return $this->hasMany('App\villaProminents');
    }

    public function manual_calendars()
    {
        return $this->hasMany('App\ManualCalendar');
    }

    public function prices()
    {
        return $this->hasMany('App\villaPrice');
    }
    public function panel_villa()
    {
        return $this->hasOne('App\WebsitePanelVilla','villa_id','id')->where(['website_id'=>15/*APP_WEBSITE_ID*/, 'status' => 1]);
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'distirct_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany('App\VillaPhoto','villa_id','id')->orderBy('ranking');
    }

    public function seo()
    {
        return $this->hasOne('App\WebsitePanelSeo','item_id','id')->where(['website_id'=>15/*APP_WEBSITE_ID*/,'pivot'=>'website_panel_villas']);
    }

    public function floors()
    {
        return $this->hasMany('App\VillaFloor', 'villa_id', 'id')->orderBy('floor_ranking');
    }

}
