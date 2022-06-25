<?php

namespace App\Repo\ImageProcess;

class ImageProcessFacade extends \Illuminate\Support\Facades\Facade {

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor() {
        return 'App\Repo\ImageProcess\ImageProcessInterface';
    }
}
