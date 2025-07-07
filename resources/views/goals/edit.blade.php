@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ progress: {{ old('progress_percent', $goal->progress_percent) }}, status: '{{ old('status', $goal->status) }}' }">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('goals.show', $goal->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Goal
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Goal</h1>
                <p class="text-gray-600 mb-8">Refine your objective and keep moving forward.</p>

                <form action="{{ route('goals.update', $goal->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                            <p class="font-bold">Please fix the errors below:</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-gray-700 font-medium mb-2">Goal Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $goal->title) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description', $goal->description) }}</textarea>
                        </div>

                        <div>
                            <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                            <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $goal->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="priority" class="block text-gray-700 font-medium mb-2">Priority</label>
                            <select name="priority" id="priority" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="low" {{ old('priority', $goal->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $goal->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $goal->priority) == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $goal->start_date ? $goal->start_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-gray-700 font-medium mb-2">Target Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $goal->end_date ? $goal->end_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="progress_percent" class="block text-gray-700 font-medium mb-2">Progress: <span x-text="progress + '%'" class="font-bold"></span></label>
                            <input type="range" name="progress_percent" id="progress_percent" min="0" max="100" step="5" x-model="progress" class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                            <select name="status" id="status" x-model="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-save mr-2"></i> Update Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush