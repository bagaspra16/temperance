@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Daily Journals</h1>
            <p class="text-gray-400 text-sm sm:text-base mt-2">Reflect on your day and track your personal growth journey</p>
        </div>
        <a href="{{ route('journals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2 text-sm sm:text-base w-full sm:w-auto" onclick="showLoading('Loading page...', 'Please wait a moment')">
            <i class="fas fa-plus"></i> <span class="hidden sm:inline">Write New Journal</span><span class="sm:hidden">New Journal</span>
        </a>
    </div>

    <!-- Today's Reminder -->
    @if(!$todayJournal)
        <div class="bg-gradient-to-r from-pink-500/50 to-pink-700/50 rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-2xl sm:text-3xl text-yellow-300"></i>
                </div>
                <div class="ml-3 sm:ml-4 flex-1">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-2">Today's Reflection</h3>
                    <p class="text-blue-100 mb-3 sm:mb-4 text-sm sm:text-base">Take a moment to write today's journal. Daily reflection helps you understand your emotions and personal growth.</p>
                    <a href="{{ route('journals.create') }}" class="inline-flex items-center bg-blue-500 text-gray-100 font-semibold py-2 px-3 sm:px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm sm:text-base" onclick="showLoading('Loading page...', 'Please wait a moment')">
                        <i class="fas fa-pen mr-2"></i> Start Writing
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8 shadow-lg border border-gray-600/70">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base sm:text-lg font-semibold text-white">
                <i class="fas fa-filter mr-2 text-pink-400"></i>Filter Journals
            </h3>
            @if(request('date') || request('mood') || request('category') || request('important') || request('search'))
                <span class="text-xs sm:text-sm text-pink-400 font-medium">
                    <i class="fas fa-check-circle mr-1"></i>Filters Active
                </span>
            @endif
        </div>
        
        <form method="GET" action="{{ route('journals.index') }}" id="filterForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <div class="flex flex-col">
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 sm:py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('date') ? 'border-pink-500' : '' }}"
                           style="min-height: 40px;">
                </div>
                
                <div class="flex flex-col">
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Mood</label>
                    <select name="mood" class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 sm:py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('mood') ? 'border-pink-500' : '' }}">
                        <option value="">All Moods</option>
                        <option value="happy" {{ request('mood') == 'happy' ? 'selected' : '' }}>😊 Happy</option>
                        <option value="sad" {{ request('mood') == 'sad' ? 'selected' : '' }}>😢 Sad</option>
                        <option value="anxious" {{ request('mood') == 'anxious' ? 'selected' : '' }}>😰 Anxious</option>
                        <option value="calm" {{ request('mood') == 'calm' ? 'selected' : '' }}>😌 Calm</option>
                        <option value="angry" {{ request('mood') == 'angry' ? 'selected' : '' }}>😠 Angry</option>
                        <option value="confused" {{ request('mood') == 'confused' ? 'selected' : '' }}>😕 Confused</option>
                        <option value="excited" {{ request('mood') == 'excited' ? 'selected' : '' }}>💪 Excited</option>
                        <option value="tired" {{ request('mood') == 'tired' ? 'selected' : '' }}>😴 Tired</option>
                        <option value="satisfied" {{ request('mood') == 'satisfied' ? 'selected' : '' }}>😌 Satisfied</option>
                        <option value="frustrated" {{ request('mood') == 'frustrated' ? 'selected' : '' }}>😤 Frustrated</option>
                    </select>
                </div>
                
                <div class="flex flex-col">
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Category</label>
                    <select name="category" class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 sm:py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('category') ? 'border-pink-500' : '' }}">
                        <option value="">All Categories</option>
                        <option value="Personal" {{ request('category') == 'Personal' ? 'selected' : '' }}>Personal</option>
                        <option value="Social" {{ request('category') == 'Social' ? 'selected' : '' }}>Social</option>
                        <option value="Career" {{ request('category') == 'Career' ? 'selected' : '' }}>Career</option>
                        <option value="Spiritual" {{ request('category') == 'Spiritual' ? 'selected' : '' }}>Spiritual</option>
                        <option value="Academic" {{ request('category') == 'Academic' ? 'selected' : '' }}>Academic</option>
                        <option value="Health" {{ request('category') == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Finance" {{ request('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Hobby" {{ request('category') == 'Hobby' ? 'selected' : '' }}>Hobby</option>
                    </select>
                </div>
                
                <div class="flex flex-col">
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Important</label>
                    <select name="important" class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 sm:py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('important') ? 'border-pink-500' : '' }}">
                        <option value="">All</option>
                        <option value="true" {{ request('important') === 'true' ? 'selected' : '' }}>Important</option>
                        <option value="false" {{ request('important') === 'false' ? 'selected' : '' }}>Regular</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                <div class="flex flex-col">
                    <label class="block text-xs sm:text-sm font-medium text-gray-300 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search in title or content..."
                           class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 sm:py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('search') ? 'border-pink-500' : '' }}">
                </div>
                
                <div class="flex items-end justify-end">
                    <span class="text-xs sm:text-sm text-gray-400 italic h-10 flex items-center">No active filters</span>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-6 sm:mb-8">
        <a href="{{ route('journals.calendar') }}" 
           class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl sm:rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center gap-2 text-sm sm:text-base"
           onclick="showLoading('Loading calendar...', 'Please wait a moment')">
            <i class="fas fa-calendar-alt mr-2"></i> <span class="hidden sm:inline">Calendar View</span><span class="sm:hidden">Calendar</span>
        </a>
        <a href="{{ route('journals.insights') }}" 
           class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl sm:rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center gap-2 text-sm sm:text-base"
           onclick="showLoading('Loading insights...', 'Please wait a moment')">
            <i class="fas fa-chart-bar mr-2"></i> <span class="hidden sm:inline">Insights & Analytics</span><span class="sm:hidden">Insights</span>
        </a>
    </div>

    <!-- Journals List -->
    <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden border border-gray-600/70">
        @if($journals->count() > 0)
            <div class="divide-y divide-gray-600/70">
                @foreach($journals as $journal)
                    <div class="p-4 sm:p-6 hover:bg-gray-800/40 backdrop-blur-sm transition-all duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 sm:space-x-3 mb-3">
                                    <span class="text-xl sm:text-2xl">{{ $journal->mood_emoji ?? '😐' }}</span>
                                    <div class="flex items-center space-x-1 sm:space-x-2">
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full {{ $journal->mood_badge_class }}">
                                            {{ ucfirst($journal->mood) }}
                                        </span>
                                        <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full {{ $journal->category_badge_class }}">
                                            {{ $journal->category }}
                                        </span>
                                        @if($journal->important)
                                            <span class="px-2 sm:px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                ⭐ Important
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    @if($journal->title)
                                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2">{{ $journal->title }}</h3>
                                    @endif
                                    <div class="text-gray-300 leading-relaxed text-sm sm:text-base prose prose-invert max-w-none">
                                        {!! Str::limit(strip_tags($journal->content), 200) !!}
                                    </div>
                                </div>
                                
                                @if($journal->formatted_tags)
                                    <div class="mb-3">
                                        <span class="text-xs sm:text-sm text-pink-400">{{ $journal->formatted_tags }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center text-xs sm:text-sm text-gray-400">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>{{ $journal->date->format('d M Y') }}</span>
                                    @if($journal->is_today)
                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Today</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2 ml-3 sm:ml-4">
                                <a href="{{ route('journals.show', $journal->id) }}" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-200 p-2"
                                   title="View Details">
                                    <i class="fas fa-eye text-sm sm:text-base"></i>
                                </a>
                                <a href="{{ route('journals.edit', $journal->id) }}" 
                                   class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200 p-2"
                                   title="Edit">
                                    <i class="fas fa-edit text-sm sm:text-base"></i>
                                </a>
                                <button onclick="showDeleteConfirmation('delete-form-{{ $journal->id }}', '{{ $journal->title ?: 'Journal ' . $journal->date->format('d M Y') }}', 'journal')"
                                        class="text-red-400 hover:text-red-300 transition-colors duration-200 p-2"
                                        title="Delete">
                                    <i class="fas fa-trash text-sm sm:text-base"></i>
                                </button>
                                <form id="delete-form-{{ $journal->id }}" action="{{ route('journals.destroy', $journal->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-4 sm:px-6 py-4 border-t border-gray-600/70">
                {{ $journals->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center p-6 sm:p-8 lg:p-12 bg-gradient-to-br from-gray-800/30 to-gray-900/40 backdrop-blur-sm">
                <div class="w-24 h-24 sm:w-32 sm:h-32 lg:w-40 lg:h-40 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center mx-auto mb-6 sm:mb-8 border border-pink-500/30">
                    <i class="fas fa-book-open text-3xl sm:text-4xl lg:text-5xl text-pink-400"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent mb-2">No Journals Yet</h2>
                <p class="text-gray-300 mb-6 sm:mb-8 max-w-md mx-auto text-sm sm:text-base">Start writing your daily journals to reflect on your self-improvement journey.</p>
                <a href="{{ route('journals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2 text-sm sm:text-base" onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-plus"></i> <span class="hidden sm:inline">Write First Journal</span><span class="sm:hidden">Write Journal</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* Rich text content styling for index */
.prose {
    color: #D1D5DB;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #F9FAFB;
    margin-top: 0.5rem;
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.prose h1 { font-size: 1.125rem; }
.prose h2 { font-size: 1rem; }
.prose h3 { font-size: 0.875rem; }
.prose h4 { font-size: 0.75rem; }
.prose h5 { font-size: 0.625rem; }
.prose h6 { font-size: 0.5rem; }

.prose p {
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.prose ul, .prose ol {
    margin-bottom: 0.5rem;
    padding-left: 1rem;
}

.prose li {
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.prose blockquote {
    border-left: 2px solid #EC4899;
    padding-left: 0.5rem;
    margin: 0.5rem 0;
    font-style: italic;
    color: #9CA3AF;
    background-color: rgba(236, 72, 153, 0.1);
    padding: 0.5rem;
    border-radius: 0.25rem;
}

.prose code {
    background-color: #1F2937;
    padding: 0.125rem 0.25rem;
    border-radius: 0.125rem;
    font-family: 'Courier New', monospace;
    color: #F3F4F6;
    font-size: 0.75em;
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

.prose a {
    color: #EC4899;
    text-decoration: underline;
}

.prose a:hover {
    color: #F472B6;
}
</style>
@endpush

@push('scripts')
<style>
/* Custom styling untuk konsistensi form inputs */
.filter-input {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    box-sizing: border-box;
    font-size: 14px;
    line-height: 1.5;
}

/* Khusus untuk input date agar konsisten */
input[type="date"].filter-input {
    position: relative;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 8px center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
    padding-right: 40px;
}

/* Khusus untuk select agar konsisten */
select.filter-input {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 8px center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
    padding-right: 40px;
}

/* Hover state untuk semua inputs */
.filter-input:hover {
    border-color: #9ca3af;
}

/* Focus state untuk semua inputs */
.filter-input:focus {
    border-color: #ec4899;
    box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.2);
}

/* Placeholder styling */
.filter-input::placeholder {
    color: #9ca3af;
    opacity: 1;
}

/* Disabled state */
.filter-input:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>

<script>
// Auto-submit functionality for filters
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    
    // Get all filter inputs
    const filterInputs = document.querySelectorAll('.filter-input');
    
    // Add event listeners for immediate submit (date, mood, category, important)
    filterInputs.forEach(input => {
        if (input.name !== 'search') {
            input.addEventListener('change', function() {
                showLoading('Filtering journals...', 'Please wait a moment');
                document.getElementById('filterForm').submit();
            });
        }
    });
    
    // Add event listener for search input with debouncing
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                showLoading('Searching journals...', 'Please wait a moment');
                document.getElementById('filterForm').submit();
            }, 500); // 500ms delay for search
        });
    }
});

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

function clearFilters() {
    showLoading('Clearing filters...', 'Please wait a moment');
    document.getElementById('filterForm').reset();
    document.getElementById('filterForm').submit();
}
</script>
@endpush 