<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreReservation extends Model
{
    public function villa()
    {
    	return $this->belongsTo('App\Villa', 'villa_id');
    }

    public function customer_real(){
        if($this->customer_type=="possible"){
            return $this->belongsTo('App\PossibleCustomer','customer_id','id');
        }else{
            return $this->belongsTo('App\Customer','customer_id','id');
        }
    }

    public function invoice_data() {
        return $this->hasOne(CustomerInvoiceData::class, 'pre_reservation_id');
    }
}

