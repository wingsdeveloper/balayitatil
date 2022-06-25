<?php

namespace App\Repo\Todoist\Traits;

trait Task {

    public function create_task($project_id = null)
    {
        /*TODO task iceriginde ne olmali*/
        $content = '';
        $parameters = new \stdClass();
        $parameters->project_id = $project_id;
        $parameters->content = $content;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.todoist.com/rest/v1/tasks');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"content\": \"Appointment with Maria\", \"due_string\": \"tomorrow at 12:00\", \"due_lang\": \"en\", \"priority\": 4}");
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'X-Request-Id: uuidgen';
        $headers[] = 'Authorization: Bearer token';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);
    }

}

