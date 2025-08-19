@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 gap-4 sm:gap-0">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Journal Insights</h1>
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

        @if($totalJournals == 0)
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden border border-gray-600/70">
                <div class="text-center p-6 sm:p-8 lg:p-12 bg-gradient-to-br from-gray-800/30 to-gray-900/40 backdrop-blur-sm">
                    <div class="w-24 h-24 sm:w-32 sm:h-32 lg:w-40 lg:h-40 bg-gradient-to-br from-pink-500/20 to-pink-700/20 rounded-full flex items-center justify-center mx-auto mb-6 sm:mb-8 border border-pink-500/30">
                        <i class="fas fa-chart-bar text-3xl sm:text-4xl lg:text-5xl text-pink-400"></i>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-pink-400 to-pink-600 bg-clip-text text-transparent mb-2">No Data Available</h2>
                    <p class="text-gray-300 mb-6 sm:mb-8 max-w-md mx-auto text-sm sm:text-base">Start writing journals to see insights and patterns about your self-improvement journey.</p>
                    <a href="{{ route('journals.create') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2 text-sm sm:text-base" onclick="showLoading('Loading page...', 'Please wait a moment')">
                        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Write First Journal</span><span class="sm:hidden">Write Journal</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8 mb-8 sm:mb-10">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-book-open text-2xl sm:text-3xl md:text-4xl mr-3 sm:mr-4 md:mr-6"></i>
                        <div>
                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-3">Total Journals</h3>
                            <p class="text-blue-100 text-sm sm:text-base md:text-lg">{{ $totalJournals }} entries</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-star text-2xl sm:text-3xl md:text-4xl mr-3 sm:mr-4 md:mr-6"></i>
                        <div>
                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-3">Important Journals</h3>
                            <p class="text-green-100 text-sm sm:text-base md:text-lg">{{ $importantCount }} entries</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-fire text-2xl sm:text-3xl md:text-4xl mr-3 sm:mr-4 md:mr-6"></i>
                        <div>
                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-3">Current Streak</h3>
                            <p class="text-purple-100 text-sm sm:text-base md:text-lg">{{ $streak }} days</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl p-4 sm:p-6 md:p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-2xl sm:text-3xl md:text-4xl mr-3 sm:mr-4 md:mr-6"></i>
                        <div>
                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold mb-2 sm:mb-3">Average per Month</h3>
                            <p class="text-orange-100 text-sm sm:text-base md:text-lg">{{ round($totalJournals / max(1, ceil($totalJournals / 30)), 1) }} journals</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Patterns -->
            <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur-xl rounded-2xl p-6 sm:p-8 shadow-2xl border border-gray-700/50 mt-8 sm:mt-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white">
                        <i class="fas fa-calendar-alt text-teal-400 mr-3"></i>Weekly Activity
                    </h3>
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white text-lg"></i>
                    </div>
                </div>
                
                @if($mostActiveDay)
                    <div class="bg-gradient-to-r from-teal-500/20 to-teal-600/20 backdrop-blur-sm rounded-xl p-4 sm:p-6 mb-6 border border-teal-500/30">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-day text-white text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-lg">
                                        @php
                                            // Detect database type and map days accordingly
                                            try {
                                                $connection = \DB::connection()->getDriverName();
                                                if ($connection === 'pgsql') {
                                                    $dayNames = [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
                                                } else {
                                                    $dayNames = [1 => 'Sunday', 2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday', 5 => 'Thursday', 6 => 'Friday', 7 => 'Saturday'];
                                                }
                                            } catch (\Exception $e) {
                                                $dayNames = [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
                                            }
                                            $dayName = $dayNames[$mostActiveDay->day_of_week] ?? 'Unknown';
                                        @endphp
                                        {{ $dayName }}
                                    </h4>
                                    <p class="text-teal-200 text-sm">Most active day</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-teal-400">{{ round(($mostActiveDay->count / $totalJournals) * 100, 1) }}%</div>
                                <div class="text-teal-200 text-sm">{{ $mostActiveDay->count }} entries</div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Mobile: Horizontal scroll, Desktop: Grid -->
                <div class="block sm:hidden">
                    <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
                        @php
                            // Define day data arrays
                            $dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                            $dayIcons = ['fas fa-sun', 'fas fa-moon', 'fas fa-star', 'fas fa-heart', 'fas fa-thumbs-up', 'fas fa-fire', 'fas fa-crown'];
                            $dayColors = ['from-yellow-500 to-orange-500', 'from-blue-500 to-indigo-500', 'from-purple-500 to-pink-500', 'from-green-500 to-emerald-500', 'from-red-500 to-pink-500', 'from-indigo-500 to-purple-500', 'from-yellow-400 to-yellow-600'];
                            
                            // Detect database type for day numbering
                            try {
                                $connection = \DB::connection()->getDriverName();
                                $isPostgreSQL = $connection === 'pgsql';
                            } catch (\Exception $e) {
                                $isPostgreSQL = true;
                            }
                        @endphp
                        @for($i = 0; $i < 7; $i++)
                            @php
                                $count = 0;
                                $dayNumber = $isPostgreSQL ? $i : $i + 1;
                                if ($mostActiveDay && $mostActiveDay->day_of_week == $dayNumber) {
                                    $count = $mostActiveDay->count;
                                }
                                $percentage = $totalJournals > 0 ? round(($count / $totalJournals) * 100, 1) : 0;
                                $isMostActive = $mostActiveDay && $mostActiveDay->day_of_week == $dayNumber;
                            @endphp
                            <div class="bg-gray-700/50 backdrop-blur-sm rounded-lg p-3 text-center border {{ $isMostActive ? 'border-teal-500/50 bg-teal-500/10' : 'border-gray-600/30' }} transition-all duration-300 hover:scale-105 flex-shrink-0 min-w-[80px]">
                                <div class="w-8 h-8 bg-gradient-to-r {{ $dayColors[$i] }} rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="{{ $dayIcons[$i] }} text-white text-sm"></i>
                                </div>
                                <div class="text-xs font-semibold text-white mb-1">{{ $dayNames[$i] }}</div>
                                <div class="text-lg font-bold {{ $isMostActive ? 'text-teal-400' : 'text-gray-300' }} mb-1">{{ $count }}</div>
                                <div class="text-xs text-gray-400">{{ $percentage }}%</div>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <!-- Desktop: Grid layout -->
                <div class="hidden sm:grid sm:grid-cols-7 gap-2 md:gap-3">

                    @for($i = 0; $i < 7; $i++)
                        @php
                            $count = 0;
                            $dayNumber = $isPostgreSQL ? $i : $i + 1;
                            if ($mostActiveDay && $mostActiveDay->day_of_week == $dayNumber) {
                                $count = $mostActiveDay->count;
                            }
                            $percentage = $totalJournals > 0 ? round(($count / $totalJournals) * 100, 1) : 0;
                            $isMostActive = $mostActiveDay && $mostActiveDay->day_of_week == $dayNumber;
                        @endphp
                        <div class="bg-gray-700/50 backdrop-blur-sm rounded-lg p-2 sm:p-3 md:p-4 text-center border {{ $isMostActive ? 'border-teal-500/50 bg-teal-500/10' : 'border-gray-600/30' }} transition-all duration-300 hover:scale-105">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-r {{ $dayColors[$i] }} rounded-lg flex items-center justify-center mx-auto mb-1 sm:mb-2">
                                <i class="{{ $dayIcons[$i] }} text-white text-xs sm:text-sm"></i>
                            </div>
                            <div class="text-xs font-semibold text-white mb-1">{{ $dayNames[$i] }}</div>
                            <div class="text-sm sm:text-lg font-bold {{ $isMostActive ? 'text-teal-400' : 'text-gray-300' }} mb-1">{{ $count }}</div>
                            <div class="text-xs text-gray-400">{{ $percentage }}%</div>
                        </div>
                    @endfor
                </div>
                </div>
            

            <!-- Mood & Category Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mt-8 sm:mt-10">
                    <!-- Mood Analysis -->
                    <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur-xl rounded-2xl p-6 sm:p-8 shadow-2xl border border-gray-700/50">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl sm:text-2xl font-bold text-white">
                                <i class="fas fa-smile text-pink-400 mr-3"></i>Mood Trends
                            </h3>
                            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                        </div>
                        
                        @if($mostCommonMood)
                            <div class="bg-gradient-to-r from-pink-500/20 to-pink-600/20 backdrop-blur-sm rounded-xl p-4 sm:p-6 mb-6 border border-pink-500/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center">
                                            <span class="text-2xl">
                                                @php
                                                    $emoji = match($mostCommonMood->mood) {
                                                        'happy' => '😊', 'sad' => '😢', 'anxious' => '😰', 'calm' => '😌',
                                                        'angry' => '😠', 'confused' => '😕', 'excited' => '💪', 'tired' => '😴',
                                                        'satisfied' => '😌', 'frustrated' => '😤', default => '😐',
                                                    };
                                                @endphp
                                                {{ $emoji }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold text-lg">{{ ucfirst($mostCommonMood->mood) }}</h4>
                                            <p class="text-pink-200 text-sm">Most frequent mood</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold text-pink-400">{{ round(($mostCommonMood->count / $totalJournals) * 100, 1) }}%</div>
                                        <div class="text-pink-200 text-sm">{{ $mostCommonMood->count }} times</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @php
                                $allMoods = [
                                    'happy' => ['😊', 'Happy', 'from-green-500 to-green-600'],
                                    'sad' => ['😢', 'Sad', 'from-blue-500 to-blue-600'],
                                    'anxious' => ['😰', 'Anxious', 'from-yellow-500 to-yellow-600'],
                                    'calm' => ['😌', 'Calm', 'from-indigo-500 to-indigo-600'],
                                    'angry' => ['😠', 'Angry', 'from-red-500 to-red-600'],
                                    'confused' => ['😕', 'Confused', 'from-gray-500 to-gray-600'],
                                    'excited' => ['💪', 'Excited', 'from-orange-500 to-orange-600'],
                                    'tired' => ['😴', 'Tired', 'from-purple-500 to-purple-600'],
                                    'satisfied' => ['😌', 'Satisfied', 'from-teal-500 to-teal-600'],
                                    'frustrated' => ['😤', 'Frustrated', 'from-pink-500 to-pink-600'],
                                ];
                            @endphp

                            @foreach($allMoods as $moodKey => $moodInfo)
                                @php
                                    $count = 0;
                                    if ($mostCommonMood && $mostCommonMood->mood == $moodKey) {
                                        $count = $mostCommonMood->count;
                                    }
                                    $percentage = $totalJournals > 0 ? round(($count / $totalJournals) * 100, 1) : 0;
                                @endphp
                                <div class="flex items-center justify-between p-3 bg-gray-700/50 rounded-lg backdrop-blur-sm border border-gray-600/30">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg">{{ $moodInfo[0] }}</span>
                                        <span class="font-medium text-white text-sm">{{ $moodInfo[1] }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-12 bg-gray-600 rounded-full h-2">
                                            <div class="bg-gradient-to-r {{ $moodInfo[2] }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-gray-300 font-semibold text-xs">{{ $percentage }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category Analysis -->
                    <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur-xl rounded-2xl p-6 sm:p-8 shadow-2xl border border-gray-700/50">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl sm:text-2xl font-bold text-white">
                                <i class="fas fa-tags text-indigo-400 mr-3"></i>Category Focus
                            </h3>
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chart-pie text-white text-lg"></i>
                            </div>
                        </div>
                        
                        @if($mostCommonCategory)
                            <div class="bg-gradient-to-r from-indigo-500/20 to-indigo-600/20 backdrop-blur-sm rounded-xl p-4 sm:p-6 mb-6 border border-indigo-500/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-tag text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold text-lg">{{ $mostCommonCategory->category }}</h4>
                                            <p class="text-indigo-200 text-sm">Most written about</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold text-indigo-400">{{ round(($mostCommonCategory->count / $totalJournals) * 100, 1) }}%</div>
                                        <div class="text-indigo-200 text-sm">{{ $mostCommonCategory->count }} entries</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @php
                                $allCategories = [
                                    'Personal' => ['fas fa-user', 'from-purple-500 to-purple-600'],
                                    'Career' => ['fas fa-briefcase', 'from-green-500 to-green-600'],
                                    'Social' => ['fas fa-users', 'from-blue-500 to-blue-600'],
                                    'Health' => ['fas fa-heartbeat', 'from-red-500 to-red-600'],
                                    'Academic' => ['fas fa-graduation-cap', 'from-yellow-500 to-yellow-600'],
                                    'Spiritual' => ['fas fa-heart', 'from-indigo-500 to-indigo-600'],
                                    'Finance' => ['fas fa-dollar-sign', 'from-emerald-500 to-emerald-600'],
                                    'Hobby' => ['fas fa-star', 'from-pink-500 to-pink-600'],
                                ];
                            @endphp

                            @foreach($allCategories as $categoryKey => $categoryInfo)
                                @php
                                    $count = 0;
                                    if ($mostCommonCategory && $mostCommonCategory->category == $categoryKey) {
                                        $count = $mostCommonCategory->count;
                                    }
                                    $percentage = $totalJournals > 0 ? round(($count / $totalJournals) * 100, 1) : 0;
                                @endphp
                                <div class="flex items-center justify-between p-3 bg-gray-700/50 rounded-lg backdrop-blur-sm border border-gray-600/30">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-gradient-to-r {{ $categoryInfo[1] }} rounded-lg flex items-center justify-center">
                                            <i class="{{ $categoryInfo[0] }} text-white text-sm"></i>
                                        </div>
                                        <span class="font-medium text-white text-sm">{{ $categoryKey }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-12 bg-gray-600 rounded-full h-2">
                                            <div class="bg-gradient-to-r {{ $categoryInfo[1] }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-gray-300 font-semibold text-xs">{{ $percentage }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            <!-- Smart Insights -->
            <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur-xl rounded-2xl p-6 sm:p-8 shadow-2xl border border-gray-700/50 mt-8 sm:mt-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-white">
                        <i class="fas fa-lightbulb text-yellow-400 mr-3"></i>Smart Insights
                    </h3>
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-brain text-white text-lg"></i>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @php
                        $insights = [
                            // Streak related insights
                            [
                                'condition' => $streak > 0,
                                'title' => 'Amazing Streak!',
                                'icon' => 'fas fa-fire',
                                'color' => 'green',
                                'content' => "You've been journaling for <span class='font-bold text-green-300'>" . $streak . " consecutive days</span>. This consistency shows great dedication to self-reflection!"
                            ],
                            [
                                'condition' => $streak > 7,
                                'title' => 'Week Warrior!',
                                'icon' => 'fas fa-trophy',
                                'color' => 'amber',
                                'content' => "You've maintained a <span class='font-bold text-amber-300'>week-long streak</span>. This habit is becoming part of your daily routine!"
                            ],
                            [
                                'condition' => $streak > 30,
                                'title' => 'Monthly Master!',
                                'icon' => 'fas fa-crown',
                                'color' => 'purple',
                                'content' => "An incredible <span class='font-bold text-purple-300'>month-long streak</span>! You've built a powerful self-reflection habit."
                            ],
                            [
                                'condition' => $streak > 100,
                                'title' => 'Century Club!',
                                'icon' => 'fas fa-medal',
                                'color' => 'gold',
                                'content' => "Incredible! You've reached <span class='font-bold text-yellow-300'>100+ days</span> of journaling. You're a true inspiration!"
                            ],
                            
                            // Mood related insights
                            [
                                'condition' => $mostCommonMood,
                                'title' => 'Mood Pattern',
                                'icon' => 'fas fa-smile',
                                'color' => 'blue',
                                'content' => "You often feel <span class='font-bold text-blue-300'>" . $mostCommonMood->mood . "</span>. Consider exploring what triggers this mood and strategies to enhance positive emotions."
                            ],
                            [
                                'condition' => $mostCommonMood && $mostCommonMood->mood == 'happy',
                                'title' => 'Positive Vibes',
                                'icon' => 'fas fa-sun',
                                'color' => 'yellow',
                                'content' => "Your journals show a <span class='font-bold text-yellow-300'>positive outlook</span>. Keep nurturing this optimistic mindset!"
                            ],
                            [
                                'condition' => $mostCommonMood && in_array($mostCommonMood->mood, ['sad', 'anxious', 'frustrated']),
                                'title' => 'Emotional Awareness',
                                'icon' => 'fas fa-heart',
                                'color' => 'pink',
                                'content' => "You're experiencing <span class='font-bold text-pink-300'>challenging emotions</span>. Remember, acknowledging these feelings is the first step to growth."
                            ],
                            [
                                'condition' => $mostCommonMood && in_array($mostCommonMood->mood, ['calm', 'satisfied']),
                                'title' => 'Inner Peace',
                                'icon' => 'fas fa-dove',
                                'color' => 'cyan',
                                'content' => "You're cultivating <span class='font-bold text-cyan-300'>inner peace</span>. This balanced state of mind is precious and worth maintaining."
                            ],
                            [
                                'condition' => $mostCommonMood && in_array($mostCommonMood->mood, ['excited', 'confused']),
                                'title' => 'Life Transitions',
                                'icon' => 'fas fa-arrows-alt',
                                'color' => 'orange',
                                'content' => "You're navigating <span class='font-bold text-orange-300'>life transitions</span>. These periods of change often lead to the most growth."
                            ],
                            
                            // Category related insights
                            [
                                'condition' => $mostCommonCategory,
                                'title' => 'Focus Area',
                                'icon' => 'fas fa-tag',
                                'color' => 'purple',
                                'content' => "You write most about <span class='font-bold text-purple-300'>" . $mostCommonCategory->category . "</span>. This suggests it's a significant area in your life worth deeper exploration."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Career',
                                'title' => 'Career Focus',
                                'icon' => 'fas fa-briefcase',
                                'color' => 'indigo',
                                'content' => "Your <span class='font-bold text-indigo-300'>career</span> is a major focus. Consider how this aligns with your personal goals and values."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Health',
                                'title' => 'Wellness Journey',
                                'icon' => 'fas fa-heartbeat',
                                'color' => 'red',
                                'content' => "You're prioritizing <span class='font-bold text-red-300'>health and wellness</span>. This self-care focus will benefit all areas of your life."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Personal',
                                'title' => 'Self-Reflection',
                                'icon' => 'fas fa-user',
                                'color' => 'violet',
                                'content' => "You're deeply exploring your <span class='font-bold text-violet-300'>personal life</span>. This introspection is building self-awareness."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Social',
                                'title' => 'Social Butterfly',
                                'icon' => 'fas fa-users',
                                'color' => 'sky',
                                'content' => "Your <span class='font-bold text-sky-300'>social connections</span> are important to you. Relationships are a key part of your growth."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Academic',
                                'title' => 'Lifelong Learner',
                                'icon' => 'fas fa-graduation-cap',
                                'color' => 'lime',
                                'content' => "You're committed to <span class='font-bold text-lime-300'>learning and education</span>. Knowledge is power in your journey."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Spiritual',
                                'title' => 'Soul Explorer',
                                'icon' => 'fas fa-heart',
                                'color' => 'fuchsia',
                                'content' => "You're exploring your <span class='font-bold text-fuchsia-300'>spiritual side</span>. This deeper connection enriches your life."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Finance',
                                'title' => 'Financial Wisdom',
                                'icon' => 'fas fa-dollar-sign',
                                'color' => 'emerald',
                                'content' => "You're building <span class='font-bold text-emerald-300'>financial awareness</span>. Money management is part of your growth strategy."
                            ],
                            [
                                'condition' => $mostCommonCategory && $mostCommonCategory->category == 'Hobby',
                                'title' => 'Passion Pursuer',
                                'icon' => 'fas fa-gamepad',
                                'color' => 'rose',
                                'content' => "You're nurturing your <span class='font-bold text-rose-300'>hobbies and passions</span>. Joy and creativity fuel your growth."
                            ],
                            
                            // Important journals insights
                            [
                                'condition' => $importantCount > 0,
                                'title' => 'Key Moments',
                                'icon' => 'fas fa-star',
                                'color' => 'yellow',
                                'content' => "You've marked <span class='font-bold text-yellow-300'>" . $importantCount . " journals as important</span>. These entries contain valuable insights about your most meaningful experiences."
                            ],
                            [
                                'condition' => $importantCount > 5,
                                'title' => 'Life Milestones',
                                'icon' => 'fas fa-flag',
                                'color' => 'teal',
                                'content' => "You've documented <span class='font-bold text-teal-300'>" . $importantCount . " significant moments</span>. These are your personal milestones worth celebrating!"
                            ],
                            [
                                'condition' => $importantCount > 10,
                                'title' => 'Memory Keeper',
                                'icon' => 'fas fa-bookmark',
                                'color' => 'amber',
                                'content' => "You're preserving <span class='font-bold text-amber-300'>" . $importantCount . " precious memories</span>. Your journal is a treasure trove of life lessons."
                            ],
                            
                            // Writing patterns insights
                            [
                                'condition' => $totalJournals > 10,
                                'title' => 'Dedicated Writer',
                                'icon' => 'fas fa-pen',
                                'color' => 'emerald',
                                'content' => "You've written <span class='font-bold text-emerald-300'>" . $totalJournals . " journals</span>. Your commitment to self-reflection is inspiring!"
                            ],
                            [
                                'condition' => $totalJournals > 50,
                                'title' => 'Journaling Veteran',
                                'icon' => 'fas fa-book',
                                'color' => 'blue',
                                'content' => "With <span class='font-bold text-blue-300'>" . $totalJournals . " entries</span>, you've built a comprehensive record of your personal growth journey."
                            ],
                            [
                                'condition' => $totalJournals > 100,
                                'title' => 'Storyteller',
                                'icon' => 'fas fa-feather-alt',
                                'color' => 'purple',
                                'content' => "You've crafted <span class='font-bold text-purple-300'>" . $totalJournals . " stories</span> of your life. You're the author of your own narrative."
                            ],
                            
                            // Activity pattern insights
                            [
                                'condition' => $mostActiveDay,
                                'title' => 'Active Day',
                                'icon' => 'fas fa-calendar-day',
                                'color' => 'teal',
                                'content' => "You're most active on <span class='font-bold text-teal-300'>" . ($dayNames[$mostActiveDay->day_of_week] ?? 'Unknown') . "</span>. This might be your optimal time for reflection."
                            ],
                            [
                                'condition' => $mostActiveDay && $mostActiveDay->day_of_week == 1,
                                'title' => 'Monday Motivation',
                                'icon' => 'fas fa-rocket',
                                'color' => 'blue',
                                'content' => "You start your week with <span class='font-bold text-blue-300'>Monday journaling</span>. This sets a positive tone for the entire week!"
                            ],
                            [
                                'condition' => $mostActiveDay && $mostActiveDay->day_of_week == 6,
                                'title' => 'Weekend Warrior',
                                'icon' => 'fas fa-coffee',
                                'color' => 'orange',
                                'content' => "You prefer <span class='font-bold text-orange-300'>weekend reflection</span>. This relaxed time allows for deeper insights."
                            ],
                            
                            // Writing frequency insights
                            [
                                'condition' => $totalJournals > 0 && $totalJournals <= 10,
                                'title' => 'Getting Started',
                                'icon' => 'fas fa-seedling',
                                'color' => 'green',
                                'content' => "You're <span class='font-bold text-green-300'>beginning your journey</span>. Every entry is a step toward self-discovery."
                            ],
                            [
                                'condition' => $totalJournals > 10 && $totalJournals <= 30,
                                'title' => 'Building Momentum',
                                'icon' => 'fas fa-chart-line',
                                'color' => 'blue',
                                'content' => "You're <span class='font-bold text-blue-300'>building momentum</span>. The habit is taking root and growing stronger."
                            ],
                            [
                                'condition' => $totalJournals > 30 && $totalJournals <= 100,
                                'title' => 'Consistent Practice',
                                'icon' => 'fas fa-dumbbell',
                                'color' => 'purple',
                                'content' => "You've developed <span class='font-bold text-purple-300'>consistent practice</span>. This discipline is transforming your life."
                            ],
                            
                            // General motivational insights
                            [
                                'condition' => true,
                                'title' => 'Growth Mindset',
                                'icon' => 'fas fa-seedling',
                                'color' => 'green',
                                'content' => "Every journal entry represents a step toward <span class='font-bold text-green-300'>personal growth</span>. Keep nurturing this beautiful habit!"
                            ],
                            [
                                'condition' => true,
                                'title' => 'Self-Discovery',
                                'icon' => 'fas fa-compass',
                                'color' => 'indigo',
                                'content' => "Your journal is a <span class='font-bold text-indigo-300'>compass</span> guiding you through self-discovery. Trust the process!"
                            ],
                            [
                                'condition' => true,
                                'title' => 'Inner Wisdom',
                                'icon' => 'fas fa-lightbulb',
                                'color' => 'yellow',
                                'content' => "You're tapping into your <span class='font-bold text-yellow-300'>inner wisdom</span>. Each entry reveals more about your authentic self."
                            ],
                            [
                                'condition' => true,
                                'title' => 'Mindful Living',
                                'icon' => 'fas fa-leaf',
                                'color' => 'emerald',
                                'content' => "You're practicing <span class='font-bold text-emerald-300'>mindful living</span>. Awareness is the foundation of positive change."
                            ],
                            [
                                'condition' => true,
                                'title' => 'Emotional Intelligence',
                                'icon' => 'fas fa-brain',
                                'color' => 'pink',
                                'content' => "You're developing <span class='font-bold text-pink-300'>emotional intelligence</span>. Understanding your feelings is a superpower."
                            ],
                            [
                                'condition' => true,
                                'title' => 'Resilience Builder',
                                'icon' => 'fas fa-shield-alt',
                                'color' => 'red',
                                'content' => "You're building <span class='font-bold text-red-300'>resilience</span>. Every challenge documented makes you stronger."
                            ],
                            [
                                'condition' => true,
                                'title' => 'Gratitude Practice',
                                'icon' => 'fas fa-hands',
                                'color' => 'amber',
                                'content' => "You're cultivating <span class='font-bold text-amber-300'>gratitude</span>. Appreciating life's blessings brings more joy."
                            ],
                            [
                                'condition' => true,
                                'title' => 'Future Self',
                                'icon' => 'fas fa-eye',
                                'color' => 'cyan',
                                'content' => "You're investing in your <span class='font-bold text-cyan-300'>future self</span>. Today's reflections become tomorrow's wisdom."
                            ]
                        ];
                        
                        // Filter insights based on conditions and shuffle them
                        $availableInsights = array_filter($insights, function($insight) {
                            return $insight['condition'];
                        });
                        
                        // Shuffle and take first 6 insights (even number)
                        shuffle($availableInsights);
                        $selectedInsights = array_slice($availableInsights, 0, 6);
                    @endphp

                    @foreach($selectedInsights as $insight)
                        <div class="bg-gradient-to-r from-{{ $insight['color'] }}-500/20 to-{{ $insight['color'] }}-600/20 backdrop-blur-sm rounded-xl p-4 sm:p-6 border border-{{ $insight['color'] }}-500/30 hover:scale-105 transition-transform duration-300">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-{{ $insight['color'] }}-500 to-{{ $insight['color'] }}-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="{{ $insight['icon'] }} text-white text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-white font-bold text-lg mb-1">{{ $insight['title'] }}</h4>
                                    <p class="text-{{ $insight['color'] }}-200 text-sm leading-relaxed">{!! $insight['content'] !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Journaling Techniques & Prompts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mt-8 sm:mt-10">
                <!-- Journaling Prompts -->
                <div class="bg-gradient-to-br from-emerald-900/80 to-teal-900/80 rounded-xl p-4 sm:p-6 md:p-8 shadow-lg border border-emerald-500/30">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <i class="fas fa-lightbulb text-2xl sm:text-3xl text-emerald-300 mr-3 sm:mr-4"></i>
                        <h3 class="text-lg sm:text-xl font-bold text-white">Writing Prompts</h3>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        @php
                            $prompts = [
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
                            $randomPrompts = array_rand($prompts, 4);
                        @endphp
                        @foreach($randomPrompts as $index)
                            <div class="bg-emerald-800/50 rounded-lg p-3 sm:p-4 hover:bg-emerald-700/50 transition-colors duration-200 cursor-pointer group"
                                 onclick="createJournalWithPrompt('{{ $prompts[$index] }}')">
                                <div class="flex items-start space-x-2">
                                    <span class="text-emerald-300 text-sm sm:text-base">💭</span>
                                    <p class="text-sm sm:text-base text-emerald-100 group-hover:text-white transition-colors duration-200">{{ $prompts[$index] }}</p>
                                </div>
                            </div>
                        @endforeach
                        <button onclick="showMorePrompts()" class="w-full bg-emerald-700/50 hover:bg-emerald-600/50 text-emerald-200 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                            <i class="fas fa-plus mr-2"></i>More Prompts
                        </button>
                    </div>
                </div>

                <!-- Journaling Techniques -->
                <div class="bg-gradient-to-br from-amber-900/80 to-orange-900/80 rounded-xl p-4 sm:p-6 md:p-8 shadow-lg border border-amber-500/30">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <i class="fas fa-tools text-2xl sm:text-3xl text-amber-300 mr-3 sm:mr-4"></i>
                        <h3 class="text-lg sm:text-xl font-bold text-white">Journaling Techniques</h3>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        <div class="bg-amber-800/50 rounded-lg p-3 sm:p-4 hover:bg-amber-700/50 transition-colors duration-200 cursor-pointer group"
                             onclick="showTechnique('gratitude')">
                            <div class="flex items-center space-x-2">
                                <span class="text-amber-300">🙏</span>
                                <span class="text-sm sm:text-base text-amber-100 group-hover:text-white transition-colors duration-200">Gratitude Journaling</span>
                            </div>
                        </div>
                        
                        <div class="bg-orange-800/50 rounded-lg p-3 sm:p-4 hover:bg-orange-700/50 transition-colors duration-200 cursor-pointer group"
                             onclick="showTechnique('stream')">
                            <div class="flex items-center space-x-2">
                                <span class="text-orange-300">🌊</span>
                                <span class="text-sm sm:text-base text-orange-100 group-hover:text-white transition-colors duration-200">Stream of Consciousness</span>
                            </div>
                        </div>
                        
                        <div class="bg-amber-800/50 rounded-lg p-3 sm:p-4 hover:bg-amber-700/50 transition-colors duration-200 cursor-pointer group"
                             onclick="showTechnique('reflection')">
                            <div class="flex items-center space-x-2">
                                <span class="text-amber-300">🔍</span>
                                <span class="text-sm sm:text-base text-amber-100 group-hover:text-white transition-colors duration-200">Reflective Writing</span>
                            </div>
                        </div>
                        
                        <div class="bg-orange-800/50 rounded-lg p-3 sm:p-4 hover:bg-orange-700/50 transition-colors duration-200 cursor-pointer group"
                             onclick="showTechnique('bullet')">
                            <div class="flex items-center space-x-2">
                                <span class="text-orange-300">📝</span>
                                <span class="text-sm sm:text-base text-orange-100 group-hover:text-white transition-colors duration-200">Bullet Journaling</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mental Health Benefits & Motivation -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mt-8 sm:mt-10 mb-8 sm:mb-10">
                <!-- Psychological Benefits -->
                <div class="bg-gradient-to-br from-rose-900/80 to-pink-900/80 rounded-xl p-4 sm:p-6 md:p-8 shadow-lg border border-rose-500/30">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <i class="fas fa-heart text-2xl sm:text-3xl text-rose-300 mr-3 sm:mr-4"></i>
                        <h3 class="text-lg sm:text-xl font-bold text-white">Mental Health Benefits</h3>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        <div class="bg-rose-800/50 rounded-lg p-3 sm:p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm sm:text-base font-semibold text-rose-200">Stress Reduction</span>
                                <i class="fas fa-check-circle text-rose-300"></i>
                            </div>
                            <p class="text-xs sm:text-sm text-rose-300">Writing helps process emotions and reduce cortisol levels</p>
                        </div>
                        
                        <div class="bg-pink-800/50 rounded-lg p-3 sm:p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm sm:text-base font-semibold text-pink-200">Self-Awareness</span>
                                <i class="fas fa-eye text-pink-300"></i>
                            </div>
                            <p class="text-xs sm:text-sm text-pink-300">Regular reflection increases emotional intelligence</p>
                        </div>
                        
                        <div class="bg-rose-800/50 rounded-lg p-3 sm:p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm sm:text-base font-semibold text-rose-200">Goal Achievement</span>
                                <i class="fas fa-target text-rose-300"></i>
                            </div>
                            <p class="text-xs sm:text-sm text-rose-300">Journaling increases goal clarity and motivation</p>
                        </div>
                    </div>
                </div>

                <!-- Motivation & Tips -->
                <div class="bg-gradient-to-br from-violet-900/80 to-purple-900/80 rounded-xl p-4 sm:p-6 md:p-8 shadow-lg border border-violet-500/30">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <i class="fas fa-quote-left text-2xl sm:text-3xl text-violet-300 mr-3 sm:mr-4"></i>
                        <h3 class="text-lg sm:text-xl font-bold text-white">Daily Motivation</h3>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        @php
                            $motivations = [
                                'Every journal entry is a step toward self-discovery and growth.',
                                'Your thoughts matter. Write them down and watch them transform.',
                                'The best time to journal is when you least feel like it.',
                                'Your future self will thank you for today\'s reflections.',
                                'Small daily improvements lead to remarkable long-term results.',
                                'The act of writing helps clarify your thoughts and feelings.',
                                'Your journal is a safe space for your authentic self.',
                                'Every word you write brings you closer to understanding yourself.',
                                'Journaling is a conversation with your inner wisdom.',
                                'The pages of your journal hold the story of your growth.'
                            ];
                            $randomMotivation = $motivations[array_rand($motivations)];
                        @endphp
                        <div class="bg-violet-800/50 rounded-lg p-3 sm:p-4">
                            <p class="text-sm sm:text-base text-violet-100 italic">"{{ $randomMotivation }}"</p>
                        </div>
                        
                        <div class="bg-purple-800/50 rounded-lg p-3 sm:p-4">
                            <h4 class="text-sm sm:text-base font-semibold text-purple-200 mb-2">Today's Tip</h4>
                            <p class="text-xs sm:text-sm text-purple-300">Try writing for just 5 minutes. You'll be surprised how much you can discover in a short time.</p>
                        </div>
                        
                        <button onclick="showMoreMotivation()" class="w-full bg-violet-700/50 hover:bg-violet-600/50 text-violet-200 hover:text-white font-semibold py-2 sm:py-3 px-4 rounded-lg transition-colors duration-200 text-sm sm:text-base">
                            <i class="fas fa-refresh mr-2"></i>New Motivation
                        </button>
                    </div>
                </div>
            </div>

        @endif
    </div>
</div>

<!-- Technique Modal -->
<div id="techniqueModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
            <div class="p-4 sm:p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <h2 id="techniqueTitle" class="text-lg sm:text-xl md:text-2xl font-bold bg-gradient-to-r from-amber-400 to-orange-600 bg-clip-text text-transparent"></h2>
                    <button onclick="closeTechniqueModal()" class="text-gray-400 hover:text-white text-lg sm:text-xl p-1.5 sm:p-2 hover:bg-gray-700 rounded-lg transition-all duration-300 transform hover:scale-110">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div id="techniqueContent" class="p-4 sm:p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function createJournalWithPrompt(prompt) {
    // Store prompt in localStorage and redirect to create page
    localStorage.setItem('journalPrompt', prompt);
    window.location.href = '{{ route("journals.create") }}';
}

function showMorePrompts() {
    const allPrompts = [
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
    
    const randomPrompts = [];
    for (let i = 0; i < 4; i++) {
        const randomIndex = Math.floor(Math.random() * allPrompts.length);
        randomPrompts.push(allPrompts[randomIndex]);
    }
    
    // Update the prompts in the UI
    const promptContainer = document.querySelector('.bg-gradient-to-br.from-emerald-900\\/80.to-teal-900\\/80 .space-y-3');
    const promptElements = promptContainer.querySelectorAll('.bg-emerald-800\\/50');
    
    randomPrompts.forEach((prompt, index) => {
        if (promptElements[index]) {
            promptElements[index].onclick = () => createJournalWithPrompt(prompt);
            promptElements[index].querySelector('p').textContent = prompt;
        }
    });
}

function showMoreMotivation() {
    const motivations = [
        'Every journal entry is a step toward self-discovery and growth.',
        'Your thoughts matter. Write them down and watch them transform.',
        'The best time to journal is when you least feel like it.',
        'Your future self will thank you for today\'s reflections.',
        'Small daily improvements lead to remarkable long-term results.',
        'The act of writing helps clarify your thoughts and feelings.',
        'Your journal is a safe space for your authentic self.',
        'Every word you write brings you closer to understanding yourself.',
        'Journaling is a conversation with your inner wisdom.',
        'The pages of your journal hold the story of your growth.'
    ];
    
    const randomMotivation = motivations[Math.floor(Math.random() * motivations.length)];
    const motivationElement = document.querySelector('.bg-violet-800\\/50 p');
    if (motivationElement) {
        motivationElement.textContent = `"${randomMotivation}"`;
    }
}

function showTechnique(technique) {
    const techniques = {
        gratitude: {
            title: 'Gratitude Journaling 🙏',
            content: `
                <div class="space-y-4">
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">What is it?</h4>
                        <p class="text-amber-100 text-sm">Focusing on things you're thankful for to boost positive emotions and mental well-being.</p>
                    </div>
                    
                    <div class="bg-orange-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-orange-200 mb-2">How to practice:</h4>
                        <ul class="text-orange-100 text-sm space-y-2">
                            <li>• Write 3 things you're grateful for each day</li>
                            <li>• Be specific about why you're thankful</li>
                            <li>• Include both big and small things</li>
                            <li>• Reflect on people, experiences, and simple pleasures</li>
                        </ul>
                    </div>
                    
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">Benefits:</h4>
                        <ul class="text-amber-100 text-sm space-y-1">
                            <li>• Reduces stress and anxiety</li>
                            <li>• Improves sleep quality</li>
                            <li>• Increases overall happiness</li>
                            <li>• Strengthens relationships</li>
                        </ul>
                    </div>
                    
                    <button onclick="createJournalWithPrompt('What are you grateful for today?')" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200">
                        Start Gratitude Journaling
                    </button>
                </div>
            `
        },
        stream: {
            title: 'Stream of Consciousness 🌊',
            content: `
                <div class="space-y-4">
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">What is it?</h4>
                        <p class="text-amber-100 text-sm">Writing whatever comes to mind without filtering or editing, allowing thoughts to flow freely.</p>
                    </div>
                    
                    <div class="bg-orange-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-orange-200 mb-2">How to practice:</h4>
                        <ul class="text-orange-100 text-sm space-y-2">
                            <li>• Set a timer for 10-20 minutes</li>
                            <li>• Write continuously without stopping</li>
                            <li>• Don't worry about grammar or spelling</li>
                            <li>• Let your thoughts wander naturally</li>
                        </ul>
                    </div>
                    
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">Benefits:</h4>
                        <ul class="text-amber-100 text-sm space-y-1">
                            <li>• Clears mental clutter</li>
                            <li>• Reveals subconscious thoughts</li>
                            <li>• Reduces overthinking</li>
                            <li>• Improves creativity</li>
                        </ul>
                    </div>
                    
                    <button onclick="createJournalWithPrompt('Write whatever comes to mind right now...')" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200">
                        Start Free Writing
                    </button>
                </div>
            `
        },
        reflection: {
            title: 'Reflective Writing 🔍',
            content: `
                <div class="space-y-4">
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">What is it?</h4>
                        <p class="text-amber-100 text-sm">Deeply analyzing experiences, emotions, and behaviors to gain self-awareness and insights.</p>
                    </div>
                    
                    <div class="bg-orange-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-orange-200 mb-2">How to practice:</h4>
                        <ul class="text-orange-100 text-sm space-y-2">
                            <li>• Ask "why" questions about your feelings</li>
                            <li>• Examine patterns in your behavior</li>
                            <li>• Consider different perspectives</li>
                            <li>• Connect past experiences to present</li>
                        </ul>
                    </div>
                    
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">Benefits:</h4>
                        <ul class="text-amber-100 text-sm space-y-1">
                            <li>• Increases emotional intelligence</li>
                            <li>• Improves decision-making</li>
                            <li>• Helps process difficult emotions</li>
                            <li>• Promotes personal growth</li>
                        </ul>
                    </div>
                    
                    <button onclick="createJournalWithPrompt('What did you learn about yourself today?')" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200">
                        Start Reflecting
                    </button>
                </div>
            `
        },
        bullet: {
            title: 'Bullet Journaling 📝',
            content: `
                <div class="space-y-4">
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">What is it?</h4>
                        <p class="text-amber-100 text-sm">A rapid logging system using symbols and short-form notes to track tasks, events, and notes.</p>
                    </div>
                    
                    <div class="bg-orange-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-orange-200 mb-2">How to practice:</h4>
                        <ul class="text-orange-100 text-sm space-y-2">
                            <li>• Use symbols: • for tasks, ○ for events, - for notes</li>
                            <li>• Keep entries short and concise</li>
                            <li>• Review and migrate items regularly</li>
                            <li>• Create collections for related topics</li>
                        </ul>
                    </div>
                    
                    <div class="bg-amber-800/30 rounded-lg p-4">
                        <h4 class="font-bold text-amber-200 mb-2">Benefits:</h4>
                        <ul class="text-amber-100 text-sm space-y-1">
                            <li>• Improves productivity and organization</li>
                            <li>• Reduces mental load</li>
                            <li>• Provides clear overview of life</li>
                            <li>• Flexible and customizable system</li>
                        </ul>
                    </div>
                    
                    <button onclick="createJournalWithPrompt('What are your priorities for today?')" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200">
                        Start Bullet Journaling
                    </button>
                </div>
            `
        }
    };
    
    const techniqueData = techniques[technique];
    if (techniqueData) {
        document.getElementById('techniqueTitle').textContent = techniqueData.title;
        document.getElementById('techniqueContent').innerHTML = techniqueData.content;
        document.getElementById('techniqueModal').classList.remove('hidden');
    }
}

function closeTechniqueModal() {
    document.getElementById('techniqueModal').classList.add('hidden');
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const techniqueModal = document.getElementById('techniqueModal');
    
    if (event.target === techniqueModal) {
        closeTechniqueModal();
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeTechniqueModal();
    }
});
</script>
@endsection

@push('styles')
<style>
/* Custom scrollbar for mobile horizontal scroll */
.scrollbar-hide {
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
    scrollbar-width: none;  /* Firefox */
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;  /* Safari and Chrome */
}

/* Rich text content styling for insights */
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