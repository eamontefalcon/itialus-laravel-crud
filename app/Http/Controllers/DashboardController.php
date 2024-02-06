<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\SearchRequest;
use App\Models\Task;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class DashboardController extends Controller
{

    public function index(SearchRequest $request): Response
    {

        $tasks = Task::select('tasks.id', 'tasks.title', 'tasks.description', 'tasks.status', 'u.id as user_id', 'u.name')
            ->join('users as u', 'tasks.user_id', '=', 'u.id')
            ->sort($request->getColumn(), $request->getDirection())
            ->filter($request->getSearchValue())
            ->paginate($request->getPage() ?? 5);

        $users = User::all();

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
            'users' => $users,
        ]);
    }
}
