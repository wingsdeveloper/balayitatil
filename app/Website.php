<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    //
    protected $fillable = [
        'name',
        'company_id',
        'domain',
        'auth_user',
        'auth_token',
        'lang',
        'currency',
        'blog_author_avatar_size',
        'blog_category_list_size',
        'blog_category_banner_size',
        'blog_article_list_size',
        'blog_article_banner_size',
        'page_banner_size',
        'category_banner_size',
        'sms_header',
        'sms_template',
        'sms_user',
        'sms_pass',
        'prefix'
    ];

    public function seos()
    {
        return $this->hasMany('App\WebsitePanelSeo');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function blog()
    {
        return $this->hasMany('App\WebsitePanelBlog')->select(array('title'));
    }

    public function blogs()
    {
        return $this->hasMany('App\WebsitePanelBlog');
    }
    public function blog_homepage()
    {
        return $this->hasMany('App\WebsitePanelBlog')->where('is_homepage', '1');
    }

    public function blog_categories()
    {
        return $this->hasMany('App\WebsitePanelBlogCategory');
    }

    public function blog_authors()
    {
        return $this->hasMany('App\WebsitePanelBlogAuthor');
    }

    public function general_setting()
    {
        return $this->hasOne('App\WebsitePanelGeneralsetting', 'website_id');
    }

    public function how()
    {
        return $this->hasOne('App\WebsitePanelHow');
    }

    public function how_article()
    {
        return $this->hasOne('App\WebsitePanelHowArticle')->where('show_website',1);
    }

    public function how_articles()
    {
        return $this->hasMany('App\WebsitePanelHowArticle')->where(['show_website'=>1,'website_id'=>15/*APP_WEBSITE_ID*/]);
    }

    public function how_categories()
    {
        return $this->hasMany('App\WebsitePanelHowCategory');
    }

    public function how_category()
    {
        return $this->hasOne('App\WebsitePanelHowCategory');
    }

    public function panel_villas()
    {
        return $this->hasMany('App\WebsitePanelVilla','website_id');
    }

    public function categories()
    {
        return $this->hasMany('App\WebsitePanelCategory')->orderBy('ranking');
    }

    public function websiteCategories()
    {
        return $this->hasMany('App\WebsitePanelCategory')->orderBy('ranking');
    }

    public function about()
    {
        return $this->hasOne('App\WebsitePanelAbout');
    }

    public function pages()
    {
        return $this->hasMany('App\WebsitePage');
    }

    public function menus()
    {
        return $this->hasMany('App\WebsiteMenu');
    }

    public function special_areas()
    {
        return $this->hasMany('App\WebsiteSpecialArea');
    }

    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    public function tags()
    {
        return $this->hasMany('App\WebsitePanelTag');
    }

    public function extras()
    {
        return $this->hasMany('App\WebsitePanelExtra');
    }

    public function homepage()
    {
        return $this->hasOne('App\WebsitePanelHomepage');
    }

    public function homepage_villatypes()
    {
        return $this->hasMany('App\WebsiteHomepageVillatype')->where('id',env('HOMEPAGE_POPULAR_VILLAS'));
    }

    public function homepage_villas()
    {
        return $this->hasMany('App\WebsiteHomepageVilla')->whereHas('villa', function($q) {$q->where('status', '1');})->where('villa_type_id',env('HOMEPAGE_POPULAR_VILLAS'))
        ->inRandomOrder()->take('2');
    }

    public function homepage_contents()
    {
        return $this->hasMany('App\WebsiteHomepageContent');
    }

    public function contacts()
    {
        return $this->hasMany('App\WebsitePanelContact');
    }

    public function contact_notifications()
    {
        return $this->hasMany('App\WebsitePanelContactNotification','website_id');
    }
    public function currency()
    {
        return $this->hasOne('App\Currency', 'id', 'currency_id');
    }

    public function whatsapp_phones()
    {
        return $this->hasMany(WebsiteWhatsappPhone::class, 'website_id', 'id')->where('website_id', '15')->where('status', '1');
    }


}
