<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class villaCategory extends Model
{
    //
    protected $fillable = ['name'];
    public $timestamps = false;

    public function villas()
    {
        return $this->belongsToMany('App\Villa', 'villa_category');
    }

}
