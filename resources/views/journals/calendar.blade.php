@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Journal Calendar</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('journals.create') }}" 
               class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-colors duration-200"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <i class="fas fa-plus mr-2"></i> New Journal
            </a>
            <a href="{{ route('journals.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-colors duration-200"
               onclick="showLoading('Loading page...', 'Please wait a moment')">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

         <!-- Quick Stats -->
         <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8 mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white">
                <div class="flex items-center">
                    <i class="fas fa-calendar-check text-4xl mr-6"></i>
                    <div>
                        <h3 class="text-2xl font-bold mb-3">Journals This Month</h3>
                        <p class="text-blue-100 text-lg">{{ $journals->count() }} entries</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-8 text-white">
                <div class="flex items-center">
                    <i class="fas fa-star text-4xl mr-6"></i>
                    <div>
                        <h3 class="text-2xl font-bold mb-3">Important Journals</h3>
                        <p class="text-green-100 text-lg">{{ $journals->where('important', true)->count() }} entries</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-8 text-white">
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-4xl mr-6"></i>
                    <div>
                        <h3 class="text-2xl font-bold mb-3">Average per Week</h3>
                        <p class="text-purple-100 text-lg">{{ round($journals->count() / 4, 1) }} journals</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Month Navigation -->
        <div class="bg-gray-800 rounded-2xl p-6 mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <a href="{{ route('journals.calendar', ['year' => $month == 1 ? $year - 1 : $year, 'month' => $month == 1 ? 12 : $month - 1]) }}" 
                   class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200"
                   onclick="showLoading('Loading calendar...', 'Please wait a moment')">
                    <i class="fas fa-chevron-left mr-2"></i> Previous Month
                </a>
                
                <h2 class="text-3xl font-bold text-white">
                    {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
                </h2>
                
                <a href="{{ route('journals.calendar', ['year' => $month == 12 ? $year + 1 : $year, 'month' => $month == 12 ? 1 : $month + 1]) }}" 
                   class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200"
                   onclick="showLoading('Loading calendar...', 'Please wait a moment')">
                    Next Month <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <!-- Calendar Header -->
            <div class="grid grid-cols-7 bg-gray-750 border-b border-gray-700">
                @php
                    $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                @endphp
                @foreach($daysOfWeek as $day)
                    <div class="p-6 text-center">
                        <span class="text-lg font-semibold text-gray-300">{{ $day }}</span>
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
                        $dateKey = $currentDate->format('Y-m-d');
                        $journal = $journals->get($dateKey);
                    @endphp
                    
                    <div class="min-h-[160px] p-4 border border-gray-700 {{ $isCurrentMonth ? 'bg-gray-800' : 'bg-gray-900' }}">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-lg font-semibold {{ $isCurrentMonth ? 'text-white' : 'text-gray-500' }} {{ $isToday ? 'bg-pink-500 text-white rounded-full w-8 h-8 flex items-center justify-center' : '' }}">
                                {{ $currentDate->day }}
                            </span>
                            @if($journal && $journal->mood_emoji)
                                <span class="text-2xl">{{ $journal->mood_emoji }}</span>
                            @endif
                        </div>
                        
                        @if($journal)
                            <div class="space-y-2">
                                @if($journal->title)
                                    <div class="text-sm text-gray-300 truncate font-medium" title="{{ $journal->title }}">
                                        {{ $journal->title }}
                                    </div>
                                @endif
                                
                                <div class="flex items-center space-x-2">
                                    @if($journal->mood_badge_class)
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $journal->mood_badge_class }}">
                                            {{ ucfirst($journal->mood) }}
                                        </span>
                                    @endif
                                    @if($journal->important)
                                        <span class="text-yellow-400 text-sm">⭐</span>
                                    @endif
                                </div>
                                
                                <div class="text-sm text-gray-400 truncate leading-relaxed">
                                    {{ $journal->calendar_content_preview }}
                                </div>
                                
                                <a href="{{ route('journals.show', $journal->id) }}" 
                                   class="block text-sm text-pink-400 hover:text-pink-300 transition-colors duration-200 font-medium"
                                   onclick="showLoading('Loading details...', 'Please wait a moment')">
                                    View Details →
                                </a>
                            </div>
                        @else
                            @if($isCurrentMonth && $currentDate->isPast())
                                <div class="text-sm text-gray-500 mt-3">
                                    No journal yet
                                </div>
                            @endif
                        @endif
                    </div>
                    
                    @php
                        $currentDate->addDay();
                    @endphp
                @endwhile
            </div>
        </div>

        <!-- Monthly Insights & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Monthly Statistics -->
            <div class="bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-xl font-bold text-white mb-6">
                    <i class="fas fa-chart-bar mr-3 text-pink-400"></i>Monthly Overview
                </h3>
                
                <div class="space-y-6">

                 <!-- Motivation Quote -->
                 <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-xl p-6 text-white">
                        <div class="text-center">
                            <i class="fas fa-quote-left text-3xl text-indigo-200 mb-3"></i>
                            <p class="text-lg font-medium mb-2">
                                @php
                                    $quotes = [
                                        "The only way to do great work is to love what you do. - Steve Jobs",
                                        "Your time is limited, don't waste it living someone else's life. - Steve Jobs",
                                        "Success is not final, failure is not fatal: it is the courage to continue that counts. - Winston Churchill",
                                        "The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt",
                                        "The only limit to our realization of tomorrow is our doubts of today. - Franklin D. Roosevelt",
                                        "It always seems impossible until it's done. - Nelson Mandela",
                                        "The way to get started is to quit talking and begin doing. - Walt Disney",
                                        "Don't watch the clock; do what it does. Keep going. - Sam Levenson"
                                    ];
                                    $quoteIndex = (now()->day - 1) % count($quotes);
                                @endphp
                                "{{ $quotes[$quoteIndex] }}"
                            </p>
                        </div>
                    </div>
                    <!-- Journal Count -->
                    <div class="flex items-center justify-between p-4 bg-gray-750 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-book-open text-white text-lg"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-400">Total Journals</div>
                                <div class="text-2xl font-bold text-white">{{ $journals->count() }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-400">This Month</div>
                            <div class="text-lg font-semibold text-blue-400">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('M Y') }}</div>
                        </div>
                    </div>

                    <!-- Most Common Mood -->
                    @php
                        $moodCounts = $journals->groupBy('mood')->map->count();
                        $mostCommonMood = $moodCounts->sortDesc()->first();
                        $mostCommonMoodName = $moodCounts->sortDesc()->keys()->first();
                    @endphp
                    @if($mostCommonMood)
                    <div class="flex items-center justify-between p-4 bg-gray-750 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-pink-500 rounded-full flex items-center justify-center">
                                <span class="text-2xl">
                                    @php
                                        $emoji = match($mostCommonMoodName) {
                                            'happy' => '😊',
                                            'sad' => '😢',
                                            'anxious' => '😰',
                                            'calm' => '😌',
                                            'angry' => '😠',
                                            'confused' => '😕',
                                            'excited' => '💪',
                                            'tired' => '😴',
                                            'satisfied' => '😌',
                                            'frustrated' => '😤',
                                            default => '😐',
                                        };
                                    @endphp
                                    {{ $emoji }}
                                </span>
                            </div>
                            <div>
                                <div class="text-sm text-gray-400">Most Common Mood</div>
                                <div class="text-lg font-semibold text-white">{{ ucfirst($mostCommonMoodName) }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-400">Count</div>
                            <div class="text-lg font-semibold text-pink-400">{{ $mostCommonMood }}</div>
                        </div>
                    </div>
                    @endif

                    <!-- Important Journals -->
                    @php
                        $importantCount = $journals->where('important', true)->count();
                    @endphp
                    <div class="flex items-center justify-between p-4 bg-gray-750 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-white text-lg"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-400">Important Journals</div>
                                <div class="text-lg font-semibold text-white">{{ $importantCount }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-400">Marked</div>
                            <div class="text-lg font-semibold text-yellow-400">{{ $journals->count() > 0 ? round(($importantCount / $journals->count()) * 100, 1) : 0 }}%</div>
                        </div>
                    </div>

                    <!-- Journaling Streak -->
                    @php
                        $currentStreak = 0;
                        $currentDate = now()->startOfDay();
                        while (true) {
                            $journal = $journals->first(function($j) use ($currentDate) {
                                return $j->date->format('Y-m-d') === $currentDate->format('Y-m-d');
                            });
                            if (!$journal) break;
                            $currentStreak++;
                            $currentDate->subDay();
                        }
                    @endphp
                    <div class="flex items-center justify-between p-4 bg-gray-750 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-fire text-white text-lg"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-400">Current Streak</div>
                                <div class="text-lg font-semibold text-white">{{ $currentStreak }} days</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-400">Keep going!</div>
                            <div class="text-lg font-semibold text-green-400">
                                @if($currentStreak > 0)
                                    🔥
                                @else
                                    Start today!
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Journaling Tips & Quick Actions -->
            <div class="bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-xl font-bold text-white mb-6">
                    <i class="fas fa-lightbulb mr-3 text-pink-400"></i>Tips & Quick Actions
                </h3>
                
                <div class="space-y-6">
                    <!-- Today's Tip -->
                    <div class="bg-gradient-to-r from-pink-600 to-pink-700 rounded-xl p-6 text-white">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-quote-left text-2xl text-pink-200 mt-1"></i>
                            <div>
                                <h4 class="text-lg font-semibold mb-2">Today's Journaling Tip</h4>
                                <p class="text-pink-100 leading-relaxed">
                                    @php
                                        $tips = [
                                            "Reflect on one thing you're grateful for today. Gratitude journaling can boost your mood and overall well-being.",
                                            "Write about a challenge you faced and how you handled it. This helps build resilience and problem-solving skills.",
                                            "Describe your biggest achievement today, no matter how small. Celebrating wins keeps you motivated.",
                                            "Write about someone who made a positive impact on your day. Acknowledging others strengthens relationships.",
                                            "Reflect on what you learned today, whether it's a new skill or a life lesson. Growth comes from learning.",
                                            "Write about your goals for tomorrow. Planning ahead helps you stay focused and productive.",
                                            "Describe a moment that made you smile today. Focusing on positive moments improves your mood.",
                                            "Reflect on how you've grown this month. Personal development is worth celebrating."
                                        ];
                                        $tipIndex = (now()->day - 1) % count($tips);
                                    @endphp
                                    {{ $tips[$tipIndex] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="space-y-3">
                        <h4 class="text-lg font-semibold text-white mb-4">Quick Actions</h4>
                        
                        <a href="{{ route('journals.create') }}" 
                           class="flex items-center justify-between p-4 bg-gray-750 rounded-xl hover:bg-gray-700 transition-colors duration-200 group"
                           onclick="showLoading('Loading page...', 'Please wait a moment')">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Write Today's Journal</div>
                                    <div class="text-sm text-gray-400">Capture your thoughts and feelings</div>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-white transition-colors duration-200"></i>
                        </a>

                        <a href="{{ route('journals.insights') }}" 
                           class="flex items-center justify-between p-4 bg-gray-750 rounded-xl hover:bg-gray-700 transition-colors duration-200 group"
                           onclick="showLoading('Loading insights...', 'Please wait a moment')">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">View Insights</div>
                                    <div class="text-sm text-gray-400">Analyze your journaling patterns</div>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-white transition-colors duration-200"></i>
                        </a>

                        @if($journals->count() > 0)
                        <a href="{{ route('journals.index') }}" 
                           class="flex items-center justify-between p-4 bg-gray-750 rounded-xl hover:bg-gray-700 transition-colors duration-200 group"
                           onclick="showLoading('Loading journals...', 'Please wait a moment')">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-list text-white"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">View All Journals</div>
                                    <div class="text-sm text-gray-400">Browse your journal collection</div>
                                </div>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-white transition-colors duration-200"></i>
                        </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection 