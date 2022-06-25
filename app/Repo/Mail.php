<?php
namespace App\Repo;

use Mail as MailSender;
use DB;

class Mail {
    public function __construct()
    {
        $website = DB::table('websites')->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $receivers = json_decode($website->mail_receivers);
        foreach($receivers as $key => $row):
            $this->receiver_list[]=$row->receiver;
        endforeach;


    }
    public function submitContactForm($data)
    {
        MailSender::send('emails.contact-form', ['form' => $data['form'] ], function($m) {
            $m->from(config('app.mail_username'), 'VillaKalkan');
            $m->to($this->receiver_list, 'İletişim Formu')->subject('İletişim Formu');
        });
    }
}
