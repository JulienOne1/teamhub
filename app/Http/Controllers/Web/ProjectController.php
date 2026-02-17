<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['owner', 'tasks']);

        // Sortierung nach Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Sortierung nach Datum
        $sort = $request->get('sort', 'latest');
        match($sort) {
            'oldest' => $query->oldest(),
            'name' => $query->orderBy('name'),
            'status' => $query->orderBy('status'),
            default => $query->latest(),
        };

        $projects = $query->paginate(10);
        $currentStatus = $request->get('status', '');
        $currentSort = $sort;

        return view('projects.index', compact('projects', 'currentStatus', 'currentSort'));
    }
    
    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'owner_id' => 'required|exists:users,id',
        ]);

        Project::create($validated);

        return redirect('/projects')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load(['owner', 'tasks.assignedUser', 'tasks.creator']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'owner_id' => 'required|exists:users,id',
        ]);

        $project->update($validated);

        return redirect('/projects/' . $project->id)
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect('/projects')
            ->with('success', 'Project deleted successfully!');
    }
}
