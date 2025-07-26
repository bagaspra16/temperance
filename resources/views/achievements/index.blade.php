@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">My Achievements</h1>
        <p class="text-gray-300">Celebrate your accomplishments and track your journey to success.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-800 rounded-2xl p-6 border border-pink-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total Achievements</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 border border-pink-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">This Month</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['this_month'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 border border-pink-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">This Year</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['this_year'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements Grid -->
    @if($achievements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($achievements as $achievement)
                <div class="bg-gray-800 rounded-2xl overflow-hidden border border-pink-500/10 hover:border-pink-500/30 transition-all duration-300 transform hover:scale-105">
                    <!-- Certificate Header -->
                    <div class="bg-gradient-to-r from-pink-500 to-pink-700 p-6 text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-certificate text-white text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2">{{ $achievement->title }}</h3>
                        <p class="text-pink-100 text-sm">{{ $achievement->certificate_number }}</p>
                    </div>

                    <!-- Certificate Content -->
                    <div class="p-6">
                        <div class="mb-4">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block" style="background-color: {{ $achievement->goal->category->color }}20; color: {{ $achievement->goal->category->color }};">
                                {{ $achievement->goal->category->name }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-300 text-sm line-clamp-3">{{ $achievement->certificate_message }}</p>
                        </div>

                        <div class="mb-4 p-3 bg-gradient-to-r from-green-500/10 to-blue-500/10 rounded-lg border border-green-500/20">
                            <p class="text-green-400 text-sm font-medium italic">{{ $achievement->affirmation_message }}</p>
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                            <span><i class="fas fa-calendar mr-1"></i> {{ $achievement->formatted_date }}</span>
                            <span class="px-2 py-1 rounded-full text-xs {{ $achievement->status_badge_class }}">
                                {{ ucfirst($achievement->status) }}
                            </span>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('achievements.show', $achievement->id) }}" 
                               class="flex-1 bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white text-center py-2 px-4 rounded-lg font-medium transition-all duration-300">
                                <i class="fas fa-eye mr-2"></i> View
                            </a>
                            <button onclick="openDownloadModal('{{ route('achievements.download', $achievement->id) }}')" 
                                    class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition-colors duration-300">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $achievements->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gray-800 rounded-3xl shadow-xl p-12 text-center border border-pink-500/10">
            <div class="w-24 h-24 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-trophy text-white text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">No Achievements Yet</h3>
            <p class="text-gray-300 mb-6 max-w-md mx-auto">
                Complete your goals to earn achievement certificates! Each finished goal will automatically generate a personalized certificate with AI-generated congratulatory messages.
            </p>
            <a href="{{ route('goals.index') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2">
                <i class="fas fa-bullseye"></i> Start Setting Goals
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
function openDownloadModal(url) {
    window.location.href = url;
}
</script>
@endpush 