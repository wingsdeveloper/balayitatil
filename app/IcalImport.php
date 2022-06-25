<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class IcalImport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'dtstart',
        'dtend',
        'villa_id',
        'villa_site_rel_id',
        'is_dirty',
        'exportable'
    ];

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id');
    }
}
