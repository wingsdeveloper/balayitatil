<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class RedirectController extends Controller
{
    public function index($url)
    {
    	$res = DB::table('website_panel_seos')->where('seo_url', $url)->first();
    	if(is_null($res) || empty($res)):
    		abort(404);
    	else:
    		return redirect($res->seo_url, 301);
    	endif;
    }
}
