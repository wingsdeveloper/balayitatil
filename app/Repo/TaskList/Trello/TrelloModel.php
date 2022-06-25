<?php
namespace App\Repo\Tasklist\Trello;
use DB;

class TrelloModel {
    public function save($data)
    {
        $parent_id = $data['parent_id'];
        $list_id = $data['list_id'];
        $reservation_id = $data['reservation_id'];
        $title = $data['title'];
        $type = $data['type'];
        DB::table("wunder_list_items")->insert([
            'parent_id' => $parent_id,
            'list_id' => $list_id,
            'item_id' => $reservation_id,
            'name' => $title,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'reservation_type' => $data['reservation_type'],
            'type' => $type,
            'extended_id' => isset($data['extended_id']) ? $data['extended_id'] : null
        ]);
    }
}
