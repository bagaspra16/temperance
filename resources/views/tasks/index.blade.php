@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">All Tasks</h1>
            <p class="text-gray-400 text-sm sm:text-base mt-2">Manage your daily tasks and track your productivity</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl sm:rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 flex items-center justify-center gap-2 text-sm sm:text-base w-full sm:w-auto" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
            <i class="fas fa-plus"></i> <span class="hidden sm:inline">Add New Task</span><span class="sm:hidden">New Task</span>
        </a>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden border border-gray-600/70">
        @if($tasks->count() > 0)
            @include('tasks._list', ['tasks' => $tasks])
        @else
            <div class="text-center p-6 sm:p-8 lg:p-12 bg-gradient-to-br from-gray-800/30 to-gray-900/40 backdrop-blur-sm">
                <div class="w-24 h-24 sm:w-32 sm:h-32 lg:w-40 lg:h-40 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center mx-auto mb-6 sm:mb-8 border border-pink-500/30">
                    <i class="fas fa-check-circle text-3xl sm:text-4xl lg:text-5xl text-pink-400"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent mb-2">All Tasks Clear!</h2>
                <p class="text-gray-300 mb-6 sm:mb-8 max-w-md mx-auto text-sm sm:text-base">You have no pending tasks. Create a new task to get started or enjoy the peace of mind!</p>
                <a href="{{ route('tasks.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2 text-sm sm:text-base" onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                    <i class="fas fa-plus"></i> <span class="hidden sm:inline">Create a New Task</span><span class="sm:hidden">Create Task</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'task' ? 'Task' : 'Data') + '?',
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
            showLoading('Menghapus task...', 'Mohon tunggu sebentar');
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush