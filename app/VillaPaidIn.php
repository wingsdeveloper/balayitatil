<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaPaidIn extends Model
{
    protected $fillable = [
        'villa_id',
        'id',
        'paidin_id'
    ];

    public function villa()
    {
        return $this->belongsTo('App\Villa', 'villa_id');
    }
}
