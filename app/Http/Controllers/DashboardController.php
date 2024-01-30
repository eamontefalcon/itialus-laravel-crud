<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('Dashboard', [
            'tasks' => Task::latest('tasks.created_at')->paginate(5)
                ->withQueryString($request->query()),
        ]);
    }
}
