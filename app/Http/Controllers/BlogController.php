<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Website,WebsitePanelSeo,WebsitePanelBlog,WebsitePanelBlogAuthor,WebsitePanelBlogCategory,Area};
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{

    public function blog(Request $req)
    {
        $link = $req->link;

        $meta_seo = $seo = WebsitePanelSeo::where(['website_id' => 15/*APP_WEBSITE_ID*/,'seo_url' => $link])->firstOrFail();


        switch ($seo->pivot) {
            case 'website_panel_blogs':
                $blog = WebsitePanelBlog::with(['blog_category.area','blog_category.seo' => function($q){
                    $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blog_categories']);
                }])->where(['website_id' => 15/*APP_WEBSITE_ID*/,'id' => $seo->item_id])->firstOrFail();
                $interests = WebsitePanelBlog::with(['seo' => function($q){
                        $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blogs']);
                    }])
                    ->where(['website_id' => 15/*APP_WEBSITE_ID*/,'blog_status' => 1,'category_id' => $blog->category_id])
                    ->whereNotIn('id',[$blog->id])
                    ->orderBy('id','DESC')
                    ->take(4)
                    ->get();
                // $meta_author Meta tagları için gerekli sadece -> Ümit UZ
                $meta_author = WebsitePanelBlogAuthor::where(['website_id' => 15/*APP_WEBSITE_ID*/,'id' => $blog->author_id])->first();

                return view('blog.detail.index',compact('blog','category_name','interests','interestCount','area_name','meta_seo','meta_author'));
                break;
            case 'website_panel_blog_categories':

                $blogs = WebsitePanelBlog::with(['blog_category.seo' => function($q){
                    $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blog_categories']);
                },'seo' => function($q){
                    $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blogs']);
                }])->where(['website_id' => 15/*APP_WEBSITE_ID*/,'category_id' => $seo->item_id])->orderBy('id', 'DESC')->paginate(5);
                $areas = Area::with(['blog_categories.seo' => function($qu){
                    $qu->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blog_categories']);
                },'blog_categories' => function ($q) {
                    $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'category_status' => 1]);
                }])->get();

                $generals = WebsitePanelBlogCategory::with(['seo' => function($q){
                    $q->where(['website_id' => 15/*APP_WEBSITE_ID*/,'pivot' => 'website_panel_blog_categories']);
                }])->where(['website_id' => 15/*APP_WEBSITE_ID*/,'area_id' => 0])->get();

                return view('blog.category.index',compact('blogs','areas','generals','meta_seo'));

                break;

        }

        abort(404);

    }
}
