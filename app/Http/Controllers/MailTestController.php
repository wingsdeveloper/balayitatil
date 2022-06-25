<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Mail;
class MailTestController extends Controller
{
    public function index()
    {
        $message = "Hello using Sendinblue";

        Config::set('mail.port', "587");
        Config::set('mail.host', "smtp-relay.sendinblue.com");
        Config::set('mail.username', "birtan@villakalkan.com.tr");
        Config::set('mail.password', "bNyhQIYmGcCagX90");
        Config::set('mail.encryption', "tls");

        try {
            Mail::send('emails.test', ['message' => $message], function($m) {
                $m->from("villakalkanrezervasyon@gmail.com", 'VillaKalkan');
                $m->to("taskinbirtan@gmail.com", 'Test')->subject('Test');
            });
        } catch(\Exception $e) {
            dd($e);
        }


    }

    public function api()
    {
        $params = new \StdClass();

        $params->sender = new \StdClass();
        $params->sender->name = "Wings Rezervasyon";
        $params->sender->email = "rezervasyon@wings.com.tr";

        $params->to = [];
        array_push($params->to, ['email' => "birtan1991@hotmail.com", 'name' => "Birtan Taskin"]);

        $params->subject = "Api Test";
        $params->htmlContent = "<html><head></head><body><p>Hello,</p>This is my first transactional email sent from Sendinblue.</p></body></html>";

        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v3/smtp/email');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Api-Key: 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';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        dd($result);
        curl_close ($ch);
    }
}
