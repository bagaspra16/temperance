@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Daily Journals</h1>
        <a href="{{ route('journals.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300" onclick="showLoading('Loading page...', 'Please wait a moment')">
            <i class="fas fa-plus mr-2"></i> Write New Journal
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-900/50 border-l-4 border-green-500 text-green-300 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 mb-6 rounded-md shadow" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Today's Reminder -->
    @if(!$todayJournal)
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-6 mb-8 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-3xl text-yellow-300"></i>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-xl font-bold text-white mb-2">Today's Reflection</h3>
                    <p class="text-blue-100 mb-4">Take a moment to write today's journal. Daily reflection helps you understand your emotions and personal growth.</p>
                    <a href="{{ route('journals.create') }}" class="inline-flex items-center bg-white text-blue-600 font-semibold py-2 px-4 rounded-lg hover:bg-blue-50 transition-colors duration-200" onclick="showLoading('Loading page...', 'Please wait a moment')">
                        <i class="fas fa-pen mr-2"></i> Start Writing
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="bg-gray-800 rounded-2xl p-6 mb-8 shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">
                <i class="fas fa-filter mr-2 text-pink-400"></i>Filter Journals
            </h3>
            @if(request('date') || request('mood') || request('category') || request('important') || request('search'))
                <span class="text-sm text-pink-400 font-medium">
                    <i class="fas fa-check-circle mr-1"></i>Filters Active
                </span>
            @endif
        </div>
        
        <form method="GET" action="{{ route('journals.index') }}" id="filterForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex flex-col">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('date') ? 'border-pink-500' : '' }}"
                           style="min-height: 40px;">
                </div>
                
                <div class="flex flex-col">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mood</label>
                    <select name="mood" class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('mood') ? 'border-pink-500' : '' }}">
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
                    <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                    <select name="category" class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('category') ? 'border-pink-500' : '' }}">
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
                    <label class="block text-sm font-medium text-gray-300 mb-2">Important</label>
                    <select name="important" class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('important') ? 'border-pink-500' : '' }}">
                        <option value="">All</option>
                        <option value="true" {{ request('important') === 'true' ? 'selected' : '' }}>Important</option>
                        <option value="false" {{ request('important') === 'false' ? 'selected' : '' }}>Regular</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search in title or content..."
                           class="filter-input w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-pink-500 h-10 {{ request('search') ? 'border-pink-500' : '' }}">
                </div>
                
                <div class="flex items-end justify-end">
                    @if(request('date') || request('mood') || request('category') || request('important') || request('search'))
                        <button type="button" onclick="clearFilters()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg transition-colors duration-200 h-10">
                            <i class="fas fa-times mr-2"></i> Clear All
                        </button>
                    @else
                        <span class="text-sm text-gray-400 italic h-10 flex items-center">No active filters</span>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Actions -->
    <div class="flex flex-wrap gap-4 mb-8">
        <a href="{{ route('journals.calendar') }}" 
           class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105"
           onclick="showLoading('Loading calendar...', 'Please wait a moment')">
            <i class="fas fa-calendar-alt mr-2"></i> Calendar View
        </a>
        <a href="{{ route('journals.insights') }}" 
           class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105"
           onclick="showLoading('Loading insights...', 'Please wait a moment')">
            <i class="fas fa-chart-bar mr-2"></i> Insights & Analytics
        </a>
    </div>

    <!-- Journals List -->
    <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        @if($journals->count() > 0)
            <div class="divide-y divide-gray-700">
                @foreach($journals as $journal)
                    <div class="p-6 hover:bg-gray-750 transition-colors duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="text-2xl">{{ $journal->mood_emoji ?? '😐' }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $journal->mood_badge_class }}">
                                            {{ ucfirst($journal->mood) }}
                                        </span>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $journal->category_badge_class }}">
                                            {{ $journal->category }}
                                        </span>
                                        @if($journal->important)
                                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                ⭐ Important
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    @if($journal->title)
                                        <h3 class="text-xl font-bold text-white mb-2">{{ $journal->title }}</h3>
                                    @endif
                                    <p class="text-gray-300 leading-relaxed">{{ $journal->content_preview }}</p>
                                </div>
                                
                                @if($journal->formatted_tags)
                                    <div class="mb-3">
                                        <span class="text-sm text-pink-400">{{ $journal->formatted_tags }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center text-sm text-gray-400">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>{{ $journal->date->format('d M Y') }}</span>
                                    @if($journal->is_today)
                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Today</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('journals.show', $journal->id) }}" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-200"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('journals.edit', $journal->id) }}" 
                                   class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="showDeleteConfirmation('delete-form-{{ $journal->id }}', '{{ $journal->title ?: 'Journal ' . $journal->date->format('d M Y') }}', 'journal')"
                                        class="text-red-400 hover:text-red-300 transition-colors duration-200"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
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
            <div class="px-6 py-4 border-t border-gray-700">
                {{ $journals->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center p-12">
                <i class="fas fa-book-open text-6xl text-gray-500 mb-6"></i>
                <h2 class="text-3xl font-bold text-gray-100 mb-2">No Journals Yet</h2>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">Start writing your daily journals to reflect on your self-improvement journey.</p>
                <a href="{{ route('journals.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 inline-block" onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-plus mr-2"></i> Write First Journal
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

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

function clearFilters() {
    showLoading('Clearing filters...', 'Please wait a moment');
    document.getElementById('filterForm').reset();
    document.getElementById('filterForm').submit();
}
</script>
@endpush 