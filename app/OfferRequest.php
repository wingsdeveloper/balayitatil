<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferRequest extends Model
{

	protected $fillable = ['net_date',
	'start_date',
	'end_date',
	'net_date',
	'season',
	'month',
	'villa_type',
	'category_type',
	'three_days_available',
	'features',
	'absolutes',
	'name',
	'email',
	'prephone',
	'phone',
	'area_id',
	'adult',
	'child',
	'baby',
	'website_id',
	'customer_type',
	'customer_id'
];

public function website()
{
	return $this->hasOne('App\Website','id','website_id');
}

public function area()
{
	return $this->hasOne('App\Area','id','area_id');
}
}
