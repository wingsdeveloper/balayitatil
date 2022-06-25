<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\villaPrice;
use App\Helpers\Helper;
use App\WebsitePanelVilla;
use Illuminate\Http\Request;
use App\WebsitePanelCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\{Area, District, Iller, Ilceler, WebsitePanelVillaCategory, WebsitePanelSeo, WebsitePage};

class SearchController extends Controller
{
    public function searchOld(Request $req)
    {

        if (!request()->start_date) {
            return redirect()->route('search.new', ['start_date' => $req->giris_tarih, 'end_date' => $req->cikis_tarih, 'category' => $req->category, 'bolge' => $req->bolge, 'adult' => $req->adult, 'child' => $req->child, 'kisi_sayisi' => $req->kisi_sayisi]);
        }
        $req->giris_tarih = request()->start_date;
        $req->cikis_tarih = request()->end_date;

        $selected_category_items = Helper::searchHelper($req->category);

        $meta_seo = WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'seo_url' => 'search', 'pivot' => 'website_pages'])->first();
        // kategoriye gore villa secimi
        $giris = Carbon::parse($req->giris_tarih);
        $cikis = Carbon::parse($req->cikis_tarih);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gun_farki = $giris->diffInDays($cikis, false);

        $kiralik = WebsitePage::where(['page_type' => 'arama', 'website_id' => config('app.website.id')/*APP_WEBSITE_ID*/])->first();


        if (!empty($req->category)) {
            $villa_ids = cache()->remember('search-11' . config('app.website.id') . $selected_category_items . 'villas', 60, function () use ($selected_category_items) {
                $villa_ids = [];
                foreach ($selected_category_items as $category) {

                    $villa_ids[] = WebsitePanelVillaCategory::select('villa_id')->where('website_id', config('app.website.id')/*APP_WEBSITE_ID*/)->when(!empty(request()->category), function ($query) use ($category) {
                            return $query->where('villa_category_id', $category);
                        })->pluck('villa_id')->toArray();
                    //Seçilen kategorilere ait villa idlerini aldık
                }
                return $villa_ids;
            });

            if (count($villa_ids) <= 1) {
                $relation_ids = $villa_ids[0];
            } else {
                $relation_ids = call_user_func_array('array_intersect', $villa_ids);
            }
        } else {
            $relation_ids = array('0');
        }

        $musait_ids[] = 0;
        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih)) {
            $musaitlik = Helper::musaitVilla($giris_tarih, $cikis_tarih);
            #$musaitlik = [];
            //Seçilen tarihler arasında dolu olan villaların idlerini aldık bu idler filtreleme dışında tutulacak
            if (!empty($musaitlik)) {
                foreach ($musaitlik as $musait) {
                    $musait_ids[] = $musait->villa_id;
                    //Alınan idleri WhereNotIn fonksiyonuna uydurmak için objeden indexli diziye çevirdik
                }
            }
        }

        if (isset($req->child) && isset($req->adult)) {
            $req['kisi_sayisi'] = (int)$req->child + (int)$req->adult;
        }

        $villas = DB::table('villas')->select('villas.list_image as orjlist_image', 'villas.*', 'website_panel_villas.*')->whereIn('villas.id', $relation_ids)->whereNotIn('villas.id', $musait_ids)->join('website_panel_villas', function ($join) {
            $join->on('villas.id', '=', 'website_panel_villas.villa_id')
                ->where('website_panel_villas.website_id', '=', config('app.website.id')/*APP_WEBSITE_ID*/)
                ->where('website_panel_villas.status', '=', 1);
        })/*->join('villa_prices', function ($join)use($giris_tarih,$cikis_tarih) {
            $join->on('villas.id', '=', 'villa_prices.villa_id')->
            whereRaw("(( villa_prices.start_date <= '$giris_tarih' AND villa_prices.end_date > '$giris_tarih' ) OR ( villa_prices.start_date < '$cikis_tarih' AND villa_prices.end_date >= '$cikis_tarih' ) OR ( villa_prices.start_date >= '$giris_tarih' AND villa_prices.end_date <= '$cikis_tarih')) AND villa_prices.daily_price_tl!='0.00'");
        })*/
            ->groupBy('villas.id')
            ->when(!empty($req->kisi_sayisi) && $req->kisi_sayisi != 0, function ($query) use ($req) {
                return $query->where('number_person', '>=', $req->kisi_sayisi);
            })
            ->when(!empty($req->bolge) && $req->bolge != 0, function ($query) use ($req) {
                return $query->where('area_id', $req->bolge);
            })
            ->where('villas.status', 1)->get();


        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih)) {

            $villas = cache()->remember('search-villa-2' . $req->giris_tarih . $req->cikis_tarih . $req->bolge . $req->kisi_sayisi . request()->adult . request()->child . $selected_category_items, 60, function () use ($villas, $req) {
                foreach ($villas as $villa) {
                    //(Helper::calculateVillaPriceCache($villa->villa_id, $req->giris_tarih, $req->cikis_tarih));
                    $fiyat = Helper::gunlukFiyat($villa->villa_id, $req->giris_tarih, $req->cikis_tarih);
                    $villa->toplam = (int)$fiyat[7];
                    $villa->gece_sayisi = (int)$fiyat[2];
                    $villa->min_konaklama = ((int)$fiyat[8] >= 5 ? 5 : $fiyat[8]);
                }
                return $villas;
            });

            $villas = $villas->Where('min_konaklama', '<=', $gun_farki);
           
            $villas = $villas->Where('toplam', '!=', ' ₺');
           
            if (isset($req->siralama) && !empty($req->siralama)) {
                if ($req->siralama == "azalan") {
                    $villas = $villas->sortByDesc('toplam');
                } else {
                    $villas = $villas->SortBy('toplam');
                }
            }
        } else {
            $villas = $villas->Where('starting_price', '!=', '0')->where('starting_price', '!=', '');
            if (isset($req->siralama) && !empty($req->siralama)) {
                if ($req->siralama == "azalan") {
                    $villas = $villas->sortByDesc('starting_price');
                } else {
                    $villas = $villas->SortBy('starting_price');
                }
            }
        }

       
        $count = count($villas);
        $pagination = view('parts.pagination', ['totalCount' => !is_null($villas) ? count($villas) : 0, 'perPage' => 18])->render();

        if (!isset($_GET['sayfa'])) :
            $villas = $villas->take(18);
        else :
            $say = (count($villas) / 18);
            $say = (int)(ceil($say));
            /* if($say<$_GET['sayfa']){
                 $sayfa=$say;
             }else{*/
            $sayfa = $_GET['sayfa'];
            // }
            $villas = $villas->slice(18 * ($sayfa - 1))->take(18);
        endif;

        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih) && !empty($req->category)) {
            if (count($villas) == 0 || empty($villas)) {
                return redirect()->to('/villa-bulunamadi');
            } else {
                return view('villa.search.index', compact('page_id', 'villas', 'req', 'kiralik', 'pagination', 'count', 'meta_seo'));
            }
        } else {
            if (count($villas) == 0 || empty($villas)) {
                return redirect()->to('/villa-bulunamadi');
            } else {
                return view('villa.search.index', compact('page_id', 'villas', 'req', 'kiralik', 'pagination', 'count', 'meta_seo'));
            }

            return redirect()->to('/');
        }
    }

    public function searchNoDate(Request $req)
    {

        $selected_category_items = Helper::searchHelper($req->category);

        $meta_seo = WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'seo_url' => 'search', 'pivot' => 'website_pages'])->first();
        // kategoriye gore villa secimi
        $giris = Carbon::parse($req->giris_tarih);
        $cikis = Carbon::parse($req->cikis_tarih);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gun_farki = $giris->diffInDays($cikis, false);

        $kiralik = WebsitePage::where(['page_type' => 'arama', 'website_id' => config('app.website.id')/*APP_WEBSITE_ID*/])->first();


        if (!empty($req->category)) {
            $villa_ids = cache()->remember('search-12' . config('app.website.id') . $selected_category_items . 'villas', 60, function () use ($selected_category_items) {
                $villa_ids = [];
                foreach ($selected_category_items as $category) {

                    $villa_ids[] = WebsitePanelVillaCategory::select('villa_id')->where('website_id', config('app.website.id')/*APP_WEBSITE_ID*/)->when(!empty(request()->category), function ($query) use ($category) {
                            return $query->where('villa_category_id', $category);
                        })->pluck('villa_id')->toArray();
                    //Seçilen kategorilere ait villa idlerini aldık
                }
                return $villa_ids;
            });

            if (count($villa_ids) <= 1) {
                $relation_ids = $villa_ids[0];
            } else {
                $relation_ids = call_user_func_array('array_intersect', $villa_ids);
            }
        } else {
            $relation_ids = array('0');
        }

        $musait_ids[] = 0;
        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih)) {
            $musaitlik = Helper::musaitVilla($giris_tarih, $cikis_tarih);
            #$musaitlik = [];
            //Seçilen tarihler arasında dolu olan villaların idlerini aldık bu idler filtreleme dışında tutulacak
            if (!empty($musaitlik)) {
                foreach ($musaitlik as $musait) {
                    $musait_ids[] = $musait->villa_id;
                    //Alınan idleri WhereNotIn fonksiyonuna uydurmak için objeden indexli diziye çevirdik
                }
            }
        }

        if (isset($req->child) && isset($req->adult)) {
            $req['kisi_sayisi'] = (int)$req->child + (int)$req->adult;
        }
        $villas = DB::table('villas')->select('villas.list_image as orjlist_image', 'villas.*', 'website_panel_villas.*')->whereIn('villas.id', $relation_ids)->whereNotIn('villas.id', $musait_ids)->join('website_panel_villas', function ($join) {
            $join->on('villas.id', '=', 'website_panel_villas.villa_id')
                ->where('website_panel_villas.website_id', '=', config('app.website.id')/*APP_WEBSITE_ID*/)
                ->where('website_panel_villas.status', '=', 1);
        })/*->join('villa_prices', function ($join)use($giris_tarih,$cikis_tarih) {
            $join->on('villas.id', '=', 'villa_prices.villa_id')->
            whereRaw("(( villa_prices.start_date <= '$giris_tarih' AND villa_prices.end_date > '$giris_tarih' ) OR ( villa_prices.start_date < '$cikis_tarih' AND villa_prices.end_date >= '$cikis_tarih' ) OR ( villa_prices.start_date >= '$giris_tarih' AND villa_prices.end_date <= '$cikis_tarih')) AND villa_prices.daily_price_tl!='0.00'");
        })*/
            ->groupBy('villas.id')
            ->when(!empty($req->kisi_sayisi) && $req->kisi_sayisi != 0, function ($query) use ($req) {
                return $query->where('number_person', '>=', $req->kisi_sayisi);
            })
            ->when(!empty($req->bolge) && $req->bolge != 0, function ($query) use ($req) {
                return $query->where('area_id', $req->bolge);
            })
            ->where('villas.status', 1)->get();


        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih)) {

            $villas = cache()->remember('search-villa-2' . $req->giris_tarih . $req->cikis_tarih . $req->bolge . $req->kisi_sayisi . request()->adult . request()->child . $selected_category_items, 60, function () use ($villas, $req) {
                foreach ($villas as $villa) {
                    //(Helper::calculateVillaPriceCache($villa->villa_id, $req->giris_tarih, $req->cikis_tarih));
                    $fiyat = Helper::gunlukFiyat($villa->villa_id, $req->giris_tarih, $req->cikis_tarih);
                    $villa->toplam = (int)$fiyat[7];
                    $villa->gece_sayisi = (int)$fiyat[2];
                    $villa->min_konaklama = ((int)$fiyat[8] >= 5 ? 5 : $fiyat[8]);
                }
                return $villas;
            });

            $villas = $villas->Where('min_konaklama', '<=', $gun_farki);
            $villas = $villas->Where('toplam', '!=', ' ₺');
            if (isset($req->siralama) && !empty($req->siralama)) {
                if ($req->siralama == "azalan") {
                    $villas = $villas->sortByDesc('toplam');
                } else {
                    $villas = $villas->SortBy('toplam');
                }
            }
        } else {
            $villas = $villas->Where('starting_price', '!=', '0')->where('starting_price', '!=', '');
            if (isset($req->siralama) && !empty($req->siralama)) {
                if ($req->siralama == "azalan") {
                    $villas = $villas->sortByDesc('starting_price');
                } else {
                    $villas = $villas->SortBy('starting_price');
                }
            }
        }


        $count = count($villas);
        $pagination = view('parts.pagination', ['totalCount' => !is_null($villas) ? count($villas) : 0, 'perPage' => 18])->render();

        if (!isset($_GET['sayfa'])) :
            $villas = $villas->take(18);
        else :
            $say = (count($villas) / 18);
            $say = (int)(ceil($say));
            /* if($say<$_GET['sayfa']){
                 $sayfa=$say;
             }else{*/
            $sayfa = $_GET['sayfa'];
            // }
            $villas = $villas->slice(18 * ($sayfa - 1))->take(18);
        endif;

        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih) && !empty($req->category)) {
            if (count($villas) == 0 || empty($villas)) {
                return redirect()->to('/villa-bulunamadi');
            } else {

                return view('villa.search.no-price', compact('page_id', 'villas', 'req', 'kiralik', 'pagination', 'count', 'meta_seo'));
            }
        } else {
            if (count($villas) == 0 || empty($villas)) {
                return redirect()->to('/villa-bulunamadi');
            } else {
                return view('villa.search.no-price', compact('page_id', 'villas', 'req', 'kiralik', 'pagination', 'count', 'meta_seo'));
            }

            return redirect()->to('/');
        }
    }

    public function search(Request $req)
    { 
        

        if (!request()->start_date) {
        
            if (empty(request()->giris_tarih) && empty(request()->cikis_tarih)) {
                return redirect()->route('search.no-date', ['category' => $req->category, 'bolge' => $req->bolge, 'mahalle' => $req->mahalle, 'adult' => $req->adult, 'child' => $req->child, 'kisi_sayisi' => $req->kisi_sayisi, 'fiyat' => $req->price]);
            }
            return redirect()->route('search.spagetti', ['start_date' => $req->giris_tarih, 'end_date' => $req->cikis_tarih, 'category' => $req->category, 'area' => $req->bolge, 'district' => $req->mahalle, 'adult' => $req->adult, 'child' => $req->child, 'kisi_sayisi' => $req->kisi_sayisi, 'fiyat' => $req->price]);
           
        } 
        $req->giris_tarih = request()->start_date;
        $req->cikis_tarih = request()->end_date;

        $selected_category_items = Helper::searchHelper($req->category);

        $meta_seo = WebsitePanelSeo::where(['website_id' => config('app.website.id'), 'seo_url' => 'search', 'pivot' => 'website_pages'])->first();
        // dd(request()->all());
        // kategoriye gore villa secimi
        $giris = Carbon::parse($req->giris_tarih);
        $cikis = Carbon::parse($req->cikis_tarih);
        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gun_farki = $giris->diffInDays($cikis, false);
        $mahalle = request()->mahalle;


        $kiralik = WebsitePage::where(['page_type' => 'arama', 'website_id' => config('app.website.id')])->first();


        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih) && !empty($selected_category_items)) {
            //            if (count($villas) == 0 || empty($villas)) {
            //                return redirect()->to('/villa-bulunamadi');
            //            } else {
           
                return redirect()->route('search.spagetti', ['start_date' => $req->giris_tarih, 'end_date' => $req->cikis_tarih, 'category' => $req->category, 'area' => $req->bolge, 'district' => $req->mahalle, 'adult' => $req->adult, 'child' => $req->child, 'kisi_sayisi' => $req->kisi_sayisi, 'fiyat' => $req->price]);
                //            }

        } else {
            return redirect()->to('/');
        }
    }


    public function il_getir($ulke_id)
    {
        return response()->json(['data' => Iller::where('ulke_id', $ulke_id)->get()]);
    }

    public function ilce_getir($il_id)
    {
        return response()->json(['data' => Ilceler::where('il_id', $il_id)->get()]);
    }
    public function searchAlter()
    {

        $start_date = request()->startDate;
        $end_date = request()->endDate;

        $fiyat = request()->price;


        $selected_category_items = explode(',', request()->selectedCategories);

        $giris = Carbon::parse($start_date);
        $cikis = Carbon::parse($end_date);


        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gun_farki = $giris->diffInDays($cikis, false);

        $kisi_sayisi = request()->person;
        $area = request()->area;
        $district = request()->district;
        $orderBy = request()->orderBy;

        if (!empty($selected_category_items)) {
            $villa_ids = cache()->remember('s-vk35' . config('app.website.id') . request()->selectedCategories . request()->area . request()->district . request()->adult . request()->child . 'villas', 60, function () use ($selected_category_items) {
                $villa_ids = [];
                foreach ($selected_category_items as $category) {

                    $villa_ids[] = \App\Models\Api\WebsitePanelVillaCategory::select('villa_id')
                        ->where('website_id', config('app.website.id')/*APP_WEBSITE_ID*/)->when(!empty(request()->selectedCategories), function ($query) use ($category) {
                            return $query->where('villa_category_id', $category);
                        })->pluck('villa_id')->toArray();
                    //Seçilen kategorilere ait villa idlerini aldık
                }
                return $villa_ids;
            });

            if (count($villa_ids) <= 1) {
                $relation_ids = $villa_ids[0];
            } else {
                $relation_ids = call_user_func_array('array_intersect', $villa_ids);
            }
        } else {
            $relation_ids = array('0');
        }

        $musait_ids[] = 0;
        if (!empty($giris_tarih) && !empty($cikis_tarih)) {
            $musaitlik = Helper::musaitVilla($giris_tarih, $cikis_tarih);
            //Seçilen tarihler arasında dolu olan villaların idlerini aldık bu idler filtreleme dışında tutulacak
            if (!empty($musaitlik)) {
                foreach ($musaitlik as $musait) {
                    $musait_ids[] = $musait->villa_id;
                    //Alınan idleri WhereNotIn fonksiyonuna uydurmak için objeden indexli diziye çevirdik
                }
            }
        }

        if (isset($req->child) && isset($req->adult)) {
            $req['kisi_sayisi'] = (int)$req->child + (int)$req->adult;
        }


        
  
        $villa_panel_id = WebsitePanelVilla::select('villa_id')->where(['website_id' => config('app.website.id'), 'status' => '1'])->orderBy('ranking', 'ASC')->pluck('villa_id')->toArray();
        $villa_prices_id = villaPrice::select('villa_id')->where(function ($q) use ($giris_tarih, $cikis_tarih, $fiyat) {
            $giris_tarih = date('Y-m-d 00:00:00', strtotime($giris_tarih));
            $cikis_tarih = date('Y-m-d 00:00:00', strtotime($cikis_tarih));
            //return $q->whereRaw("(( villa_prices.start_date <= '$giris_tarih' AND villa_prices.end_date > '$giris_tarih' ) OR ( villa_prices.start_date < '$cikis_tarih' AND villa_prices.end_date >= '$cikis_tarih' ) OR ( villa_prices.start_date >= '$giris_tarih' AND villa_prices.end_date <= '$cikis_tarih')) AND villa_prices.daily_price_tl!='0.00'");
            return   $q->where(function ($qin) use ($giris_tarih, $cikis_tarih, $fiyat) {
                $qin->where('start_date', '<=', $giris_tarih)->where('end_date', '>', $giris_tarih)->where(function ($qin) use ($fiyat) {
                    return $this->searchPriceCase($qin, $fiyat);
                });
            })->orWhere(function ($qin) use ($giris_tarih, $cikis_tarih, $fiyat) {
                $qin->where('start_date', '<', $cikis_tarih)->where('end_date', '>=', $cikis_tarih)->where(function ($qin) use ($fiyat) {
                    return $this->searchPriceCase($qin, $fiyat);
                });
            })->orWhere(function ($qin) use ($giris_tarih, $cikis_tarih, $fiyat) {
                $qin->where('start_date', '>=', $giris_tarih)->where('end_date', '<=', $cikis_tarih)->where(function ($qin) use ($fiyat) {
                    return $this->searchPriceCase($qin, $fiyat);
                });
            })->orderBy('id', 'DESC');
        })->pluck('villa_id')->toArray();

        $villa_panel_price_id = array_intersect($villa_panel_id, $villa_prices_id);

        /* whereHas kullanımı performansı düşürdüğü için sorgu whereIn yapısına çevirildi
        */
        $villas = \App\Models\Api\Villa::whereIn('id', $villa_panel_price_id)
            ->with(['seo', 'area', 'panel_villa.panel_tag'])->whereIn('id', $relation_ids)->whereNotIn('id', $musait_ids)->groupBy('id')
            ->when(!empty($kisi_sayisi) && $kisi_sayisi != 0, function ($query) use ($kisi_sayisi) {
                return $query->where('number_person', '>=', $kisi_sayisi);
            })
            ->when(!empty($area) && $area != 0, function ($query) use ($area) {
                return $query->where('area_id', $area);
            })
            ->when(!empty($district) && $district != 0, function ($query) use ($district) {
                return $query->where('district_id', $district);
            })
            ->where('status', 1)->get();

    


        /*VILLAKALKANTODO
            asagidaki siralama mantigini degistirecegiz.
         * fiyatlama villa_price a gore yapilmalidir.
         * villa_price ile siralama yapilirsa butun villalarin toplam tutarlari hesaplanmaz. yalnizca sayfa uzerinde yuklecek olan villalarin
         * fiyat hesaplanmasi yapilir.
         * boylelikle siralama islemindeki bu karmasa azaltilabilir. haliyle yuklenme hizi artacaktir.
        */
        if (!empty($giris_tarih) && !empty($cikis_tarih)) {

            $view_type = \Agent::isDesktop() ? 'desktop' : 'mobile';
           
            $villas = cache()->remember('s-vk20' . $giris_tarih . $cikis_tarih . $area . $district . $kisi_sayisi . request()->adult . request()->child . request()->selectedCategories . request()->price . $view_type, 60, function () use ($villas, $giris_tarih, $cikis_tarih) {
             
                foreach ($villas as $villa) {

                    $giris = Carbon::parse($giris_tarih);
                    $cikis = Carbon::parse($cikis_tarih);

                    $gun_farki = $giris->diffInDays($cikis, false);

                    $temizlik_ucreti = 0;

                    $temizlik_ucreti_min_konaklama = $villa->prices->first()->min_stay_cleaning_price ?? 7;


                    if ($gun_farki < $temizlik_ucreti_min_konaklama) {
                        if ($villa->prices->first()->short_stay == 0 || empty($villa->prices->first()->short_stay)) {
                            $temizlik_ucreti = $villa->default_cleaning_price;
                        } else {
                            $temizlik_ucreti = $villa->prices->first()->short_stay;
                        }
                    } //endif

                    if ($gun_farki > 6) {
                        $temizlik_ucreti = 0;
                    }

                    $fiyatli_min_konaklama = $villa->prices->first()->min_accommodation ?? 0;

                    if (isset($fiyatli_min_konaklama) && $fiyatli_min_konaklama != 0 && !empty($fiyatli_min_konaklama)) {
                        $min_accommodation = $fiyatli_min_konaklama;
                    } else {
                        if (($giris_tarih >= "$cikis->year-06-01" && $giris_tarih <= "$cikis->year-09-30") || ($cikis_tarih >= "$cikis->year-06-01" && $cikis_tarih <= "$cikis->year-09-30")) {
                            $min_accommodation = (isset($villa->min_accommodation_season) ? $villa->min_accommodation_season : 0);
                        } else {
                            $min_accommodation = (isset($villa->min_accommodation) ? $villa->min_accommodation : 0);
                        }
                    } //endif


                    $villa->min_konaklama = $min_accommodation;
                    if (!empty($villa->prices) && ($villa->prices->count()) > 1) {

                        $fiyat = Helper::gunlukFiyat($villa->id, $giris_tarih, $cikis_tarih);
                        $villa->toplam = (int)$fiyat[7];
                        $villa->gece_sayisi = (int)$fiyat[2];
                        $villa->min_konaklama = ((int)$fiyat[8] >= 5 ? 5 : $fiyat[8]);
                    } else {
                        $villa->toplam = ((int)$villa->prices->first()->daily_price_tl * $gun_farki) + (int)$temizlik_ucreti;
                    } //endif


                    if (empty($villa->prices->first())) {
                        $villa->toplam = ' ₺';
                    }

                    $villa->start_date = iconv('latin5', 'utf-8', \Carbon\Carbon::parse($giris_tarih)->formatLocalized('%d %b'));
                    $villa->end_date = iconv('latin5', 'utf-8', \Carbon\Carbon::parse($cikis_tarih)->formatLocalized('%d %b'));

                    if (empty($villa->list_image)) {
                        $resim = "uploads/villa/gallery/$villa->orjlist_image/$villa->list_image_name";
                        $byImagePath = false;
                    } else {
                        $res = explode('uploads', $villa->list_image);

                        if (count($res) > 1) :
                            !empty($villa->list_image) ? $resim = "" . $villa->list_image : $resim = $villa->panel_villa->list_image;
                        else :
                            !empty($villa->list_image) ? $resim = "uploads/villa/gallery/" . $villa->list_image . "/" . $villa->list_image_name : $resim = $villa->panel_villa->list_image;
                        endif;
                        $byImagePath = true;
                    } //endif
                   
                    if ($byImagePath == false) {
                        $villa->resim = \ImageProcess::getImageByPath($resim);
                    } else {
                        $villa->resim = \ImageProcess::getImageByPath($resim);
                    }


                    $seo_url = isset($villa->seo->seo_url) ? $villa->seo->seo_url : '';
                    if (isset($giris_tarih) && !empty($giris_tarih) && isset($cikis_tarih) && !empty($cikis_tarih)) {
                        $seo_url = route('villa.detail.search', [$seo_url, $giris_tarih, $cikis_tarih]);
                    } else {
                        $seo_url = url($seo_url);
                    } //endif
                    //                    if (empty($villa->seo)):
                    //                        $orj_villa = \App\Villa::where('code', $villa->code)->first();
                    //                        $villa_seo = \App\WebsitePanelSeo::where('item_id', $orj_villa->id)->where('pivot', 'website_panel_villas')->where('website_id', config('app.website.id'))->first();
                    //                        $seo_url = url($villa_seo->seo_url);
                    //                    endif;
                    $villa->seo_url = $seo_url;
                    if (!empty($villa->panel_villa) && !empty($villa->panel_villa->tag_id)) {

                        #$tag = \App\WebsitePanelTag::where('id', $villa->panel_villa->tag_id)->where('website_id', config('app.website.id')/*APP_WEBSITE_ID*/)->first();
                        $tag = $villa->panel_villa->panel_tag;
                        if (isset($tag) && !empty($tag)) {
                            $villa->tag = [
                                'color' => $tag->color,
                                'name' => $tag->name
                            ];
                        } else {
                            $badge = "";
                        }
                    } else {
                        $badge = "";
                    } //endif

                    if (\Agent::isDesktop()) {
                        $villa->desktop = true;
                    } else {
                        $villa->desktop = false;
                    } //endif
                } //endforeach
                return $villas;
            });
           

            $villas = $villas->Where('min_konaklama', '<=', $gun_farki);
            $villas = $villas->Where('toplam', '!=', ' ₺');
            if (isset($orderBy) && !empty($orderBy)) {
                if ($orderBy == "azalan") {
                    $villas = $villas->sortByDesc('toplam');
                } else {
                    $villas = $villas->SortBy('toplam');
                }
            }
        } else {
            $villas = $villas->Where('starting_price', '!=', '0')->where('starting_price', '!=', '');
            if (isset($orderBy) && !empty($orderBy)) {
                if ($orderBy == "azalan") {
                    $villas = $villas->sortByDesc('starting_price');
                } else {
                    $villas = $villas->SortBy('starting_price');
                }
            }
        }

        $count = count($villas);


        $pagination = view('parts.pagination', ['totalCount' => !is_null($villas) ? count($villas) : 0, 'perPage' => 18])->render();
        if (!isset($_GET['activePage'])) :
            $villas = $villas->take(18);
        else :
            $say = (count($villas) / 18);
            $say = (int)(ceil($say));
            /* if($say<$_GET['sayfa']){
                 $sayfa=$say;
             }else{*/
            $sayfa = $_GET['activePage'];
            // }
            $villas = $villas->slice(18 * ($sayfa - 1))->take(18);
        endif;
        foreach ($villas as $villa) :
            $fiyat = Helper::gunlukFiyat($villa->id, $giris_tarih, $cikis_tarih);
            $villa->toplam = (int)$fiyat[7];
            $villa->gece_sayisi = (int)$fiyat[2];
        endforeach;

        if (isset($orderBy) && !empty($orderBy)) {
            if ($orderBy == "azalan") {
                $villas = $villas->sortByDesc('toplam');
            } else {
                $villas = $villas->SortBy('toplam');
            }
        }


        if (!empty($giris_tarih) && !empty($cikis_tarih) && !empty($selected_category_items)) {
            if (count($villas) == 0 || empty($villas)) {
                return response()->json([
                    'success' => false,
                    'villas' => null
                ]);
                return redirect()->to('/villa-bulunamadi');
            } else {
                return response()->json([
                    'success' => true,
                    'villas' => array_values($villas->toArray()),
                    'pagination' => $pagination,
                    'count' => $count,
                    'orderBy' => $orderBy
                ]);
                return view('villa.search.index', compact('page_id', 'villas', 'req', 'kiralik', 'pagination', 'count', 'meta_seo'));
            }
        } else {
            return response()->json([
                'success' => false,
                'villas' => null
            ]);
            return redirect()->to('/');
        }
    }


    public function searchPriceCase($qin, $fiyat)
    {
        switch ($fiyat) {

            case '1500':
                $qin->whereBetween('daily_price_tl', [500, 1500]);
                break;

            case '3000':
                $qin->whereBetween('daily_price_tl', [1500, 3000]);
                break;

            case '5000':
                $qin->whereBetween('daily_price_tl', [3000, 5000]);
                break;

            case '5000+':
                $qin->where('daily_price_tl', '>=', 5000);
                break;

            default:
                $qin->where('daily_price_tl', '<>', '0.00');
                break;
        }
    }

    public function searchSpagetti(Request $req)
    {
 
        $meta_seo = WebsitePanelSeo::where(['website_id' => 2/*APP_WEBSITE_ID*/, 'seo_url' => 'search', 'pivot' => 'website_pages'])->first();
        $kiralik = WebsitePage::where(['page_type' => 'arama', 'website_id' => config('app.website.id')/*APP_WEBSITE_ID*/])->first();

        $start_date = request()->start_date;
        $end_date = request()->end_date;

        $fiyat = request()->price;
        $req['giris_tarih']=$start_date;
        $req['cikis_tarih']=$end_date;
        $kisi_sayisi=request()->kisi_sayisi;
        $req['kisi_sayisi']=$kisi_sayisi;

        $selected_category_seos = explode('_', request()->category);
        

        //$selected_category_items=WebsitePanelCategory::select('id')->where('website_id',15)->where('status',1)->whereIn('seo_url',$selected_category_seos)->pluck('id')->toArray();
        $selected_category_items = WebsitePanelSeo::select("item_id")->where(['website_id' => 15,'pivot' => 'website_panel_categories'])->whereIn('seo_url',$selected_category_seos)->pluck('item_id')->toArray();

      
         
        $giris = Carbon::parse($start_date);
        $cikis = Carbon::parse($end_date);


        $giris_tarih = $giris->format('Y-m-d');
        $cikis_tarih = $cikis->format('Y-m-d');
        $gun_farki = $giris->diffInDays($cikis, false);

       
        $area = request()->area;
        $district = request()->district;
        $orderBy = request()->siralama;

        if($district>0) {
        $districtControl=District::where('area_id', $area)->where('id',$district)->first();
        $district=($districtControl)?$district:0;
        }


        $staticData['gun_farki']=$gun_farki;
       $staticData['start_date'] = iconv('latin5', 'utf-8', \Carbon\Carbon::parse($giris_tarih)->formatLocalized('%d %b'));
       $staticData['end_date'] = iconv('latin5', 'utf-8', \Carbon\Carbon::parse($cikis_tarih)->formatLocalized('%d %b'));


        if (!empty($selected_category_items)) {
            
                $villa_ids = [];
                foreach ($selected_category_items as $category) {

                    $villa_ids[] = \App\Models\Api\WebsitePanelVillaCategory::select('villa_id')
                        ->where('website_id', config('app.website.id')/*APP_WEBSITE_ID*/)->when(!empty(request()->category), function ($query) use ($category) {
                            return $query->where('villa_category_id', $category);
                        })->pluck('villa_id')->toArray();
                    //Seçilen kategorilere ait villa idlerini aldık
                }
         

            if (count($villa_ids) <= 1) {
                $relation_ids = $villa_ids[0];
            } else {
                $relation_ids = call_user_func_array('array_intersect', $villa_ids);
            }
        } else {
            $relation_ids = array('0');
        }
       
        $musait_ids[] = 0;
        if (!empty($giris_tarih) && !empty($cikis_tarih)) {
            $musaitlik = Helper::musaitVilla($giris_tarih, $cikis_tarih);
            //Seçilen tarihler arasında dolu olan villaların idlerini aldık bu idler filtreleme dışında tutulacak
            if (!empty($musaitlik)) {
                foreach ($musaitlik as $musait) {
                    $musait_ids[] = $musait->villa_id;
                    //Alınan idleri WhereNotIn fonksiyonuna uydurmak için objeden indexli diziye çevirdik
                }
            }
        }
      
        if (isset($req->child) && isset($req->adult)) {
            $req['kisi_sayisi'] = (int)$req->child + (int)$req->adult;
        }


        
  
        $villa_panel_id = WebsitePanelVilla::select('villa_id')->where(['website_id' => config('app.website.id'), 'status' => '1'])->orderBy('ranking', 'ASC')->pluck('villa_id')->toArray();
        $villa_prices_id = villaPrice::select('villa_id')->where(function ($q) use ($giris_tarih, $cikis_tarih, $fiyat) {
            $giris_tarih = date('Y-m-d 00:00:00', strtotime($giris_tarih));
            $cikis_tarih = date('Y-m-d 00:00:00', strtotime($cikis_tarih));
           
            //return $q->whereRaw("(( villa_prices.start_date <= '$giris_tarih' AND villa_prices.end_date > '$giris_tarih' ) OR ( villa_prices.start_date < '$cikis_tarih' AND villa_prices.end_date >= '$cikis_tarih' ) OR ( villa_prices.start_date >= '$giris_tarih' AND villa_prices.end_date <= '$cikis_tarih')) AND villa_prices.daily_price_tl!='0.00'");
            return   $q->where(function ($qin) use ($giris_tarih, $cikis_tarih, $fiyat) {
                $qin->where('start_date', '<=', $giris_tarih)->where('end_date', '>', $giris_tarih)->where(function ($qin) use ($fiyat) {
                    return $this->searchPriceCase($qin, $fiyat);
                });
            })->orWhere(function ($qin) use ($giris_tarih, $cikis_tarih, $fiyat) {
                $qin->where('start_date', '<', $cikis_tarih)->where('end_date', '>=', $cikis_tarih)->where(function ($qin) use ($fiyat) {
                    return $this->searchPriceCase($qin, $fiyat);
                });
            })->orWhere(function ($qin) use ($giris_tarih, $cikis_tarih, $fiyat) {
                $qin->where('start_date', '>=', $giris_tarih)->where('end_date', '<=', $cikis_tarih)->where(function ($qin) use ($fiyat) {
                    return $this->searchPriceCase($qin, $fiyat);
                });
            })->orderBy('id', 'DESC');
        })->pluck('villa_id')->toArray();
       
        $villa_panel_price_id = array_intersect($villa_panel_id, $villa_prices_id);
        $cikis_tarih_sorgu = date('Y-m-d 00:00:00', strtotime($cikis_tarih ." -1 days"));
        $villas = \App\Models\Api\Villa::whereIn('villas.id', $villa_panel_price_id)
           ->whereIn('id', $relation_ids)->whereNotIn('id', $musait_ids)->groupBy('id')->with(['pricesnew' => function ($query) use ($giris_tarih,$cikis_tarih_sorgu) {
          
            return $query->whereBetween('date', [$giris_tarih, $cikis_tarih_sorgu])->selectRaw('sum(CAST(daily_price_tl AS decimal(18,0))) AS toplam')->selectRaw('villa_id')
            ->groupBy('villa_id');
    }])->with(['seo', 'area', 'panel_villa.panel_tag'])->with(['prices'=>function($query) use($giris_tarih,$cikis_tarih) {
        return $query->whereRaw("(( start_date <= '$giris_tarih' AND end_date >= '$giris_tarih' ) OR ( start_date <= '$cikis_tarih' AND end_date >= '$cikis_tarih' ) OR ( start_date >= '$giris_tarih' AND end_date <= '$cikis_tarih'))  ORDER BY start_date ASC");

    }])
            ->when(!empty($kisi_sayisi) && $kisi_sayisi != 0, function ($query) use ($kisi_sayisi) {
                return $query->where('number_person', '>=', $kisi_sayisi);
            })
            ->when(!empty($area) && $area != 0, function ($query) use ($area) {
                return $query->where('area_id', $area);
            })
            ->when(!empty($district) && $district != 0, function ($query) use ($district) {
                return $query->where('district_id', $district);
            })
            ->where('status', 1)->get(['id','min_accommodation','min_accommodation_season','area_id','name','list_image','list_image_name','starting_price','code','number_bedroom','number_bathroom','number_person']);
           

            if (!empty($giris_tarih) && !empty($cikis_tarih)) {
            $view_type = \Agent::isDesktop() ? 'desktop' : 'mobile';
             

            foreach ($villas as $villa) {


                
                $temizlik_ucreti = 0;

                $temizlik_ucreti_min_konaklama = $villa->prices->first()->min_stay_cleaning_price ?? 7;


                if ($gun_farki < $temizlik_ucreti_min_konaklama) {
                    if ($villa->prices->first()->short_stay == 0 || empty($villa->prices->first()->short_stay)) {
                        $temizlik_ucreti = $villa->default_cleaning_price;
                    } else {
                        $temizlik_ucreti = $villa->prices->first()->short_stay;
                    }
                }

                if ($gun_farki > 6) {
                    $temizlik_ucreti = 0;
                }

              
                $villa->toplam = ($villa->pricesnew)[0]->toplam+(int)$temizlik_ucreti;
                

                if (isset($villa->prices->first()->min_accommodation) && ($villa->prices->first()->min_accommodation>0)) {
                    $min_accommodation = $villa->prices->first()->min_accommodation;
                } else {
                    if (($giris_tarih >= "$cikis->year-06-01" && $giris_tarih <= "$cikis->year-09-30") || ($cikis_tarih >= "$cikis->year-06-01" && $cikis_tarih <= "$cikis->year-09-30")) {
                        $min_accommodation = (isset($villa->min_accommodation_season) ? $villa->min_accommodation_season : 0);
                    } else {
                        $min_accommodation = (isset($villa->min_accommodation) ? $villa->min_accommodation : 0);
                    }
                }


                $villa->min_konaklama = $min_accommodation;
              
                if (empty($villa->list_image)) {
                    $resim = "uploads/villa/gallery/$villa->orjlist_image/$villa->list_image_name";
                    $byImagePath = false;
                } else {
                    $res = explode('uploads', $villa->list_image);

                    if (count($res) > 1):
                        !empty($villa->list_image) ? $resim = "" . $villa->list_image : $resim = $villa->panel_villa->list_image;
                    else:
                        !empty($villa->list_image) ? $resim = "uploads/villa/gallery/" . $villa->list_image . "/" . $villa->list_image_name : $resim = $villa->panel_villa->list_image;
                    endif;
                    $byImagePath = true;
                }
                $villa->resim=$resim;
                $seo_url = isset($villa->seo->seo_url) ? $villa->seo->seo_url : '';
                if (isset($giris_tarih) && !empty($giris_tarih) && isset($cikis_tarih) && !empty($cikis_tarih)) {
                    $seo_url = route('villa.detail.search', [$seo_url, $giris_tarih, $cikis_tarih]);
                } else {
                    $seo_url = url($seo_url);
                }
//                    
                $villa->seo_url = $seo_url;
                if (!empty($villa->panel_villa) && !empty($villa->panel_villa->tag_id)) {

                    #$tag = \App\WebsitePanelTag::where('id', $villa->panel_villa->tag_id)->where('website_id', config('app.website.id')/*APP_WEBSITE_ID*/)->first();
                    $tag = $villa->panel_villa->panel_tag;
                    if (isset($tag) && !empty($tag)) {
                        $villa->tag = [
                            'color' => $tag->color,
                            'name' => $tag->name
                        ];
                    } else {
                        $badge = "";
                    }
                } else {
                    $badge = "";
                }

                if (\Agent::isDesktop()) {
                    $villa->desktop = true;
                } else {
                    $villa->desktop = false;
                }


           

            } // foreach finish
            $villas = $villas->Where('min_konaklama', '<=', $gun_farki);
        
            $villas = $villas->Where('toplam', '>', 0);
            if (isset($orderBy) && !empty($orderBy)) {
                if ($orderBy == "azalan") {
                    $villas = $villas->sortByDesc('toplam');
                } else {
                    $villas = $villas->SortBy('toplam');
                }
            }
        } else {
            $villas = $villas->Where('starting_price', '!=', '0')->where('starting_price', '!=', '');
            if (isset($orderBy) && !empty($orderBy)) {
                if ($orderBy == "azalan") {
                    $villas = $villas->sortByDesc('starting_price');
                } else {
                    $villas = $villas->SortBy('starting_price');
                }
            }
        }


 
            $count = count($villas);
            $areas=Area::select('id','name')->get();
            $districts=null;
            if($area>0)
           $districts=District::where('area_id', $area)->get();
  
            

            $pagination = view('parts.pagination_new_search', ['totalCount' => !is_null($villas) ? count($villas) : 0, 'perPage' => 18])->render();
            if (!isset($_GET['sayfa'])):
                $villas = $villas->take(18);
            else:
                $say = (count($villas) / 18);
                $say = (int)(ceil($say));
                /* if($say<$_GET['sayfa']){
                     $sayfa=$say;
                 }else{*/
                $sayfa = $_GET['sayfa'];
                // }
                $villas = $villas->slice(18 * ($sayfa - 1))->take(18);
            endif;
             
    
            if (!empty($giris_tarih) && !empty($cikis_tarih) && !empty($selected_category_items)) {
                if (count($villas) == 0 || empty($villas)) {
                    return redirect()->to('/villa-bulunamadi');
                } else {
    
                    return view('villa.search.index_new', compact('areas','districts','staticData','page_id', 'villas', 'req', 'kiralik', 'pagination', 'count', 'meta_seo'));
                }
            } else {
                
    
                return redirect()->to('/');
            }

         

 
        
    }

    public function getAreas()
    {
        $areas = cache()->remember('model.areas', 60 * 60 * 24, function () {
            return Area::get();
        });
        return response()->json($areas);
    }

    public function getDistricts($area_id)
    {
        return response()->json(District::where('area_id', $area_id)->get());
    }
}
