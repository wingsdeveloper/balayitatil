<?php
/**
 * Created by Sublime Text3.
 * User: alisincar
 * Date: 11/02/19
 * Time: 3:18 AM
 */

namespace App\Helpers;
use App\{
	WebsitePanelSeo,WebsitePanelBlog,Area,WebsitePanelBlogCategory
};
use Illuminate\Http\Request;
class BlogFunctions
{

	public static function blog($req)
	{
        $meta_seo = $seo = Helper::getSeo($req->link);

		$blogs = WebsitePanelBlog::with(['blog_category','seo' => function($q){
            $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blogs']);
        }])->orderBy('id', 'DESC')->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'is_homepage' => 0])->paginate(5);

		$slider_blogs = WebsitePanelBlog::with(['blog_category','seo' => function($q){
		    $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blogs']);
        }])->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'is_homepage' => 1])->get();

		$areas = Area::with(['blog_categories.seo' => function($qu){
            $qu->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blog_categories']);
        },'blog_categories' => function ($q) {
			$q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'category_status' => 1]);
		}])->get();

		$generals = WebsitePanelBlogCategory::with(['seo' => function($qu){
            $qu->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blog_categories']);
        }])->where(['website_id' => 15/*APP_WEBSITE_ID*/, 'area_id' => 0])->get();
		return view('blog.list.index', compact('blogs', 'slider_blogs', 'areas', 'generals', 'meta_seo'));
	}
}
