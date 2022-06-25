<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaPart extends Model
{
    public function part()
    {
        return $this->hasOne('App\Part', 'id', 'part_id');
    }
    public function materials()
    {
        return $this->hasMany('App\VillaMaterial', 'part_id', 'id');
    }
    public function photos()
    {
        return $this->hasMany('App\VillaPartPhoto', 'part_id', 'id');
    }
    public function special_info()
    {
        return $this->hasOne('App\VillaMaterialSpeacialInfo', 'part_id', 'id');
    }
}
