<?php
namespace App\Repo\TaskList\Trello;
use App\Repo\Wunderlist\src\{SubTask, Task, WList, Note, Comment};
use App\Repo\Wunderlist\src\Config;
class Main{

    use SubTask, Task, WList, Note, Comment;
    use Config;
    protected $list_id;
    protected $task_id = [];

    protected $preDefinedList = [
        'bugun-gelenler' => '5e398d6796b1c482623a7964',
        'on-rezervasyonlar' => '5e3bd84648204c5477b3bc14',
        'manuel-odemeler' => '5e3bd8985673038b8b046364'
    ];

    public function __construct($list_id = null)
    {
        if(empty($list_id)):
            #yalnizca liste olusturma fonkisyonu kullanilabilir
        else:
            $this->list_id = $list_id;
        endif;
    }

    public function setListId($list_id)
    {
        $this->list_id = $list_id;
    }
    public function setTaskId($task_id)
    {
        $this->task_id = $task_id;
    }
    /**
     * type bugun-gelenler, on-rezervasyonlar, manuel-odemeler listelerinden birtanesini getirir.
     * @param $type
     * @return mixed
     */
    public function getListId($type)
    {
        try {
            $list_id = $this->preDefinedList[$type];
        }catch(\Exception $e) {
            abort(500, "List id secilirken hata yasandi bu durumu kontrol ediniz");
        }
        return $list_id;
    }
}
