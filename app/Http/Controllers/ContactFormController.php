<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\IletisimFormGonder;
class ContactFormController extends Controller
{
    public function submit()
    {

        event(new IletisimFormGonder(request()->all()));


        return redirect()->back()->with(['aciklama' => 'Mesajınız Başarıyla İletilmiştir', 'success' => '1']);
    }
}
