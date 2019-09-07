<?php

namespace App\Http\Controllers\Contexts\Task\States;

use App\Http\Controllers\Contexts\Task\TaskActions;
use App\task;
use Exception;

class InProgressTask implements TaskActions
{

    private $task = null;
    private $taskModel = null;

    public function __construct(TaskActions $task, task $model)
    {
        $this->task = $task;
        if ($model->state !== 'inprogress') {
            throw new Exception('InProgress Object populated with wrong task state');
        }

        $this->taskModel = $model;
    }

    public function makeInprogress()
    {
        return "Can't perform action on already inprogress tasks";
    }

    public function makeDone()
    {
        $this->taskModel->state = "done";
        $this->taskModel->save();

        $this->task->setState(new DoneTask($this->task, $this->taskModel));
    }

    public function editTitle($title)
    {
        return "Can't perform action on inprogress tasks";
    }

    public function editDesc($desc)
    {
        return "Can't perform action on inprogress tasks";
    }

    public function linkTasks($id)
    {
        $otherTask = task::findOrFail($id);
        if ($otherTask->state !== 'inprogress') {
            throw new Exception('Only tasks inprogress are allowed to be linked');
        }

        $this->taskModel->linked_task_id = $otherTask->id;
        $otherTask->linked_task_id = $this->taskModel->id;

        $this->taskModel->save();
        $otherTask->save();

        return $this->taskModel->with('task');

    }
    public function getModel()
    {
        return task::where('id', $this->taskModel->id)->with('task')->first();
    }
}
