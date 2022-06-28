<?php


//Route::get('test-me', function () {
//
//    $list = new \App\Repo\Tasklist\Trello\Main();
//    $card = new \App\Repo\TaskList\Trello\src\Card();
//    $card_id = $list->getListId('manuel-odemeler');
//    $str = 'post comment test';
//    $input['name'] = 'BIRTAN TEST' . ' ' . 99999 . ' TOPLAM: ' . 9999 . ' ' . 'TL';
//    $member = [];
//    $member[] = '5c02905fbd19db69ad1ccc30';/*ALPER CELIK*/
//    $member[] = '5e3c1e15bae699297785c9de';/*UGUR-DURGUN*/
//    $member[] = '5e398d41ba93930733be11b0';/*UGUR-DURGUN*/
//
//    $input['idMembers'] = implode(',', $member);
//
//
//    $response = $card->createList($card_id, $input);
//    $list_id = $response->id;
//    $card->postComment($list_id, $str);
//});


//
//Route::match(['get', 'post'], 'test-iyzico', function(){
//
//
//
//    if(request()->isMethod('post')) {
//
//        dd(request()->all());
//
//        $token = request()->token;
//
//        \App\ManualPayment::create();
//
//    }
//
//    $pre_reservation = \App\PreReservation::where('code', 'VKV194919118293')->first();
//    $customer = $pre_reservation->customer_real;
//    $customer_name = (\App\Helpers\Helper::splitName($customer->name));
//
//
//    $options = new \Iyzipay\Options();
//    $options->setApiKey(env('IYZIPAY_API_KEY'));
//    $options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
//    $options->setBaseUrl(env('IYZIPAY_BASE_URL'));
//
//
//    $conversationId = $pre_reservation->code . '-' . rand(1000, 9999);
//
//    $iyziRequest = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
//    $iyziRequest->setLocale(\Iyzipay\Model\Locale::TR);
//    $iyziRequest->setConversationId($conversationId);
//    $iyziRequest->setPrice($pre_reservation->pre_payment);
//    $iyziRequest->setPaidPrice($pre_reservation->pre_payment);
//    $iyziRequest->setCurrency(\Iyzipay\Model\Currency::TL);
//    $iyziRequest->setBasketId("B67832");
//    $iyziRequest->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
//    $iyziRequest->setCallbackUrl("/test-iyzico");
//    $iyziRequest->setEnabledInstallments(array(2, 3, 4, 6));
//
//
//    $buyer = new \Iyzipay\Model\Buyer();
//    $buyer->setId($pre_reservation->code);
//    $buyer->setName($customer_name['firstname'] . ' ' . $customer_name['middlename']);
//    $buyer->setSurname($customer_name['lastname']);
//    $buyer->setGsmNumber($customer->phone);
//    $buyer->setEmail($customer->email);
//    $buyer->setIdentityNumber($customer->idnumber);
//    $buyer->setLastLoginDate(date('Y-m-d H:i:s', strtotime($pre_reservation->created_at)));
//    $buyer->setRegistrationDate(date('Y-m-d H:i:s', strtotime($customer->created_at)));
//    $buyer->setRegistrationAddress($pre_reservation->invoice_data->billing_address ?? $customer->address);
//    $buyer->setIp(request()->ip);
//    $buyer->setCity($pre_reservation->invoice_data->ad ?? "Seçilmemiş");
//    $buyer->setCountry("Turkey");
//    $buyer->setZipCode("");
//    $iyziRequest->setBuyer($buyer);
//
//    $shippingAddress = new \Iyzipay\Model\Address();
//    $shippingAddress->setContactName($customer->name);
//    $shippingAddress->setCity($pre_reservation->invoice_data->ad ?? "Seçilmemiş");
//    $shippingAddress->setCountry("Turkey");
//    $shippingAddress->setAddress($pre_reservation->invoice_data->billing_address ?? $customer->address);
//    $shippingAddress->setZipCode("");
//    $iyziRequest->setShippingAddress($shippingAddress);
//
//
//    $billingAddress = new \Iyzipay\Model\Address();
//    $billingAddress->setContactName($customer->name);
//    $billingAddress->setCity($pre_reservation->invoice_data->ad ?? "Seçilmemiş");
//    $billingAddress->setCountry("Turkey");
//    $billingAddress->setAddress($pre_reservation->invoice_data->billing_address ?? $customer->address);
//    $billingAddress->setZipCode("");
//    $iyziRequest->setBillingAddress($billingAddress);
//
//
//
//    $basketItems = array();
//    $firstBasketItem = new \Iyzipay\Model\BasketItem();
//    $firstBasketItem->setId($pre_reservation->code);
//    $firstBasketItem->setName($pre_reservation->villa->name . ' ' . date('d-m-Y', strtotime($pre_reservation->start_date)) . ' ' . date('d-m-Y', strtotime($pre_reservation->end_date)) . ' konaklama hizmet bedeli' );
//    $firstBasketItem->setCategory1("Villa");
//    $firstBasketItem->setCategory2("Ön Ödeme");
//    $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
//    $firstBasketItem->setPrice($pre_reservation->pre_payment);
//    $basketItems[0] = $firstBasketItem;
//
//    $iyziRequest->setBasketItems($basketItems);
//
//    $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($iyziRequest, $options);
//
//
//    return view('payment.iyzipay', compact('iyziRequest', 'checkoutFormInitialize', 'conversationId'));
/* }); */
Route::group(['middleware' => ['XSS']], function () {
Route::get('/ajax-get/areas', 'SearchController@getAreas')->name('search.get-areas');
Route::match(['get', 'post'],'ajax-get/{id}/districts', 'SearchController@getDistricts')->name('search.get-districts');
Route::get('test-todoist', function() {
    $todoist = new \App\Repo\Todoist\Todoist();
    //dd(json_decode($todoist->getProject()));
});
Route::get('/clear-cache', function() {
   $exitCode = Artisan::call('cache:clear');
   // return what you want
});
Route::get('test-mail-gonder', 'MailTestController@api');

Route::post('contact-form', 'ContactFormController@submit');

Route::get('reservation/{code}', 'ReservationController@showReservationDetails')->name("showReservationDetails");
Route::get('reservation/owner/{code}', 'ReservationController@showReservationOwnerDetails')->name("showReservationDetailsOwner");
Route::get('/reservation/{id}/pdf-sozlesme', 'ReservationController@sozlesmeDownload')->name('nav.reservation.pdf.downloadSozlesme');
Route::get('kisi-listesi-ekle/{code}', 'ReservationController@kisiListesiEkle')->name("kisiListesiEkle");
Route::post('kisi-listesi-ekle/{code}', 'ReservationController@kisiListesiEklePost')->name("kisiListesiEkle.post");


Route::get('cache-temizle', 'VillaBotController@cacheTemizle');
//Route::get('sitemap.xml', 'SitemapController@index');
Route::get('sitemap.xml', 'SitemapController@main');
Route::get('sitemap-{url}.xml', 'SitemapController@detail')->name('sitemap.detail');
Route::get('criteo.xml', 'CriteoController@index');
Route::get('facebook.xml', 'FacebookController@index');

//Route::get('odeme-yap', 'PaymentController@index')->name('kredikart');
Route::post('odeme-yap', 'PaymentController@post');
Route::post('odeme-yap-iyzico/{code}/', 'PaymentController@iyzicoPost')->name('iyzicoPost');

Route::get('odeme-talebi-basari/{code}', 'PaymentController@iyzicoLandingPage')->name('iyzicoLanding');
Route::post('odeme-yap-basarili', 'PaymentController@postSuccess');
Route::post('odeme-yap-basarisiz', 'PaymentController@postError');

Route::get('odeme-yap-2', 'PaymentController@index2');
Route::post('odeme-yap-2', 'PaymentController@post2');
Route::post('odeme-yap-2-basarili', 'PaymentController@postSuccess2');
Route::post('odeme-yap-2-basarisiz', 'PaymentController@postError2');

Route::get('odeme-basarili-success/{order_id}', 'PaymentController@postSuccessLanding')->name('odemeLanding');

Route::get('public/{url}', 'RedirectController@index');
Route::get('/', 'HomeController@index')->name('home');

Route::get('/teklif/{uid}','OfferController@getOffer')->name('getOffer');
Route::get('/teklif_alin','OfferController@offer')->name('offer');
Route::post('/teklif_alin','OfferController@offer')->name('offer');
Route::get('/teklif_alindi','OfferController@offerDone')->name('offer.done');
Route::post('/teklif_alindi','OfferController@offerDone')->name('offer.done');

Route::get('/type/{type_slug}','VillatypeController@index')->name('type.index');

Route::post('/on_rezervasyon_yap','ReservationController@addPreReservation')->name('addPreReservation');
Route::get('/on_rezervasyon_tamamlandi','ReservationController@preReservationDone')->name('preReservationDone');
Route::get('odeme-yap', 'ReservationController@odemeBasla')->name('odemeYap');
Route::post('rezervasyon-guncelle', 'ReservationController@preRezGuncelle')->name('preRezGuncelle');
Route::get('/kvkk-aydinlatma-metni','ReservationController@preKvk')->name('kvkk');
Route::get('eft-rezervasyon-tamamlandi', 'ReservationController@eftRezDone')->name('eftRezDone');

 
Route::get('/rezervasyon_tamamlandi','ReservationController@reservationDone')->name('reservation.done');
Route::post('/rezervasyon_tamamlandi','ReservationController@reservationDone')->name('reservation.done');
Route::get('/rezervasyon_yapilamiyor','ReservationController@reservationError')->name('reservation.error');
Route::get('/rezervasyon_yap{id}',function() {

    return '
	<h1>Web Sitemizde Teknik bir iyileştirme yapılıyor.</h1>
Lütfen Tarayıcınızı geçmişinizi temizleyerek tekrar deneyiniz veya<a href="https://api.whatsapp.com/send?phone=902422520032&"> Whatsapp’tan lütfen satış ekibimizle iletişime geçiniz.</a> ';

});
Route::post('/rezervasyon_yap{id}','ReservationController@reservation')->name('reservation');

Route::get('/search', 'SearchController@search')->name('search');
Route::get('/arama', 'SearchController@searchAlter')->name('search.alter');
Route::get('/kiralik-villa-kategorilerimiz/{category?}', 'SearchController@searchNoDate')->name('search.no-date');
Route::get('/kiralik-villa-ara/{category?}/{start_date?}/{end_date?}', 'SearchController@search')->name('search.new');
Route::get('/kiralik-villa-ara/{category?}/{start_date?}/{end_date?}', 'SearchController@searchSpagetti')->name('search.spagetti');


//Route::get('/realtime_search/{search}', 'RealtimeSearchController@search');
Route::get('/realtime_search/{search}', 'RealtimeSearchController@searchAlt');
Route::get('/villa_status/{villa_id}/{yil}', 'VillaController@getStatus');

Route::get('/getPrices/{villa_id}/{giris_tarih}/{cikis_tarih}', 'VillaController@getPrices');

Route::get('crawl-villa-links', 'VillaBotController@updateVillaLinks');
Route::match(['GET', 'POST'], 'crawl-all-urls', 'VillaBotController@crawlVillaUri');
Route::match(['GET', 'POST'], 'crawl-all-urls-desktop', 'VillaBotController@crawlVillaUriDesktop');
Route::get('set-villa-real-urls', 'VillaBotController@setVillaUrl');

Route::get('villa-bulunamadi', 'PageController@villaNotFound');
Route::get('/{link}','StaticPageController@index')->name('static');
Route::get('/blog/{link}','BlogController@blog')->name('blog.control');
Route::get('/blog/{category_name}/{link}','BlogController@blog')->name('blog.category.detail');
Route::get('/{link}/{giris_tarih}/{cikis_tarih}','StaticPageController@index')->name('villa.detail.search');
Route::get('/ekstra/{link}','ExtraController@extra')->name('extra.detail');
Route::get('/{kategoriler_seo}/{link}','StaticPageController@index')->name('category.detail');


Route::post('ajax-il-getir/{ulke_id}', 'SearchController@il_getir')->name('search.il-getir');
Route::post('ajax-ilce-getir/{il_id}', 'SearchController@ilce_getir')->name('search.ilce-getir');
});