<?php

namespace App\Http\Controllers;

use App\{OfferRequest, Offer, Area, Villa, Customer, PossibleCustomer};
use App\Helpers\Helper;
use App\WebsitePanelGeneralsetting;
use App\WebsitePanelGeneralsettingVillatype;
use App\WebsitePanelGeneralsettingVillacategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Events\AdminTeklifAlindi;

class OfferController extends Controller
{
    public function index()
    {
        return view('offer.index');
    }

    public function offer(Request $req)
    {
//        $res = DB::table('offer_requests')->get();
//       foreach ($res as $row):
//            DB::table('offer_requests')->where('id', $row->id)->update(['area_id' => "[".json_encode($row->area_id)."]"]);
//        endforeach;
        if (Helper::isPost($req)) {

            $inputs = $req->except('_token', 'name', 'email', 'prephone', 'phone');
            $inputs['net_date'] = $req->net_date == "true" ? 1 : 0;
            $inputs['three_days_available'] = $req->three_days_available == 'on' ? 1 : 0;
            $inputs['website_id'] = 15/*APP_WEBSITE_ID*/
            ;
            $inputs['absolutes'] = (!empty($req->absolutes) ? implode(',', $req->absolutes) : '');
            $inputs['features'] = (!empty($req->features) ? implode(',', $req->features) : '');
            $inputs['area_id'] = (!empty($req->area_id) ? json_encode($req->area_id) : '');

            if ($req->net_date == "true") {
                if (\Agent::isMobile()) {
                    $inputs['start_date'] = $req->giris_tarih;
                    $inputs['end_date'] = $req->cikis_tarih;
                }
                $inputs['start_date'] = Carbon::parse($inputs['start_date'])->format("Y-m-d");
                $inputs['end_date'] = Carbon::parse($inputs['end_date'])->format("Y-m-d");
            }

            $checkCustomer = Customer::where('phone', $req->prephone . $req->phone)->first();
            $notificationArr = array_merge(['name' => $req->name, 'email' => $req->email, 'phone' => $req->prephone . $req->phone]);
            if (is_null($checkCustomer)):
                // POSSIBLE CUSTOMER
                $customer_type = "possible";

                $checkPossibleCustomer = PossibleCustomer::where('phone', $req->prephone . $req->phone)->first();
                if (is_null($checkPossibleCustomer)):
                    $possible_customer = PossibleCustomer::create(['name' => $req->name, 'email' => $req->email, 'phone' => $req->prephone . $req->phone, 'website_id' => 15/*APP_WEBSITE_ID*/]);
                    $customer_id = $possible_customer->id;
                else:
                    $customer_id = $checkPossibleCustomer->id;
                endif;

            else:
                // BOYLE BIR KULLANICI ZATEN VAR.  normal
                $customer_id = $checkCustomer->id;
                $customer_type = "normal";
            endif;
            $inputs['customer_type'] = $customer_type;
                $inputs['customer_id'] = $customer_id;

            try {
                Helper::notification('teklif', $notificationArr);
            } catch(\Exception $exception) {

            }

            try {
                $inputs['api_token'] = config('app.api_user_token');
                if(env('APP_LOCAL_DEBUG', false)){
                    /*LOCAL*/
                    $ch = curl_init(config('app.api_base_url.local') . '/offerRequest/create');
                } else {
                    $ch = curl_init(config('app.api_base_url.production') . '/offerRequest/create');
                }
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $inputs);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept' => 'application/json']);
                $response = json_decode(curl_exec($ch));
                if(isset(curl_getinfo($ch)['http_code']) && curl_getinfo($ch)['http_code']!=200) {
                    throw new \Exception('Api Server error');
                }
                curl_close($ch);
                $offerRequest = $response;
            } catch (\Exception $e) {
                $offerRequest = OfferRequest::create($inputs);
            }

            if(env('APP_LOCAL_DEBUG', false)){} else {event(new AdminTeklifAlindi($offerRequest->id));}
            return Redirect::route('offer.done')->with(['success' => 'offer_done', 'offerRequest' => $offerRequest->id, 'customer' => $customer_id]);
        } else {
            $general = WebsitePanelGeneralsetting::where(['website_id' => 15/*APP_WEBSITE_ID*/])->first();
            $areas = Area::whereHas('villa', function ($q) {
                $q->where('status', '1');
            })->select(['id', 'name'])->get();

            $villa_types = WebsitePanelGeneralsettingVillatype::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'generalsetting_id' => $general->id])->get();
            $villa_category = WebsitePanelGeneralsettingVillacategory::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'generalsetting_id' => $general->id])->get();


            return view('offer.offer', compact('general', 'villa_types', 'villa_category', 'areas'));
        }
    }

    public function offerDone(Request $req)
    {
        if (session('success')) {
            $bilgi[99] = "<svg class='icon icon-yes'><use xlink:href='#icon-yes'></use></svg>";
            $bilgi[0] = "TEKLİF TALEBİNİZ ALINMIŞTIR.";
            $bilgi[1] = "";
            $bilgi[2] = "Size uygun teklifimiz e-mail olarak gönderilecektir.";
            //Müşteri temsilcimiz aşağıdaki telefon numaranızdan      sizinle iletişime geçecektir.

            $customer = session('customer');
            $offerRequest = session('offerRequest');
            $offerRequest = OfferRequest::where('id', $offerRequest)->first();

            if ($offerRequest->customer_type == "possible") {
                $customer = PossibleCustomer::where('id', $customer)->first();
            } else {
                $customer = Customer::where('id', $customer)->first();
            }

            return view('offer.done', compact('offerRequest', 'customer', 'bilgi'));
        } elseif (Helper::isPost($req)) {
            if ($req->customer_type == "possible") {
                $customerTable = PossibleCustomer::where('id', $req->customer);
            } else {
                $customerTable = Customer::where('id', $req->customer);
            }
            $inputs = $req->except('_token', 'customer', 'offerRequest', 'customer_type');
            $customerTable->update($inputs);
            $offerRequest = $req->offerRequest;
            $customer = $req->customer;
            return Redirect::route('offer.done')->with(['success' => 'offer_done', 'offerRequest' => $offerRequest, 'customer' => $customer]);
        } else {
            return redirect()->to('/');
        }
    }

    public function getOffer(Request $req)
    {
        $offer = Offer::where('uid', $req->uid)->first();
        $json = json_decode($offer->villas);
        foreach ($json as $veri) {
            $villa_ids[] = $veri[0];
            $villa_not[] = $veri[1];
        }


        if (!empty($villa_ids)) {

//            foreach($villa_ids as $row):
//                $villas_arr[] = $villas = Villa::with(['photos', 'seo', 'prominents.generalProminent', 'panel_villa.panel_tag' => function ($query) {
//                    $query->where('website_id', '=', 2/*APP_WEBSITE_ID*/);
//                }])->where('id', $row)->first();
//            endforeach;
            $villas_arr = Villa::with(['photos', 'seo', 'prominents.generalProminent', 'panel_villa.panel_tag','panel_villa' => function ($query) {
                $query->where('website_id', '=', 15/*APP_WEBSITE_ID*/);
            $query->where('status', '=', 1);

            }])->whereIn('id', $villa_ids)->paginate(5);


//            $villas = Villa::with(['photos', 'seo', 'prominents.generalProminent', 'panel_villa.panel_tag' => function ($query) {
//                $query->where('website_id', '=', 15/*APP_WEBSITE_ID*/);
//            }])->whereIn('id', $villa_ids)->get();

            return view('offer.getOffer', compact('offer', 'prominents', 'json', 'villas_arr'));
        } else {
            return view('home.index');
        }
    }
}
