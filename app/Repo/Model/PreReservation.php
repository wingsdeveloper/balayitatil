<?php

namespace App\Repo\Model;
use App\Helpers\Helper;
use App\PossibleCustomer;
use App\PreReservation as PreReservationModel;
use Mail, DB;
class PreReservation {
	public function create_customer(PreReservationModel $data)
	{
		// try {
		// 	// $data->pre_reservation_id = $data->id;
		// 	// return PossibleCustomer::create($data->toArray());
		// } catch (\Exception $e) {
		// 	dd($e);
		// 	return kullanici bilgilerinin eksik gelmesi dolayisiyla musteri olusturulamaz, bu konuyla ilgili bir guzel exception handler olusturlaim simdilik false donderfalse;
		// }
	}

	public function sendAdminMail($id, $customer)
	{

		$website = DB::table('websites')->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $receivers = json_decode($website->mail_receivers);
        $data = PreReservationModel::where('id', $id)->first();




		foreach($receivers as $key => $row):
			$receiver_list[]=$row->receiver;
		endforeach;
		try {
			Mail::send('emails.reservation', ['data' => $data, 'customer' => $customer], function($m) use ($row,$receiver_list) {
			    $from_mail = empty(config('app.mail_sender_username')) ? 'birtan@villakalkan.com.tr' : config('app.mail_sender_username');
				$m->from($from_mail, 'VillaKalkan');
				$m->to($receiver_list, 'Yeni Bir Rezervasyon Gerceklestirilmistir')->subject('Rezervasyon Gerceklestirildi');
			});
		}
		catch (\Exception $e) {
		    //dd($e);
			// Log::error($e);
    	}
	}
}
