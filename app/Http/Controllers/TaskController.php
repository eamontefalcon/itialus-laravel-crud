<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\CreateTaskService\CreateTaskService;
use App\Services\UpdateTaskService\UpdateTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(['tasks' => Task::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        $task = $this->createTaskService->handle($request);

        return to_route('dashboard', ['task' => [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'user_id' => $task->user_id,
        ]]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $taskId)
    {

        $task = Task::findOrFail($taskId);

        return to_route('dashboard', ['task' => [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'user_id' => $task->user_id,
        ]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $taskId)
    {
        $task = Task::findOrFail($taskId);

        $this->updateTaskService->handle($request, $task);

        $latestTask = Task::find($taskId);

        return to_route('dashboard', ['task' => [
            'id' => $latestTask->id,
            'title' => $latestTask->title,
            'description' => $latestTask->description,
            'status' => $latestTask->status,
            'user_id' => $latestTask->user_id,
        ]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $taskId): JsonResponse
    {
        $task = Task::findOrFail($taskId);

        // Delete the task itself
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
