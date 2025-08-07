@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Journal Details</h1>
            <div class="flex items-center space-x-3">
                <a href="{{ route('journals.edit', $journal->id) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-colors duration-200"
                   onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('journals.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-colors duration-200"
                   onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-900/50 border-l-4 border-green-500 text-green-300 p-4 mb-6 rounded-md shadow" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="p-8 border-b border-gray-700">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-4xl">{{ $journal->mood_emoji ?? '😐' }}</span>
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">
                                {{ $journal->title ?: 'Journal ' . $journal->date->format('d M Y') }}
                            </h2>
                            <div class="flex items-center space-x-3">
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $journal->mood_badge_class }}">
                                    {{ ucfirst($journal->mood) }}
                                </span>
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $journal->category_badge_class }}">
                                    {{ $journal->category }}
                                </span>
                                @if($journal->important)
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        ⭐ Important
                                    </span>
                                @endif
                                @if($journal->is_today)
                                    <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        Today
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-sm text-gray-400 mb-1">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ $journal->date->format('l, d F Y') }}
                        </div>
                        <div class="text-sm text-gray-400">
                            <i class="fas fa-clock mr-2"></i>
                            {{ $journal->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>

                @if($journal->formatted_tags)
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-400 mb-2">Tags:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($journal->tags as $tag)
                                <span class="px-3 py-1 text-sm bg-pink-100 text-pink-800 rounded-full">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Content Section -->
            <div class="p-8">
                <div class="prose prose-invert max-w-none">
                    <div class="bg-gray-750 rounded-xl p-6 border border-gray-700">
                        <h3 class="text-lg font-semibold text-white mb-4">
                            <i class="fas fa-edit mr-2 text-pink-400"></i>Today's Reflection
                        </h3>
                        <div class="text-gray-300 leading-relaxed whitespace-pre-wrap">
                            {{ $journal->content }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="p-8 border-t border-gray-700 bg-gray-750">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2 text-sm text-gray-400">
                            <i class="fas fa-user mr-2"></i>
                            <span>{{ $journal->user->name }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm text-gray-400">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Created {{ $journal->created_at->diffForHumans() }}</span>
                        </div>
                        @if($journal->updated_at != $journal->created_at)
                            <div class="flex items-center space-x-2 text-sm text-gray-400">
                                <i class="fas fa-edit mr-2"></i>
                                <span>Updated {{ $journal->updated_at->diffForHumans() }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button onclick="showDeleteConfirmation('delete-form', '{{ $journal->title ?: 'Journal ' . $journal->date->format('d M Y') }}', 'journal')"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                        <form id="delete-form" action="{{ route('journals.destroy', $journal->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <a href="{{ route('journals.create') }}" 
               class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-6 text-white hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-lg"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <div class="flex items-center">
                    <i class="fas fa-plus text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-xl font-bold mb-2">New Journal</h3>
                        <p class="text-green-100">Write journal for today</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('journals.calendar') }}" 
               class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-2xl p-6 text-white hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 transform hover:scale-105 shadow-lg"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Calendar</h3>
                        <p class="text-indigo-100">View journals in calendar</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('journals.insights') }}" 
               class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-6 text-white hover:from-purple-700 hover:to-purple-800 transition-all duration-300 transform hover:scale-105 shadow-lg"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <div class="flex items-center">
                    <i class="fas fa-chart-bar text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Insights</h3>
                        <p class="text-purple-100">Analyze your journal patterns</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete Journal?',
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
            showLoading('Deleting journal...', 'Please wait a moment');
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush 