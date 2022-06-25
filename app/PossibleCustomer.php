<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Collection;
use Iyzico\IyzipayLaravel\Models\CreditCard;
use Iyzico\IyzipayLaravel\Models\Transaction;
use Iyzico\IyzipayLaravel\PayableContract;
use Iyzico\IyzipayLaravel\StorableClasses\Plan;


class PossibleCustomer extends Model implements PayableContract
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $fillable = ['pre_reservation_id', 'name', 'phone', 'email','website_id', 'idnumber', 'address'];

    public function prereservations()
    {
    	return $this->hasMany('App\PreReservation', 'id', 'pre_reservation_id');
    }





    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class, 'billable_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class,'billable_id');
    }

    public function subscriptions(): HasMany
    {

    }

    public function addCreditCard(array $attributes = []): CreditCard
    {

    }

    public function removeCreditCard(CreditCard $creditCard): bool
    {
        // TODO: Implement removeCreditCard() method.
    }

    public function pay(Collection $products, $currency = 'TRY', $installment = 1): Transaction
    {
        /*TODO bitirmeliyiz. POST olarak dusun*/

    }

    public function isBillable(): bool
    {
        // TODO: Implement isBillable() method.
    }

    public function subscribe(Plan $plan): void
    {
        // TODO: Implement subscribe() method.
    }

    public function isSubscribeTo(Plan $plan): bool
    {
        // TODO: Implement isSubscribeTo() method.
    }

    /**
     * @inheritDoc
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
