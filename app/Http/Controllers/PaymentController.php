<?php

namespace App\Http\Controllers;

use App\Currency;
use App\PreReservation;
use Illuminate\Http\Request;
use App\Repo\Pos\est3dModel;
use App\ManualPayment;
use Session, DB;
use App\Events\YeniOdemeAlindi;
use App\Repo\Model\ManuelPayment;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->repo = new ManualPayment;
    }
/* kredikart test */
    public function iyzicoData($code) {
        $data = $this->iyzicoIndex($code);

        $payment = ManualPayment::where('status', 'index')->where('reservation_code', $code)->first();
        if (!empty($payment)) {
            $payment->update(['conversation_id' => $data['repo']['conversation_id']]);
        } else {
            $payment = new ManualPayment;
           
            $payment->create($data['repo']);
        }
        return $data['view'];

}


    public function index()
    {
        if (request()->has('code')):

            $res = DB::table('reservations')->where('code', request('code'))->count();
            $pre = DB::table('pre_reservations')->where('code', request('code'))->count();

            if (!empty($res) || !empty($pre)):
                $pre_method = DB::table('pre_reservations')->where('code', request('code'))->first()->payment_method;
                if ($pre_method == 'iyzico') {
                    $data = $this->iyzicoIndex(request()->code);

                    $payment = ManualPayment::where('status', 'index')->where('reservation_code', request()->code)->first();
                    if (!empty($payment)) {
                        $payment->update(['conversation_id' => $data['repo']['conversation_id']]);
                    } else {
                        $payment = new ManualPayment;
                        $payment->create($data['repo']);
                    }
                    return $data['view'];
                }
                $currencies = DB::table('currencies')->get();
                return view('payment.index', ['currencies' => $currencies]);
            else:
                $aciklama = ['tr' => ['title' => 'Yanlış Bir Rezervasyon Kodu Girilmiştir, Lütfen Doğru Girdiğinizden Emin Olun ve Tekrar Deneyiniz'], 'en' => ['title' => 'The Reservation Code You Have Entered Seems to be Wrong, Please Try Again']];
                return view('payment.code-required', ['error' => $aciklama]);
            endif;
        else:
            $aciklama = ['tr' => ['title' => 'Rezervasyon Kodunuz Olmadan İşlem Yapılamaz, Rezervasyon Kodunuzu Girerek İşleminizi Tekrar Deneyiniz'], 'en' => ['title' => 'Can\'t Process Without Reservation Code, Please Enter the Reservation Code and Try Again']];
            return view('payment.code-required', ['error' => $aciklama]);
        endif;
    }

/* Vakıf */
public function postVakif($postData){

    $oid='VK-MAN-PAY-' . date('Ymds') . rand(10000, 99999);
    $data = (new \App\Repo\Pos\Vakifbank())
    ->setMerchantId("000000006097810")
    ->setMerchantPassword("Fo5n4H8N")
    ->setTerminalNo("VP782406")
    ->setOrderId($oid)
    ->setCardNumber(str_replace(' ', '', $postData['number']))
    ->setExpiryDate(substr($postData['year'],-2).$postData['month'])
    ->setPurchaseAmount($postData['total'])
    ->setCurrency($postData['currency_code'])
    ->setBrandName($postData['brand_name'])
    ->setSuccessUrl(action('PaymentController@postSuccessVakif'))
    ->setFailureUrl(action('PaymentController@postErrorVakif'))
    ->check();


    $this->repo->reservation_code = $postData['code'];
    $this->repo->url = route('odemeYap', ['code' => $postData['code']]);
    $this->repo->order_id = $oid;
    $this->repo->name = $postData['name'];
    $this->repo->currency_code = $postData['currency_code'];
    $this->repo->total = $postData['total'];
    $this->repo->ip = $postData['ip'];
    $this->repo->save();

    $postData['oid']=$oid;
    session()->put('payment', $postData); // sonraki adım için bilgiler sessionda tutuluyor
    
    return view('payment.error', ['code' => $postData['code'],'error_message'=>$data['text']]);
  
    
  
}


public function postSuccessVakif(Request $request)
{
  
    $notify = new ManuelPayment;

  $result = (new \App\Repo\Pos\Vakifbank())
    ->setMerchantId("000000006097810")
    ->setMerchantPassword("Fo5n4H8N")
    ->setTerminalNo("VP782406")
    ->setCardNumber(str_replace(' ', '', session()->get('payment.number')))
    ->setExpiryDate(session()->get('payment.year').session()->get('payment.month'))
    ->setPurchaseAmount(session()->get('payment.total'))
    ->setCurrency(session()->get('payment.currency_code'))
    ->getPayment($request);
    if ($result['ResultCode'] != '0000') {
        // Para çekimi başarısız.
        $this->repo->where('order_id', session()->get('payment.oid'))->update(['message' => $result['ResultDetail'], 'status' => 'error']);
        return view('payment.error', ['code' => session()->get('payment.code'),'error_message'=>$result['ResultDetail']]);   
    }
 
    

 $this->repo->where('order_id', session()->get('payment.oid'))->update(['status' => 'success']);
    try {
        event(new YeniOdemeAlindi(session()->get('payment.oid')));
        $notify->notifyWunderList(session()->get('payment.oid'));

    } catch (\Exception $e) {

    }
    return redirect()->route('odemeLanding', ['order_id' => session()->get('payment.oid')]); 

}

public function postErrorVakif()
    {
        $error = 'İşlem başarısız';
        $this->repo->where('order_id', session()->get('payment.oid'))->update(['message' => $error, 'status' => 'error']);

        return view('payment.error', ['code' => session()->get('payment.code'),'error_message'=>$error]);
    }
    
    /*TEB */
    public function post($postData)
    {
        
         
        srand(strtotime('now'));

        $pos = new est3dModel;
        $data = [];
        $data['instalment'] = "";
        $data['total'] = $postData['total'];
        $data['order_id'] = 'VK-MAN-PAY-' . date('Ymds') . rand(10000, 99999);
        $data['fail_url'] = action('PaymentController@postError');
        $data['success_url'] = action('PaymentController@postSuccess');
        $data['cc_number'] = str_replace(' ', '', $postData['number']);
        $data['cc_cvv2'] = $postData['cvc'];
        $data['cc_expire_date_year'] = $postData['year'];
        $data['cc_expire_date_month'] = $postData['month'];
        // $data['cc_type'] = "MasterCard";
        $data['currency_code'] = $postData['currency_code'];
        $data['cc_owner'] = $postData['name'];

        $this->repo->reservation_code = $postData['code'];
        $this->repo->url = route('odemeYap', ['code' => $postData['code']]);
        $this->repo->order_id = $data['order_id'];
        $this->repo->name = $data['cc_owner'];
        $this->repo->currency_code = $data['currency_code'];
        $this->repo->total = $data['total'];
        $this->repo->ip = $data['ip'];
        $this->repo->save();

        Session::put('payment', serialize(array_except($data, ['cc_number', 'cc_cvv2', 'cc_expire_date_year', 'cc_expire_date_month', 'fail_url', 'success_url', 'cc_number'])));
        echo $pos->methodResponse($data)['form'];
    }

    public function postSuccess()
    {
        $notify = new ManuelPayment;

        $pos = new est3dModel;

        $this->repo->where('order_id', request()->oid)->update(['status' => 'success']);
        try {
            event(new YeniOdemeAlindi(request()->oid));
            $notify->notifyWunderList(request()->oid);

        } catch (\Exception $e) {

        }
        return redirect()->route('odemeLanding', ['order_id' => request()->oid]);

    }
    public function postSuccessLanding($order_id)
    {
        $data = $this->repo->where('order_id', $order_id)->first();
        $currencies = Currency::get();

        return view('payment.success', ['code' => $data->reservation_code, 'currencies' => $currencies]);

    }

    public function postError()
    {
        $error = request()->ErrMsg . ' ' . request()->mdErrorMsg;
        $this->repo->where('order_id', request()->oid)->update(['message' => $error, 'status' => 'error']);
        
        $data = $this->repo->where('order_id', request()->oid)->first();
        return view('payment.error', ['code' => $data->reservation_code,'error_message'=>$error]);
    }


    public function post2()
    {
        $tmp = explode('/', request()->expiry);
        srand(strtotime('now'));

        $pos = new est3dModel;
        $data = [];
        $data['instalment'] = "2";
        $data['total'] = request()->total;
        $data['order_id'] = 'VK-MAN-PAY-' . date('Ymd') . rand(1000000, 9999999);
        $data['fail_url'] = action('PaymentController@postError2');
        $data['success_url'] = action('PaymentController@postSuccess2');
        $data['cc_number'] = str_replace(' ', '', request()->number);
        $data['cc_cvv2'] = request()->cvc;
        $data['cc_expire_date_year'] = request()->year;
        $data['cc_expire_date_month'] = request()->month;
        $data['cc_type'] = "2";
        $data['currency_code'] = request()->currency_code;
        $data['cc_owner'] = request()->name;

        $this->repo->reservation_code = request()->code;
        $this->repo->url = action('PaymentController@index2', ['code' => request()->code]);
        $this->repo->order_id = $data['order_id'];
        $this->repo->name = $data['cc_owner'];
        $this->repo->currency_code = $data['currency_code'];
        $this->repo->total = $data['total'];
        $this->repo->ip = request()->ip();
        $this->repo->save();

        Session::put('payment', serialize(array_except($data, ['cc_number', 'cc_cvv2', 'cc_expire_date_year', 'cc_expire_date_month', 'fail_url', 'success_url', 'cc_number'])));
        echo $pos->methodResponse2($data)['form'];
    }

    public function index2()
    {
        if (request()->has('code')):

            $res = DB::table('reservations')->where('code', request('code'))->count();
            $pre = DB::table('pre_reservations')->where('code', request('code'))->count();

            if (!empty($res) || !empty($pre)):
                $currencies = DB::table('currencies')->get();
                return view('payment.index2', ['currencies' => $currencies]);
            else:
                $aciklama = ['tr' => ['title' => 'Yanlış Bir Rezervasyon Kodu Girilmiştir, Lütfen Doğru Girdiğinizden Emin Olun ve Tekrar Deneyiniz'], 'en' => ['title' => 'The Reservation Code You Have Entered Seems to be Wrong, Please Try Again']];
                return view('payment.code-required', ['error' => $aciklama]);
            endif;
        else:
            $aciklama = ['tr' => ['title' => 'Rezervasyon Kodunuz Olmadan İşlem Yapılamaz, Rezervasyon Kodunuzu Girerek İşleminizi Tekrar Deneyiniz'], 'en' => ['title' => 'Can\'t Process Without Reservation Code, Please Enter the Reservation Code and Try Again']];
            return view('payment.code-required', ['error' => $aciklama]);
        endif;
    }

    public function postError2()
    {
        dd(request()->all());
        $this->repo->where('order_id', request()->oid)->update(['message' => request()->ErrMsg . ' ' . request()->mdErrorMsg, 'status' => 'error']);
        $error = request()->ErrMsg . ' ' . request()->mdErrorMsg;
        return view('payment.error', ['error' => $error]);
    }

    public function postSuccess2()
    {
        $notify = new ManuelPayment;

        $pos = new est3dModel;

        $this->repo->where('order_id', request()->oid)->update(['status' => 'success']);
        try {
            event(new YeniOdemeAlindi(request()->oid));
            $notify->notifyWunderList(request()->oid);

        } catch (\Exception $e) {

        }
        // dd(unserialize(session()->get('payment')));
        $data = $this->repo->where('order_id', request()->oid)->first();
        $currencies = Currency::get();
        return view('payment.success', ['data' => $data, 'currencies' => $currencies]);
    }


    public function iyzicoIndex($code)
    {
        $pre_reservation = \App\PreReservation::where('code', $code)->first();
        $customer = $pre_reservation->customer_real;
        $customer_name = (\App\Helpers\Helper::splitName($customer->name));


        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZIPAY_API_KEY'));
        $options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
        $options->setBaseUrl(env('IYZIPAY_BASE_URL'));


        $basketId = rand(1000, 9999);
        $conversationId = 'VK-IYZ-PAY-' . date('Ymd') . substr(md5($pre_reservation->id), -1)  . rand(100000, 999999);

        $iyziRequest = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $iyziRequest->setLocale(\Iyzipay\Model\Locale::TR);
        $iyziRequest->setConversationId($conversationId);
        $iyziRequest->setPrice($pre_reservation->pre_payment);
        $iyziRequest->setPaidPrice($pre_reservation->pre_payment);
        $iyziRequest->setCurrency(\Iyzipay\Model\Currency::TL);
        $iyziRequest->setBasketId('B' . $basketId);
        $iyziRequest->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $iyziRequest->setCallbackUrl(route('iyzicoPost', $code));
        $iyziRequest->setEnabledInstallments(array(2, 3, 4, 6));


        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($pre_reservation->code);
        $buyer->setName($customer_name['firstname'] . ' ' . $customer_name['middlename']);
        $buyer->setSurname($customer_name['lastname']);
        $buyer->setGsmNumber($customer->phone);
        $buyer->setEmail($customer->email);
        $buyer->setIdentityNumber($pre_reservation->invoice_data->identification ?? $customer->idnumber);
        $buyer->setLastLoginDate(date('Y-m-d H:i:s', strtotime($pre_reservation->created_at)));
        $buyer->setRegistrationDate(date('Y-m-d H:i:s', strtotime($customer->created_at)));
        $buyer->setRegistrationAddress($pre_reservation->address ?? $customer->address);
        $buyer->setIp(request()->ip);
        $buyer->setCity($pre_reservation->invoice_data->ad ?? "Seçilmemiş");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("");
        $iyziRequest->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($customer->name);
        $shippingAddress->setCity($pre_reservation->invoice_data->ad ?? "Seçilmemiş");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress($pre_reservation->address ?? $customer->address);
        $shippingAddress->setZipCode("");
        $iyziRequest->setShippingAddress($shippingAddress);


        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($customer->name);
        $billingAddress->setCity($pre_reservation->invoice_data->ad ?? "Seçilmemiş");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress($pre_reservation->address ?? $customer->address);
        $billingAddress->setZipCode("");
        $iyziRequest->setBillingAddress($billingAddress);


        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId($pre_reservation->code);
        $firstBasketItem->setName($pre_reservation->villa->name . ' ' . date('d-m-Y', strtotime($pre_reservation->start_date)) . ' ' . date('d-m-Y', strtotime($pre_reservation->end_date)) . ' konaklama hizmet bedeli');
        $firstBasketItem->setCategory1("Villa");
        $firstBasketItem->setCategory2("Ön Ödeme");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($pre_reservation->pre_payment);
        $basketItems[0] = $firstBasketItem;

        $iyziRequest->setBasketItems($basketItems);


        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($iyziRequest, $options);


        $repo = [];
        $repo['conversation_id'] = $conversationId;
        $repo['status'] = 'index';
        $repo['type'] = 'iyzico';
        $repo['reservation_code'] = $code;
        $repo['url'] = route('odemeYap', ['code' => $code]);
        $repo['order_id'] = $conversationId;
        $repo['name'] = $customer->name;
        $repo['currency_code'] = "949";
        $repo['total'] = $pre_reservation->pre_payment;
        $repo['ip'] = request()->ip();
      $view= $checkoutFormInitialize->getCheckoutFormContent();
      return ['repo'=>$repo,'view'=>$view];
       // return ['view' => view('payment.iyzipay', compact('iyziRequest', 'checkoutFormInitialize', 'conversationId')), 'repo' => $repo];

    }

    public function iyzicoPost($code)
    {
        $payment = ManualPayment::where('reservation_code', $code)->first();
        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZIPAY_API_KEY'));
        $options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
        $options->setBaseUrl(env('IYZIPAY_BASE_URL'));

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId($payment->conversation_id);
$request->setToken(request()->token);

# iyzico ödeme kontrol
$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

        if ($checkoutForm->getPaymentStatus() == 'SUCCESS') {
            try {
                event(new YeniOdemeAlindi($payment->order_id, 'iyzico'));
            
            } catch (\Exception $e) {
            
            }
            ManualPayment::where('reservation_code', $code)->update(['token' => request()->token, 'status' => 'success']);
          
            return view('payment.success', ['type' => 'iyzico', 'code' => $code]);
        
        }else {
            ManualPayment::where('reservation_code', $code)->update(['message'=>$checkoutForm->getErrorMessage(),'token' => request()->token, 'status' => 'await']);
       
            return view('payment.error', ['type' => 'iyzico', 'code' => $code,'error_message'=>$checkoutForm->getErrorMessage()]);
        }
      

       


      
    }
    public function iyzicoLandingPage($code)
    {
   
      // $pre_reservation = PreReservation::where('code', $code)->firstOrFail();
        return view('payment.success', ['type' => 'iyzico', 'code' => $code]);
    }
}
