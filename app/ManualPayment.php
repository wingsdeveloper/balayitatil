<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManualPayment extends Model
{
	protected $fillable = ['name', 'total', 'status', 'subject', 'message', 'type', 'token', 'conversation_id', 'url', 'order_id', 'reservation_code', 'currency_code', 'ip'];

	public function currency()
	{
		return $this->hasOne('App\Currency', 'code', 'currency_code');
	}

	public function reservation()
	{

	}

}
