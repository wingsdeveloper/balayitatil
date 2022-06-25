<?php

namespace App\Repo\Wunderlist\src;
use DB;
trait Task {

    public function newTask($taskname)
    {
        if(empty($this->list_id)):
            throw new \Exception("Bir liste secimi zorunludur", 404);
        endif;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://a.wunderlist.com/api/v1/tasks');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"list_id\":".$this->list_id.",\"title\":\"$taskname\"}");
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json; charset=UTF-8';
        $headers[] = 'X-Access-Token: ' . $this->get_token();
        $headers[] = 'X-Client-Id: ' . $this->get_client_id();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        $result = json_decode($result);
        $this->task_id = $result->id;
        return $result;
    }
    public function getTask($task_id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://a.wunderlist.com/api/v1/tasks/'.$task_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Content-Type: application/json;';
        $headers[] = 'X-Access-Token: ' . $this->get_token();
        $headers[] = 'X-Client-Id: ' . $this->get_client_id();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            #echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return json_decode($result);
    }
    public function getTaskComments($task_id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://a.wunderlist.com/api/v1/task_comments/'.$task_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Content-Type: application/json;';
        $headers[] = 'X-Access-Token: ' . $this->get_token();
        $headers[] = 'X-Client-Id: ' . $this->get_client_id();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            #echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return json_decode($result);
    }
    public function updateTask($task_id, $wunderData)
    {
        DB::table('wunder_list_items')->where('id', $task_id)->update(['name' => $wunderData->title,
            'revision' => $wunderData->revision]);
    }

}