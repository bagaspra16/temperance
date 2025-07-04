@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Edit Progress Record</h1>
            <a href="{{ route('progress.show', $progress->id) }}" class="text-blue-500 hover:text-blue-700">Back to Progress Record</a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('progress.update', $progress->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if($progress->goal)
                    <input type="hidden" name="record_type" value="goal">
                    <input type="hidden" name="goal_id" value="{{ $progress->goal_id }}">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Goal</label>
                        <div class="p-2 border border-gray-300 rounded-md bg-gray-50">
                            {{ $progress->goal->title }} ({{ $progress->goal->category->name }})
                        </div>
                        <p class="text-sm text-gray-500 mt-1">The associated goal cannot be changed.</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="progress_value" class="block text-gray-700 font-medium mb-2">Progress Percentage</label>
                        <input type="range" name="progress_value" id="progress_value" min="0" max="100" step="5" value="{{ old('progress_value', $progress->progress_value) }}" class="w-full" oninput="progressValue.innerText = this.value + '%'">
                        <div class="text-right text-gray-500"><span id="progressValue">{{ old('progress_value', $progress->progress_value) }}%</span></div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="not_started" {{ old('status', $progress->goal->status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ old('status', $progress->goal->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $progress->goal->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                @elseif($progress->task)
                    <input type="hidden" name="record_type" value="task">
                    <input type="hidden" name="task_id" value="{{ $progress->task_id }}">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Task</label>
                        <div class="p-2 border border-gray-300 rounded-md bg-gray-50">
                            {{ $progress->task->title }} ({{ $progress->task->goal->title }})
                        </div>
                        <p class="text-sm text-gray-500 mt-1">The associated task cannot be changed.</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="completed" value="1" {{ old('completed', $progress->task->status === 'completed') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-700">Mark as completed</span>
                        </label>
                    </div>
                @endif
                
                <div class="mb-4">
                    <label for="note" class="block text-gray-700 font-medium mb-2">Notes</label>
                    <textarea name="note" id="note" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('note', $progress->note) }}</textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Update Progress Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection