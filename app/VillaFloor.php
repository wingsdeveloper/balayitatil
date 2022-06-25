<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaFloor extends Model
{
    public function floor()
    {
        return $this->belongsTo('App\FloorPlan', 'floor_id');
    }
    public function parts()
    {
        return $this->hasMany('App\VillaPart', "floor_id", 'id')->orderBy('part_ranking');


    }
}
