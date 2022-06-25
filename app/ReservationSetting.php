<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationSetting extends Model
{
    //
    protected $fillable = ['name', 'value', 'type', 'status'];
}
