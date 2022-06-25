<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelBlogAuthor extends Model
{
    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    public function blogs()
    {
        return $this->belongsToMany('App\WebsitePanelBlog', 'website_panel_blog_author');
    }

}
