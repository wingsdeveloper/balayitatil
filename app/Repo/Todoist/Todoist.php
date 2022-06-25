<?php

namespace App\Repo\Todoist;

use App\Repo\Todoist\Traits\Project;
use App\Repo\Todoist\Traits\Task;

class Todoist {
    use Project, Task;
    private $token = '1030b261e316af6f00a858c310df6b4bf34d48b8';

    public function getToken()
    {
        return $this->token;
    }

}
