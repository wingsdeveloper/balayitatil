<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VillaPhoto extends Model
{
    public function villa()
    {
        return $this->belongsTo('App\Villa', 'villa_id');
    }

    protected $fillable = ['path', 'name', 'size', 'type', 'ranking'];




}
