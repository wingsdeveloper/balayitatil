<?php

namespace App\Http\Controllers;

use App\{
    PossibleCustomer,
    Customer,
    WebsitePanelSeo,
    Area,
    FloorPlan,
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

use App\Helpers\{Helper, VillaFunctions, AreaFunctions};
use App\WebsitePanelVillaCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VillaController extends Controller
{


    /* public function areaDetail(Request $req)
     {
      //   return AreaFunctions::areaDetail($req);
     }
     public function villaDetail(Request $req)
     {
     //    return VillaFunctions::villaDetail($req);

     }*/


    public function getPrices(Request $req)
    {
        if (isset($req) AND !empty($req->villa_id) AND !empty($req->giris_tarih) AND !empty($req->cikis_tarih)) {
            $villa_id = (int)$req->villa_id;
            $giris_tarih = (string)$req->giris_tarih;
            $cikis_tarih = (string)$req->cikis_tarih;
            $gunlukFiyat = Helper::gunlukFiyat($villa_id, $giris_tarih, $cikis_tarih);
            $villaninMusaitligi = Helper::villaninMusaitligi($villa_id, $giris_tarih, $cikis_tarih);
            $gecelik_fiyat = $gunlukFiyat[1];
            $gece_sayisi = $gunlukFiyat[2];
            $temizlik_ucreti = $gunlukFiyat[3];
            $on_odeme = $gunlukFiyat[5];
            $kalan_odeme = $gunlukFiyat[6];
            $toplam_fiyat = $gunlukFiyat[0];
            $hesap_toplam = $gunlukFiyat[7];
            $gun_ve_fiyat = $gunlukFiyat[4];
            $minimum_konaklama = $gunlukFiyat[8];
            $minimum_konaklama = $gunlukFiyat[8];
            $min_temizlik_gun_sayisi = ($gunlukFiyat[9]) ?? 7;
            if (isset($villaninMusaitligi) && !empty($villaninMusaitligi)) {
                $durum = false;
            } else {
                $durum = true;
            }
        } else {
            $gecelik_fiyat = "";
            $gece_sayisi = "";
            $temizlik_ucreti = "";
            $on_odeme = "";
            $kalan_odeme = "";
            $toplam_fiyat = "";
            $hesap_toplam = "";
            $gun_ve_fiyat = "";
            $minimum_konaklama = "";

            $durum = false;

        }

        $array = array(
            "gecelik_fiyat" => $gecelik_fiyat,
            "gece_sayisi" => $gece_sayisi,
            "temizlik_ucreti" => $temizlik_ucreti,
            "on_odeme" => $on_odeme,
            "kalan_odeme" => $kalan_odeme,
            "toplam_fiyat" => $toplam_fiyat,
            "hesap_toplam" => $hesap_toplam,
            "gun_ve_fiyat" => $gun_ve_fiyat,
            "minimum_konaklama" => $minimum_konaklama,
            "durum" => $durum,
            "min_temizlik_gun_sayisi" => $min_temizlik_gun_sayisi
        );
        echo json_encode($array);
    }

    public function getStatus(Request $req)
    {
        if (isset($req) AND !empty($req->villa_id) AND !empty($req->yil)) {
            $villa_id = (int)$req->villa_id;
            $yil = (int)$req->yil;
            $return = Helper::villaDoluluk($villa_id, $yil);
        } else {
            $return = array();
        }
        echo json_encode($return);
    }
}
