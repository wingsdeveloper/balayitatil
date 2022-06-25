<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;
use App\{WebsitePanelContact,WebsitePanelSeo};
use Illuminate\Http\Request;
class ContactFunctions
{

	public static function contact($req)
	{
		$seo = Helper::getSeo($req->link);
		$meta_seo = $seo;
		$defaultContact = WebsitePanelContact::where('website_id', 15/*APP_WEBSITE_ID*/)->orderBy('id','ASC')->first();
		if(isset($defaultContact) && !empty($defaultContact)){
			$df_id = $defaultContact->id;
			$anotherContacts = WebsitePanelContact::where('website_id', 15/*APP_WEBSITE_ID*/)->orderBy('id','ASC')->whereNotIn('id',[$df_id])->get();
		}

		return view('contact.index', compact('defaultContact', 'anotherContacts', 'meta_seo'));
	}
}
