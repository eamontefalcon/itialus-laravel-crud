<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $tasks = Task::latest('updated_at')
            ->when($request->filled('search'), function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
                return $query;
            })
            ->paginate(5);

        $users = User::all();

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
            'users' => $users,
        ]);
    }
}
