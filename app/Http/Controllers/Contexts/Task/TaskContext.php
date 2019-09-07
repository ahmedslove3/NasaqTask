<?php

namespace App\Http\Controllers\Contexts\Task;

use App\Http\Controllers\Contexts\Task\TaskActions;
use App\task;

class TaskContext implements TaskActions
{

    private $taskState = null;

    public function setState(TaskActions $task)
    {
        $this->taskState = $task;
    }

    public function getState()
    {
        return $this->taskState;
    }

    public function makeInprogress()
    {
        $this->taskState->makeInprogress();
    }

    public function makeDone()
    {
        $this->taskState->makeDone();
    }

    public function editTitle($title)
    {
        $this->taskState->editTitle($title);
    }

    public function editDesc($desc)
    {
        $this->taskState->editDesc($desc);
    }

    public function linkTasks($id)
    {
        $this->taskState->linkTasks($id);
    }

    public function getModel()
    {
        return $this->taskState->getModel();
    }

}
