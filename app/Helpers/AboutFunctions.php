<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;
use App\{
	WebsitePanelAbout,WebsiteSpecialArea,WebsitePanelAboutOfficePhoto
};
use Illuminate\Http\Request;
class AboutFunctions
{

	public static function about($req)
	{
		$seo = Helper::getSeo($req->link);
		$meta_seo = $seo;

		$about = WebsitePanelAbout::with('managers','workers','documents','office_photos')->where(['website_id' => 15/*APP_WEBSITE_ID*/])->firstOrFail();

		$team = WebsiteSpecialArea::where(['website_id' => 15/*APP_WEBSITE_ID*/,'id' => config('app.SPECIAL_AREA_ABOUT_TEAM_DESCRIPTION_ID')])->first();

		$vertical = WebsitePanelAboutOfficePhoto::where(['website_id' => 15/*APP_WEBSITE_ID*/,'about_id' => $about->id, 'is_vertical' => 1])->first();
		$hr1 = WebsitePanelAboutOfficePhoto::where(['website_id' => 15/*APP_WEBSITE_ID*/,'is_vertical' => 0])->orderBy('id','ASC')->take(2)->get();
		$hr2 = WebsitePanelAboutOfficePhoto::where(['website_id' => 15/*APP_WEBSITE_ID*/,'is_vertical' => 0])->orderBy('id','DESC')->take(2)->get();

		return view('about.index', compact('about', 'meta_seo','vertical','hr1','hr2','team'));
	}
}
