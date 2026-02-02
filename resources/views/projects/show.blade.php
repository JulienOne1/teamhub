@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="px-4 sm:px-0">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $project->name }}</h1>
                <div class="mt-2 flex items-center gap-3">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($project->status === 'active') bg-green-100 text-green-800
                        @elseif($project->status === 'planning') bg-yellow-100 text-yellow-800
                        @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                        @elseif($project->status === 'on_hold') bg-orange-100 text-orange-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ url('/projects/' . $project->id . '/edit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Edit
                </a>
                <a href="{{ url('/projects') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Back to Projects
                </a>
            </div>
        </div>
    </div>

    <!-- Project Details -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Project Details</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $project->description ?: 'No description provided' }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Owner</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $project->owner->name }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $project->start_date ? $project->start_date->format('d.m.Y') : 'Not set' }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">End Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $project->end_date ? $project->end_date->format('d.m.Y') : 'Not set' }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $project->created_at->format('d.m.Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Tasks -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Tasks ({{ $project->tasks->count() }})</h3>
            <a href="{{ url('/tasks/create?project_id=' . $project->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Add Task
            </a>
        </div>
        <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
                @forelse($project->tasks as $task)
                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <a href="{{ url('/tasks/' . $task->id) }}" class="block">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-blue-600 truncate">{{ $task->title }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    @if($task->assignedUser)
                                        Assigned to: {{ $task->assignedUser->name }}
                                    @else
                                        Unassigned
                                    @endif
                                    @if($task->due_date)
                                        • Due: {{ $task->due_date->format('d.m.Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex gap-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($task->priority === 'urgent') bg-red-100 text-red-800
                                    @elseif($task->priority === 'high') bg-orange-100 text-orange-800
                                    @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($task->priority) }}
                                </span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($task->status === 'done') bg-green-100 text-green-800
                                    @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                </span>
                            </div>
                        </div>
                    </a>
                </li>
                @empty
                <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                    No tasks yet. <a href="{{ url('/tasks/create?project_id=' . $project->id) }}" class="text-blue-600 hover:text-blue-800">Create the first task</a>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection