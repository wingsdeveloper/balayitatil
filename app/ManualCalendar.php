<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualCalendar extends Model
{
    //
    protected $fillable = ['villa_id', 'start_date', 'end_date', 'status_id', 'status', 'description'];
    public $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];

    public function villa()
    {
        return $this->belongsTo('App\Villa');
    }

    public function statusSetting()
    {
        return $this->belongsTo('App\CalendarSetting', 'status_id');
    }
}
