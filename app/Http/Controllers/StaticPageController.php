<?php

namespace App\Http\Controllers;

use App\Website;
use App\WebsitePanelSeo;
use App\Helpers\{Helper,
    VillaFunctions,
    AreaFunctions,
    CategoryFunctions,
    FaqFunctions,
    AboutFunctions,
    ContactFunctions,
    BlogFunctions,
    OpportunityFunctions};
use Carbon\Carbon;
use Illuminate\Http\Request;


class StaticPageController extends Controller
{
    public function index(Request $req)
    {
  
        $seo = WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'seo_url' => $req->link])->firstOrFail();

        
        switch ($seo->pivot) {
            case 'website_pages':
                switch ($seo->page->page_type) {
                    case "villa_liste":
                        //Villa-Liste
                        
                        return VillaFunctions::villaList($req);
                        break;

                    case "bolge_liste":
                        //bolge-liste
                        return AreaFunctions::areaList($req);
                        break;

                    case "kategori_liste":
                        //kategori-liste
                        if (!empty($req->giris_tarih) && !empty($req->cikis_tarih)):
                            abort(404);
                        endif;
                        return CategoryFunctions::categoryList($req);
                        break;

                    case "nasil_kiralarim":
                        //nasil-kiralarim
                        return FaqFunctions::faq($req);
                        break;

                    case "hakkimizda":
                        //hakkimizda
                        return AboutFunctions::about($req);
                        break;

                    case "iletisim":
                        //iletisim
                        return ContactFunctions::contact($req);
                        break;

                    case "blog":
                        //blog
                        if(!empty($req->kategoriler_seo)):
                            abort(404);
                        endif;
                        return BlogFunctions::blog($req);
                        break;

                    case 'firsat_liste':
                        //firsat-liste
                        return OpportunityFunctions::opportunities($req);
                        break;

                    case "":
                        //dinamik Sayfa
                        $page = $seo->page;
                        $meta_seo = $seo;
                        return view('static.index', compact('page', 'meta_seo'));
                        break;

                    default:
                        //home anasayfa
                        return redirect()->action('HomeController@index');
                }
            case 'website_panel_villas':
                //VİLLA DETAY
                if (!empty($req->kategoriler_seo) ):
                    abort(404);
                endif;

                if(!empty($req->giris_tarih) && !empty($req->cikis_tarih)):


                    try {
                        if(Carbon::parse($req->giris_tarih) && Carbon::parse($req->cikis_tarih)):
//                            dd(strtotime($req->giris_tarih) . ' ' . strtotime(date('Y-m-d')) . ' ' . request()->link);
                            if(strtotime($req->giris_tarih) < strtotime(date('Y-m-d'))):
                                return redirect()->route('static', request()->link);
                            else:

                            endif;
                        else:
                            abort(404);
                        endif;
                    } catch(\Exception $e ) {
                        abort(404);
                    }
                endif;

                return VillaFunctions::villaDetail($req);

                break;

            case 'website_panel_area_contents':
                //bölge-detay
                return AreaFunctions::areaDetail($req);
                break;

            case 'website_panel_categories':
                //kategori-detay
                return CategoryFunctions::categoryDetail($req);
                break;
        }
    }
}
