<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['owner', 'tasks'])->latest()->paginate(10);
        return view('projects.index', compact('projects'));
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
