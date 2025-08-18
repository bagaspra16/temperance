@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-8">
    <div class="w-full">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 sm:mb-6 md:mb-8 gap-3 sm:gap-0">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Journal Details</h1>
            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('journals.edit', $journal->id) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 sm:py-2.5 md:py-3 px-3 sm:px-4 md:px-6 rounded-lg shadow-lg transition-colors duration-200 text-xs sm:text-sm md:text-base"
                   onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-edit mr-1 sm:mr-2 text-xs sm:text-sm"></i> Edit
                </a>
                <a href="{{ route('journals.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 sm:py-2.5 md:py-3 px-3 sm:px-4 md:px-6 rounded-lg shadow-lg transition-colors duration-200 text-xs sm:text-sm md:text-base"
                   onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-arrow-left mr-1 sm:mr-2 text-xs sm:text-sm"></i> Back
                </a>
            </div>
        </div>



        <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="p-4 sm:p-6 md:p-8 lg:p-12 border-b border-gray-700">
                <div class="flex flex-col sm:flex-row items-start justify-between mb-4 sm:mb-6 gap-3 sm:gap-0">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <span class="text-3xl sm:text-4xl">{{ $journal->mood_emoji ?? '😐' }}</span>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white mb-1 sm:mb-2">
                                {{ $journal->title ?: 'Journal ' . $journal->date->format('d M Y') }}
                            </h2>
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium rounded-full {{ $journal->mood_badge_class }}">
                                    {{ ucfirst($journal->mood) }}
                                </span>
                                <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium rounded-full {{ $journal->category_badge_class }}">
                                    {{ $journal->category }}
                                </span>
                                @if($journal->important)
                                    <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium rounded-full bg-yellow-100 text-yellow-800">
                                        ⭐ Important
                                    </span>
                                @endif
                                @if($journal->is_today)
                                    <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium rounded-full bg-green-100 text-green-800">
                                        Today
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <div class="text-xs sm:text-sm text-gray-400 mb-1">
                            <i class="fas fa-calendar mr-1 sm:mr-2"></i>
                            {{ $journal->date->format('l, d F Y') }}
                        </div>
                        <div class="text-xs sm:text-sm text-gray-400">
                            <i class="fas fa-clock mr-1 sm:mr-2"></i>
                            {{ $journal->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>

                @if($journal->formatted_tags)
                    <div class="mb-3 sm:mb-4">
                        <h3 class="text-xs sm:text-sm font-medium text-gray-400 mb-1 sm:mb-2">Tags:</h3>
                        <div class="flex flex-wrap gap-1 sm:gap-2">
                            @foreach($journal->tags as $tag)
                                <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm bg-pink-100 text-pink-800 rounded-full">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Content Section -->
            <div class="p-4 sm:p-6 md:p-8 lg:p-12">
                <div class="prose prose-invert max-w-none">
                    <div class="bg-gray-750 rounded-xl p-4 sm:p-6 md:p-8 lg:p-12 border border-gray-700">
                        <h3 class="text-base sm:text-lg font-semibold text-white mb-3 sm:mb-4">
                            <i class="fas fa-edit mr-1 sm:mr-2 text-pink-400"></i>Today's Reflection
                        </h3>
                        <div class="text-gray-300 leading-relaxed text-sm sm:text-base lg:text-lg prose prose-invert max-w-none">
                            @if($journal->content && trim($journal->content) !== '')
                                {!! $journal->content !!}
                            @else
                                <p class="text-gray-500 italic">No content available for this journal entry.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="p-4 sm:p-6 md:p-8 lg:p-12 border-t border-gray-700 bg-gray-750">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                        <div class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-400">
                            <i class="fas fa-user mr-1 sm:mr-2"></i>
                            <span>{{ $journal->user->name }}</span>
                        </div>
                        <div class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-400">
                            <i class="fas fa-clock mr-1 sm:mr-2"></i>
                            <span>Created {{ $journal->created_at->diffForHumans() }}</span>
                        </div>
                        @if($journal->updated_at != $journal->created_at)
                            <div class="flex items-center space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-400">
                                <i class="fas fa-edit mr-1 sm:mr-2"></i>
                                <span>Updated {{ $journal->updated_at->diffForHumans() }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <button onclick="showDeleteConfirmation('delete-form', '{{ $journal->title ?: 'Journal ' . $journal->date->format('d M Y') }}', 'journal')"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-1.5 sm:py-2 px-3 sm:px-4 rounded-lg transition-colors duration-200 text-xs sm:text-sm">
                            <i class="fas fa-trash mr-1 sm:mr-2 text-xs sm:text-sm"></i> Delete
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mt-6 sm:mt-8">
            <a href="{{ route('journals.create') }}" 
               class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-4 sm:p-6 text-white hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-lg"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <div class="flex items-center">
                    <i class="fas fa-plus text-2xl sm:text-3xl mr-3 sm:mr-4"></i>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">New Journal</h3>
                        <p class="text-green-100 text-xs sm:text-sm">Write journal for today</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('journals.calendar') }}" 
               class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-2xl p-4 sm:p-6 text-white hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 transform hover:scale-105 shadow-lg"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-2xl sm:text-3xl mr-3 sm:mr-4"></i>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Calendar</h3>
                        <p class="text-indigo-100 text-xs sm:text-sm">View journals in calendar</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('journals.insights') }}" 
               class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-4 sm:p-6 text-white hover:from-purple-700 hover:to-purple-800 transition-all duration-300 transform hover:scale-105 shadow-lg"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <div class="flex items-center">
                    <i class="fas fa-chart-bar text-2xl sm:text-3xl mr-3 sm:mr-4"></i>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold mb-1 sm:mb-2">Insights</h3>
                        <p class="text-purple-100 text-xs sm:text-sm">Analyze your journal patterns</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Rich text content styling -->
<style>
/* Rich text content styling */
.prose {
    color: #D1D5DB;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #F9FAFB;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
}

.prose h1 { font-size: 1.875rem; }
.prose h2 { font-size: 1.5rem; }
.prose h3 { font-size: 1.25rem; }
.prose h4 { font-size: 1.125rem; }
.prose h5 { font-size: 1rem; }
.prose h6 { font-size: 0.875rem; }

.prose p {
    margin-bottom: 1rem;
    line-height: 1.7;
}

.prose ul, .prose ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.prose li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.prose blockquote {
    border-left: 4px solid #EC4899;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #9CA3AF;
    background-color: rgba(236, 72, 153, 0.1);
    padding: 1rem;
    border-radius: 0.5rem;
}

.prose code {
    background-color: #1F2937;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-family: 'Courier New', monospace;
    color: #F3F4F6;
    font-size: 0.875em;
}

.prose pre {
    background-color: #1F2937;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.5rem 0;
    border: 1px solid #374151;
}

.prose pre code {
    background: none;
    padding: 0;
    border-radius: 0;
    color: #F3F4F6;
}

.prose table {
    border-collapse: collapse;
    width: 100%;
    margin: 1.5rem 0;
    background-color: #374151;
    border-radius: 0.5rem;
    overflow: hidden;
}

.prose th, .prose td {
    border: 1px solid #4B5563;
    padding: 0.75rem;
    text-align: left;
}

.prose th {
    background-color: #4B5563;
    font-weight: 600;
    color: #F9FAFB;
}

.prose a {
    color: #EC4899;
    text-decoration: underline;
    transition: color 0.2s;
}

.prose a:hover {
    color: #F472B6;
}

.prose strong {
    color: #F9FAFB;
    font-weight: 600;
}

.prose em {
    color: #D1D5DB;
    font-style: italic;
}

.prose u {
    text-decoration: underline;
    color: #F9FAFB;
}

.prose s {
    text-decoration: line-through;
    color: #9CA3AF;
}

.prose mark {
    background-color: #FEF3C7;
    color: #92400E;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

.prose hr {
    border: none;
    border-top: 2px solid #4B5563;
    margin: 2rem 0;
}

.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.prose .highlight {
    background-color: #FEF3C7;
    color: #92400E;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

/* Mobile responsive adjustments */
@media (max-width: 640px) {
    .prose h1 { font-size: 1.5rem; }
    .prose h2 { font-size: 1.25rem; }
    .prose h3 { font-size: 1.125rem; }
    .prose h4 { font-size: 1rem; }
    .prose h5 { font-size: 0.875rem; }
    .prose h6 { font-size: 0.75rem; }
    
    .prose ul, .prose ol {
        padding-left: 1.5rem;
    }
    
    .prose table {
        font-size: 0.875rem;
    }
    
    .prose th, .prose td {
        padding: 0.5rem;
    }
}
</style>
<style>
/* Full width layout improvements */
@media (min-width: 1024px) {
    .container {
        max-width: 100%;
        padding-left: 2rem;
        padding-right: 2rem;
    }
}

@media (min-width: 1280px) {
    .container {
        padding-left: 3rem;
        padding-right: 3rem;
    }
}

@media (min-width: 1536px) {
    .container {
        padding-left: 4rem;
        padding-right: 4rem;
    }
}
</style>
@endpush

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
            showLoading('Deleting journal...', 'Please wait a moment');
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush 