<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonPaid extends Model
{
    protected $fillable = [
        'property',
        'description'];
}
