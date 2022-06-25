<?php

namespace App\Observers;

use App\PreReservation;
use Log, Config, DB, Mail, Carbon\Carbon;
use App\Website;

use App\Repo\Model\PreReservation as PreReservationRepo;

use App\Events\PreReservationMail;

class PreReservationObserver
{
    /**
     * Handle the pre reservation "created" event.
     *
     * @param  \App\PreReservation  $preReservation
     * @return void
     */
    public function created(PreReservation $preReservation)
    {
        // yeni bir prereservation olusturuldugunda, sistemde mail gonderilecektir.
        $general = Website::select('prefix')->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $website = DB::table('websites')->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $villa = DB::table('villas')->where('id', $preReservation->villa_id)->first();

        $receivers = json_decode($website->mail_receivers);

        $giris = Carbon::parse($preReservation->start_date);

        PreReservation::where('id', $preReservation->id)->update(['code' => $general->prefix.$villa->code.$giris->format('dm') . $preReservation->id, 'cc_link' => route('odemeYap',['code' => $general->prefix.$villa->code.$giris->format('dm') . $preReservation->id] )]);

        $data = PreReservation::with('villa')->where('id', $preReservation->id)->first();

        $customer_id = $data->customer_id;
        $customer_type = $data->customer_type;
        if($customer_type == 'possible'):
            $customer = DB::table('possible_customers')->where('id', $customer_id)->first();
            DB::table('possible_customers')->where('id', $customer_id)->update(['pre_reservation_id' => $preReservation->id]);
        else:
            $customer = DB::table('customers')->where('id', $customer_id)->first();
        endif;


        #event(new PreReservationMail($preReservation->id, $customer));

       // foreach($receivers as $key => $row):
       //      $receiver_list[]=$row->receiver;
       //  endforeach;
       //      try {
       //          Mail::send('emails.reservation', ['data' => $data, 'customer' => $customer], function($m) use ($row,$receiver_list) {
       //            $m->from('testfagus@gmail.com', 'VillaKalkan');
       //            $m->to($receiver_list, 'Yeni Bir Rezervasyon Gerceklestirilmistir')->subject('Rezervasyon Gerceklestirildi');
       //          });
       //      } catch (\Exception $e) {
       //          Log::error($e);
       //          dd($e);
       //      }
        // yeni bir prereservation olusutuldugunda gelen data kullanilarak yeni bir possible musteri olusturulacaktir
        $repo = new PreReservationRepo;
        $repo->create_customer($preReservation);
    }

    /**
     * Handle the pre reservation "updated" event.
     *
     * @param  \App\PreReservation  $preReservation
     * @return void
     */
    public function updated(PreReservation $preReservation)
    {
        //
    }

    /**
     * Handle the pre reservation "deleted" event.
     *
     * @param  \App\PreReservation  $preReservation
     * @return void
     */
    public function deleted(PreReservation $preReservation)
    {
        //
    }

    /**
     * Handle the pre reservation "restored" event.
     *
     * @param  \App\PreReservation  $preReservation
     * @return void
     */
    public function restored(PreReservation $preReservation)
    {
        //
    }

    /**
     * Handle the pre reservation "force deleted" event.
     *
     * @param  \App\PreReservation  $preReservation
     * @return void
     */
    public function forceDeleted(PreReservation $preReservation)
    {
        //
    }
}
