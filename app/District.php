<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $fillable = ['name', 'area_id'];

    public function area()
    {
        return $this->belongsTo('App\Area');
    }
}
