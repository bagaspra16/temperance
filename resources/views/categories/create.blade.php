@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-pink-600">Create a New Category</h1>
            <p class="text-gray-500">Organize your goals with a fresh category.</p>
        </div>
        
        <div class="bg-gray-800 rounded-xl shadow-lg p-8">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                        <p class="font-bold">Oops! Something went wrong.</p>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="mb-6">
                    <label for="name" class="block text-gray-500 font-semibold mb-2">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-3 border bg-transparent text-gray-100 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition-shadow" placeholder="e.g., Fitness, Work, Personal Growth" required>
                </div>
                
                <div class="mb-6">
                    <label for="color" class="block text-gray-500 font-semibold mb-2">Color</label>
                    <input type="color" name="color" id="color" value="{{ old('color', '#3b82f6') }}" class="w-full h-12 p-1 border border-gray-300 rounded-lg shadow-sm cursor-pointer">
                </div>
                
                <div class="mb-8">
                    <label for="description" class="block text-gray-500 font-semibold mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 text-gray-100 border border-gray-300 bg-transparent rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent transition-shadow" placeholder="What is this category about?">{{ old('description') }}</textarea>
                </div>
                
                <div class="flex justify-between items-center">
                    <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-800 font-semibold transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                    <button type="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-plus-circle mr-2"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection