@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-8">
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('categories.index') }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 text-xs sm:text-sm md:text-base">
            <i class="fas fa-arrow-left mr-1 sm:mr-2 text-xs sm:text-sm"></i> Back to All Categories
        </a>
    </div>
    
    <!-- Category Header -->
    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-6 sm:mb-8">
        <div class="h-4" style="background-color: {{ $category->color }};"></div>
        <div class="p-4 sm:p-6 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start">
                <div>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-pink-500 mb-1 sm:mb-2">{{ $category->name }}</h1>
                    <p class="text-gray-400 text-sm sm:text-base md:text-lg">{{ $category->description }}</p>
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-3 mt-4 md:mt-0">
                    <a href="{{ route('categories.edit', $category->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1.5 sm:py-2 px-3 sm:px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 text-xs sm:text-sm">
                        <i class="fas fa-pencil-alt mr-1 sm:mr-2 text-xs sm:text-sm"></i>Edit
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" id="delete-category-form-{{ $category->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showDeleteConfirmation('delete-category-form-{{ $category->id }}', '{{ addslashes($category->name) }}', 'category')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 sm:py-2 px-3 sm:px-5 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 text-xs sm:text-sm">
                            <i class="fas fa-trash mr-1 sm:mr-2 text-xs sm:text-sm"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Goals Section -->
    <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0">
        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-pink-500">Goals in this Category</h2>
        <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="bg-gradient-to-r from-pink-600 to-pink-800 hover:bg-gradient-to-l from-pink-600 to-pink-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 text-xs sm:text-sm">
            <i class="fas fa-plus mr-1 sm:mr-2 text-xs sm:text-sm"></i> Add New Goal
        </a>
    </div>
    
    @if($category->goals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            @foreach($category->goals as $goal)
                <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-100 mb-2 sm:mb-3 truncate">{{ $goal->title }}</h3>
                        <p class="text-gray-400 mb-3 sm:mb-4 h-12 sm:h-16 overflow-hidden text-xs sm:text-sm">{{ Str::limit($goal->description, 100) }}</p>
                        
                        <div class="mb-3 sm:mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs sm:text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-xs sm:text-sm font-bold" style="color: {{ $category->color }};">{{ $goal->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 sm:h-2.5">
                                <div class="h-2 sm:h-2.5 rounded-full" style="width: {{ $goal->progress_percent }}%; background-color: {{ $category->color }};"></div>
                            </div>
                        </div>
                        
                        <div class="mt-4 sm:mt-6 flex justify-between items-center">
                            <span class="text-xs sm:text-sm text-gray-500"><i class="fas fa-check-circle mr-1"></i> {{ $goal->tasks->where('is_completed', true)->count() }}/{{ $goal->tasks->count() }} tasks</span>
                            <a href="{{ route('goals.show', $goal->id) }}" class="font-semibold text-blue-600 hover:text-blue-800 transition-colors duration-300 text-xs sm:text-sm">
                                View Details <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center p-8 sm:p-12 bg-gray-800 rounded-xl shadow-lg">
            <i class="fas fa-bullseye-pointer text-4xl sm:text-5xl md:text-6xl text-gray-300 mb-3 sm:mb-4"></i>
            <h2 class="text-xl sm:text-2xl font-semibold text-pink-500 mb-2">No Goals Yet</h2>
            <p class="text-gray-500 mb-4 sm:mb-6 text-sm sm:text-base">This category is waiting for its first goal. What will you achieve?</p>
            <a href="{{ route('goals.create', ['category_id' => $category->id]) }}" class="inline-block bg-gradient-to-r from-pink-600 to-pink-800 hover:bg-gradient-to-l from-pink-600 to-pink-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 text-xs sm:text-sm">
                <i class="fas fa-plus mr-1 sm:mr-2 text-xs sm:text-sm"></i> Create the First Goal
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'category' ? 'Category' : 'Data') + '?',
        html: `Are you sure you want to delete <b>"${itemTitle}"</b>?<br><span class='text-sm text-gray-400'>This action cannot be undone.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-xl sm:text-2xl font-bold text-red-400 pt-4',
            htmlContainer: 'text-base sm:text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg shadow-lg text-sm sm:text-base',
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg shadow-lg text-sm sm:text-base'
        },
        buttonsStyling: false,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush