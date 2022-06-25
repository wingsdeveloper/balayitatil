<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaNonPaid extends Model
{
    protected $fillable = [
        'villa_id',
        'id',
        'nonpaid_id'
    ];

    public function villa()
    {
        return $this->belongsTo('App\Villa', 'villa_id');
    }
}
