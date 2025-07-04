@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Add New Task</a>
    </div>
    
    @if($tasks->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @foreach($tasks as $task)
                    <li class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex-shrink-0 h-5 w-5 rounded-full border-2 {{ $task->status === 'completed' ? 'bg-blue-500 border-blue-500' : 'border-gray-300' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"></button>
                                </form>
                                <div>
                                    <h3 class="text-lg font-medium {{ $task->status === 'completed' ? 'line-through text-gray-500' : 'text-gray-900' }}">{{ $task->title }}</h3>
                                    @if($task->description)
                                        <p class="text-sm text-gray-500">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                    <div class="flex items-center space-x-4 text-xs text-gray-500 mt-1">
                                        <span>Goal: <a href="{{ route('goals.show', $task->goal->id) }}" class="font-medium text-blue-500">{{ $task->goal->title }}</a></span>
                                        <span>Category: <span class="font-medium" style="color: {{ $task->goal->category->color }};">{{ $task->goal->category->name }}</span></span>
                                        @if($task->due_date)
                                            <span class="{{ $task->due_date->isPast() && !$task->completed ? 'text-red-500 font-medium' : '' }}">Due: {{ $task->due_date->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500 mb-4">You don't have any tasks yet.</p>
            <a href="{{ route('tasks.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Create Your First Task</a>
        </div>
    @endif
</div>
@endsection