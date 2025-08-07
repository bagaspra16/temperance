@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Journal Insights</h1>
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

        @if($totalJournals == 0)
            <div class="bg-gray-800 rounded-2xl p-16 text-center shadow-lg">
                <i class="fas fa-chart-bar text-8xl text-gray-500 mb-8"></i>
                <h2 class="text-4xl font-bold text-gray-100 mb-4">No Data Available</h2>
                <p class="text-gray-400 mb-10 max-w-2xl mx-auto text-lg">Start writing journals to see insights and patterns about your self-improvement journey.</p>
                <a href="{{ route('journals.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-4 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300 inline-block text-lg" onclick="showLoading('Loading page...', 'Please wait a moment')">
                    <i class="fas fa-plus mr-2"></i> Write First Journal
                </a>
            </div>
        @else
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-book-open text-4xl mr-6"></i>
                        <div>
                            <h3 class="text-2xl font-bold mb-3">Total Journals</h3>
                            <p class="text-blue-100 text-lg">{{ $totalJournals }} entries</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-star text-4xl mr-6"></i>
                        <div>
                            <h3 class="text-2xl font-bold mb-3">Important Journals</h3>
                            <p class="text-green-100 text-lg">{{ $importantCount }} entries</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-fire text-4xl mr-6"></i>
                        <div>
                            <h3 class="text-2xl font-bold mb-3">Current Streak</h3>
                            <p class="text-purple-100 text-lg">{{ $streak }} days</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl p-8 text-white">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-4xl mr-6"></i>
                        <div>
                            <h3 class="text-2xl font-bold mb-3">Average per Month</h3>
                            <p class="text-orange-100 text-lg">{{ round($totalJournals / max(1, ceil($totalJournals / 30)), 1) }} journals</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <!-- Mood Analysis -->
                <div class="bg-gray-800 rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-white mb-8">
                        <i class="fas fa-smile mr-3 text-pink-400"></i>Mood Analysis
                    </h3>
                    
                    @if($mostCommonMood)
                        <div class="bg-gradient-to-r from-pink-600 to-pink-700 rounded-xl p-8 mb-8">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <span class="text-3xl">
                                        @php
                                            $emoji = match($mostCommonMood->mood) {
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
                                    <span class="font-semibold text-white text-lg">{{ ucfirst($mostCommonMood->mood) }}</span>
                                </div>
                                <span class="text-3xl font-bold text-white">{{ round(($mostCommonMood->count / $totalJournals) * 100, 1) }}%</span>
                            </div>
                            <p class="text-pink-100 text-lg">Your most common mood</p>
                        </div>
                    @endif

                    <div class="space-y-4">
                        @php
                            $moodData = [
                                'happy' => ['😊', 'Happy', 'bg-green-100 text-green-800'],
                                'sad' => ['😢', 'Sad', 'bg-blue-100 text-blue-800'],
                                'anxious' => ['😰', 'Anxious', 'bg-yellow-100 text-yellow-800'],
                                'calm' => ['😌', 'Calm', 'bg-indigo-100 text-indigo-800'],
                                'angry' => ['😠', 'Angry', 'bg-red-100 text-red-800'],
                                'confused' => ['😕', 'Confused', 'bg-gray-100 text-gray-800'],
                                'excited' => ['💪', 'Excited', 'bg-orange-100 text-orange-800'],
                                'tired' => ['😴', 'Tired', 'bg-purple-100 text-purple-800'],
                                'satisfied' => ['😌', 'Satisfied', 'bg-teal-100 text-teal-800'],
                                'frustrated' => ['😤', 'Frustrated', 'bg-pink-100 text-pink-800'],
                            ];
                        @endphp

                        @foreach($moodData as $moodKey => $moodInfo)
                            @php
                                $count = 0;
                                if ($mostCommonMood && $mostCommonMood->mood == $moodKey) {
                                    $count = $mostCommonMood->count;
                                }
                                $percentage = $totalJournals > 0 ? round(($count / $totalJournals) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gray-750 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <span class="text-2xl">{{ $moodInfo[0] }}</span>
                                    <span class="font-semibold text-white text-lg">{{ $moodInfo[1] }}</span>
                                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $moodInfo[2] }}">
                                        {{ $count }} times
                                    </span>
                                </div>
                                <span class="text-gray-400 font-semibold text-lg">{{ $percentage }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Category Analysis -->
                <div class="bg-gray-800 rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold text-white mb-8">
                        <i class="fas fa-tag mr-3 text-pink-400"></i>Category Analysis
                    </h3>
                    
                    @if($mostCommonCategory)
                        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-xl p-8 mb-8">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-tag text-3xl text-white"></i>
                                    <span class="font-semibold text-white text-lg">{{ $mostCommonCategory->category }}</span>
                                </div>
                                <span class="text-3xl font-bold text-white">{{ round(($mostCommonCategory->count / $totalJournals) * 100, 1) }}%</span>
                            </div>
                            <p class="text-indigo-100 text-lg">Your most common category</p>
                        </div>
                    @endif

                    <div class="space-y-4">
                        @php
                            $categoryData = [
                                'Personal' => ['bg-purple-100 text-purple-800'],
                                'Social' => ['bg-blue-100 text-blue-800'],
                                'Career' => ['bg-green-100 text-green-800'],
                                'Spiritual' => ['bg-indigo-100 text-indigo-800'],
                                'Academic' => ['bg-yellow-100 text-yellow-800'],
                                'Health' => ['bg-red-100 text-red-800'],
                                'Finance' => ['bg-emerald-100 text-emerald-800'],
                                'Hobby' => ['bg-pink-100 text-pink-800'],
                            ];
                        @endphp

                        @foreach($categoryData as $categoryKey => $categoryClass)
                            @php
                                $count = 0;
                                if ($mostCommonCategory && $mostCommonCategory->category == $categoryKey) {
                                    $count = $mostCommonCategory->count;
                                }
                                $percentage = $totalJournals > 0 ? round(($count / $totalJournals) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gray-750 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-tag text-gray-400 text-lg"></i>
                                    <span class="font-semibold text-white text-lg">{{ $categoryKey }}</span>
                                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $categoryClass[0] }}">
                                        {{ $count }} times
                                    </span>
                                </div>
                                <span class="text-gray-400 font-semibold text-lg">{{ $percentage }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Activity Patterns -->
            <div class="bg-gray-800 rounded-2xl p-8 shadow-lg mt-10 mb-10">
                <h3 class="text-2xl font-bold text-white mb-8">
                    <i class="fas fa-calendar-alt mr-3 text-pink-400"></i>Activity Patterns
                </h3>
                
                @if($mostActiveDay)
                    <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-xl p-8 mb-8">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-calendar-day text-3xl text-white"></i>
                                <span class="font-semibold text-white text-lg">
                                    @php
                                        // Detect database type and map days accordingly
                                        try {
                                            $connection = \DB::connection()->getDriverName();
                                            if ($connection === 'pgsql') {
                                                // PostgreSQL: 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday
                                                $dayNames = [
                                                    0 => 'Sunday',
                                                    1 => 'Monday', 
                                                    2 => 'Tuesday',
                                                    3 => 'Wednesday',
                                                    4 => 'Thursday',
                                                    5 => 'Friday',
                                                    6 => 'Saturday'
                                                ];
                                            } else {
                                                // MySQL: 1=Sunday, 2=Monday, 3=Tuesday, 4=Wednesday, 5=Thursday, 6=Friday, 7=Saturday
                                                $dayNames = [
                                                    1 => 'Sunday',
                                                    2 => 'Monday', 
                                                    3 => 'Tuesday',
                                                    4 => 'Wednesday',
                                                    5 => 'Thursday',
                                                    6 => 'Friday',
                                                    7 => 'Saturday'
                                                ];
                                            }
                                        } catch (\Exception $e) {
                                            // Fallback to PostgreSQL format
                                            $dayNames = [
                                                0 => 'Sunday',
                                                1 => 'Monday', 
                                                2 => 'Tuesday',
                                                3 => 'Wednesday',
                                                4 => 'Thursday',
                                                5 => 'Friday',
                                                6 => 'Saturday'
                                            ];
                                        }
                                        $dayName = $dayNames[$mostActiveDay->day_of_week] ?? 'Unknown';
                                    @endphp
                                    {{ $dayName }}
                                </span>
                            </div>
                            <span class="text-3xl font-bold text-white">{{ round(($mostActiveDay->count / $totalJournals) * 100, 1) }}%</span>
                        </div>
                        <p class="text-teal-100 text-lg">Your most active day of the week</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-6">
                    @php
                        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        $dayIcons = ['fas fa-sun', 'fas fa-moon', 'fas fa-star', 'fas fa-heart', 'fas fa-thumbs-up', 'fas fa-fire', 'fas fa-crown'];
                        
                        // Detect database type for day numbering
                        try {
                            $connection = \DB::connection()->getDriverName();
                            $isPostgreSQL = $connection === 'pgsql';
                        } catch (\Exception $e) {
                            // Fallback to PostgreSQL format
                            $isPostgreSQL = true;
                        }
                    @endphp

                    @for($i = 0; $i < 7; $i++)
                        @php
                            $count = 0;
                            $dayNumber = $isPostgreSQL ? $i : $i + 1; // PostgreSQL: 0-6, MySQL: 1-7
                            if ($mostActiveDay && $mostActiveDay->day_of_week == $dayNumber) {
                                $count = $mostActiveDay->count;
                            }
                            $percentage = $totalJournals > 0 ? round(($count / $totalJournals) * 100, 1) : 0;
                        @endphp
                        <div class="bg-gray-750 rounded-xl p-6 text-center">
                            <div class="text-3xl text-pink-400 mb-3">
                                <i class="{{ $dayIcons[$i] }}"></i>
                            </div>
                            <div class="text-base font-semibold text-white mb-2">{{ $dayNames[$i] }}</div>
                            <div class="text-2xl font-bold text-pink-400 mb-1">{{ $count }}</div>
                            <div class="text-sm text-gray-400">{{ $percentage }}%</div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Recommendations -->
            <div class="bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-8">
                    <i class="fas fa-lightbulb mr-3 text-pink-400"></i>Recommendations
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @if($streak > 0)
                        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl p-8 text-white">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-fire text-4xl mr-6"></i>
                                <div>
                                    <h4 class="text-xl font-bold mb-2">Great Streak!</h4>
                                    <p class="text-green-100 text-lg">You've been journaling for {{ $streak }} consecutive days. Keep up the momentum!</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($mostCommonMood)
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-8 text-white">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-smile text-4xl mr-6"></i>
                                <div>
                                    <h4 class="text-xl font-bold mb-2">Mood Pattern</h4>
                                    <p class="text-blue-100 text-lg">You often feel {{ $mostCommonMood->mood }}. Consider what triggers this mood and how to manage it.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($mostCommonCategory)
                        <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-8 text-white">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-tag text-4xl mr-6"></i>
                                <div>
                                    <h4 class="text-xl font-bold mb-2">Focus Area</h4>
                                    <p class="text-purple-100 text-lg">You write most about {{ $mostCommonCategory->category }}. This might be an area you want to explore more.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($importantCount > 0)
                        <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-xl p-8 text-white">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-star text-4xl mr-6"></i>
                                <div>
                                    <h4 class="text-xl font-bold mb-2">Important Moments</h4>
                                    <p class="text-yellow-100 text-lg">You've marked {{ $importantCount }} journals as important. Review these for key insights.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 