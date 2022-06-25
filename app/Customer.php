<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = ['name', 'tckn', 'city', 'status', 'note', 'phone', 'email', 'company_id'];


    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public function hasReservation()
    {
        return (count($this->reservations)) ? true : false;
    }


}
