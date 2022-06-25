<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class villaProminents extends Model
{
    public function villa()
    {
        return $this->belongsTo('App\Villa', 'villa_id');
    }

    public function generalProminent()
    {
        return $this->hasOne('App\Prominent','id','prominent_id');
    }
}
