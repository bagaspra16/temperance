@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Edit Goal</h1>
            <a href="{{ route('goals.show', $goal->id) }}" class="text-blue-500 hover:text-blue-700">Back to Goal</a>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('goals.update', $goal->id) }}" method="POST">
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
                
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $goal->title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                </div>
                
                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                    <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $goal->category_id) == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description', $goal->description) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">Target Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $goal->end_date ? $goal->end_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        <option value="not_started" {{ old('status', $goal->status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ old('status', $goal->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $goal->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="progress_percent" class="block text-gray-700 font-medium mb-2">Progress Percentage</label>
                    <input type="range" name="progress_percent" id="progress_percent" min="0" max="100" step="5" value="{{ old('progress_percent', $goal->progress_percent) }}" class="w-full" oninput="progressValue.innerText = this.value + '%'">
                    <div class="text-right text-gray-500"><span id="progressValue">{{ old('progress_percent', $goal->progress_percent) }}%</span></div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Update Goal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection