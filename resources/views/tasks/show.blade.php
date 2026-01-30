@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="px-4 sm:px-0">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $task->title }}</h1>
                <div class="mt-2 flex items-center gap-3">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($task->priority === 'urgent') bg-red-100 text-red-800
                        @elseif($task->priority === 'high') bg-orange-100 text-orange-800
                        @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst($task->priority) }} Priority
                    </span>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($task->status === 'done') bg-green-100 text-green-800
                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif($task->status === 'review') bg-purple-100 text-purple-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ str_replace('_', ' ', ucfirst($task->status)) }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Edit
                </a>
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Back to Tasks
                </a>
            </div>
        </div>
    </div>

    <!-- Task Details -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Task Details</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $task->description ?: 'No description provided' }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Project</dt>
                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                        <a href="{{ route('projects.show', $task->project) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $task->project->name }}
                        </a>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Assigned To</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($task->assignedUser)
                            {{ $task->assignedUser->name }}
                        @else
                            <span class="text-gray-500 italic">Unassigned</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Created By</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $task->creator->name }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($task->due_date)
                            {{ $task->due_date->format('d.m.Y') }}
                            @if($task->due_date->isPast() && $task->status !== 'done')
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                            @endif
                        @else
                            <span class="text-gray-500 italic">Not set</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $task->created_at->format('d.m.Y H:i') }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $task->updated_at->format('d.m.Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection