<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelAbout extends Model
{
    protected $fillable = ['website_id','description','banner','banner_thumb'];

    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    public function managers()
    {
        return $this->hasMany('App\WebsitePanelAboutManager','about_id');
    }

    public function workers()
    {
        return $this->hasMany('App\WebsitePanelAboutWorker','about_id');
    }

    public function documents()
    {
        return $this->hasMany('App\WebsitePanelAboutDocument','about_id')->orderBy('document_ranking');
    }

    public function office_photos()
    {
        return $this->hasMany('App\WebsitePanelAboutOfficePhoto','about_id')->orderBy('office_photo_ranking');
    }
}
