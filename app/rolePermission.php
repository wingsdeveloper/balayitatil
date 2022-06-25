<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rolePermission extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['role_id','name','value'];

    public function role(){
        return $this->belongsTo('App\Role');
    }
}
