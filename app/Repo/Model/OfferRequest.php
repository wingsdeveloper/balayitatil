<?php
namespace App\Repo\Model;
use App\OfferRequest as OfferRequestModel;
use Mail, DB;
class OfferRequest {
	public function __construct()
	{
		$this->model = new OfferRequestModel;

	}
	public function index()
	{

	}
	public function adminNotification($id)
	{

		$website = DB::table('websites')->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $receivers = json_decode($website->mail_receivers);
        $data = OfferRequestModel::where('id', $id)->first();

        if($data->customer_type == 'possible'):
        	/*possible musteriden getirecegiz*/
        	$customer = DB::table('possible_customers')->where('id', $data->customer_id)->first();
        else:
        	$customer = DB::table('customers')->where('id', $data->customer_id)->first();
        endif;

		foreach($receivers as $key => $row):
			$receiver_list[]=$row->receiver;
		endforeach;

		try {
			Mail::send('emails.offer_request', ['data' => $data, 'customer' => $customer], function($m) use ($receiver_list) {
				$m->from(config('app.mail_username'), 'VillaKalkan');
				$m->to($receiver_list, 'Sistemde Yeni Bir Teklif Isteği Bulunmaktadır')->subject('Teklif İsteği Gerçekleştirildi');
			});
		}
		catch (\Exception $e) {

    	}
	}
}
