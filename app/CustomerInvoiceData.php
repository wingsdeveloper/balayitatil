<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoiceData extends Model
{
    protected $table = 'customer_invoice_data';

    protected $fillable = [
        'pre_customer_id',
        'customer_id',
        'pre_reservation_id',
        'reservation_id',
        'ulke_id',
        'il_id',
        'ilce_id',
        'name',
        'surname',
        'identification',
        'billing_address',
        'email',
        'tax_administration',
        'billing_type',
        'option1',
        'option2',
        'issue_date'
    ];

    public function pre_customer()
    {
        return $this->belongsTo(PossibleCustomer::class, 'pre_customer_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function ulke()
    {
        return $this->hasOne(Ulke::class, 'id', 'ulke_id');
    }
    public function il()
    {
        return $this->hasOne(Iller::class, 'id', 'il_id');
    }
    public function ilce()
    {
        return $this->hasOne(Ilceler::class, 'id', 'ilce_id');
    }


}
