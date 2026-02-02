@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="px-4 sm:px-0">
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Projects</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all projects in your organization.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ url('/projects/create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                Create Project
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <ul class="divide-y divide-gray-200">
            @forelse($projects as $project)
            <li class="px-6 py-4 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <a href="{{ url('/projects/' . $project->id) }}" class="block">
                            <p class="text-lg font-medium text-blue-600 truncate">{{ $project->name }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($project->description, 100) }}</p>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <span>Owner: {{ $project->owner->name }}</span>
                                <span class="mx-2">•</span>
                                <span>Tasks: {{ $project->tasks->count() }}</span>
                                @if($project->start_date)
                                <span class="mx-2">•</span>
                                <span>Start: {{ $project->start_date->format('d.m.Y') }}</span>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex items-center gap-2">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($project->status === 'active') bg-green-100 text-green-800
                            @elseif($project->status === 'planning') bg-yellow-100 text-yellow-800
                            @elseif($project->status === 'completed') bg-blue-100 text-blue-800
                            @elseif($project->status === 'on_hold') bg-orange-100 text-orange-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                        <a href="{{ url('/projects/' . $project->id . '/edit') }}" class="text-blue-600 hover:text-blue-900">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-4 text-center text-gray-500">
                No projects found. <a href="{{ url('/projects/create') }}" class="text-blue-600 hover:text-blue-800">Create your first project</a>
            </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
    <div class="mt-6">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection