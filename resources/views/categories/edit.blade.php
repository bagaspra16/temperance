@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-pink-600">Edit Category</h1>
            <p class="text-gray-500">Refine the details of your category.</p>
        </div>
        
        <div class="bg-gray-800 rounded-xl shadow-lg p-8">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" onsubmit="showLoading('Menyimpan perubahan...', 'Mohon tunggu sebentar')">
                @csrf
                @method('PUT')
                
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
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class=" text-gray-200 w-full px-4 py-3 border bg-transparent border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow" required>
                </div>
                
                <div class="mb-6">
                    <label for="color" class="block text-gray-500 font-semibold mb-2">Color</label>
                    <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}" class="text-gray-200 w-full h-12 p-1 border bg-transparent border-gray-600 rounded-lg shadow-sm cursor-pointer">
                </div>
                
                <div class="mb-8">
                    <label for="description" class="block text-gray-500 font-semibold mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="text-gray-200 w-full px-4 py-3 border bg-transparent border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-shadow">{{ old('description', $category->description) }}</textarea>
                </div>
                
                <div class="flex justify-between items-center">
                    <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-pink-600 font-semibold transition-colors duration-300" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-save mr-2"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
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
            title: 'text-2xl font-bold text-red-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
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