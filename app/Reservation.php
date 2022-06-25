<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'villa_id',
        'customer_id',
        'company_id',
        'price',
        'adult_count',
        'child_count',
        'baby_count',
        'start_date',
        'end_date',
        'status',
        'entry_payment',
        'pre_payment',
        'cleaning_payment',
        'total_price',
        'note',
        'website_id',
        'code',
        'idnumber',
        'tc',
        'address',
        'fatura_kesilecek'
    ];
    public $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];

    public function villa()
    {
        return $this->belongsTo('App\Villa', 'villa_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function statusSetting()
    {
        return $this->belongsTo('App\ReservationSetting', 'status', 'id');
    }
}
