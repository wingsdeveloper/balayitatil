<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaPayment extends Model
{
    //
    protected $fillable = ['amount', 'reservation_id', 'type', 'currency'];

    public function reservation()
    {
        return $this->belongsTo('App\Reservation');
    }
}
