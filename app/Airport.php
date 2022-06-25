<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AirportAreaRel;
class Airport extends Model
{
    protected $fillable = ['title', 'name', 'country_id', 'content', 'status'];

    public function area()
    {
        return $this->hasMany(AirportAreaRel::class, 'airport_id')->where('status', '1');
    }
}
