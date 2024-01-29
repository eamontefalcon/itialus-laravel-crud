<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use App\Services\CreateTaskService\CreateTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{

    private CreateTaskService $createTaskService;

    public function __construct(CreateTaskService $createTaskService)
    {
        $this->createTaskService = $createTaskService;
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
    public function store(CreateTaskRequest $request): Response
    {
        $task = $this->createTaskService->handle($request);

        return Inertia::render('Dashboard', [
           'task' => $task
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $taskId)
    {
        $task = Task::findOrFail($taskId);

        // Detach all users associated with the task
        $task->users()->detach();

        // Delete the task itself
        $task->delete();

        return response()->json(['message' => 'Task and associated users deleted successfully']);
    }
}
