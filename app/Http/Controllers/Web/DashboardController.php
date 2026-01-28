<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'active')->count(),
            'total_tasks' => Task::count(),
            'pending_tasks' => Task::whereIn('status', ['todo', 'in_progress'])->count(),
            'total_users' => User::count(),
        ];

        $recent_projects = Project::with('owner')
            ->latest()
            ->take(5)
            ->get();

        $recent_tasks = Task::with(['project', 'assignedUser'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_projects', 'recent_tasks'));
    }
}