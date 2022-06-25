<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaMaterial extends Model
{
//    public $timestamps = false;
    public function material()
    {
        return $this->hasOne('App\Material', 'id', 'material_id');
    }
}
