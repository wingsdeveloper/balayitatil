<?php

namespace App\Repo\Model;

use App\Helpers\Helper;
use App\ManualPayment;

use App\Repo\TaskList\Trello\src\Card;
use Mail, DB;
use App\Repo\Wunderlist\Main;
use App\Repo\TaskList\Trello\Main as TrelloMain;

class ManuelPayment
{
    public function __construct()
    {
        $this->model = new ManualPayment;
    }

    public function index()
    {

    }

    public function sendAdminMail($id, $type = null)
    {
        $odeme = $this->model->where('order_id', $id)->first();
        $resCode = $odeme->reservation_code;

        $website = DB::table('websites')->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $receivers = json_decode($website->mail_receivers);

        $data = $this->model->with('currency')->where('order_id', $id)->first();

        $res = DB::table('reservations')->where('code', $resCode)->first();
        $pre = DB::table('pre_reservations')->where('code', $resCode)->first();

        if (!empty($res)):
            $reservation = $res;
            $customer = DB::table('customers')->where('id', $res->customer_id)->first();
        endif;

        if (!empty($pre)):
            if ($pre->customer_type == 'possible'):
                $customer = DB::table('possible_customers')->where('id', $pre->customer_id)->first();
            else:
                $customer = DB::table('customers')->where('id', $pre->customer_id)->first();
            endif;
            $reservation = $pre;
        endif;

        $villa = DB::table('villas')->where('id', $reservation->villa_id)->first();

        foreach ($receivers as $key => $row):
            $receiver_list[] = $row->receiver;
        endforeach;

        try {
            Helper::notification('manuelodeme', ['data' => $data, 'customer' => $customer, 'reservation' => $reservation, 'villa' => $villa, 'odeme' => $odeme, 'type' => $type]);
        } catch (\Exception $exception) {

        }

        Mail::send('emails.manuel-payment', ['data' => $data, 'customer' => $customer, 'reservation' => $reservation, 'villa' => $villa, 'odeme' => $odeme, 'type' => $type], function ($m) use ($receiver_list) {
            $m->from(config('app.mail_username'), 'VillaKalkan');
            $m->to($receiver_list, 'Yeni Bir Ödeme Gerçekleştirilmiştir')->subject('Manuel Ödeme Gerçekleştirilmiştir');
        });
        try {

        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * @param $id
     * @throws \Exception
     * notifyWunderList fonksiyonu icerisine order_id alir ve wunderlistte yeni bir not olusturmayi saglar.
     */
    public function notifyWunderList($id)
    {
        $odeme = $this->model->where('order_id', $id)->first();
        $resCode = $odeme->reservation_code;

        #$website = DB::table('websites')->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $data = $this->model->with('currency')->where('order_id', $id)->first();

        $res = DB::table('reservations')->where('code', $resCode)->first();
        $pre = DB::table('pre_reservations')->where('code', $resCode)->first();

        if (!empty($res)):
            $reservation = $res;
            $customer = DB::table('customers')->where('id', $res->customer_id)->first();
        endif;
        if (!empty($pre)):
            if ($pre->customer_type == 'possible'):
                $customer = DB::table('possible_customers')->where('id', $pre->customer_id)->first();
            else:
                $customer = DB::table('customers')->where('id', $pre->customer_id)->first();
            endif;
            $reservation = $pre;
        endif;

        $villa = DB::table('villas')->where('id', $reservation->villa_id)->first();

        $str = view('emails.manuel-payment', ['data' => $data, 'customer' => $customer, 'reservation' => $reservation, 'villa' => $villa]);
        #$str

        #$list = new Main('414928850');
        $list = new TrelloMain();
        $card = new Card();
        $card_id = $list->getListId('manuel-odemeler');
        $input['name'] = $customer->name . ' ' . $data->order_id . ' TOPLAM: ' . $data->total . ' ' . $data->currency->name;


        $member[] = '5c02905fbd19db69ad1ccc30';/*ALPER CELIK*/
        $member[] = '5e3c1e15bae699297785c9de';/*UGUR-DURGUN*/
        $member[] = '5e398d41ba93930733be11b0';/*UGUR-DURGUN*/

        $input['idMembers'] = implode(',', $member);


        $response = $card->createList($card_id, $input);
        $list_id = $response->id;
        $card->postComment($list_id, $str);

    }

}
