<?php

namespace App\Repo\Wunderlist\src;

trait Comment {

    public function newComment($task_id, $comment)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://a.wunderlist.com/api/v1/task_comments');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"task_id\":$task_id,\"text\":\"$comment\"}");
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'X-Access-Token: ' . $this->get_token();
        $headers[] = 'X-Client-Id: ' . $this->get_client_id();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return json_decode($result);
    }
    public function getComments($task_id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://a.wunderlist.com/api/v1/task_comments?task_id=' . $task_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'X-Access-Token: ' . $this->get_token();
        $headers[] = 'X-Client-Id: ' . $this->get_client_id();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            #echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
        return json_decode($result);
    }
}