<?php

namespace App\Repo\Todoist\Traits;

trait Project {
    private $mainProjectId = '2237860733';

    public function getProject()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.todoist.com/rest/v1/projects');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $this->getToken();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        return $result;
    }


    public function getMainProjectId()
    {
        return $this->mainProjectId;
    }
}
