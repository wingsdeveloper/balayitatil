<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaPartPhoto extends Model
{
    public function photo()
    {
        return $this->hasOne('App\VillaPhoto', 'id', 'photo_id')->orderBy('ranking');
    }
}
