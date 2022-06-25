<?php

namespace App\Repo\Wunderlist\src;

trait WList {
    protected $list_id;
    public function __construct()
    {
    }
    public function newList()
    {
        #yeni liste eklendikten sonra list_id belirlenmis olur
    }
    

}