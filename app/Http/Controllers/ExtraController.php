<?php

namespace App\Http\Controllers;

use App\{Website,WebsitePanelSeo};
use Illuminate\Http\Request;

class ExtraController extends Controller
{

    public function extra(Request $req)
    {
        $link = $req->link;
        $seo = WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,'seo_url' => $link,'pivot' => 'website_panel_extras'])->firstOrFail();
        $meta_seo = $seo;
        switch ($seo) {
            case $seo->pivot == 'website_panel_extras':
                $extra_id = $seo->item_id;
                $siteExtras = Website::with(['extras' => function($q) use($extra_id){
                    $q->where('id',$extra_id);
                    $q->with(['extra_galleries' => function($qu) {
                        $qu->where('website_id',15/*APP_WEBSITE_ID*/);
                    }]);
                    $q->firstOrFail();
                },'pages' => function($q){
                    $q->where('link','ekstra');
                }])->where('id', 2/*APP_WEBSITE_ID*/)->select('id')->firstOrFail();
                $extra = $siteExtras->extras[0];
                $ex = isset($siteExtras->pages[0]) ? $siteExtras->pages[0] : '';
                $compact = ['extra','ex','meta_seo'];
                return view('extra.index',compact($compact));
                break;
        }
    }
}
