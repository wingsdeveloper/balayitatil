<?php

namespace App\Http\Controllers;

use App\{PossibleCustomer,
    Customer,
    Repo\Model\CustomerInvoiceDataRepo,
    Reservation,
    ReservationPeople,
    WebsitePanelSeo,
    Area,
    FloorPlan,
    ManualPayment,
    NonPaid,
    PaidIn,
    Part,
    Prominent,
    PreReservation,
    Villa,
    villaCategory,
    VillaFloor,
    villaOwner,
    VillaPart,
    villaPrice,
    villaProminents,
    Website,
    WebsitePanelAreaContent,
    WebsitePanelOpportunity,
    WebsitePanelVilla
};


use App\Helpers\{Helper, VillaFunctions};
use App\WebsitePanelVillaCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\PaymetController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Dompdf\Exception;
use App\Events\PreReservationMail;

class ReservationController extends Controller
{

    public function sozlesmeDownload($id)
    {
        // $customer = Customer::find($id);
        $res = Reservation::find($id);
        $website = Website::where('id', $res->website_id)->first();
        // if($res->customer_type == 'possible'):
        // $customer = DB::table('possible_customers')->where('id', $res->customer_id)->first();
        // else:
        $customer = DB::table('customers')->where('id', $res->customer_id)->first();
        // endif;
        $villa = DB::table('villas')->find($res->villa_id);
        $panel_villas = DB::table('website_panel_villas')->where('villa_id', $res->villa_id)->where('website_id', $res->website_id)->first();
        // $text = Helper::replaceCustomerInputs($customer,$text);
       // $pdf = app('dompdf.wrapper');
        //$pdf = $pdf->loadView('pdf_template', compact('res', 'customer', 'villa', 'panel_villas', 'website'));
//        return $pdf->download('sozlesme.pdf');
        //return $pdf->download($res->code . ' ' . $villa->name . '.pdf');
        return view('layouts.pdf_template',compact('res', 'customer', 'villa', 'panel_villas', 'website'));
    }




    protected function addCustomerInfoset($customerData) {

    }


    protected function addDealInfoset($rezID,$infosetID) {




    }


    /* Ön Rezervasyon  kişi bilgisi ve SMS doğrulama */
    public function addPreReservation(Request $req)
    {

        /* kopya  rezervasyonun  önlenmesi*/


        $villaninMusaitligi = Helper::villaninMusaitligi($req->villa, $req->giris_tarih, $req->cikis_tarih);
        $giris = Carbon::parse($req->giris_tarih);
        $cikis = Carbon::parse($req->cikis_tarih);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gunlukFiyat = Helper::gunlukFiyat($req->villa, $giris_tarih, $cikis_tarih);


        if (isset($villaninMusaitligi) && !empty($villaninMusaitligi)) {
            return Redirect::route('reservation.error')->with(['success' => 'dupplicate_rezervation', 'villa' => $req->villa]);
        } else {
            if ($gunlukFiyat[2] < $gunlukFiyat[8]) {
                return Redirect::route('reservation.error')->with(['success' => 'min_accommodation_season', 'night' => $gunlukFiyat[8], 'villa' => $req->villa]);
            }

            $email=$req->email;
            $phone = preg_replace('/[^0-9.]+/', '', $req->phone);

            $telDogrula = false;
            $customer_data = $checkCustomer = Customer::where('email', $email)->orWhere('phone',$phone)->first();
            if (is_null($checkCustomer)):
                // POSSIBLE CUSTOMER
                $customer_type = "possible";
                $customer_data = $checkPossibleCustomer = PossibleCustomer::where('email', $email)->orWhere('phone',$phone)->first();
                if (is_null($checkPossibleCustomer)):
                    $customer_data = $possible_customer = PossibleCustomer::create(['address' => $req->address, 'name' => $req->name,
                        'tc' => $req->tc, 'idnumber' => $req->idnumber, 'email' => $req->email,
                        'phone' => $phone, 'website_id' => 15/*APP_WEBSITE_ID*/]);
                    $customer_id = $possible_customer->id;
                else:
                     //telefon ve isim güncelle
               $checkPossibleCustomer->phone=$phone;
               $checkPossibleCustomer->name=$req->name;
               $checkPossibleCustomer->save();
                    $customer_id = $checkPossibleCustomer->id;
                    $telDogrula = true;
                endif;
            else:
                //telefon ve isim güncelle
                $checkCustomer->phone=$phone;
                $checkCustomer->name=$req->name;
                $checkCustomer->save();
                // BOYLE BIR KULLANICI ZATEN VAR.  normal
                $customer_id = $checkCustomer->id;
                $customer_type = "normal";
                $telDogrula = true;
            endif;





            $on_odeme = $gunlukFiyat[5];
            $kalan_odeme = $gunlukFiyat[6];
            $temizlik_ucreti = $gunlukFiyat[3];
            $toplam_fiyat = $gunlukFiyat[7];


        /*    $preCotrol = PreReservation::where('customer_id', $customer_id)->where('start_date', $giris_tarih)->where('end_date', $cikis_tarih)->where('website_id', 2)->where('villa_id', $req->villa)->where('operation',3)->first();
            if ($preCotrol) {
                return response()->json(['telDogrula' => $telDogrula, 'code' => $preCotrol->code]);
            } else { */
                $villa = Villa::select('code')->where('id', $req->villa)->first();
                $website = Website::select('prefix', 'currency_id')->where('id', 15/*APP_WEBSITE_ID*/)->first();

                $code = $website->prefix . $villa->code . $giris->format('dm');
                $preReservation = new PreReservation;
                $preReservation->currency_id = $website->currency_id;
                $preReservation->villa_id = $req->villa;
                $preReservation->company_id = 1;
                $preReservation->website_id = 15/*APP_WEBSITE_ID*/
                ;
                $preReservation->customer_id = $customer_id;
                $preReservation->customer_type = $customer_type;
                $preReservation->code = $code . $preReservation->id;
                $preReservation->cc_link = route('odemeYap', ['code' => $preReservation->code]);

                $preReservation->cleaning_payment = $temizlik_ucreti;
                $preReservation->total_price = $toplam_fiyat;
                $preReservation->pre_payment = $on_odeme;
                $preReservation->entry_payment = $kalan_odeme;

                $preReservation->adult_count = $req->adult;
                $preReservation->child_count = $req->child;
                $preReservation->baby_count = $req->baby;
                $preReservation->operation = 3;
                $preReservation->payment_method = 'teb';
                $preReservation->payment_type = 0;
                $preReservation->start_date = $giris_tarih;
                $preReservation->end_date = $cikis_tarih;
                $preReservation->payment_type = $req->payment_type;
                $preReservation->idnumber = $req->idnumber;
                $preReservation->address = $req->address;
                $preReservation->tc = $req->tc;
                $preReservation->save();
                $rezID=$preReservation->id;

                /** infoset kontrolü */
                if ($customer_data->infosetID) {

                $infosetID=$customer_data->infosetID;
                }else { //infosete kayıt
                $infosetID=$this->addCustomerInfoset($customer_data);

                }

                $this->addDealInfoset($rezID,$infosetID);



                event(new PreReservationMail($preReservation->id, $customer_data));


                try {
                    Helper::notification('onrezervasyon', [
                        'data' => $preReservation,
                        'customer' => $customer_data
                    ]);
                } catch (\Exception $exception) {


                }


                $customer_invoice_repo = new CustomerInvoiceDataRepo();
                $customer_invoice_repo->createWithRequest($preReservation, request()->fatura, $customer_data, $req->tc, request()->fatura_kesilecek, $customer_type);
                return response()->json(['telDogrula' => $telDogrula, 'code' => $code . $preReservation->id]);
            /*} */
        }
    }

    public function preReservationDone(Request $request)
    {
        $code = $request->input('code');
        if($code) {
            $reservation = PreReservation::where('code', $code)->first();
            if ($reservation->view_page=='0') {
                $reservation->view_page='1';
                $reservation->save();

                return view("villa.reservation.prereservationdone", compact(["code","reservation"]));
            }else {
                return redirect()->route('home');
            }

        }else{
            return redirect()->route('home');
        }

    }


    public function preKvk()
    {

        return view("villa.reservation.prekvk");
    }

    public function kisiListesiEkle($code)
    {
        $reservation = Reservation::where("code", $code)->first();
        $totalPeople = $reservation->adult_count + $reservation->child_count + $reservation->baby_count;
        $people = ReservationPeople::where("reservation_id", $reservation->id)->get();

        return view("reservation.kisiEkle", compact(["reservation", "totalPeople", "code", "people"]));
    }

    public function kisiListesiEklePost(Request $request, $code)
    {

        $reservation = Reservation::where("code", $code)->first();

        $uyruklar = @$request->uyruk;
        $isimler = @$request->isim;
        $soyisimler = @$request->soyisim;
        $tcler = @$request->tc;

        ReservationPeople::where("reservation_id", $reservation->id)->delete();

        foreach ($uyruklar as $key => $uyruk) {

            if (ReservationPeople::where("reservation_id", $reservation->id)->where("document_type", @$uyruklar[$key])->where("document_no", @$tcler[$key])->exists()) {
                continue;
            }

            ReservationPeople::create([
                "reservation_id" => $reservation->id,
                "name" => @$isimler[$key],
                "surname" => @$soyisimler[$key],
                "document_type" => @$uyruklar[$key],
                "document_no" => @$tcler[$key]
            ]);
        }

        return redirect()->back()->with("type", "success")->with("message", "Bilgileriniz kayıt edilmiştir.");
        //return redirect()->route("showReservationDetails", $code);
    }

    public function showReservationDetails($code)
    {
        $reservation = Reservation::where("code", $code)->first();
        return view("reservation.detail", compact("reservation"));
    }

    public function showReservationOwnerDetails($code)
    {
        $reservation = Reservation::with('villa.owner', 'villa.seo')->where("code", $code)->first();

        return view("reservation.detailOwner", compact("reservation"));
    }


    public function odemeBasla()
    {

        $rez = PreReservation::where('code', request('code'))->first();
        $customer = $rez->customer_real;
        if (!$rez) {
            $rez = Reservation::where('code', request('code'))->first();
            $customer = $rez->customer;
        }

        /** Ödeme kontrol: Daha önce ödeme yapılmış ise ödeme formu gösterilmeyecek */
      $paymentControl=ManualPayment::where('reservation_code',request('code'))->where('status','success')->first();
        if ($paymentControl) {
            return redirect()->route('odemeLanding',$paymentControl->order_id);
        }


        $giris = Carbon::parse($rez->start_date);
        $cikis = Carbon::parse($rez->end_date);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gunlukFiyat = Helper::gunlukFiyat($rez->villa_id, $giris_tarih, $cikis_tarih);

        $req = [
            'adult' => $rez->adult_count,
            'odeme'=> $rez->pre_payment,
            'total'=> $rez->total_price,
            'kalan'=> $rez->entry_payment,
            'child' => $rez->child_count,
            'baby' => $rez->baby->count,
            'giris_tarih' => $giris_tarih,
            'cikis_tarih' => $cikis_tarih,
            'villa' => $rez->villa_id,
            'preID' => $rez->id,
            'c_name' => $customer->name,
            'c_phone' => $customer->phone,
            'c_email' => $customer->email,
            'c_tckn' => $customer->idnumber,
            'c_address' => $customer->address,
            'payment_method' => $rez->payment_method,
            'payment_type' => ($rez->payment_type === 0) ? 0 : null
        ];


        $villa = Villa::where('id', $rez->villa_id)->first();
        $seo = WebsitePanelSeo::select("seo_url")
            ->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'item_id' => $villa->id, 'pivot' => 'website_panel_villas'])->first();
        $seo_url = isset($seo->seo_url) ? $seo->seo_url : '';
        foreach ($villa->paidin as $villapaidin) {
            $villapaidin_ids[] = $villapaidin->paidin_id;
        }
        if (isset($villapaidin_ids))
            $paidins = PaidIn::whereIn('id', $villapaidin_ids)->get();
        $currencies = DB::table('currencies')->get();


        return view('villa.reservation.index', compact('currencies', 'req', 'villa', 'paidins', 'gunlukFiyat', 'seo_url', 'iyziData'));
    }


    public function preRezGuncelle(Request $req)
    {
      
        $pre = PreReservation::find($req->preID);

        if ($pre->customer_type == 'possible') {
            $customer = PossibleCustomer::find($pre->customer_id);
        } else {
            $customer = Customer::find($pre->customer_id);
        }


        /* Müşteri güncelle */
        $customer->email = $req->email;
        $customer->idnumber = $req->idnumber;
        $customer->address = $req->address;
        $customer->ulkeID =  $req->ikamet["ulke_id"];
        $customer->sehirID =  $req->ikamet["il_id"];
        $customer->ilceID =  $req->ikamet["ilce_id"];
        $customer->save();
        /* Ön rezervasyon güncelle */
        $pre->payment_type = $req->payment_type;
        $pre->idnumber = $req->idnumber;
        $pre->address = $req->address;
        $pre->tc = $req->tc;
        $pre->save();

        if ($req->payment_type == 1) { //havale
            return Redirect::route('eftRezDone', ['code' => $pre->code]);
        } else { // kredikartı
            if ($pre->payment_method == "teb") {
                $tmp = explode('/', request()->expiry);
                $data = [
                    'total' => $req->total,
                    'number' => $req->number,
                    'year' => trim($tmp[1]),
                    'month' => trim($tmp[0]),
                    'cvc' => $req->cvv,
                    'currency_code' => $req->currency_code,
                    'code' => $pre->code,
                    'name' => $req->cart_name,
                    'ip' => $req->ip()
                ];

                return app(PaymentController::class)->post($data);
            }

            if ($pre->payment_method == "iyzico") {
                $pc = new PaymentController;
                $iyziData = $pc->iyzicoData($pre->code);
                // return $iyziData;
                return view('payment.iyzico', compact('iyziData'));

            }


            // return Redirect::route('kredikart',['code'=>$pre->code]);
        }

    }


    public function eftRezDone()
    {

        $rez = PreReservation::where('code', request('code'))->first();
        $giris = Carbon::parse($rez->start_date);
        $cikis = Carbon::parse($rez->end_date);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gunlukFiyat = Helper::gunlukFiyat($rez->villa_id, $giris_tarih, $cikis_tarih);

        return view('villa.reservation.done', compact('rez', 'gunlukFiyat'));

    }

    public function reservation(Request $req)
    {
        $villaninMusaitligi = Helper::villaninMusaitligi($req->villa, $req->giris_tarih, $req->cikis_tarih);
        $giris = Carbon::parse($req->giris_tarih);
        $cikis = Carbon::parse($req->cikis_tarih);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gunlukFiyat = Helper::gunlukFiyat($req->villa, $giris_tarih, $cikis_tarih);

        if (isset($villaninMusaitligi) && !empty($villaninMusaitligi)) {
            return Redirect::route('reservation.error')->with(['success' => 'dupplicate_rezervation', 'villa' => $req->villa]);
        } else {
            if ($gunlukFiyat[2] < $gunlukFiyat[8]) {
                return Redirect::route('reservation.error')->with(['success' => 'min_accommodation_season', 'night' => $gunlukFiyat[8], 'villa' => $req->villa]);
            }
            if (Helper::isPost($req)) {

                $this->validate($req, [
                    'phone' => 'required|numeric',
                    'prephone' => 'required|numeric',
                    'email' => 'required|email',
                    'name' => 'required|string',
                    'villa' => 'required|numeric',
                    'payment_type' => 'required|numeric',
                    'giris_tarih' => 'required|date',
                    'cikis_tarih' => 'required|date',
                ]);


                /*$gecelik_fiyat=$gunlukFiyat[1];
                 $gece_sayisi=$gunlukFiyat[2];

                 $gun_ve_fiyat=$gunlukFiyat[4];
                 $hesap_toplam=$gunlukFiyat[7];*/
                $on_odeme = $gunlukFiyat[5];
                $kalan_odeme = $gunlukFiyat[6];
                $temizlik_ucreti = $gunlukFiyat[3];
                $toplam_fiyat = $gunlukFiyat[7];
                $customer_data = $checkCustomer = Customer::where('phone', $req->prephone . $req->phone)->first();
                if (is_null($checkCustomer)):
                    // POSSIBLE CUSTOMER
                    $customer_type = "possible";
                    $customer_data = $checkPossibleCustomer = PossibleCustomer::where('phone', $req->prephone . $req->phone)->first();
                    if (is_null($checkPossibleCustomer)):
                        $customer_data = $possible_customer = PossibleCustomer::create(['address' => $req->address, 'name' => $req->name,
                            'tc' => $req->tc, 'idnumber' => $req->idnumber, 'email' => $req->email,
                            'phone' => $req->prephone . $req->phone, 'website_id' => 15/*APP_WEBSITE_ID*/]);
                        $customer_id = $possible_customer->id;
                    else:
                        $customer_id = $checkPossibleCustomer->id;

                    endif;
                else:
                    // BOYLE BIR KULLANICI ZATEN VAR.  normal
                    $customer_id = $checkCustomer->id;
                    $customer_type = "normal";
                endif;
                $villaninOpsiyonu = Helper::villaninOpsiyonu($req->villa, $req->giris_tarih, $req->cikis_tarih);
                $villa = Villa::select('code')->where('id', $req->villa)->first();
                $website = Website::select('prefix', 'currency_id')->where('id', 15/*APP_WEBSITE_ID*/)->first();

                $code = $website->prefix . $villa->code . $giris->format('dm');
                $preReservation = new PreReservation;
                $preReservation->currency_id = $website->currency_id;
                $preReservation->villa_id = $req->villa;
                $preReservation->company_id = 1;
                $preReservation->website_id = 15/*APP_WEBSITE_ID*/
                ;
                $preReservation->customer_id = $customer_id;
                $preReservation->customer_type = $customer_type;
                $preReservation->code = $code . $preReservation->id;
                $preReservation->cc_link = route('odemeYap', ['code' => $preReservation->code]);

                $preReservation->cleaning_payment = $temizlik_ucreti;
                $preReservation->total_price = $toplam_fiyat;
                $preReservation->pre_payment = $on_odeme;
                $preReservation->entry_payment = $kalan_odeme;

                $preReservation->adult_count = $req->adult;
                $preReservation->child_count = $req->child;
                $preReservation->baby_count = $req->baby;
                $preReservation->operation = 3;
                $preReservation->start_date = $giris_tarih;
                $preReservation->end_date = $cikis_tarih;
                $preReservation->payment_type = $req->payment_type;
                $preReservation->idnumber = $req->idnumber;
                $preReservation->address = $req->address;
                $preReservation->tc = $req->tc;


                // Helper::opportunityDelete($giris_tarih,$cikis_tarih,$req->villa);
                if ((request()->ip() == "31.142.247.47") || $req->email == "cenk.oruc@hotmail.com") {
                    return redirect()->to('/');
                }
                try {
                    //throw new \Exception("Exception");
                    $request_data = request()->all();
                    $request_data['api_token'] = config('app.api_user_token');
                    $request_data['cc_link'] = route('odemeYap', ['code' => null]);
                    $request_data['user_ip'] = request()->ip();
                    $request_data['other'] = json_encode($this->getBrowser());

                    if (env('APP_LOCAL_DEBUG', false)) {
                        $ch = curl_init(config('app.api_base_url.local') . '/preReservation/create');
                    } else {
                        $ch = curl_init(config('app.api_base_url.production') . '/preReservation/create');
                    }
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json']);

                    $response = json_decode(curl_exec($ch));

                    if (isset(curl_getinfo($ch)['http_code']) && curl_getinfo($ch)['http_code'] != 200) {
                        throw new \Exception('Api Server error');
                    }
                    $preReservation = $response;
                } catch (\Exception $e) {
                    $preReservation->save();
                }

                #dd(json_decode($preReservation));

                event(new PreReservationMail($preReservation->id, $customer_data));


                $customer_invoice_repo = new CustomerInvoiceDataRepo();
                $customer_invoice_repo->createWithRequest($preReservation, request()->fatura, $customer_data, $req->tc, request()->fatura_kesilecek, $customer_type);

                /*TODO bu islem sonunda customer invoice data olusturulmalidir.*/


                if (isset($villaninOpsiyonu) && !empty($villaninOpsiyonu)) {
                    return Redirect::route('reservation.done')->with(['success' => 'option_alert', 'reservation' => $preReservation->id, 'customer' => $customer_id]);
                } else {
                    return Redirect::route('reservation.done')->with(['success' => 'reservation_done', 'reservation' => $preReservation->id, 'customer' => $customer_id]);
                }
            } else {
                $villa = Villa::where('id', $req->villa)->first();
                $seo = WebsitePanelSeo::select("seo_url")
                    ->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'item_id' => $villa->id, 'pivot' => 'website_panel_villas'])->first();
                $seo_url = isset($seo->seo_url) ? $seo->seo_url : '';
                foreach ($villa->paidin as $villapaidin) {
                    $villapaidin_ids[] = $villapaidin->paidin_id;
                }
                if (isset($villapaidin_ids))
                    $paidins = PaidIn::whereIn('id', $villapaidin_ids)->get();

                /*foreach ($villa->nonpaid as $villanonpaid) {
                    $villanonpaid_ids[] = $villanonpaid->nonpaid_id;
                }  if(isset($villanonpaid_ids))
                $nonpaids = NonPaid::whereIn('id',$villanonpaid_ids)->get();*/

                return view('villa.reservation.index', compact('req', 'villa', 'paidins', 'gunlukFiyat', 'seo_url'));
            }
        }
    }


    public function reservationDone(Request $req)
    {
        if (session('success')) {
            switch (session('success')) {
                case 'reservation_done':
                    $bilgi[99] = "<svg class='icon icon-yes'><use xlink:href='#icon-yes'></use></svg>";
                    $bilgi[0] = "REZERVASYON ÖN TALEBİNİZ BAŞARI İLE ALINMIŞTIR.";
                    $bilgi[1] = "Ön rezervasyon detaylarınız e-mail olarak gönderilecektir.";
                    $bilgi[2] = "Müşteri temsilcimiz aşağıdaki telefon numaranızdan
                sizinle iletişime geçecektir.";
                    break;

                case 'option_alert':
                    $bilgi[99] = "<svg class='icon icon-info1'><use xlink:href='#icon-info1'></use></svg>";
                    $bilgi[0] = "REZERVASYON ÖN TALEBİNİZ HAKKINDA BİLGİLENDİRME.";
                    $bilgi[1] = ".";
                    $bilgi[2] = "Seçtiğiniz tarihler farklı bir müşterimiz adına OPSİYONLANMIŞ olup; Kesin rezervasyon gerçekleşmediği taktirde tarafınıza bilgi verilecektir. Farklı bir tarih aralığı seçmek için lütfen GERİ tuşuna basın.";
                    break;
            }

            $customer = session('customer');
            $reservation = session('reservation');
            $reservation = PreReservation::where('id', $reservation)->first();
            if ($reservation->customer_type == "possible") {
                $customer = PossibleCustomer::where('id', $customer)->first();
            } else {
                $customer = Customer::where('id', $customer)->first();
            }
            $seo = WebsitePanelSeo::select("seo_url")->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'item_id' => $reservation->villa_id, 'pivot' => 'website_panel_villas'])->first();
            $seo_url = isset($seo->seo_url) ? $seo->seo_url : '';

            return view('villa.reservation.done', compact('reservation', 'customer', 'bilgi', 'seo_url'));
        } elseif (Helper::isPost($req)) {
            if ($req->customer_type == "possible") {
                $customerTable = PossibleCustomer::where('id', $req->customer);
            } else {
                $customerTable = Customer::where('id', $req->customer);
            }
            $inputs = $req->except('_token', 'customer', 'reservation', 'customer_type');
            $customerTable->update($inputs);
            $reservation = $req->reservation;
            $customer = $req->customer;
            return Redirect::route('reservation.done')->with(['success' => 'reservation_done', 'reservation' => $reservation, 'customer' => $customer]);

        } else {
            return redirect()->to('/');
        }

    }

    public function reservationError(Request $req)
    {
        if (session('success')) {
            $gece = session('night');
            $villa_id = (int)session('villa');
            $seo = WebsitePanelSeo::select("seo_url")->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'item_id' => $villa_id, 'pivot' => 'website_panel_villas'])->first();
            $seo_url = isset($seo->seo_url) ? $seo->seo_url : '';
            switch (session('success')) {
                case 'min_accommodation':
                    $bilgi[0] = "Maalesef Rezervasyonunuzu Alamıyoruz.";
                    $bilgi[1] = "Seçilen sezonda minimum $gece gece konaklayabilirsiniz. Dilerseniz başka bir tarih seçebilirsiniz veya Müşteri temsilcimizle aşağıdaki telefon numarasından iletişime geçebilirsiniz.";
                    $bilgi[2] = "0242 252 0032";
                    break;
                case 'min_accommodation_season':
                    $bilgi[0] = "Maalesef Rezervasyonunuzu Alamıyoruz.";
                    $bilgi[1] = "Seçilen sezonda minimum $gece gece konaklayabilirsiniz. Dilerseniz başka bir tarih seçebilirsiniz veya Müşteri temsilcimizle aşağıdaki telefon numarasından iletişime geçebilirsiniz.";
                    $bilgi[2] = "0242 252 0032";
                    break;
                case 'dupplicate_rezervation':
                    $bilgi[0] = "Maalesef Rezervasyonunuzu Alamıyoruz.";
                    $bilgi[1] = "Bu villa için seçtiğiniz tarihler doludur. Başka bir tarih seçebilirsiniz veya Müşteri temsilcimizle aşağıdaki telefon numarasından iletişime geçebilirsiniz.";
                    $bilgi[2] = "0242 252 0032";
                    break;

                default:
                    $bilgi[0] = "Maalesef Rezervasyonunuzu Alamıyoruz.";
                    $bilgi[1] = "Bu villa için seçtiğiniz tarihler doludur. Başka bir tarih seçebilirsiniz veya Müşteri temsilcimizle aşağıdaki telefon numarasından iletişime geçebilirsiniz.";
                    $bilgi[2] = "0242 252 0032";
                    break;
            }
            return view('villa.reservation.error', compact('areas', 'bilgi', 'seo_url'));
        } else {
            return redirect()->to('/');
        }
    }


    public function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }
}
