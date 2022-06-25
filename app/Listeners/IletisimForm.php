<?php

namespace App\Listeners;

use App\Events\IletisimFormGonder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repo\Mail;
class IletisimForm implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  IletisimFormGonder  $event
     * @return void
     */
    public function handle(IletisimFormGonder $event)
    {
        $data = $event->data;
        $handler = new Mail;
        $handler->submitContactForm($data);
    }
}
