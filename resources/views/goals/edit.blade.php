@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-8" x-data="{ progress: {{ old('progress_percent', $goal->progress_percent) }}, status: '{{ old('status', $goal->status) }}' }">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <a href="{{ route('goals.show', $goal->id) }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base">
                <i class="fas fa-arrow-left text-xs sm:text-sm"></i> Back to Goal
            </a>
        </div>
        <div class="bg-gray-800 rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
            <div class="p-4 sm:p-6 md:p-8">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-1 sm:mb-2">Edit Goal</h1>
                <p class="text-gray-300 mb-4 sm:mb-6 md:mb-8 text-xs sm:text-sm md:text-base">Refine your objective and keep moving forward.</p>
                

                <form action="{{ route('goals.update', $goal->id) }}" method="POST">
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 md:gap-8">
                        <div class="md:col-span-3">
                            <label for="title" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Goal Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $goal->title) }}" class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="md:col-span-3">
                            <label for="description" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Description</label>
                            <textarea name="description" id="description" rows="3" class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">{{ old('description', $goal->description) }}</textarea>
                        </div>
                        <div>
                            <label for="category_id" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Category</label>
                            <select name="category_id" id="category_id" class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $goal->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="priority" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Priority</label>
                            <select name="priority" id="priority" class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                                <option value="low" {{ old('priority', $goal->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $goal->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $goal->priority) == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div>
                            <label for="start_date" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $goal->start_date ? $goal->start_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="end_date" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Target Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $goal->end_date ? $goal->end_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="status" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Status</label>
                            <select name="status" id="status" class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                                <option value="not_started" {{ old('status', $goal->status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                <option value="in_progress" {{ old('status', $goal->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="complete" {{ old('status', $goal->status) == 'complete' ? 'selected' : '' }}>Complete</option>
                                <option value="finished" {{ old('status', $goal->status) == 'finished' ? 'selected' : '' }}>Finished</option>
                                <option value="abandoned" {{ old('status', $goal->status) == 'abandoned' ? 'selected' : '' }}>Abandoned</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4 sm:mt-6 md:mt-8">
                        <button type="submit" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2 sm:py-2.5 md:py-3 px-4 sm:px-6 md:px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base">
                            <i class="fas fa-save"></i> Update Goal
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
        title: 'Delete ' + (type === 'goal' ? 'Goal' : 'Data') + '?',
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
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush