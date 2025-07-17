@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-pink-500">Your Categories</h1>
        <a href="{{ route('categories.create') }}" class=" bg-gradient-to-tl from-pink-500 to-pink-700 hover:bg-gradient-to-br from-pink-500 to-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
            <i class="fas fa-plus mr-2"></i> Add New Category
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h2 class="text-2xl font-bold text-gray-100 mb-2">{{ $category->name }}</h2>
                            <span class="text-sm font-semibold py-1 px-3 rounded-full" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                {{ $category->goals->count() }} {{ Str::plural('goal', $category->goals->count()) }}
                            </span>
                        </div>
                        <p class="text-gray-400 mb-6 h-12 overflow-hidden">{{ $category->description ?? 'No description provided.' }}</p>
                        <div class="flex justify-end items-center">
                            <div class="flex space-x-3">
                                <a href="{{ route('categories.show', $category->id) }}" class="bg-blue-600 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded transition-colors duration-300">View</a>
                                <a href="{{ route('categories.edit', $category->id) }}" class="bg-yellow-600 hover:bg-yellow-800 text-white font-semibold py-2 px-4 rounded transition-colors duration-300">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" id="delete-category-form-{{ $category->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="showDeleteConfirmation('delete-category-form-{{ $category->id }}', '{{ addslashes($category->name) }}', 'category and all its goals')" class="bg-red-600 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded transition-colors duration-300">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center p-12 bg-white rounded-xl shadow-lg">
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">No Categories Found</h2>
            <p class="text-gray-500 mb-6">Get started by creating your first category to organize your goals.</p>
            <a href="{{ route('categories.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                <i class="fas fa-plus mr-2"></i> Create Your First Category
            </a>
        </div>
    @endif
</div>
@endsection