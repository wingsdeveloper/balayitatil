<?php
namespace App\Repo\Wunderlist\src;

trait Note {
    public function newNote($note)
    {
        $note= strip_tags($note);
        $note = str_replace("\n", ' ', $note);
        $note = str_replace("\r", ' ', $note);
        $note = str_replace("PHP_EOL", ' ', $note);


        if(empty($this->task_id)):
            throw new \Exception("Not eklemek icin task_id belirtmeniz şarttır.", 404);
        endif;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://a.wunderlist.com/api/v1/notes');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"task_id\":".$this->task_id.",\"content\":\"$note\"}");
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


        return $result;
    }
}