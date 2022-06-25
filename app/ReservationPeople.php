<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationPeople extends Model
{
    protected $table = "reservation_people";
    public $timestamps = true;

    protected $fillable = [
        "reservation_id",
        "name",
        "surname",
        "document_type",
        "document_no"
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
