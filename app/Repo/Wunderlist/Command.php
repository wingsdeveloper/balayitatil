<?php

namespace App\Repo\Wunderlist;
use App\Repo\Wunderlist\Main;
use App\PreReservation;
use App\WunderlistItem;
use App\ReservationComment;
use Storage;
use DB;
class Command {
    public function __construct()
    {
        $this->wunderlist_model = new WunderlistItem;
        $this->reservation_comment_model = new ReservationComment;
        $this->repo = new Main;
    }

    /**
     *  checkTask() metodu kayıtlı olan taskların güncellemelerini
     * yapıp bizim sistemimize aktarmak için kullanılır.
     */
    public function checkTasks()
    {
        $tasks = $this->getTasks();#bizim sistem kayitli olan tasklari getir

        foreach($tasks as $row):
            # row icerisinde bizdeki wunder icerikleri bulunur
            $wunderTask = $this->repo->getTask($row->list_id);#WUNDERLIST donen sonuc, bizdeki rezervasyonla

            if(empty($row->error)):
                if($wunderTask->revision == $row->revision):
                    #guncel
                else:
                    #guncellenecek
                    $this->repo->updateTask($row->id, $wunderTask);
                endif;
                $comments = $this->repo->getComments($wunderTask->id);
                $this->checkComments($comments, $wunderTask);

            else:
                #bu task wunderlistten silinmis, bunu tekrar olustur gerek yok dendi ..

            endif;
        endforeach;
    }

    /**
     * @return mixed
     * getTask() metodu bizim sistem
     * tarafindan wunderlist te olusturulmus ve kayda alinmis olan butun tasklari getirir.
     */
    public function getTasks()
    {
        return $this->wunderlist_model->where('type', 'task')->get();
    }

    /**
     *  createNewCommentOnReservation() metodu ile {tablo} uzerinde yeni bir comment olusturur
     */
    public function createNewCommentOnReservation($id, $data)
    {
        ReservationComment::create($data);
        $this->createNewWunderListItem();
    }
    /**
     *  createNewWunderListItem() metodu ile {tablo} uzerinde yeni bir wunderlist item olusturulur.
     */
    public function createNewWunderListItem($data, $wunder_id, $parent_id=null)
    {
        WunderlistItem::create([
            'list_id' => $comment_id, 'parent_id' => $task_id,
            'name' => $value, 'status' => '1',
            'type' => 'comment',
            'reservation_type' => $type,
            'item_id' => $result->id
        ]);
    }
    /**
     * @param $comments, $wunderTask
     * checkComments() metodu ile wunderlist tarafindan getirilen commentlerin varligi bizim sistemdekiyle
     * kontrol edilir.
     */
    public function checkComments($comments, $wunderTask)
    {
        $taskWunderList = $this->wunderlist_model->where('list_id', $wunderTask->id)->where('type', 'task')->first();
        if($taskWunderList->reservation_type == 'prereservation'):
            $reservation = DB::table('pre_reservations')->where('id', $taskWunderList->item_id)->first();
        else:
            $reservation = DB::table('reservations')->where('id', $taskWunderList->item_id)->first();
        endif;
        $rezervasyon_id = $reservation->id;
        $task_id = $wunderTask->id;
        foreach ($comments as $row):
            $result = $this->wunderlist_model->where('list_id', $row->id)->where('type', 'comment')->first();
            if(empty($result)):
                WunderlistItem::create([
                    'list_id' => $row->id, 'parent_id' => $task_id,
                    'name' => $row->text, 'status' => '1',
                    'type' => 'comment',
                    'reservation_type' => $taskWunderList->reservation_type,
                    'item_id' => $rezervasyon_id,
                    'revision' => $row->revision
                ]);
                $this->reservation_comment_model->create([
                    'reservation_id' => $rezervasyon_id,
                    'type' => 'prereservation',
                    'note' =>$row->text
                ]);
            else:
                #revizyon kontrolu yapilacak
                if($row->revision != $result->revision):
                    WunderlistItem::where('list_id', $row->list_id )
                        ->update(['name' => $row->text, 'revision' => $row->revision]);
                endif;
            endif;
        endforeach;
    }
}
