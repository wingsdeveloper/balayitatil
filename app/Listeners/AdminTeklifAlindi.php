<?php

namespace App\Listeners;

use App\Events\AdminTeklifAlindi as AdminTeklifAlindiEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repo\Model\OfferRequest as OfferRequestRepo;

class AdminTeklifAlindi implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repo = new OfferRequestRepo;
        
    }

    /**
     * Handle the event.
     *
     * @param  AdminTeklifAlindiEvent  $event
     * @return void
     */
    public function handle(AdminTeklifAlindiEvent $event)
    {
        $offer_id = $event->offer_id;
        
        $this->repo->adminNotification($offer_id);
    }
}
