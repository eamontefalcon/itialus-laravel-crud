<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $tasks = Task::latest('created_at')
            ->when($request->filled('search'), function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%');
                $query->orWhere('status', 'LIKE', '%' . $search . '%');
                return $query;
            })

            ->paginate(5)
            ->withQueryString($request->query());

        return Inertia::render('Dashboard', [
            'tasks' => $tasks,
        ]);
    }
}
