<?php
/**
 * Created by PhpStorm.
 * User: meta
 * Date: 19/03/21
 * Time: 4:10 PM
 */
namespace App\Repo\Wunderlist;
use DB;
trait Model {

    public function save($data, $type, $parent_id = 0, $item_id=null, $list_id)
    {
        DB::table("wunder_list_items")->insert([
            'parent_id' => $parent_id,
            'list_id' => $list_id,
            'item_id' => $item_id,
            'name' => $data->title,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'reservation_type' => 'prereservation',
            'type' => $type,
        ]);
    }
    public function update()
    {

    }
    public function delete()
    {

    }
}