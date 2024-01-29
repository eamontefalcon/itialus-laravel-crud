<?php

namespace App\Services\UpdateTaskService;

use App\Models\Task;

class UpdateTaskService
{

    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle(UpdateTaskInterface $updateTask, Task $task): Task
    {
        $task->title = $updateTask->getTitle();
        $task->description = $updateTask->getDescription();
        $task->status = $updateTask->getStatus();
        $task->user_id = $updateTask->getUserId();
        $task->save();

        return $task;

    }
}
