@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">All Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
            <i class="fas fa-plus mr-2"></i> Add New Task
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-900/50 border-l-4 border-green-500 text-green-300 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        @if($tasks->count() > 0)
            @include('tasks._list', ['tasks' => $tasks])
        @else
            <div class="text-center p-12">
                <img src="{{ asset('img/no-tasks.svg') }}" alt="No Tasks" class="mx-auto h-40 mb-8">
                <h2 class="text-3xl font-bold text-gray-100 mb-2">All Tasks Clear!</h2>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">You have no pending tasks. Create a new task to get started or enjoy the peace of mind!</p>
                <a href="{{ route('tasks.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 inline-block">
                    <i class="fas fa-plus mr-2"></i> Create a New Task
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
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush