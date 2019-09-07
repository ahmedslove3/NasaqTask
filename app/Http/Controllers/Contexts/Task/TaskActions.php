<?php

namespace App\Http\Controllers\Contexts\Task;

interface TaskActions
{
    public function makeInprogress();

    public function makeDone();

    public function editTitle($title);

    public function editDesc($desc);

    public function linkTasks($id);

    public function getModel();
}
