<?php

namespace App\Providers;

use App\Website;
use App\WebsiteHomepageVilla;
use App\WebsitePage;
use App\WebsitePanelGeneralsetting;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Observers\PreReservationObserver;
use App\PreReservation;

use Artisan;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        #Artisan::call('cache:clear');

        Schema::defaultStringLength(191);

        if (Schema::hasTable('website_pages')) {
            $pages = WebsitePage::with(['seo' => function($query){
                $query->where('website_id',15/*APP_WEBSITE_ID*/);
                $query->where('pivot','website_pages');
            }])->where(['website_id' => 15/*APP_WEBSITE_ID*/,'status' => 1])->get();
           
            View::share('pages', $pages);
        }
        view()->composer('*', function($view){
            $view_name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $view_name);

        });

        setlocale(LC_TIME, 'tr_TR@TL', 'tr_TR', 'tr', 'Turkish');
        $website = Website::with(['categories','company','general_setting'])->where('id', 15/*APP_WEBSITE_ID*/)->first();
        $homepagevilla = WebsiteHomepageVilla::with(['month_of_villa' => function($q){
            $q->with(['area']);
        }])->where(['website_id' => 15/*APP_WEBSITE_ID*/,'villa_type_id' => config("app.FOOTER_VILLA_ID_OF_MONTH")])->first();
      
        if($homepagevilla != null){
            $month = $homepagevilla->month_of_villa;
            
            View::share('month', $month);
        }
        $id = config('app.website.id');
        View::share('id',$id);
        View::share('website', $website);
        // Villa secenekleri detay sayfasında degişken isimleri çakışmasını önlemek için farklı bir isim
        $villa_secenekleri_footer = Website::with(['categories.panel_seo'])->where('id', 15/*APP_WEBSITE_ID*/)->first();
//        dd($villa_secenekleri_footer);
        View::share('villa_secenekleri_footer', $villa_secenekleri_footer);

        $general = WebsitePanelGeneralsetting::where(['website_id' => 15/*APP_WEBSITE_ID*/])->first();
        View::share('general',$general);

        $hava_durumu = cache()->remember('havadurumu3', 60*3, function() {
            $hava_arr = [
                'kalkan' => 'https://www.havadurumu15gunluk.xyz/havadurumu/146/Antalya-Kalkan-hava-durumu-15-gunluk.html',
                'fethiye' => 'https://www.havadurumu15gunluk.xyz/havadurumu/1009/mugla-fethiye-hava-durumu-15-gunluk.html',
                'kas' => 'https://www.havadurumu15gunluk.xyz/havadurumu/147/antalya-kas-hava-durumu-15-gunluk.html',
                'marmaris' => 'https://www.havadurumu15gunluk.xyz/havadurumu/1015/mugla-marmaris-hava-durumu-15-gunluk.html',
                'gokova' => 'https://www.havadurumu15gunluk.xyz/havadurumu/1024/mugla-ula-hava-durumu-15-gunluk.html',
                'dalyan' => 'https://www.havadurumu15gunluk.xyz/havadurumu/1007/mugla-dalyan-hava-durumu-15-gunluk.html'
            ];
            $result = [];
            foreach($hava_arr as $key => $row):
                try {
                    $site = file_get_contents($row);
                    preg_match('/<span class="report-C">(.*?)<\/span>/', $site, $output_array);
                } catch(\Exception $e) {
                    $result[$key] = rand(15, 25) . '°C';
                }


                try {
                    $result[$key] = $output_array[1];
                } catch(\Exception $e) {
                    $result[$key] = rand(15, 25) . '°C';
                }
            endforeach;
            return $result;
        });
        View::share('hava_durumu', $hava_durumu);

 //        Facebook Capi İçin Değikenler - Sadettin Karlı   

 function GetIP(){  
    if(getenv("HTTP_CLIENT_IP")) {
    $ip = getenv("HTTP_CLIENT_IP");
    } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
    if (strstr($ip, ',')) {
        $tmp = explode (',', $ip);
        $ip = trim($tmp[0]);
    }
    } else {
    $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
   } 

   $ip = GetIP();
   switch($ip)
   {
      
       case'178.244.238.41';// office3
       $ipsonuc=2;
       break;
   
       case'178.244.238.39';//office2
       $ipsonuc=2;
       break;
   
       case'178.244.238.38'; // office1 88.247.182.43
       $ipsonuc=2;
       break;
   
       case'88.247.182.43'; // office1 88.247.182.43
       $ipsonuc=2;
       break;
   
       default;
       $ipsonuc=1;
       break;
   }
   View::share('ipsonuc',$ipsonuc);


   $fb_ip = GetIP();
   View::share('fb_ip',$fb_ip);
   
        $footerData = [];
        if(!empty($month)):
        $footerData['seo'] = \App\WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,
            'item_id' => $month->id,'pivot' => 'website_panel_villas'])->first();
//        $footerData['seo'] = cache()->remember('footer-seo', 60*24, function() use ($month) {
//            return \App\WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,
//                'item_id' => $month->id,'pivot' => 'website_panel_villas'])->first();
//        });
//        $footerData['category_prefix'] = cache()->remember('footer-category_prefix', 60*24, function() use ($month) {
//            return \App\WebsitePage::where(['website_id' => 15/*APP_WEBSITE_ID*/,'page_type' => 'kategori_liste'])->first();
//        });
        $footerData['category_prefix'] = \App\WebsitePage::where(['website_id' => 15/*APP_WEBSITE_ID*/,'page_type' => 'kategori_liste'])->first();
        endif;
        View::share('footerData',$footerData);

        error_reporting(0);
        ini_set('display_errors', 0);

        $this->observers();

    }

    public function register()
    {
        //
    }

    protected function observers()
    {
        PreReservation::observe(PreReservationObserver::class);
    }
}
