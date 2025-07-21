@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('tasks.show', $task->id) }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Task
            </a>
        </div>
        <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
            <div class="p-8">
                <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">Edit Task</h1>
                <p class="text-gray-300 mb-8">Make adjustments to this task.</p>
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="bg-pink-100 border-l-4 border-pink-500 text-pink-800 p-4 mb-6 rounded-xl" role="alert">
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
                            <label for="title" class="block text-pink-200 font-medium mb-2">Task Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-pink-200 font-medium mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label for="goal_id" class="block text-pink-200 font-medium mb-2">Related Goal</label>
                            <select name="goal_id" id="goal_id" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                                <option value="">Select a goal</option>
                                @foreach($goals as $goal)
                                    <option value="{{ $goal->id }}" {{ (old('goal_id', $task->goal_id) == $goal->id) ? 'selected' : '' }}>
                                        {{ $goal->title }} ({{ $goal->category->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="due_date" class="block text-pink-200 font-medium mb-2">Due Date</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label for="priority" class="block text-pink-200 font-medium mb-2">Priority</label>
                            <select name="priority" id="priority" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                                <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="status" class="block text-pink-200 font-medium mb-2">Status</label>
                            <select name="status" id="status" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                                <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                            <i class="fas fa-save mr-2"></i> Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
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