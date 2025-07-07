@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ progress: {{ old('progress_percent', 0) }}, status: '{{ old('status', 'not_started') }}' }">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('goals.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Goals
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Create a New Goal</h1>
                <p class="text-gray-600 mb-8">Let's set up your next big achievement.</p>

                <form action="{{ route('goals.store') }}" method="POST">
                    @csrf
                    
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
                            <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g., Learn Laravel from scratch" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" placeholder="Describe what you want to accomplish." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                            <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id') == $category->id || request('category_id') == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="priority" class="block text-gray-700 font-medium mb-2">Priority</label>
                            <select name="priority" id="priority" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') ?? date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-gray-700 font-medium mb-2">Target Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="progress_percent" class="block text-gray-700 font-medium mb-2">Initial Progress: <span x-text="progress + '%'" class="font-bold"></span></label>
                            <input type="range" name="progress_percent" id="progress_percent" min="0" max="100" step="5" x-model="progress" class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="status" class="block text-gray-700 font-medium mb-2">Initial Status</label>
                            <select name="status" id="status" x-model="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-check mr-2"></i> Create Goal
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