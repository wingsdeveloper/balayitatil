<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidIn extends Model
{
    protected $fillable = [
        'property',
        'description'];
}
