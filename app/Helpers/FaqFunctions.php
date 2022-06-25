<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;
use App\{
	WebsitePanelSeo,WebsitePanelHowCategory,WebsitePanelCategory,WebsitePage,Website
};
use App\Helpers\Helper;
use Illuminate\Http\Request;
class FaqFunctions
{
	public static function faq($req)
	{
        $meta_seo = $seo = Helper::getSeo($req->link);
        $website = Website::where('id', 15/*APP_WEBSITE_ID*/)->first();
		$faqCats = WebsitePanelHowCategory::with(['articles'])->where("website_id", 15/*APP_WEBSITE_ID*/)->get();
		$sss = WebsitePage::where(['website_id' => 15/*APP_WEBSITE_ID*/, 'id' => $seo->item_id])->first();
		$video = Helper::video($website->general_setting->video_url);
		return view('faq.index', compact('faqCats', 'website', 'sss', 'video', 'meta_seo'));
	}
}
