<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $query = Task::with(['project', 'assignedUser', 'creator']);

    // Filter nach Priority
    if ($request->has('priority') && $request->priority != '') {
        $query->where('priority', $request->priority);
    }

    // Filter nach Status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Sortierung
    $sort = $request->get('sort', 'latest');
    
    if ($sort === 'priority') {
        // SQLite-kompatible Priority-Sortierung mit CASE
        $query->orderByRaw("CASE priority 
            WHEN 'urgent' THEN 1 
            WHEN 'high' THEN 2 
            WHEN 'medium' THEN 3 
            WHEN 'low' THEN 4 
            ELSE 5 END");
    } else {
        match($sort) {
            'oldest' => $query->oldest(),
            'due_date' => $query->orderBy('due_date'),
            'status' => $query->orderBy('status'),
            default => $query->latest(),
        };
    }

    $tasks = $query->paginate(15);
    $currentPriority = $request->get('priority', '');
    $currentStatus = $request->get('status', '');
    $currentSort = $sort;

    return view('tasks.index', compact('tasks', 'currentPriority', 'currentStatus', 'currentSort'));
}

    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'created_by' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:todo,in_progress,review,done',
            'due_date' => 'nullable|date',
        ]);

        Task::create($validated);

        return redirect('/tasks')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->load(['project', 'assignedUser', 'creator']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:todo,in_progress,review,done',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect('/tasks/' . $task->id)
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('/tasks')
            ->with('success', 'Task deleted successfully!');
    }
}
