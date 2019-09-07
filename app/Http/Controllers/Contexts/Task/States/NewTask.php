<?php

namespace App\Http\Controllers\Contexts\Task\States;

use App\Http\Controllers\Contexts\Task\TaskActions;
use App\task;
use Exception;

class NewTask implements TaskActions
{

    private $task = null;
    private $taskModel = null;
    public function __construct(TaskActions $task, task $model)
    {
        $this->task = $task;

        if ($model->state !== 'new') {
            throw new Exception('NewTask Object populated with wrong task state');
        }

        $this->taskModel = $model;
    }
    public function makeInprogress()
    {
        $this->taskModel->state = 'inprogress';
        $this->taskModel->save();

        $this->task->setState(new InProgressTask($this->task, $this->taskModel));
    }

    public function makeDone()
    {
        return "Can't perform action on new tasks";
    }

    public function editTitle($title)
    {
        $this->taskModel->title = $title;
        $this->taskModel->save();
        return $this->getModel();
    }

    public function editDesc($desc)
    {
        $this->taskModel->describtion = $desc;
        $this->taskModel->save();
        return $this->getModel();

    }

    public function linkTasks($id)
    {
        return "Can't perform action on new tasks";
    }

    public function getModel()
    {
        return task::where('id', $this->taskModel->id)->with('task')->first();
    }

}
