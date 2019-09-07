<?php

namespace App\Http\Controllers\Contexts\Task\States;

use App\Http\Controllers\Contexts\Task\TaskActions;
use App\task;

class DoneTask implements TaskActions
{
    private $task = null;
    private $taskModel = null;

    public function __construct(TaskActions $task, task $model)
    {
        $this->task = $task;

        if ($model->state !== 'done') {
            throw new Exception('Done Object populated with wrong task state');
        }

        $this->taskModel = $model;
    }
    public function makeInprogress()
    {
        return "Can't perform action on Done tasks";
    }

    public function makeDone()
    {
        return "Can't perform action on Done tasks";
    }

    public function editTitle($title)
    {
        return "Can't perform action on Done tasks";
    }

    public function editDesc($desc)
    {
        return "Can't perform action on Done tasks";
    }

    public function linkTasks($id)
    {
        return "Can't perform action on Done tasks";
    }

    public function getModel()
    {
        return task::where('id', $this->taskModel->id)->with('task')->first();
    }
}
