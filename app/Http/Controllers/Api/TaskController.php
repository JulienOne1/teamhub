<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::with(['project', 'assignedUser', 'creator'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    public function store(Request $request): JsonResponse
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

        $task = Task::create($validated);
        $task->load(['project', 'assignedUser', 'creator']);

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'data' => $task
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $task->load(['project', 'assignedUser', 'creator']);
        
        return response()->json([
            'success' => true,
            'data' => $task
        ]);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'sometimes|required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'sometimes|required|in:low,medium,high,urgent',
            'status' => 'sometimes|required|in:todo,in_progress,review,done',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);
        $task->load(['project', 'assignedUser', 'creator']);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }
}