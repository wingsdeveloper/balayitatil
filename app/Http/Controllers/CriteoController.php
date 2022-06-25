<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\WebsitePanelVilla;
use App\{villaPrice,Villa};
class CriteoController extends Controller
{
	public function index()
	{
		WebsitePanelVilla::with('prices')->first();

		$products = Villa::whereHas('panel_villa', function($q) {
			$q->where('website_id', 15/*APP_WEBSITE_ID*/);
			$q->where('status', '1');
		})->whereHas('seo')->with(['panel_villa', 'seo' => function($q) {
			$q->where('website_id', 15/*APP_WEBSITE_ID*/);
			$q->where('pivot', 'website_panel_villas');

		} ])->where('status', '1')->whereNotNull('list_price')->get();

		$view = view('sitemap.criteo', ['products' => $products])->render();
		return response($view)->header('Content-Type', 'text/xml');
	}
}
