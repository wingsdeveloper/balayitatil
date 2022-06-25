<?php
/**
 * Created by PhpStorm.
 * User: candgrmc
 * Date: 11/24/18
 * Time: 3:18 PM
 */

namespace App\Helpers;

use App\IcalImport;
use App\Models\WebsitePanelPriority;
use App\PreReservation;
use App\villaPrice;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Intervention\Image\Facades\Image;
use PhpParser\Error;
use App\Reservation;
use App\ManualCalendar;
use App\Villa;
use App\WebsitePanelOpportunity;
use App\WebsitePanelSeo;
use App\WebsitePanelGeneralsetting;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function notification($type, $data = [])
    {
        switch ($type) {
            case 'teklif':
                $url = 'https://chat.wings.com.tr/hooks/625adf35496cc93381dfda78/xvSwyHAQ87B6WBZob6HCpQrL9RLpbLpJoCrgWvKgNJRvvKmA';
                $text = "++_________________________++\n Villakalkan teklif isteği oluşturuldu. \n ";
                $text .= ' Isim: ' . $data['name'] . " \n Telefon: " . $data['phone'] . " \n Email: " . $data['email'] . "\n ++_________________________++";
                $postdata = ['text' => $text];
                break;
            case 'onrezervasyon':
                $url = 'https://chat.wings.com.tr/hooks/625ad979496cc93381dfda4e/CJ8qeEPBKd3YX6xTRJWESrFGrcqxok8cERK3TwQuMRAs9mWh';
                $text = view('emails.reservation', ['data' => $data['data'], 'customer' => $data['customer']])->render();
                $text = str_replace('</b>', '*', str_replace('<b>', '*', $text));
                $postdata = ['text' => str_replace('<br>', "", $text)];
                break;

            case 'manuelodeme':
                $url = 'https://chat.wings.com.tr/hooks/625adfe9496cc93381dfda79/eLaa9yGapQHjeiSZEany7Bu5JoxADsZpuiQMwpLq24oo6mLR';
                $text = view('emails.manuel-payment', ['data' => $data['data'], 'customer' => $data['customer'], 'reservation' => $data['reservation'], 'villa' => $data['villa'], 'odeme' => $data['odeme'], 'type' => $data['type']])->render();
                $postdata = ['text' => str_replace('<br>', "", $text)];
                break;
            default:
                break;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public static function cdn_url($url)
    {
        return $url;
    }

    public static function getPermissions()
    {
        return [
            'villas',
            'customers',
            'companies',
            'websites',
            'users',
        ];
    }

    public static function isPost($request)
    {
        return ($request->method() == 'POST') ? true : false;
    }

    public static function setResponse($data, $code = 200)
    {
        if ($data && count($data)) {
            $response = [
                'status' => true,
                'data' => $data
            ];
        } else {
            $response = [
                'status' => false,
                'data' => $data
            ];
        }

        return response()->json($response, $code);
    }

    public static function getSmsTemplate($replace, $template)
    {
        try {
            if (!is_array($replace)) {
                throw new \Exception('Variable is not an array');
            }
            return str_replace(array_keys($replace), array_values($replace), $template);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public static function hasReservationDates($start, $end, $villa)
    {
        if (Reservation::where('villa_id', $villa)->whereNull('deleted_at')->where('start_date', '>=', $start)->where('end_date', '<=', $start)->exists()) {
            return true;
        } else if (Reservation::where('villa_id', $villa)->whereNull('deleted_at')->where('end_date', '>=', $end)->where('end_date', '<=', $end)->exists()) {
            return true;
        } else if (ManualCalendar::where('villa_id', $villa)->whereNull('deleted_at')->where('start_date', '>=', $start)->where('end_date', '<=', $start)->exists()) {
            return true;
        } else if (ManualCalendar::where('villa_id', $villa)->whereNull('deleted_at')->where('end_date', '>=', $end)->where('end_date', '<=', $end)->exists()) {
            return true;
        }
        return false;
    }


    public static function image_convert($image, $directory, $thumb_directory, $filename)
    {
        if (file_exists($directory)) {
            Image::make($image->getRealPath())->save(public_path("{$directory}/{$filename}"));
            if (file_exists($thumb_directory)) {
                Image::make($image->getRealPath())->save(public_path("{$thumb_directory}/{$filename}"));
            } else {
                if (mkdir($thumb_directory, 0777, true)) {
                    Image::make($image->getRealPath())->save(public_path("{$thumb_directory}/{$filename}"));
                } else {
                    return "error";
                }
            }
        } else {
            if ($image != null) {
                if (mkdir($directory, 0777, true)) {
                    Image::make($image->getRealPath())->save(public_path("{$directory}/{$filename}"));
                    if (file_exists($thumb_directory)) {
                        Image::make($image->getRealPath())->save(public_path("{$thumb_directory}/{$filename}"));
                    } else {
                        if (mkdir($thumb_directory, 0777, true)) {
                            Image::make($image->getRealPath())->save(public_path("{$thumb_directory}/{$filename}"));
                        } else {
                            return "error";
                        }
                    }
                } else {
                    return "error";
                }
            }
        }
    }

    public static function image_delete($path, $thumb_path)
    {
        if (file_exists($path)) {
            unlink($path);
            if (file_exists($thumb_path)) {
                unlink($thumb_path);
            }
        }
    }

    public static function recursiveRemoveDirectory($directory)
    {
        foreach (glob("{$directory}/*") as $file) {
            if (is_dir($file)) {
                Helper::recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        }
        rmdir($directory);
    }

    /*
Villaya ait  geçerli sezondaki gecelik fiyat

    */
    public static function nPrice($villaID)
    {
        $orderbyraw = "CAST(daily_price_tl AS DECIMAL(10,2)) ASC";
        $pricesmin = villaPrice::select("daily_price_tl")->where('villa_id', $villaID)->whereYear('start_date',date('Y'))->where("daily_price_tl", ">", 0)->
        orderByRaw($orderbyraw)->first();
        return ceil($pricesmin->daily_price_tl);
    }

    /*

    Seçilen villanın 2 tarih arasındaki fiyat detaylarını getirir

    Kullanımı:
    $villa_fiyat=App\Helpers\Helper::gunlukFiyat($villa->villa_id,$req->giris_tarih,$req->cikis_tarih);
    sonuç olarak dizi döner
    [0]: Toplam Fiyat
    [1]: Günlük Ortalama Fiyat
    [2]: Gün Farkı (Gece sayısını baz alır)
    [3]: Temizlik Ücreti
    [4]: Günleri ve Karşılık gelen fiyatı dizi olarak döner
    [5]: Ön Ödeme
    [6]: Kalan Ödeme
    [7]: Hesap Toplam
    [8]: Minimum Konaklama Süresi
    */
    public static function gunlukFiyat($villa_id, $giris_tarih, $cikis_tarih)
    {

        $villa = Villa::select(['prepayment_rate', 'default_cleaning_price', 'min_accommodation', 'min_accommodation_season'])->where('id', $villa_id)->first();

        $giris = Carbon::parse($giris_tarih);
        $cikis = Carbon::parse($cikis_tarih);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $girisYil = $giris->format('Y');
        $cikisYil = $cikis->format('Y');


        $price = villaPrice::select(['daily_price_tl', 'short_stay', 'min_accommodation', 'min_stay_cleaning_price'])->where('villa_id', $villa_id)->whereRaw("(( start_date <= '$giris_tarih' AND end_date >= '$giris_tarih' ) OR ( start_date <= '$cikis_tarih' AND end_date >= '$cikis_tarih' ) OR ( start_date >= '$giris_tarih' AND end_date <= '$cikis_tarih')) AND daily_price_tl!='0.00' ORDER BY start_date ASC")->get();
//$price Değişkeni girilen tarihler arasındaki fiyatları listeler örneğin hem haziran hemde temmuz ayı seçilmişse bu 2 ayın da fiyat bilgilerini dizi halinde verir
        $toplam_fiyat = null;
        $temizlik_ucreti = null;
        $period = CarbonPeriod::create($giris, $cikis);
        $gun_farki = $giris->diffInDays($cikis, false);

        //Tarihler arasındaki gün farkını Carbon ile hesaplıyoruz(Gece sayısını almak için)
        if (count($price) == 1) {
            //eğer 1 fiyat modeli varsa direk gün sayısıyla çarpıp toplam fiyatı alıyoruz

            $gune_ait_fiyat = floatval(str_replace(",", ".", $price->first()->daily_price_tl));

            $toplam_fiyat = ceil($gun_farki * $gune_ait_fiyat);


            foreach ($period as $key => $date) {
                if (count($period) != $key + 1) {
                    $gun = $date->format('Y-m-d');
                    $gun_ve_fiyat[] = array(ceil($gune_ait_fiyat), $gun);
                }
            }
            $fiyatli_min_konaklama = $price->first()->min_accommodation ?? 0;
            $temizlik_ucreti_min_konaklama = $price->first()->min_stay_cleaning_price ?? 7;
            if ($gun_farki < $temizlik_ucreti_min_konaklama) {
                if ($price->first()->short_stay == 0 || empty($price->first()->short_stay)) {
                    $temizlik_ucreti = $villa->default_cleaning_price;
                } else {
                    $temizlik_ucreti = $price->first()->short_stay;
                }
            }
//            if ($gun_farki < 7) {
//                /*Gün farkı 7den az ise temizlik ücreti hesaplanacak farklı fiyat modelleri olduğu için temizlik ücretini de günlük topluyoruz diğer modellerin ortalaması alınacak
//                                */
//                if ($price->first()->short_stay == 0 || empty($price->first()->short_stay)) {
//                    $temizlik_ucreti = $villa->default_cleaning_price;
//                } else {
//                    $temizlik_ucreti = $price->first()->short_stay;
//                }
//            }
        } elseif (count($price) > 1) {
            //eğer 1 den fazla fiyat modeli varsa her güne denk gelen fiyatı tek tek hesaplıyoruz
            //Gelen tarihi gün gün artacak şekilde döngüye koyuyoruz (86400 saniye 24 saate denk geliyor)
            /*1 den fazla tarih araligi geldiginde ilk olarak secilmis olan fiyat araliginin min_stay_cleaning_price secilecek*/

            foreach ($period as $key => $date) {
                if (count($period) != $key + 1) {

                    $gun = $date->format('Y-m-d');

                    $prices = villaPrice::select(['daily_price_tl', 'short_stay', 'end_date', 'min_accommodation', 'min_stay_cleaning_price'])->where('villa_id', $villa_id)->whereDate('end_date', '>=', $gun)->whereDate('start_date', '<=', $gun)->where('daily_price_tl', '!=', '0.00')->first();

                    if (!empty($prices)) {
                        $gune_ait_fiyat = floatval(str_replace(",", ".", $prices->daily_price_tl));
                        $toplam_fiyat = $toplam_fiyat + $gune_ait_fiyat;

                        $gun_ve_fiyat[] = array(ceil($gune_ait_fiyat), $gun);
                        $fiyatli_min_konaklama = $prices->min_accommodation;
                    }
//                    if ($gun_farki < 7) {
//                        if (empty($prices) || $prices->short_stay == 0 || empty($prices->short_stay)) {
//                            $temizlik_ucreti = $villa->default_cleaning_price;
//                        } else {
//                            $temizlik_ucreti = $prices->short_stay;
//                        }
//                    }
                }
            }

            $temizlik_ucreti_min_konaklama = $price->first()->min_stay_cleaning_price ?? 7;;
            if ($gun_farki < $temizlik_ucreti_min_konaklama) {
                if ($price->first()->short_stay == 0 || empty($price->first()->short_stay)) {
                    $temizlik_ucreti = $villa->default_cleaning_price;
                } else {
                    $temizlik_ucreti = $price->first()->short_stay;
                }
            }

        }

        $opp = WebsitePanelOpportunity::where('villa_id', '=', $villa_id)->whereDate('start_date', $giris_tarih)->whereDate('end_date', $cikis_tarih)->first();
        if (is_null($opp)) {

            if (isset($fiyatli_min_konaklama) && $fiyatli_min_konaklama != 0 && !empty($fiyatli_min_konaklama)) {
                $min_accommodation = $fiyatli_min_konaklama;
            } else {
                if (($giris_tarih >= "$cikisYil-06-01" && $giris_tarih <= "$cikisYil-09-30") || ($cikis_tarih >= "$cikisYil-06-01" && $cikis_tarih <= "$cikisYil-09-30")) {
                    $min_accommodation = (isset($villa->min_accommodation_season) ? $villa->min_accommodation_season : 0);
                } else {
                    $min_accommodation = (isset($villa->min_accommodation) ? $villa->min_accommodation : 0);
                }
            }
        } else {
            $oppgiris = Carbon::parse($opp->start_date);
            $oppcikis = Carbon::parse($opp->end_date);
            $oppgun_farki = $oppgiris->diffInDays($oppcikis, false);
            $min_accommodation = $oppgun_farki;

        }
        if ($gun_farki > 6) {
            $temizlik_ucreti = 0;
        }
        if (count($price) == 0) {
            //seçilen tarih aralığına ait fiyat yoksa gunluk_ortalama_fiyat 0'a eşitleniyor
            $gunluk_ortalama_fiyat = $on_odeme = $kalan_odeme = $hesap_toplam = 0;
            $gun_ve_fiyat = "";
        } else {
            $panel_setting = WebsitePanelGeneralsetting::select("prepayment_rate")->where("website_id", 15/*APP_WEBSITE_ID*/)->first();
            $hesap_toplam = $toplam_fiyat;

            $panel_prepayment_rate = ($panel_setting->prepayment_rate != 0) ? $panel_setting->prepayment_rate : 35;
            //gunluk_ortalama_fiyat toplam fiyatın gece sayısına bölümünden elde ediliyor
            $on_odeme_orani = (!empty($villa->prepayment_rate) ? $villa->prepayment_rate : $panel_prepayment_rate);
            $on_odeme = ceil(($hesap_toplam / 100) * $on_odeme_orani);
            $kalan_oran = 100 - (!empty($villa->prepayment_rate) ? $villa->prepayment_rate : $panel_prepayment_rate);
            $kalan_odeme = floor(($hesap_toplam / 100) * $kalan_oran) + $temizlik_ucreti;

            try {
                $gunluk_ortalama_fiyat = ceil($toplam_fiyat / $gun_farki);
            } catch (\Exception $e) {
                $gunluk_ortalama_fiyat = 0;
            }

            $hesap_toplam = $toplam_fiyat + $temizlik_ucreti;

        }
        //sonuçlar diziye alındı fonksiyon $sonuc değişkenini döndürecek
        $sonuc = array($toplam_fiyat . " ₺", $gunluk_ortalama_fiyat . " ₺", $gun_farki, $temizlik_ucreti . " ₺", $gun_ve_fiyat, $on_odeme . " ₺", $kalan_odeme . " ₺", $hesap_toplam . " ₺", $min_accommodation, $temizlik_ucreti_min_konaklama);
        return $sonuc;
    }

    public static function villaPriceCache($villa_id)
    {
        return cache()->remember('villa-price-' . config('app.website.id') . $villa_id, 60, function () use ($villa_id) {
            return villaPrice::select(['start_date', 'end_date', 'daily_price_tl', 'short_stay', 'min_accommodation', 'min_stay_cleaning_price'])->where('villa_id', $villa_id)->where('end_date', '>', date('Y-m-d'))->orderBy('start_date')->get();
        });
    }

    public static function calculateVillaPriceCache($villa_id, $giris_tarih, $cikis_tarih)
    {
        $villa = Villa::select(['prepayment_rate', 'default_cleaning_price', 'min_accommodation', 'min_accommodation_season'])->where('id', $villa_id)->first();
        $villaPrice = static::villaPriceCache($villa_id);

        $giris = Carbon::parse($giris_tarih);
        $cikis = Carbon::parse($cikis_tarih);
        $giris_tarih = $giris->format('Y-m-d 00:00:00');
        $cikis_tarih = $cikis->format('Y-m-d 00:00:00');
        $girisYil = $giris->format('Y');
        $cikisYil = $cikis->format('Y');

        #->("(( start_date <= '$giris_tarih' AND end_date >= '$giris_tarih' ) OR ( start_date <= '$cikis_tarih' AND end_date >= '$cikis_tarih' ) OR ( start_date >= '$giris_tarih' AND end_date <= '$cikis_tarih')) AND daily_price_tl!='0.00' ORDER BY start_date ASC"));

        $price = $villaPrice->filter(function ($item) use ($giris_tarih, $cikis_tarih, $villa_id) {

            if ((strtotime($item['start_date']) <= strtotime($giris_tarih)) && (strtotime($item['end_date']) >= strtotime($giris_tarih))) {
                return true;
            } else {
                if ($villa_id == 89) {
                    #dd($item['start_date']);
                }

                if ((strtotime($item['start_date']) <= strtotime($cikis_tarih)) && (strtotime($item['end_date']) >= strtotime($cikis_tarih))) {
                    return true;
                } else {
                    if ((strtotime($item['start_date']) >= strtotime($giris_tarih)) && (strtotime($item['end_date']) <= strtotime($cikis_tarih))) {
                        return true;
                    }
                }
                return false;
            }
        });

//$price Değişkeni girilen tarihler arasındaki fiyatları listeler örneğin hem haziran hemde temmuz ayı seçilmişse bu 2 ayın da fiyat bilgilerini dizi halinde verir
        $toplam_fiyat = null;
        $temizlik_ucreti = null;
        $period = CarbonPeriod::create($giris, $cikis);
        $gun_farki = $giris->diffInDays($cikis, false);

        //Tarihler arasındaki gün farkını Carbon ile hesaplıyoruz(Gece sayısını almak için)
        if (count($price) == 1) {
            //eğer 1 fiyat modeli varsa direk gün sayısıyla çarpıp toplam fiyatı alıyoruz

            $gune_ait_fiyat = floatval(str_replace(",", ".", $price->first()->daily_price_tl));

            $toplam_fiyat = ceil($gun_farki * $gune_ait_fiyat);


            foreach ($period as $key => $date) {
                if (count($period) != $key + 1) {
                    $gun = $date->format('Y-m-d');
                    $gun_ve_fiyat[] = array(ceil($gune_ait_fiyat), $gun);
                }
            }
            $fiyatli_min_konaklama = $price->first()->min_accommodation ?? 0;
            $temizlik_ucreti_min_konaklama = $price->first()->min_stay_cleaning_price ?? 7;
            if ($gun_farki < $temizlik_ucreti_min_konaklama) {
                if ($price->first()->short_stay == 0 || empty($price->first()->short_stay)) {
                    $temizlik_ucreti = $villa->default_cleaning_price;
                } else {
                    $temizlik_ucreti = $price->first()->short_stay;
                }
            }
//            if ($gun_farki < 7) {
//                /*Gün farkı 7den az ise temizlik ücreti hesaplanacak farklı fiyat modelleri olduğu için temizlik ücretini de günlük topluyoruz diğer modellerin ortalaması alınacak
//                                */
//                if ($price->first()->short_stay == 0 || empty($price->first()->short_stay)) {
//                    $temizlik_ucreti = $villa->default_cleaning_price;
//                } else {
//                    $temizlik_ucreti = $price->first()->short_stay;
//                }
//            }
        } elseif (count($price) > 1) {
            //eğer 1 den fazla fiyat modeli varsa her güne denk gelen fiyatı tek tek hesaplıyoruz
            //Gelen tarihi gün gün artacak şekilde döngüye koyuyoruz (86400 saniye 24 saate denk geliyor)
            /*1 den fazla tarih araligi geldiginde ilk olarak secilmis olan fiyat araliginin min_stay_cleaning_price secilecek*/

            foreach ($period as $key => $date) {
                if (count($period) != $key + 1) {

                    $gun = $date->format('Y-m-d');

                    $prices = villaPrice::select(['daily_price_tl', 'short_stay', 'end_date', 'min_accommodation', 'min_stay_cleaning_price'])->where('villa_id', $villa_id)->whereDate('end_date', '>=', $gun)->whereDate('start_date', '<=', $gun)->where('daily_price_tl', '!=', '0.00')->first();

                    if (!empty($prices)) {
                        $gune_ait_fiyat = floatval(str_replace(",", ".", $prices->daily_price_tl));
                        $toplam_fiyat = $toplam_fiyat + $gune_ait_fiyat;

                        $gun_ve_fiyat[] = array(ceil($gune_ait_fiyat), $gun);
                        $fiyatli_min_konaklama = $prices->min_accommodation;
                    }
                    if ($gun_farki < 7) {
                        if (empty($prices) || $prices->short_stay == 0 || empty($prices->short_stay)) {
                            $temizlik_ucreti = $villa->default_cleaning_price;
                        } else {
                            $temizlik_ucreti = $prices->short_stay;
                        }
                    }
                }
            }

            $temizlik_ucreti_min_konaklama = $price->first()->min_stay_cleaning_price ?? 7;;
            if ($gun_farki < $temizlik_ucreti_min_konaklama) {
                if ($price->first()->short_stay == 0 || empty($price->first()->short_stay)) {
                    $temizlik_ucreti = $villa->default_cleaning_price;
                } else {
                    $temizlik_ucreti = $price->first()->short_stay;
                }
            }

        }

        $opp = WebsitePanelOpportunity::where('villa_id', '=', $villa_id)->whereDate('start_date', $giris_tarih)->whereDate('end_date', $cikis_tarih)->first();
        if (is_null($opp)) {

            if (isset($fiyatli_min_konaklama) && $fiyatli_min_konaklama != 0 && !empty($fiyatli_min_konaklama)) {
                $min_accommodation = $fiyatli_min_konaklama;
            } else {
                if (($giris_tarih >= "$cikisYil-06-01" && $giris_tarih <= "$cikisYil-09-30") || ($cikis_tarih >= "$cikisYil-06-01" && $cikis_tarih <= "$cikisYil-09-30")) {
                    $min_accommodation = (isset($villa->min_accommodation_season) ? $villa->min_accommodation_season : 0);
                } else {
                    $min_accommodation = (isset($villa->min_accommodation) ? $villa->min_accommodation : 0);
                }
            }
        } else {
            $oppgiris = Carbon::parse($opp->start_date);
            $oppcikis = Carbon::parse($opp->end_date);
            $oppgun_farki = $oppgiris->diffInDays($oppcikis, false);
            $min_accommodation = $oppgun_farki;

        }
        if ($gun_farki > 6) {
            $temizlik_ucreti = 0;
        }
        if (count($price) == 0) {
            //seçilen tarih aralığına ait fiyat yoksa gunluk_ortalama_fiyat 0'a eşitleniyor
            $gunluk_ortalama_fiyat = $on_odeme = $kalan_odeme = $hesap_toplam = 0;
            $gun_ve_fiyat = "";
        } else {
            $panel_setting = WebsitePanelGeneralsetting::select("prepayment_rate")->where("website_id", 15/*APP_WEBSITE_ID*/)->first();
            $hesap_toplam = $toplam_fiyat;

            $panel_prepayment_rate = ($panel_setting->prepayment_rate != 0) ? $panel_setting->prepayment_rate : 35;
            //gunluk_ortalama_fiyat toplam fiyatın gece sayısına bölümünden elde ediliyor
            $on_odeme_orani = (!empty($villa->prepayment_rate) ? $villa->prepayment_rate : $panel_prepayment_rate);
            $on_odeme = ceil(($hesap_toplam / 100) * $on_odeme_orani);
            $kalan_oran = 100 - (!empty($villa->prepayment_rate) ? $villa->prepayment_rate : $panel_prepayment_rate);
            $kalan_odeme = floor(($hesap_toplam / 100) * $kalan_oran) + $temizlik_ucreti;

            try {
                $gunluk_ortalama_fiyat = ceil($toplam_fiyat / $gun_farki);
            } catch (\Exception $e) {
                $gunluk_ortalama_fiyat = 0;
            }

            $hesap_toplam = $toplam_fiyat + $temizlik_ucreti;

        }
        //sonuçlar diziye alındı fonksiyon $sonuc değişkenini döndürecek
        $sonuc = array($toplam_fiyat . " ₺", $gunluk_ortalama_fiyat . " ₺", $gun_farki, $temizlik_ucreti . " ₺", $gun_ve_fiyat, $on_odeme . " ₺", $kalan_odeme . " ₺", $hesap_toplam . " ₺", $min_accommodation, $temizlik_ucreti_min_konaklama);
        return $sonuc;

    }


    public static function bolumle($veri, $adet, $isaret = FALSE)
    {
        $kelimeler = explode(' ', $veri);
        if (count($kelimeler) > $adet) {
            array_splice($kelimeler, $adet);
            $veri = implode(' ', $kelimeler);
            if (is_string($isaret)) {
                $veri .= $ellipsis;
            } elseif ($isaret) {
                $veri .= '&hellip;';
            }
        }
        return $veri;
    }


    /*public static function turkceGun($gun){
        $gun=utf8_encode($gun);
        $search  = array('þ', 'ý');
        $replace = array('ş', 'ı');
        return str_replace($search, $replace, $gun);

    }*/

    public static function video($video)
    {
        if (!empty($video) && filter_var($video, FILTER_VALIDATE_URL)) {
            if (strpos($video, "vimeo")) {
                //Vimeo Videosu ise
                if (!strpos($video, "video")) {
                    $video = explode("/", $video);
                    $video = "https://player" . $video[2] . "/video/" . $video[3];
                }
                if (explode(".", $video)[0] != "https://player") {
                    $video = explode("https://", $video);
                    $video = "https://player" . $video[1];
                }
            } elseif (strpos($video, "youtube")) {
                //Youtube videosu ise
                if (!strpos($video, "embed")) {
                    $video = explode("watch?v=", $video);

                    if (strpos($video[1], "&")) {
                        $video_id = explode("&", $video[1]);
                        $video_id = $video_id[0];
                    } else {
                        $video_id = $video[1];
                    }
                    $video = $video[0] . "/embed/" . $video_id;

                }
            }
        } else {
            $video = "";
        }
        return $video;
    }

    public static function tr_prestrlover($text)
    {
        $search = array("Ç", "İ", "I", "Ğ", "Ö", "Ş", "Ü");
        $replace = array("ç", "i", "ı", "ğ", "ö", "ş", "ü");
        $text = str_replace($search, $replace, $text);
        return $text;
    }

    public static function tr_ucwords($gelen)
    {
        $bir = array('ö', 'ç', 'i', 'ş', 'ğ', 'ü');
        $iki = array('Ö', 'Ç', 'İ', 'Ş', 'Ğ', 'Ü');
        $kelimeler = explode(" ", $gelen);
        $yazi = "";
        foreach ($kelimeler as $kelime) {
            $uzunluk = strlen($kelime);
            $ilkharf = mb_substr($kelime, 0, 1, "UTF-8");
            $sonrakiharfler = mb_substr($kelime, 1, $uzunluk, "UTF-8");
            $buyumus = str_replace($bir, $iki, $ilkharf);
            $yazi .= " " . ucwords($buyumus) . $sonrakiharfler;
        }
        return $yazi;
    }

    public static function ali_ucwords($text)
    {
        $bir = array("Ç", "İ", "I", "Ğ", "Ö", "Ş", "Ü");
        $iki = array("ç", "i", "ı", "ğ", "ö", "ş", "ü");
        $text = str_replace($bir, $iki, $text);
        $text = mb_strtolower($text, 'utf8');
        $kelimeler = explode(" ", $text);
        $yazi = "";
        foreach ($kelimeler as $kelime) {
            $uzunluk = strlen($kelime);
            $ilkharf = mb_substr($kelime, 0, 1, "UTF-8");
            $sonrakiharfler = mb_substr($kelime, 1, $uzunluk, "UTF-8");
            $buyumus = str_replace($iki, $bir, $ilkharf);
            $yazi .= " " . ucwords($buyumus) . $sonrakiharfler;
        }
        $text = $yazi;
        return $text;
    }

    public static function opportunityDelete($start, $end, $villa)
    {


        $opp = WebsitePanelOpportunity::where('villa_id', $villa)->whereRaw('(( start_date <= "' . $start . '" AND end_date > "' . $start . '" ) OR ( start_date < "' . $end . '" AND end_date >= "' . $end . '" ) OR ( start_date >= "' . $start . '" AND end_date <= "' . $end . '"))')->delete();

    }

    public static function opportunityHistoryClear()
    {
        WebsitePanelOpportunity::whereDate('start_date', '<', Carbon::now())->delete();
    }

    public static function musaitVilla($g_tarih, $c_tarih)
    {
        $giris_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $g_tarih)));
        $cikis_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $c_tarih)));
        $musait1 = DB::select('select villa_id from reservations where ISNULL(deleted_at) AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="2"  group by villa_id');
        $musait2 = DB::select('select villa_id from manual_calendars  where   ISNULL(deleted_at) AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="2"  group by villa_id');
        $musait3 = DB::select('select villa_id from ical_imports  where   ISNULL(deleted_at) AND (( dtstart <= "' . $giris_tarihi . '" AND dtend > "' . $giris_tarihi . '" ) OR ( dtstart < "' . $cikis_tarihi . '" AND dtend >= "' . $cikis_tarihi . '" ) OR ( dtstart >= "' . $giris_tarihi . '" AND dtend <= "' . $cikis_tarihi . '"))  AND exportable="0"  group by villa_id');
        $musait = array_merge($musait1, $musait2);
        $musait = array_merge($musait, $musait3);
        return $musait;
    }

    public static function villaninMusaitligi($villa_id, $g_tarih, $c_tarih)
    {
        $villa_id = (int)$villa_id;
        $villa = Villa::find($villa_id);
        if ($villa->multiple == 1) {
            $giris_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $g_tarih)));
            $cikis_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $c_tarih)));
            $musait1 = DB::select('select villa_id from manual_calendars where villa_id="' . $villa_id . '" AND ISNULL(deleted_at)  AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="2"  group by villa_id');
            $musait2 = DB::select('select villa_id from ical_imports where villa_id="' . $villa_id . '" AND ISNULL(deleted_at)  AND (( dtstart <= "' . $giris_tarihi . '" AND dtend > "' . $giris_tarihi . '" ) OR ( dtstart < "' . $cikis_tarihi . '" AND dtend >= "' . $cikis_tarihi . '" ) OR ( dtstart >= "' . $giris_tarihi . '" AND dtend <= "' . $cikis_tarihi . '"))  group by villa_id');
            $musait = array_merge($musait1, $musait2);
            return $musait;
        } else {
            $giris_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $g_tarih)));
            $cikis_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $c_tarih)));
            $musait1 = DB::select('select villa_id from reservations where villa_id="' . $villa_id . '" AND ISNULL(deleted_at) AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="2" group by villa_id');
            $musait2 = DB::select('select villa_id from manual_calendars where villa_id="' . $villa_id . '" AND ISNULL(deleted_at)  AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="2"  group by villa_id');
            $musait = array_merge($musait1, $musait2);
            return $musait;
        }


    }

    public static function villaninOpsiyonu($villa_id, $g_tarih, $c_tarih)
    {
        $villa_id = (int)$villa_id;
        $giris_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $g_tarih)));
        $cikis_tarihi = date("Y-m-d", strtotime(str_replace('/', '-', $c_tarih)));

        $musait1 = DB::select('select villa_id from reservations where villa_id="' . $villa_id . '" AND ISNULL(deleted_at) AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="3" group by villa_id');
        $musait2 = DB::select('select villa_id from pre_reservations where villa_id="' . $villa_id . '" AND ISNULL(deleted_at) AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="3" group by villa_id');
        $musait3 = DB::select('select villa_id from manual_calendars where villa_id="' . $villa_id . '" AND ISNULL(deleted_at) AND (( start_date <= "' . $giris_tarihi . '" AND end_date > "' . $giris_tarihi . '" ) OR ( start_date < "' . $cikis_tarihi . '" AND end_date >= "' . $cikis_tarihi . '" ) OR ( start_date >= "' . $giris_tarihi . '" AND end_date <= "' . $cikis_tarihi . '"))  AND operation="3"  group by villa_id');
        $musait = array_merge($musait1, $musait2);
        $musait = array_merge($musait, $musait3);
        return $musait;
    }


    public static function villaDoluluk($villa_id, $yil)
    {
        if (request()->has('priority') && (request()->priority == true)) {
            return Helper::villaDolulukPriority($villa_id, $yil);
        }
        $villa_data = Villa::find($villa_id);

        if (($villa_data->multiple == 1)) {
            $dolu1 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu11 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu2 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('villa_id', $villa_id)->whereYear('dtend', $yil)->orderBy('dtstart')->get()->toArray();
            $dolu22 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('villa_id', $villa_id)->whereYear('dtend', $yil + 1)->orderBy('dtstart')->get()->toArray();

            $dolu = array_merge($dolu11, $dolu22);
            $dolu = array_merge($dolu, $dolu1);
            $dolu = array_merge($dolu, $dolu2);
        } else {
            $dolu1 = Reservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu2 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu3 = PreReservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu4 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('exportable', '0')->where('villa_id', $villa_id)->whereYear('dtend', $yil)->orderBy('dtstart')->get()->toArray();

            $dolu11 = Reservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu22 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu33 = PreReservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu44 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('exportable', '0')->where('villa_id', $villa_id)->whereYear('dtend', $yil + 1)->orderBy('dtstart')->get()->toArray();

            $dolu = array_merge($dolu11, $dolu22);
            $dolu = array_merge($dolu, $dolu33);
            $dolu = array_merge($dolu, $dolu33);
            $dolu = array_merge($dolu, $dolu44);

            $dolu = array_merge($dolu, $dolu1);
            $dolu = array_merge($dolu, $dolu2);
            $dolu = array_merge($dolu, $dolu3);
            $dolu = array_merge($dolu, $dolu4);
        }


        usort($dolu, function ($a1, $a2) {
            $v1 = strtotime($a1['start_date']);
            $v2 = strtotime($a2['start_date']);
            return $v1 - $v2; // $v2 - $v1 to reverse direction
        });

        if (isset($dolu) && !empty($dolu)) {

            foreach ($dolu as $tarih) {
                $giris = Carbon::parse($tarih['start_date']);
                $cikis = Carbon::parse($tarih['end_date']);
                $period = CarbonPeriod::create($giris, $cikis);
                foreach ($period as $key => $date) {

                    if ($key == 0) {
                        $start = true;
                    } else {
                        $start = false;
                    }

                    end($period);
                    if ($key == count($period) - 1) {
                        $end = true;
                    } else {
                        $end = false;
                    }

                    $gun = $date->format('Y-m-d');

                    $gunler[] = array('tarih' => $gun, 'status' => $tarih['operation'] ?? 2, 'start' => $start, 'end' => $end);
                }
            }
        } else {
            $gunler[] = "";
        }

        //  $sonuc = array_unique($gunler, SORT_REGULAR);
        return $gunler;


    }

    public static function villaDolulukPriority($villa_id, $yil)
    {
        $villa_data = Villa::find($villa_id);

        if (($villa_data->multiple == 1)) {
            $dolu1 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu11 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu2 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('villa_id', $villa_id)->whereYear('dtend', $yil)->orderBy('dtstart')->get()->toArray();
            $dolu22 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('villa_id', $villa_id)->whereYear('dtend', $yil + 1)->orderBy('dtstart')->get()->toArray();


            $dolu = array_merge($dolu11, $dolu22);
            $dolu = array_merge($dolu, $dolu1);
            $dolu = array_merge($dolu, $dolu2);
        } else {
            $dolu1 = Reservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu2 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu3 = PreReservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();
            $dolu4 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('exportable', '0')->where('villa_id', $villa_id)->whereYear('dtend', $yil)->orderBy('dtstart')->get()->toArray();
            $dolu5 = \App\WebsitePanelPriority::select('start_date', 'end_date')->where('villa_id', $villa_id)->whereYear('end_date', $yil)->orderBy('start_date')->get()->toArray();

            $dolu11 = Reservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu22 = ManualCalendar::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu33 = PreReservation::select('start_date', 'end_date', 'operation')->whereNull('deleted_at')->where('villa_id', $villa_id)->where('operation', '!=', 1)->where('operation', '!=', 0)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();
            $dolu44 = IcalImport::select('dtstart as start_date', 'dtend as end_date', 'exportable')->whereNull('deleted_at')->where('exportable', '0')->where('villa_id', $villa_id)->whereYear('dtend', $yil + 1)->orderBy('dtstart')->get()->toArray();
            $dolu55 = \App\WebsitePanelPriority::select('start_date', 'end_date')->where('villa_id', $villa_id)->whereYear('end_date', $yil + 1)->orderBy('start_date')->get()->toArray();

            $dolu = array_merge($dolu11, $dolu22);
            $dolu = array_merge($dolu, $dolu33);
            $dolu = array_merge($dolu, $dolu33);
            $dolu = array_merge($dolu, $dolu44);
            $dolu = array_merge($dolu, $dolu55);

            $dolu = array_merge($dolu, $dolu1);
            $dolu = array_merge($dolu, $dolu2);
            $dolu = array_merge($dolu, $dolu3);
            $dolu = array_merge($dolu, $dolu4);
            $dolu = array_merge($dolu, $dolu5);
        }


        usort($dolu, function ($a1, $a2) {
            $v1 = strtotime($a1['start_date']);
            $v2 = strtotime($a2['start_date']);
            return $v1 - $v2; // $v2 - $v1 to reverse direction
        });

        if (isset($dolu) && !empty($dolu)) {

            foreach ($dolu as $tarih) {
                $giris = Carbon::parse($tarih['start_date']);
                $cikis = Carbon::parse($tarih['end_date']);
                $period = CarbonPeriod::create($giris, $cikis);
                foreach ($period as $key => $date) {

                    if ($key == 0) {
                        $start = true;
                    } else {
                        $start = false;
                    }

                    end($period);
                    if ($key == count($period) - 1) {
                        $end = true;
                    } else {
                        $end = false;
                    }

                    $gun = $date->format('Y-m-d');

                    $gunler[] = array('tarih' => $gun, 'status' => $tarih['operation'] ?? 2, 'start' => $start, 'end' => $end);
                }
            }
        } else {
            $gunler[] = "";
        }

        //  $sonuc = array_unique($gunler, SORT_REGULAR);
        return $gunler;


    }


    public static function parametreTemizle($parametre)
    {
        $parametre = preg_replace('/page=[^&]*/', '', $parametre);
        $parametre = preg_replace('/sayfa=[^&]*/', '', $parametre);
        $parametre = str_replace("&siralama=azalan", "", $parametre);
        $parametre = str_replace("&siralama=artan", "", $parametre);
        return $parametre;
    }

    public static function getSeo($link)
    {
        return WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'seo_url' => $link])->firstOrFail();
    }

    public static function splitName($name)
    {
        $parts = explode(' ', $name);
        return array(
            'firstname' => array_shift($parts),
            'lastname' => array_pop($parts),
            'middlename' => join(' ', $parts)
        );
    }

    public static function searchHelper($category)
    {
        $selected_categories = explode('_', $category);
        return WebsitePanelSeo::select('item_id as id')->whereIn('seo_url', $selected_categories)
            ->where('pivot', 'website_panel_categories')->where('website_id', config('app.website.id'))->orderBy('item_id')->get()->pluck('id');

    }
}
