<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelBlog extends Model
{
    protected $fillable = [
        'website_id',
        'title',
        'seo_url',
        'description',
        'image',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status',
        'category_id',
        'author_id',
        'thumb',
        'blog_status',
        'is_homepage'
    ];

    public function website()
    {
        return $this->belongsTo('App\Website', 'website_id');
    }

    public function blog_categories()
    {
        return $this->hasMany('App\WebsitePanelBlogCategory', 'id');
    }

    public function blog_category()
    {
        return $this->hasOne('App\WebsitePanelBlogCategory','id','category_id');
    }

    public function blog_author()
    {
        return $this->hasOne('App\WebsitePanelBlogAuthor','id','author_id');
    }

    public function seo()
    {
        return $this->hasOne('App\WebsitePanelSeo','item_id','id');
    }

}
