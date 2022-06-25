<?php
/**
 * Created by PhpStorm.
 * User: meta
 * Date: 19/03/01
 * Time: 11:11 AM
 */

namespace App\Repo\Cache;

class CacheFacade extends \Illuminate\Support\Facades\Facade {

    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor() {
        return 'App\Repo\Cache\CacheInterface';
    }
}
