@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Your Categories</h1>
        <a href="{{ route('categories.create') }}" class="bg-gradient-to-tl from-pink-500 to-pink-700 hover:bg-gradient-to-br from-pink-500 to-pink-700 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl sm:rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 flex items-center justify-center gap-2 text-sm sm:text-base w-full sm:w-auto" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
            <i class="fas fa-plus"></i> <span class="hidden sm:inline">Add New Category</span><span class="sm:hidden">New Category</span>
        </a>
    </div>

    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($categories as $category)
                <div class="bg-gray-800 rounded-xl sm:rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="p-4 sm:p-6">
                        <div class="flex justify-between items-start">
                            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-100 mb-2">{{ $category->name }}</h2>
                            <span class="text-xs sm:text-sm font-semibold py-1 px-2 sm:px-3 rounded-full" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                {{ $category->goals->count() }} {{ Str::plural('goal', $category->goals->count()) }}
                            </span>
                        </div>
                        <p class="text-gray-400 mb-4 sm:mb-6 h-12 overflow-hidden text-sm sm:text-base">{{ $category->description ?? 'No description provided.' }}</p>
                        <div class="flex justify-end items-center">
                            <div class="flex flex-col sm:flex-row gap-2 sm:space-x-3 w-full sm:w-auto">
                                <a href="{{ route('categories.show', $category->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-3 sm:px-4 rounded-lg sm:rounded-xl transition-colors duration-300 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm" onclick="showLoading('Memuat detail...', 'Mohon tunggu sebentar')">
                                    <i class="fas fa-eye"></i> <span class="hidden sm:inline">View</span><span class="sm:hidden">View</span>
                                </a>
                                <a href="{{ route('categories.edit', $category->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-3 sm:px-4 rounded-lg sm:rounded-xl transition-colors duration-300 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm" onclick="showLoading('Memuat halaman edit...', 'Mohon tunggu sebentar')">
                                    <i class="fas fa-edit"></i> <span class="hidden sm:inline">Edit</span><span class="sm:hidden">Edit</span>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline w-full sm:w-auto" id="delete-category-form-{{ $category->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="showDeleteConfirmation('delete-category-form-{{ $category->id }}', '{{ addslashes($category->name) }}', 'category')" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-3 sm:px-4 rounded-lg sm:rounded-xl transition-colors duration-300 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm">
                                        <i class="fas fa-trash"></i> <span class="hidden sm:inline">Delete</span><span class="sm:hidden">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center p-6 sm:p-8 lg:p-12 bg-white rounded-xl sm:rounded-xl shadow-lg">
            <i class="fas fa-folder-open text-4xl sm:text-6xl text-gray-300 mb-4 sm:mb-4"></i>
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-700 mb-2">No Categories Found</h2>
            <p class="text-gray-500 mb-6 text-sm sm:text-base">Get started by creating your first category to organize your goals.</p>
            <a href="{{ route('categories.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 flex items-center justify-center gap-2 text-sm sm:text-base w-full sm:w-auto" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                <i class="fas fa-plus"></i> <span class="hidden sm:inline">Create Your First Category</span><span class="sm:hidden">Create Category</span>
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
            showLoading('Menghapus kategori...', 'Mohon tunggu sebentar');
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush