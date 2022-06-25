<?php
namespace App\Repo\Wunderlist;
use App\Repo\Wunderlist\src\{SubTask, Task, WList, Note, Comment};
use App\Repo\Wunderlist\src\Config;
class Main{
    use SubTask, Task, WList, Note, Comment, Config;
    use Model;
    protected $list_id;
    protected $task_id = [];

    public function __construct($list_id = null)
    {
        if(empty($list_id)):
            #yalnizca liste olusturma fonkisyonu kullanilabilir
        else:
            $this->list_id = $list_id;
        endif;
    }

}