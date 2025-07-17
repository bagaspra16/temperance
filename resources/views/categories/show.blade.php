@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Back to All Categories
        </a>
    </div>
    
    <!-- Category Header -->
    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="h-4" style="background-color: {{ $category->color }};"></div>
        <div class="p-8">
            <div class="flex flex-col md:flex-row justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold text-pink-500 mb-2">{{ $category->name }}</h1>
                    <p class="text-gray-400 text-lg">{{ $category->description }}</p>
                </div>
                <div class="flex space-x-3 mt-4 md:mt-0">
                    <a href="{{ route('categories.edit', $category->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-pencil-alt mr-2"></i>Edit
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" id="delete-category-form-{{ $category->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showDeleteConfirmation('delete-category-form-{{ $category->id }}', '{{ addslashes($category->name) }}', 'category')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-trash mr-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Goals Section -->
    <div class="mb-8 flex justify-between items-center">
        <h2 class="text-3xl font-bold text-pink-500">Goals in this Category</h2>
        <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="bg-gradient-to-r from-pink-600 to-pink-800 hover:bg-gradient-to-l from-pink-600 to-pink-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
            <i class="fas fa-plus mr-2"></i> Add New Goal
        </a>
    </div>
    
    @if($category->goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($category->goals as $goal)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3 truncate">{{ $goal->title }}</h3>
                        <p class="text-gray-600 mb-4 h-16 overflow-hidden">{{ Str::limit($goal->description, 100) }}</p>
                        
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-sm font-bold" style="color: {{ $category->color }};">{{ $goal->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%; background-color: {{ $category->color }};"></div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-between items-center">
                            <span class="text-sm text-gray-500"><i class="fas fa-check-circle mr-1"></i> {{ $goal->tasks->where('is_completed', true)->count() }}/{{ $goal->tasks->count() }} tasks</span>
                            <a href="{{ route('goals.show', $goal->id) }}" class="font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center p-12 bg-gray-800 rounded-xl shadow-lg">
            <i class="fas fa-bullseye-pointer text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-semibold text-pink-500 mb-2">No Goals Yet</h2>
            <p class="text-gray-500 mb-6">This category is waiting for its first goal. What will you achieve?</p>
            <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="inline-block bg-gradient-to-r from-pink-600 to-pink-800 hover:bg-gradient-to-l from-pink-600 to-pink-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                <i class="fas fa-plus mr-2"></i> Create the First Goal
            </a>
        </div>
    @endif
</div>
@endsection