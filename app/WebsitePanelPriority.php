<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsitePanelPriority extends Model
{

    public function villa()
    {
        return $this->hasOne('App\Models\Villa', 'id', 'villa_id');
    }

}
