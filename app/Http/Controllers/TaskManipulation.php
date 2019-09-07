<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Contexts\Task\States\InProgressTask;
use App\Http\Controllers\Contexts\Task\States\NewTask;
use App\Http\Controllers\Contexts\Task\TaskContext;
use App\task;
use Illuminate\Http\Request;

class TaskManipulation extends Controller
{

    public function create(Request $req)
    {
        $req->validate([
            'title' => 'required|max:255',
            'describtion' => 'required',
        ]);

        $task = new task;
        $task->title = $req->title;
        $task->describtion = $req->describtion;
        $task->save();
        return $task;
    }

    public function update(TaskContext $context, Request $req, $id)
    {
        $task = task::findOrFail($id);

        if ($req->has('title')) {
            $context->setState(new NewTask($context, $task));
            $context->editTitle($req->title);
        }

        if ($req->has('describtion')) {
            $context->setState(new NewTask($context, $task));
            $context->editDesc($req->describtion);
        }

        if ($req->has('state') && $req->state === 'inprogress') {
            $context->setState(new NewTask($context, $task));
            $context->makeInprogress();
        }
        if ($req->has('state') && $req->state === 'done') {
            $context->setState(new InProgressTask($context, $task));
            $context->makeDone();
        }
        return $context->getModel();

    }

    public function linkTasks(TaskContext $context, Request $req, $id)
    {
        $req->validate([
            'task_id' => 'required|integer',
        ]);
        $task = task::findOrFail($id);
        $context->setState(new InProgressTask($context, $task));
        $context->linkTasks($req->task_id);

        return $context->getModel();
    }

    public function getTask($id)
    {
        return task::with('task')->findOrFail($id);
    }
}
