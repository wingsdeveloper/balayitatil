<?php

namespace App\Listeners;

use App\Events\YeniOdemeAlindi as YeniOdemeAlindiEvent;
use Dompdf\Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repo\Model\ManuelPayment;
use App\Repo\Wunderlist\Main;

class YeniOdemeAlindi implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repo = new ManuelPayment;
    }

    /**
     * Handle the event.
     *
     * @param  YeniOdemeAlindi  $event
     * @return void
     */
    public function handle(YeniOdemeAlindiEvent $event)
    {
        $id = $event->id;
        $type = $event->type;

        $this->repo->sendAdminMail($id);
        #'emails.manuel-payment', ['data' => $data, 'customer' => $customer, 'reservation' => $reservation, 'villa' => $villa ]
        try {
            $this->repo->notifyWunderList($id);
        } catch (\Exception $e) {

        }

    }
}
