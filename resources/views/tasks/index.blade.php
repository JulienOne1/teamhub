@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="px-4 sm:px-0">
    <div class="mb-6">
        <div>
            <h1 class="text-5xl font-bold text-center mb-8 mt-8" style="
                background: linear-gradient(145deg, #fbbf24, #f59e0b);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
            ">Tasks</h1>
        </div>
        <div class="text-center mb-6">
            <a href="{{ url('/tasks/create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                Create Task
            </a>
        </div>
    </div>

    <!-- Filter & Sort Bar -->
    <div class="glass rounded-2xl p-4 mb-6 shadow-xl">
        <form method="GET" action="{{ url('/tasks') }}" class="flex flex-wrap gap-4 items-center">
            <!-- Filter nach Priority -->
            <div class="flex items-center gap-2">
                <label class="text-sm font-bold text-gray-800">Priority:</label>
                <select name="priority" onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 bg-white bg-opacity-70">
                    <option value="" {{ $currentPriority == '' ? 'selected' : '' }}>All</option>
                    <option value="urgent" {{ $currentPriority == 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                    <option value="high" {{ $currentPriority == 'high' ? 'selected' : '' }}>🟠 High</option>
                    <option value="medium" {{ $currentPriority == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                    <option value="low" {{ $currentPriority == 'low' ? 'selected' : '' }}>🟢 Low</option>
                </select>
            </div>

            <!-- Filter nach Status -->
            <div class="flex items-center gap-2">
                <label class="text-sm font-bold text-gray-800">Status:</label>
                <select name="status" onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 bg-white bg-opacity-70">
                    <option value="" {{ $currentStatus == '' ? 'selected' : '' }}>All</option>
                    <option value="todo" {{ $currentStatus == 'todo' ? 'selected' : '' }}>To Do</option>
                    <option value="in_progress" {{ $currentStatus == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="review" {{ $currentStatus == 'review' ? 'selected' : '' }}>Review</option>
                    <option value="done" {{ $currentStatus == 'done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>

            <!-- Sortierung -->
            <div class="flex items-center gap-2">
                <label class="text-sm font-bold text-gray-800">Sort by:</label>
                <select name="sort" onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500 bg-white bg-opacity-70">
                    <option value="latest" {{ $currentSort == 'latest' ? 'selected' : '' }}>Newest First</option>
                    <option value="oldest" {{ $currentSort == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="priority" {{ $currentSort == 'priority' ? 'selected' : '' }}>Priority</option>
                    <option value="due_date" {{ $currentSort == 'due_date' ? 'selected' : '' }}>Due Date</option>
                    <option value="status" {{ $currentSort == 'status' ? 'selected' : '' }}>Status</option>
                </select>
            </div>

            <!-- Reset -->
            @if($currentPriority || $currentStatus || $currentSort != 'latest')
            <a href="{{ url('/tasks') }}" class="px-3 py-1 text-sm bg-white bg-opacity-50 rounded-lg text-gray-800 hover:bg-opacity-70 transition">
                ✕ Reset
            </a>
            @endif

            <!-- Ergebnis Anzahl -->
            <span class="text-sm text-gray-800 font-medium ml-auto">
                {{ $tasks->total() }} task(s) found
            </span>
        </form>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <ul class="divide-y divide-gray-200">
            @forelse($tasks as $task)
            <li class="px-6 py-4 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="{{ url('/tasks/' . $task->id) }}" class="block">
                            <p class="text-lg font-medium text-blue-600 truncate">{{ $task->title }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($task->description, 100) }}</p>
                            <div class="mt-2 flex items-center text-sm text-gray-500 flex-wrap gap-2">
                                <span class="inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    {{ $task->project->name }}
                                </span>
                                <span>•</span>
                                <span class="inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    @if($task->assignedUser)
                                        {{ $task->assignedUser->name }}
                                    @else
                                        Unassigned
                                    @endif
                                </span>
                                @if($task->due_date)
                                <span>•</span>
                                <span class="inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Due: {{ $task->due_date->format('d.m.Y') }}
                                </span>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex items-center gap-2">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($task->priority === 'urgent') bg-red-100 text-red-800
                            @elseif($task->priority === 'high') bg-orange-100 text-orange-800
                            @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($task->priority) }}
                        </span>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($task->status === 'done') bg-green-100 text-green-800
                            @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                            @elseif($task->status === 'review') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($task->status)) }}
                        </span>
                        <a href="{{ url('/tasks/' . $task->id . '/edit') }}" class="text-blue-600 hover:text-blue-900">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-4 text-center text-gray-500">
                No tasks found. <a href="{{ url('/tasks/create') }}" class="text-blue-600 hover:text-blue-800">Create your first task</a>
            </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    @if($tasks->hasPages())
    <div class="mt-6">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endsection