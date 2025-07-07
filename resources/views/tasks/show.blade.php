@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ $goal_url ?? route('tasks.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                <div class="flex items-start space-x-4">
                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                        @csrf
                        <button type="submit" class="mt-1 flex-shrink-0 h-8 w-8 rounded-full border-2 flex items-center justify-center {{ $task->is_completed ? 'bg-blue-600 border-blue-600 text-white cursor-not-allowed' : 'border-gray-300 hover:border-blue-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" {{ $task->is_completed ? 'disabled' : '' }}>
                            @if($task->is_completed)
                                <i class="fas fa-check"></i>
                            @endif
                        </button>
                    </form>
                    <div>
                        <h1 class="text-4xl font-bold text-gray-800 {{ $task->is_completed ? 'line-through text-gray-500' : '' }}">{{ $task->title }}</h1>
                        <p class="text-gray-600 mt-2 max-w-2xl">{{ $task->description }}</p>
                    </div>
                </div>
                <div class="flex space-x-3 mt-4 md:mt-0">
                    @if(!$task->is_completed)
                        <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">Delete</button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Details -->
            <div class="border-t border-gray-200 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Left Column -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Details</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-md font-semibold px-3 py-1 rounded-full inline-block
                                    @if($task->status == 'completed')
                                        bg-green-100 text-green-800
                                    @elseif($task->status == 'in_progress')
                                        bg-blue-100 text-blue-800
                                    @else
                                        bg-yellow-100 text-yellow-800
                                    @endif
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </dd>
                            </div>
                            @if($task->is_completed && $task->completed_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Completed On</dt>
                                <dd class="mt-1 text-md text-gray-900">{{ $task->completed_at->format('M d, Y \a\t h:i A') }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                                <dd class="mt-1 text-md text-gray-900 {{ $task->due_date && $task->due_date->isPast() && !$task->is_completed ? 'text-red-500 font-bold' : '' }}">
                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not Set' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Priority</dt>
                                <dd class="mt-1 text-md text-gray-900 capitalize">{{ $task->priority }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Right Column -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Related Goal</h3>
                        <div class="bg-gray-50 hover:bg-gray-100 rounded-xl p-6 transition-colors duration-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-semibold" style="color: {{ $task->goal->category->color }};">{{ $task->goal->category->name }}</p>
                                    <a href="{{ route('goals.show', $task->goal->id) }}" class="text-xl font-bold text-gray-800 hover:text-blue-600">{{ $task->goal->title }}</a>
                                </div>
                                <a href="{{ route('goals.show', $task->goal->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">View Goal <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700">Goal Progress</span>
                                    <span class="text-sm font-bold text-blue-600">{{ $task->goal->progress_percent }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $task->goal->progress_percent }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection