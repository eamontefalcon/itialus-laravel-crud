<?php

namespace App\Services\CreateTaskService;

use App\Models\Task;

class CreateTaskService
{

    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle(CreateTaskInterface $createTask): Task
    {
        return $this->task->create([
            'title' => $createTask->getTitle(),
            'description' => $createTask->getDescription(),
            'password' => $createTask->getDescription(),
            'status' => $createTask->getStatus(),
            'user_id' => $createTask->getUserId()
        ]);

    }
}
