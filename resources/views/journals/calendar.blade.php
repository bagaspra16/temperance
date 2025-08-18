@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 gap-4 sm:gap-0">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Journal Calendar</h1>
        <div class="flex items-center space-x-2 sm:space-x-3">
            <a href="{{ route('journals.create') }}" 
               class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 sm:py-3 px-3 sm:px-6 rounded-lg shadow-lg transition-colors duration-200 text-xs sm:text-sm"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <i class="fas fa-plus mr-1 sm:mr-2"></i> New Journal
            </a>
            <a href="{{ route('journals.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 sm:py-3 px-3 sm:px-6 rounded-lg shadow-lg transition-colors duration-200 text-xs sm:text-sm"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <i class="fas fa-arrow-left mr-1 sm:mr-2"></i> Back
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8 mb-6 sm:mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-3 sm:p-4 md:p-6 text-white">
            <div class="flex items-center">
                <i class="fas fa-calendar-check text-xl sm:text-2xl md:text-3xl mr-2 sm:mr-3 md:mr-4"></i>
                <div>
                    <h3 class="text-sm sm:text-base md:text-lg font-bold mb-1 sm:mb-2">Journals This Month</h3>
                    <p class="text-blue-100 text-xs sm:text-sm md:text-base">{{ $journals->count() }} entries</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-3 sm:p-4 md:p-6 text-white">
            <div class="flex items-center">
                <i class="fas fa-star text-xl sm:text-2xl md:text-3xl mr-2 sm:mr-3 md:mr-4"></i>
                <div>
                    <h3 class="text-sm sm:text-base md:text-lg font-bold mb-1 sm:mb-2">Important Journals</h3>
                    <p class="text-green-100 text-xs sm:text-sm md:text-base">{{ $journals->where('important', true)->count() }} entries</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-3 sm:p-4 md:p-6 text-white">
            <div class="flex items-center">
                <i class="fas fa-chart-line text-xl sm:text-2xl md:text-3xl mr-2 sm:mr-3 md:mr-4"></i>
                <div>
                    <h3 class="text-sm sm:text-base md:text-lg font-bold mb-1 sm:mb-2">Average per Week</h3>
                    <p class="text-purple-100 text-xs sm:text-sm md:text-base">{{ round($journals->count() / 4, 1) }} journals</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Month Navigation -->
    <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl p-3 sm:p-4 md:p-6 mb-6 sm:mb-8 shadow-lg border border-gray-700/40">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-0">
            <a href="{{ route('journals.calendar', ['year' => $month == 1 ? $year - 1 : $year, 'month' => $month == 1 ? 12 : $month - 1]) }}" 
               class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 sm:py-3 px-3 sm:px-6 rounded-lg transition-colors duration-200 text-xs sm:text-sm"
               onclick="showLoading('Loading calendar...', 'Please wait a moment')">
                <i class="fas fa-chevron-left mr-1 sm:mr-2"></i> Previous Month
            </a>
            
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-white">
                {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
            </h2>
            
            <a href="{{ route('journals.calendar', ['year' => $month == 12 ? $year + 1 : $year, 'month' => $month == 12 ? 1 : $month + 1]) }}" 
               class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 sm:py-3 px-3 sm:px-6 rounded-lg transition-colors duration-200 text-xs sm:text-sm"
               onclick="showLoading('Loading calendar...', 'Please wait a moment')">
                Next Month <i class="fas fa-chevron-right ml-1 sm:ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-gray-900/40 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-700/40">
        <!-- Calendar Header -->
        <div class="grid grid-cols-7 bg-gradient-to-l from-gray-900/30 to-gray-900/40 border-b border-gray-700/40">
            @php
                $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            @endphp
            @foreach($daysOfWeek as $day)
                <div class="p-2 sm:p-3 md:p-4 text-center">
                    <span class="text-xs sm:text-sm font-semibold text-gray-300">{{ $day }}</span>
                </div>
            @endforeach
        </div>

        <!-- Calendar Body -->
        <div class="grid grid-cols-7">
            @php
                $firstDayOfMonth = \Carbon\Carbon::createFromDate($year, $month, 1);
                $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();
                $startDate = $firstDayOfMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                $endDate = $lastDayOfMonth->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);
                $currentDate = $startDate->copy();
            @endphp

            @while($currentDate <= $endDate)
                @php
                    $isCurrentMonth = $currentDate->month == $month;
                    $isToday = $currentDate->isToday();
                    $dayJournals = $journals->filter(function($journal) use ($currentDate) {
                        return $journal->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
                    });
                @endphp
                
                <div class="min-h-[60px] sm:min-h-[80px] md:min-h-[100px] lg:min-h-[120px] border-r border-b border-gray-700/40 p-1 sm:p-2 {{ $isCurrentMonth ? 'bg-gray-800/40' : 'bg-gray-900/40' }} {{ $isToday ? 'bg-gradient-to-br from-pink-900/40 to-pink-800/40 border-pink-500/30' : '' }} hover:bg-gray-700/40 transition-all duration-300 group {{ $dayJournals->count() > 0 ? 'cursor-pointer' : '' }} relative calendar-day"
                     @if($dayJournals->count() > 0)
                     onclick="showDayJournals('{{ $currentDate->format('Y-m-d') }}', '{{ $currentDate->format('l, F j, Y') }}')"
                     @endif>
                    
                    <!-- Journal count indicator -->
                    @if($dayJournals->count() > 0)
                        <div class="absolute top-1 right-1 bg-pink-600/80 text-white text-[8px] sm:text-xs font-bold px-1 py-0.5 rounded-full z-10 transition-all duration-200 journal-indicator border border-pink-500/30"
                             title="{{ $dayJournals->count() }} journal{{ $dayJournals->count() > 1 ? 's' : '' }} on {{ $currentDate->format('M j') }}">
                            {{ $dayJournals->count() }}
                        </div>
                    @endif
                    
                    <!-- Date Number -->
                    <div class="flex justify-between items-start mb-1">
                        <span class="text-xs sm:text-sm font-bold {{ $isCurrentMonth ? 'text-white' : 'text-gray-500' }} {{ $isToday ? 'bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-full w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 flex items-center justify-center shadow-lg' : '' }} group-hover:scale-110 transition-transform duration-200">
                            {{ $currentDate->format('j') }}
                        </span>
                        @if($isToday)
                            <span class="text-[10px] sm:text-xs text-pink-300 font-bold bg-pink-900/30 px-1 py-0.5 rounded-full border border-pink-500/20">TODAY</span>
                        @endif
                    </div>
                    
                    <!-- Journal Indicators -->
                    @if($dayJournals->count() > 0)
                        <div class="space-y-0.5 sm:space-y-1">
                            @foreach($dayJournals->take(2) as $journal)
                                <div class="flex items-center justify-between space-x-1 group/journal">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-[10px] sm:text-xs">{{ $journal->mood_emoji ?? '📝' }}</span>
                                        <span class="text-[8px] sm:text-xs text-gray-300 truncate max-w-[60px] sm:max-w-[80px] group-hover/journal:text-white transition-colors duration-200">
                                            {{ $journal->title ? Str::limit($journal->title, 8) : Str::limit($journal->content, 8) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-0.5">
                                        @if($journal->important)
                                            <i class="fas fa-star text-[8px] sm:text-xs text-yellow-400"></i>
                                        @endif
                                        @if($journal->category)
                                            <span class="text-[6px] sm:text-[8px] px-1 py-0.5 bg-gray-600 text-gray-200 rounded-full">
                                                {{ Str::limit($journal->category, 3) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @if($dayJournals->count() > 2)
                                <div class="text-[8px] sm:text-xs text-gray-400 flex items-center justify-between">
                                    <span>+{{ $dayJournals->count() - 2 }} more</span>
                                    <div class="flex items-center space-x-1">
                                        @if($dayJournals->where('important', true)->count() > 0)
                                            <span class="text-[6px] sm:text-[8px] bg-pink-600 text-white px-1 rounded-full">
                                                {{ $dayJournals->where('important', true)->count() }} ⭐
                                            </span>
                                        @endif
                                        @php
                                            $moodSummary = $dayJournals->groupBy('mood')->map->count()->sortDesc()->take(2);
                                        @endphp
                                        @if($moodSummary->count() > 0)
                                            <span class="text-[6px] sm:text-[8px] bg-blue-600 text-white px-1 rounded-full">
                                                {{ $moodSummary->keys()->first() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                @php
                    $currentDate->addDay();
                @endphp
            @endwhile
        </div>
    </div>

    <!-- Functional Content Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mt-8 sm:mt-12">
        <!-- Quick Actions -->
        <div class="bg-gradient-to-br from-blue-900/80 to-indigo-900/80 rounded-xl p-4 sm:p-6 shadow-lg border border-blue-500/30">
            <div class="flex items-center mb-4 sm:mb-6">
                <i class="fas fa-bolt text-2xl sm:text-3xl text-blue-300 mr-3 sm:mr-4"></i>
                <h3 class="text-lg sm:text-xl font-bold text-white">Quick Actions</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                <a href="{{ route('journals.create') }}" 
                   class="bg-blue-700/50 hover:bg-blue-600/50 text-blue-100 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base block text-center"
                   onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-plus mr-2"></i>New Journal
                </a>
                <a href="{{ route('journals.insights') }}" 
                   class="bg-indigo-700/50 hover:bg-indigo-600/50 text-indigo-100 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base block text-center"
                   onclick="showLoading('Loading insights...', 'Please wait a moment')">
                    <i class="fas fa-chart-bar mr-2"></i>View Insights
                </a>
                <button onclick="showTodayPrompt()" 
                        class="w-full bg-blue-600/50 hover:bg-blue-500/50 text-blue-100 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                    <i class="fas fa-lightbulb mr-2"></i>Today's Prompt
                </button>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="bg-gradient-to-br from-green-900/80 to-emerald-900/80 rounded-xl p-4 sm:p-6 shadow-lg border border-green-500/30">
            <div class="flex items-center mb-4 sm:mb-6">
                <i class="fas fa-chart-pie text-2xl sm:text-3xl text-green-300 mr-3 sm:mr-4"></i>
                <h3 class="text-lg sm:text-xl font-bold text-white">Monthly Stats</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                <div class="bg-green-800/50 rounded-lg p-3 sm:p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm sm:text-base font-semibold text-green-200">This Month</span>
                        <span class="text-sm sm:text-base font-bold text-green-100">{{ $journals->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="flex-1 bg-green-700/50 rounded-full h-2">
                            @php
                                $monthlyGoal = 30;
                                $monthlyCount = $journals->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
                                $monthlyProgress = min(100, ($monthlyCount / $monthlyGoal) * 100);
                            @endphp
                            <div class="bg-gradient-to-r from-green-400 to-emerald-400 h-2 rounded-full" style="width: {{ $monthlyProgress }}%"></div>
                        </div>
                        <span class="text-xs sm:text-sm text-green-300">{{ round($monthlyProgress, 1) }}%</span>
                    </div>
                </div>
                
                <div class="bg-emerald-800/50 rounded-lg p-3 sm:p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm sm:text-base font-semibold text-emerald-200">Average per Day</span>
                        <span class="text-sm sm:text-base font-bold text-emerald-100">{{ round($journals->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count() / max(1, now()->day), 1) }}</span>
                    </div>
                </div>
                
                <div class="bg-green-800/50 rounded-lg p-3 sm:p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm sm:text-base font-semibold text-green-200">Important Entries</span>
                        <span class="text-sm sm:text-base font-bold text-green-100">{{ $journals->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->where('important', true)->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-gradient-to-br from-purple-900/80 to-pink-900/80 rounded-xl p-4 sm:p-6 shadow-lg border border-purple-500/30">
            <div class="flex items-center mb-4 sm:mb-6">
                <i class="fas fa-clock text-2xl sm:text-3xl text-purple-300 mr-3 sm:mr-4"></i>
                <h3 class="text-lg sm:text-xl font-bold text-white">Recent Activity</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @php
                    $recentJournals = $journals->sortByDesc('created_at')->take(3);
                @endphp
                @forelse($recentJournals as $journal)
                    <div class="bg-purple-800/50 rounded-lg p-3 sm:p-4 hover:bg-purple-700/50 transition-colors duration-200 cursor-pointer group"
                         onclick="window.location.href='{{ route('journals.show', $journal->id) }}'">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm sm:text-base font-semibold text-purple-100 group-hover:text-white transition-colors duration-200">
                                {{ $journal->title ?: 'Journal ' . $journal->created_at->format('M d') }}
                            </span>
                            <span class="text-xs text-purple-300">{{ $journal->created_at->format('M d') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg">{{ $journal->mood_emoji ?? '📝' }}</span>
                            @if($journal->important)
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                            @endif
                            <span class="text-xs text-purple-300">{{ Str::limit($journal->content, 30) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-purple-800/50 rounded-lg p-3 sm:p-4 text-center">
                        <p class="text-sm text-purple-300">No recent journals</p>
                    </div>
                @endforelse
                
                <a href="{{ route('journals.index') }}" 
                   class="w-full bg-purple-700/50 hover:bg-purple-600/50 text-purple-200 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base block text-center"
                   onclick="showLoading('Loading journals...', 'Please wait a moment')">
                    <i class="fas fa-list mr-2"></i>View All Journals
                </a>
            </div>
        </div>

        <!-- Calendar Navigation -->
        <div class="bg-gradient-to-br from-orange-900/80 to-red-900/80 rounded-xl p-4 sm:p-6 shadow-lg border border-orange-500/30">
            <div class="flex items-center mb-4 sm:mb-6">
                <i class="fas fa-calendar-alt text-2xl sm:text-3xl text-orange-300 mr-3 sm:mr-4"></i>
                <h3 class="text-lg sm:text-xl font-bold text-white">Calendar Tools</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                <button onclick="goToToday()" 
                        class="w-full bg-orange-700/50 hover:bg-orange-600/50 text-orange-100 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                    <i class="fas fa-calendar-day mr-2"></i>Go to Today
                </button>
                <button onclick="showDatePicker()" 
                        class="w-full bg-red-700/50 hover:bg-red-600/50 text-red-100 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                    <i class="fas fa-calendar-plus mr-2"></i>Jump to Date
                </button>
                <div class="bg-orange-800/50 rounded-lg p-3 sm:p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm sm:text-base font-semibold text-orange-200">Current Month</span>
                        <span class="text-sm sm:text-base font-bold text-orange-100">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Writing Streak -->
        <div class="bg-gradient-to-br from-cyan-900/80 to-blue-900/80 rounded-xl p-4 sm:p-6 shadow-lg border border-cyan-500/30">
            <div class="flex items-center mb-4 sm:mb-6">
                <i class="fas fa-fire text-2xl sm:text-3xl text-cyan-300 mr-3 sm:mr-4"></i>
                <h3 class="text-lg sm:text-xl font-bold text-white">Writing Streak</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @php
                    $streak = 0;
                    $currentDate = now()->startOfDay();
                    while (true) {
                        $journal = $journals->where('created_at', '>=', $currentDate->copy()->startOfDay())
                                           ->where('created_at', '<=', $currentDate->copy()->endOfDay())
                                           ->first();
                        if (!$journal) {
                            break;
                        }
                        $streak++;
                        $currentDate->subDay();
                    }
                    $bestStreak = $streak; // For now, using current streak as best streak
                @endphp
                <div class="bg-cyan-800/50 rounded-lg p-3 sm:p-4 text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-cyan-100 mb-1">{{ $streak }}</div>
                    <div class="text-sm sm:text-base text-cyan-200">Consecutive Days</div>
                </div>
                
                <div class="bg-blue-800/50 rounded-lg p-3 sm:p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm sm:text-base font-semibold text-blue-200">Best Streak</span>
                        <span class="text-sm sm:text-base font-bold text-blue-100">{{ $bestStreak }}</span>
                    </div>
                    <div class="text-xs text-blue-300">Keep the momentum going!</div>
                </div>
                
                @if($streak > 0)
                    <div class="bg-cyan-700/50 rounded-lg p-3 sm:p-4">
                        <div class="text-sm text-cyan-200 text-center">
                            <i class="fas fa-trophy mr-1"></i>
                            Great job! You're on fire!
                        </div>
                    </div>
                @else
                    <button onclick="createJournalWithPrompt('Start your journaling streak today!')" 
                            class="w-full bg-cyan-600/50 hover:bg-cyan-500/50 text-cyan-100 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                        <i class="fas fa-play mr-2"></i>Start Streak
                    </button>
                @endif
            </div>
        </div>

        <!-- Quick Insights -->
        <div class="bg-gradient-to-br from-indigo-900/80 to-purple-900/80 rounded-xl p-4 sm:p-6 shadow-lg border border-indigo-500/30">
            <div class="flex items-center mb-4 sm:mb-6">
                <i class="fas fa-brain text-2xl sm:text-3xl text-indigo-300 mr-3 sm:mr-4"></i>
                <h3 class="text-lg sm:text-xl font-bold text-white">Quick Insights</h3>
            </div>
            <div class="space-y-3 sm:space-y-4">
                @php
                    $moodCounts = $journals->groupBy('mood')->map->count()->sortDesc();
                    $categoryCounts = $journals->groupBy('category')->map->count()->sortDesc();
                    $topMood = $moodCounts->keys()->first();
                    $topCategory = $categoryCounts->keys()->first();
                @endphp
                
                @if($topMood)
                    <div class="bg-indigo-800/50 rounded-lg p-3 sm:p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm sm:text-base font-semibold text-indigo-200">Top Mood</span>
                            <span class="text-sm sm:text-base font-bold text-indigo-100">{{ ucfirst($topMood) }}</span>
                        </div>
                    </div>
                @endif
                
                @if($topCategory)
                    <div class="bg-purple-800/50 rounded-lg p-3 sm:p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm sm:text-base font-semibold text-purple-200">Top Category</span>
                            <span class="text-sm sm:text-base font-bold text-purple-100">{{ $topCategory }}</span>
                        </div>
                    </div>
                @endif
                
                <div class="bg-indigo-800/50 rounded-lg p-3 sm:p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm sm:text-base font-semibold text-indigo-200">Total Words</span>
                        <span class="text-sm sm:text-base font-bold text-indigo-100">{{ $journals->sum(function($journal) { return strlen($journal->content); }) }}</span>
                    </div>
                </div>
                
                <a href="{{ route('journals.insights') }}" 
                   class="w-full bg-indigo-700/50 hover:bg-indigo-600/50 text-indigo-200 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base block text-center"
                   onclick="showLoading('Loading insights...', 'Please wait a moment')">
                    <i class="fas fa-chart-line mr-2"></i>Detailed Insights
                </a>
            </div>
        </div>
    </div>
</div>



<!-- Day Journals Modal -->
<div id="dayJournalsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 z-[9999] hidden overflow-hidden">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div id="journalModalPanel" class="bg-gray-800 rounded-xl shadow-2xl w-full max-w-sm sm:max-w-2xl lg:max-w-3xl max-h-[90vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="p-3 sm:p-4 lg:p-6 border-b border-gray-700 flex-shrink-0">
                <div class="flex justify-between items-start">
                    <div class="flex-1 min-w-0">
                        <h2 id="modalDate" class="text-base sm:text-lg lg:text-xl xl:text-2xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent truncate"></h2>
                        <p id="modalStats" class="text-xs sm:text-sm text-gray-400 mt-1 flex flex-wrap gap-2 sm:gap-4"></p>
                    </div>
                    <button onclick="closeDayModal()" class="text-gray-400 hover:text-white text-lg sm:text-xl p-1.5 sm:p-2 hover:bg-gray-700 rounded-lg transition-all duration-300 transform hover:scale-110 flex-shrink-0 ml-2">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Content -->
            <div id="modalContent" class="p-3 sm:p-4 lg:p-6 overflow-y-auto flex-1">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showDayJournals(date, formattedDate) {
    document.getElementById('modalDate').textContent = formattedDate;
    const backdrop = document.getElementById('dayJournalsModal');
    const panel = document.getElementById('journalModalPanel');
    backdrop.classList.remove('hidden');
    // Inline styles to ensure transition works above Tailwind
    backdrop.style.display = 'block';
    backdrop.style.opacity = '0';
    backdrop.style.transition = 'opacity 250ms ease';
    requestAnimationFrame(() => {
        backdrop.style.opacity = '1';
    });
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
    document.body.classList.add('modal-open');
    
    // Animate panel in
    if (panel) {
        panel.style.opacity = '0';
        panel.style.transform = 'scale(0.96) translateY(12px)';
        panel.style.transition = 'opacity 320ms ease, transform 360ms cubic-bezier(0.22, 1, 0.36, 1), box-shadow 360ms ease';
        panel.style.boxShadow = '0 20px 40px rgba(0,0,0,0.35)';
        requestAnimationFrame(() => {
            panel.style.opacity = '1';
            panel.style.transform = 'scale(1) translateY(0)';
        });
    }
    
    // Show loading state
    const content = document.getElementById('modalContent');
    const statsElement = document.getElementById('modalStats');
    statsElement.innerHTML = '';
    content.innerHTML = '<div class="modal-loading"></div>';
    
    // Load journals for this date
    fetch(`/journals/by-date/${date}`)
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('modalContent');
            const statsElement = document.getElementById('modalStats');
            
            if (data.journals && data.journals.length > 0) {
                // Update stats
                const importantCount = data.journals.filter(j => j.important).length;
                const totalWords = data.journals.reduce((sum, j) => sum + (j.content ? j.content.length : 0), 0);
                statsElement.innerHTML = `
                    <span class="flex items-center text-xs sm:text-sm"><i class="fas fa-book-open mr-1"></i>${data.journals.length} journal${data.journals.length > 1 ? 's' : ''}</span>
                    ${importantCount > 0 ? `<span class="flex items-center text-xs sm:text-sm"><i class="fas fa-star mr-1 text-yellow-400"></i>${importantCount} important</span>` : ''}
                    <span class="flex items-center text-xs sm:text-sm"><i class="fas fa-keyboard mr-1"></i>${totalWords} chars</span>
                `;
                
                content.innerHTML = data.journals.map(journal => `
                    <div class="bg-gray-700 rounded-lg p-3 sm:p-4 lg:p-6 mb-3 sm:mb-4 lg:mb-6 hover:bg-gray-650 transition-colors duration-200 journal-card">
                        <!-- Header -->
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-3 sm:mb-4 gap-3">
                            <div class="flex items-start space-x-2 sm:space-x-3 flex-1 min-w-0">
                                <span class="text-xl sm:text-2xl lg:text-3xl flex-shrink-0">${journal.mood_emoji || '📝'}</span>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <h3 class="text-base sm:text-lg lg:text-xl font-bold text-white truncate">${journal.title || 'Untitled Journal'}</h3>
                                        ${journal.important ? '<i class="fas fa-star text-yellow-400 flex-shrink-0"></i>' : ''}
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 sm:gap-2 text-xs sm:text-sm text-gray-400 mb-2">
                                        <span class="flex items-center"><i class="fas fa-clock mr-1"></i>${journal.created_at}</span>
                                        ${journal.category ? `<span class="bg-gray-600 text-gray-200 px-1.5 sm:px-2 py-0.5 rounded-full text-xs">${journal.category}</span>` : ''}
                                        <span class="bg-gray-600 text-gray-200 px-1.5 sm:px-2 py-0.5 rounded-full text-xs">${journal.content ? journal.content.length : 0} chars</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end space-x-2 flex-shrink-0">
                                <a href="/journals/${journal.id}" 
                                   class="bg-pink-600 hover:bg-pink-700 text-white text-xs sm:text-sm font-semibold px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg transition-colors duration-200 flex items-center"
                                   onclick="showLoading('Loading journal...', 'Please wait a moment')">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    <span>View</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="bg-gray-750 rounded-lg p-2 sm:p-3 lg:p-4 mb-3 sm:mb-4">
                            <div class="text-gray-300 text-xs sm:text-sm lg:text-base leading-relaxed prose prose-invert max-w-none">
                                ${journal.content ? journal.content.replace(/</g, '&lt;').replace(/>/g, '&gt;') : ''}
                            </div>
                        </div>
                        
                        <!-- Tags -->
                        ${journal.tags ? `
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="text-xs text-gray-400 font-semibold">Tags:</span>
                                ${journal.tags.split(',').map(tag => 
                                    `<span class="bg-pink-600 text-white text-xs px-2 py-1 rounded-full">${tag.trim()}</span>`
                                ).join('')}
                            </div>
                        ` : ''}
                        
                        <!-- Footer -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-3 border-t border-gray-600 gap-2">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs text-gray-400">
                                <span class="flex items-center"><i class="fas fa-smile mr-1"></i>${journal.mood || 'No mood'}</span>
                                ${journal.important ? '<span class="text-yellow-400 flex items-center"><i class="fas fa-star mr-1"></i>Important</span>' : ''}
                            </div>
                            <div class="flex items-center justify-end space-x-2">
                                <button onclick="createJournalWithPrompt('Continue from: ${journal.title || 'previous journal'}')" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-2 sm:px-3 py-1.5 rounded transition-colors duration-200 flex items-center">
                                    <i class="fas fa-plus mr-1"></i>
                                    <span>Continue</span>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                statsElement.innerHTML = '';
                content.innerHTML = `
                    <div class="text-center py-6 sm:py-8 lg:py-12">
                        <i class="fas fa-calendar-day text-3xl sm:text-4xl lg:text-5xl text-gray-500 mb-3 sm:mb-4 lg:mb-6"></i>
                        <p class="text-gray-400 text-sm sm:text-base lg:text-lg mb-4">No journals for this date</p>
                        <button onclick="createJournalWithPrompt('Write about ${formattedDate}')" 
                                class="bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                            <i class="fas fa-plus mr-1 sm:mr-2"></i>Start Writing
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading journals:', error);
            document.getElementById('modalStats').innerHTML = '';
            document.getElementById('modalContent').innerHTML = `
                <div class="text-center py-6 sm:py-8 lg:py-12">
                    <i class="fas fa-exclamation-triangle text-3xl sm:text-4xl lg:text-5xl text-red-500 mb-3 sm:mb-4 lg:mb-6"></i>
                    <p class="text-red-400 text-sm sm:text-base lg:text-lg mb-4">Error loading journals</p>
                    <button onclick="closeDayModal()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                        <i class="fas fa-times mr-1 sm:mr-2"></i>Close
                    </button>
                </div>
            `;
        });
}

function closeDayModal() {
    const backdrop = document.getElementById('dayJournalsModal');
    const panel = document.getElementById('journalModalPanel');
    if (panel) {
        panel.style.opacity = '0';
        panel.style.transform = 'scale(0.96) translateY(12px)';
    }
    if (backdrop) {
        backdrop.style.opacity = '0';
    }
    setTimeout(() => {
        if (backdrop) {
            backdrop.classList.add('hidden');
            backdrop.style.display = '';
            backdrop.style.opacity = '';
            backdrop.style.transition = '';
        }
        // Restore body scroll when modal is closed
        document.body.style.overflow = '';
        document.body.classList.remove('modal-open');
    }, 300);
}

function createJournalWithPrompt(prompt) {
    // Store prompt in localStorage and redirect to create page
    localStorage.setItem('journalPrompt', prompt);
    window.location.href = '{{ route("journals.create") }}';
}

function showTodayPrompt() {
    const prompts = [
        'What made you smile today?',
        'What challenge did you overcome?',
        'What are you grateful for right now?',
        'What would you like to improve tomorrow?',
        'How are you feeling about your goals?',
        'What did you learn today?',
        'Who made a positive impact on your day?',
        'What are you looking forward to?',
        'What\'s something you\'re proud of?',
        'How can you be kinder to yourself today?',
        'What\'s a small win you had today?',
        'What would you tell your future self?'
    ];
    
    const randomPrompt = prompts[Math.floor(Math.random() * prompts.length)];
    createJournalWithPrompt(randomPrompt);
}

function goToToday() {
    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth() + 1;
    window.location.href = `{{ route('journals.calendar') }}?year=${year}&month=${month}`;
}

function showDatePicker() {
    const date = prompt('Enter date (YYYY-MM-DD):', new Date().toISOString().split('T')[0]);
    if (date) {
        const [year, month] = date.split('-');
        window.location.href = `{{ route('journals.calendar') }}?year=${year}&month=${month}`;
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const dayModal = document.getElementById('dayJournalsModal');
    
    if (event.target === dayModal) {
        closeDayModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDayModal();
    }
});

// Prevent scroll on body when modal is open
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('dayJournalsModal');
    
    // Prevent scroll on modal background
    modal.addEventListener('wheel', function(event) {
        if (event.target === modal) {
            event.preventDefault();
        }
    }, { passive: false });
    
    // Prevent scroll on modal background with touch
    modal.addEventListener('touchmove', function(event) {
        if (event.target === modal) {
            event.preventDefault();
        }
    }, { passive: false });
});
</script>
@endsection

<style>
/* Prevent body scroll when modal is open */
body.modal-open {
    overflow: hidden !important;
    position: fixed;
    width: 100%;
}

/* Modal scroll improvements */
#dayJournalsModal {
    overscroll-behavior: contain;
}

#dayJournalsModal .overflow-y-auto {
    overscroll-behavior: contain;
    scrollbar-width: thin;
    scrollbar-color: #4B5563 #1F2937;
}

#dayJournalsModal .overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

#dayJournalsModal .overflow-y-auto::-webkit-scrollbar-track {
    background: #1F2937;
    border-radius: 2px;
}

#dayJournalsModal .overflow-y-auto::-webkit-scrollbar-thumb {
    background: #4B5563;
    border-radius: 2px;
}

#dayJournalsModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #6B7280;
}

/* Modal header improvements */
#modalStats {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
}

#modalStats span {
    display: flex;
    align-items: center;
    white-space: nowrap;
}

/* Mobile-specific modal improvements */
@media (max-width: 640px) {
    #dayJournalsModal {
        padding: 0.5rem;
    }
    
    #dayJournalsModal .overflow-y-auto::-webkit-scrollbar {
        width: 2px;
    }
    
    #dayJournalsModal .journal-card {
        margin-bottom: 1rem;
    }
    
    #dayJournalsModal .journal-card:last-child {
        margin-bottom: 0;
    }
    
    #dayJournalsModal .journal-card .bg-gray-750 {
        max-height: 100px;
        overflow-y: auto;
    }
    
    #dayJournalsModal button,
    #dayJournalsModal a {
        min-height: 36px;
        min-width: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }
    
    #dayJournalsModal .text-xs {
        font-size: 0.75rem;
        line-height: 1rem;
    }
    
    #dayJournalsModal button span,
    #dayJournalsModal a span {
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }
    
    #dayJournalsModal .gap-1 {
        gap: 0.25rem;
    }
    
    #dayJournalsModal .gap-2 {
        gap: 0.5rem;
    }
    
    #dayJournalsModal .space-x-2 > * + * {
        margin-left: 0.5rem;
    }
    
    #dayJournalsModal .p-3 {
        padding: 0.75rem;
    }
    
    #dayJournalsModal .mb-3 {
        margin-bottom: 0.75rem;
    }
    
    /* Button improvements for mobile */
    #dayJournalsModal .bg-pink-600,
    #dayJournalsModal .bg-blue-600 {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
        min-width: 70px;
        justify-content: center;
        text-align: center;
    }
    
    #dayJournalsModal .bg-pink-600 i,
    #dayJournalsModal .bg-blue-600 i {
        margin-right: 0.25rem;
        flex-shrink: 0;
        font-size: 0.75rem;
    }
    
    #dayJournalsModal .bg-pink-600 span,
    #dayJournalsModal .bg-blue-600 span {
        flex-shrink: 0;
        white-space: nowrap;
    }
}

/* Tablet improvements */
@media (min-width: 641px) and (max-width: 1024px) {
    #dayJournalsModal .journal-card .bg-gray-750 {
        max-height: 150px;
        overflow-y: auto;
    }
    
    #dayJournalsModal .bg-pink-600,
    #dayJournalsModal .bg-blue-600 {
        min-width: 80px;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    #dayJournalsModal button span,
    #dayJournalsModal a span {
        font-size: 0.875rem;
    }
}

/* Button improvements for all screen sizes */
@media (min-width: 1025px) {
    #dayJournalsModal .bg-pink-600,
    #dayJournalsModal .bg-blue-600 {
        min-width: 90px;
        padding-left: 1.25rem !important;
        padding-right: 1.25rem !important;
    }
    
    #dayJournalsModal button span,
    #dayJournalsModal a span {
        font-size: 0.875rem;
    }
}
/* Button improvements for all screen sizes */
#dayJournalsModal .bg-pink-600,
#dayJournalsModal .bg-blue-600 {
    transition: all 0.2s ease-in-out;
}

#dayJournalsModal .bg-pink-600:hover,
#dayJournalsModal .bg-blue-600:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

@media (hover: none) {
    #dayJournalsModal .bg-pink-600:hover,
    #dayJournalsModal .bg-blue-600:hover {
        transform: none;
        box-shadow: none;
    }
}

/* Journal card hover effects */
.journal-card {
    transition: all 0.2s ease-in-out;
    border: 1px solid transparent;
}

.journal-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    border-color: #4B5563;
}

@media (hover: none) {
    .journal-card:hover {
        transform: none;
        box-shadow: none;
        border-color: transparent;
    }
}

/* Calendar day hover effects */
.calendar-day:hover .journal-indicator {
    transform: scale(1.05);
}

@media (hover: none) {
    .calendar-day:hover .journal-indicator {
        transform: none;
    }
}

/* Loading animation for modal */
.modal-loading {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 150px;
    padding: 2rem;
}

.modal-loading::after {
    content: '';
    width: 24px;
    height: 24px;
    border: 2px solid #4B5563;
    border-top: 2px solid #EC4899;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@media (min-width: 640px) {
    .modal-loading {
        min-height: 200px;
    }
    
    .modal-loading::after {
        width: 32px;
        height: 32px;
        border-width: 3px;
    }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Rich text content styling for modal */
#dayJournalsModal .prose {
    color: #D1D5DB;
}

#dayJournalsModal .prose h1, 
#dayJournalsModal .prose h2, 
#dayJournalsModal .prose h3, 
#dayJournalsModal .prose h4, 
#dayJournalsModal .prose h5, 
#dayJournalsModal .prose h6 {
    color: #F9FAFB;
    margin-top: 0.75rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

#dayJournalsModal .prose h1 { font-size: 1.25rem; }
#dayJournalsModal .prose h2 { font-size: 1.125rem; }
#dayJournalsModal .prose h3 { font-size: 1rem; }
#dayJournalsModal .prose h4 { font-size: 0.875rem; }
#dayJournalsModal .prose h5 { font-size: 0.75rem; }
#dayJournalsModal .prose h6 { font-size: 0.625rem; }

#dayJournalsModal .prose p {
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

#dayJournalsModal .prose ul, 
#dayJournalsModal .prose ol {
    margin-bottom: 0.5rem;
    padding-left: 1rem;
}

#dayJournalsModal .prose li {
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

#dayJournalsModal .prose blockquote {
    border-left: 3px solid #EC4899;
    padding-left: 0.5rem;
    margin: 0.5rem 0;
    font-style: italic;
    color: #9CA3AF;
    background-color: rgba(236, 72, 153, 0.1);
    padding: 0.5rem;
    border-radius: 0.25rem;
}

#dayJournalsModal .prose code {
    background-color: #1F2937;
    padding: 0.125rem 0.25rem;
    border-radius: 0.125rem;
    font-family: 'Courier New', monospace;
    color: #F3F4F6;
    font-size: 0.75em;
}

#dayJournalsModal .prose strong {
    color: #F9FAFB;
    font-weight: 600;
}

#dayJournalsModal .prose em {
    color: #D1D5DB;
    font-style: italic;
}

#dayJournalsModal .prose u {
    text-decoration: underline;
    color: #F9FAFB;
}

#dayJournalsModal .prose s {
    text-decoration: line-through;
    color: #9CA3AF;
}

#dayJournalsModal .prose a {
    color: #EC4899;
    text-decoration: underline;
}

#dayJournalsModal .prose a:hover {
    color: #F472B6;
}
</style> 