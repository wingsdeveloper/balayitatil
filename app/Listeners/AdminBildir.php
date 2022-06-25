<?php

namespace App\Listeners;

use App\Events\AdminHataMailBildir;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
class AdminBildir implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminHataMailBildir  $event
     * @return void
     */
    public function handle(AdminHataMailBildir $event)
    {
        $exception = $event->exception;

        $string = 'HATAAA!!!<br>';
        $file = '';
        $line = '';
        foreach($exception as $key => $row):
            try {
                $file = 'file: ' . $row->file . '<br>';
            } catch (\Exception $e) {

            }
            try {
                $line = 'line: ' . $row->line . '<br>';
            } catch (\Exception $e) {

            }
            $string = $string . $file . $line . '<br>';
        endforeach;

        Mail::send('emails.reservation', [$string], function($m) {
            $m->from(config('app.mail_username'), 'VillaKalkan');
            $m->to(['taskinbirtan@gmail.com', 'ali1905.1995@gmail.com'], 'Yeni Bir Rezervasyon Gerceklestirilmistir')->subject('Rezervasyon Gerceklestirildi');
        });


    }
}
