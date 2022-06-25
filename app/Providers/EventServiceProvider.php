<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\PreReservationMail' => [
            'App\Listeners\PreReservationListener',
        ],
        'App\Events\AdminHataMailBildir' => [
            'App\Listeners\AdminBildir',
        ],
        'App\Events\AdminTeklifAlindi' => [
            'App\Listeners\AdminTeklifAlindi',
        ],
        'App\Events\YeniOdemeAlindi' => [
            'App\Listeners\YeniOdemeAlindi',
        ],
        'App\Events\IletisimFormGonder' => [
            'App\Listeners\IletisimForm',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
