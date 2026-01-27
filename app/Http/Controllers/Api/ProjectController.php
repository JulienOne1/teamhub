<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::with(['owner', 'tasks'])->get();
        
        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects)
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'owner_id' => 'required|exists:users,id',
        ]);

        $project = Project::create($validated);
        $project->load(['owner', 'tasks']);

        return response()->json([
            'success' => true,
            'message' => 'Project created successfully',
            'data' => new ProjectResource($project)
        ], 201);
    }

    public function show(Project $project): JsonResponse
    {
        $project->load(['owner', 'tasks.assignedUser', 'tasks.creator']);
        
        return response()->json([
            'success' => true,
            'data' => new ProjectResource($project)
        ]);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'sometimes|required|in:planning,active,on_hold,completed,cancelled',
            'owner_id' => 'sometimes|required|exists:users,id',
        ]);

        $project->update($validated);
        $project->load(['owner', 'tasks']);

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully',
            'data' => new ProjectResource($project)
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    }

    public function tasks(Project $project): JsonResponse
    {
        $tasks = $project->tasks()->with(['assignedUser', 'creator'])->get();

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks)
        ]);
    }
}