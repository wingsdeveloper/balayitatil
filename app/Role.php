<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamp = false;

    protected $fillable = ['name'];

    public function User()
    {
        $this->belongsToMany('App\User');
    }

    public function permissions(){
        return $this->hasMany('App\rolePermission');
    }


}
