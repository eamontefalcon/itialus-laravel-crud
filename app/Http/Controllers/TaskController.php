<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\CreateTaskService\CreateTaskService;
use App\Services\UpdateTaskService\UpdateTaskService;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{

    /** @var CreateTaskService $createTaskService */
    private CreateTaskService $createTaskService;

    /** @var UpdateTaskService $updateTaskService  */
    private UpdateTaskService $updateTaskService;

    public function __construct(CreateTaskService $createTaskService, UpdateTaskService $updateTaskService)
    {
        $this->createTaskService = $createTaskService;
        $this->updateTaskService = $updateTaskService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request): RedirectResponse
    {
        $this->createTaskService->handle($request);

        return to_route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $taskId): RedirectResponse
    {
        $task = Task::findOrFail($taskId);

        $this->updateTaskService->handle($request, $task);

        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $taskId): RedirectResponse
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        return to_route('dashboard');
    }
}
