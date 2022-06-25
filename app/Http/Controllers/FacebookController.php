<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WebsitePanelVilla;
use App\{villaPrice,Villa};

class FacebookController extends Controller
{
    public function index()
	{
		$villa_panel_id = WebsitePanelVilla::select('villa_id')->where(['website_id' => config('app.website.id'), 'status' => '1'])->orderBy('ranking', 'ASC')->pluck('villa_id')->toArray();
		$products = Villa::whereIn('id', $villa_panel_id)
		->with(['area','panel_villa', 'seo' => function($q) {
			$q->where('website_id', 15/*APP_WEBSITE_ID*/);
			$q->where('pivot', 'website_panel_villas');

		} ])->where('status', '1')->whereNotNull('list_price')->get();
		
		$view = view('sitemap.facebook', ['products' => $products])->render();
		return response($view)->header('Content-Type', 'text/xml');
	}
}
