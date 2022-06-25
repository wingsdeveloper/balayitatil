<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class villaOwner extends Model
{
    //

    protected $fillable = [
        'name',
        'email',
        'phone',
        'bank_account_info',
        'payment_type'
    ];

    public function villas()
    {
        return $this->hasMany('App\Villa', 'owner_id');
    }

}
