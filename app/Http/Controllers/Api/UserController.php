<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();
        
        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users)
        ]);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    public function projects(User $user): JsonResponse
    {
        $projects = $user->ownedProjects()->with('tasks')->get();

        return response()->json([
            'success' => true,
            'data' => ProjectResource::collection($projects)
        ]);
    }

    public function tasks(User $user): JsonResponse
    {
        $tasks = $user->assignedTasks()->with(['project', 'creator'])->get();

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks)
        ]);
    }
}