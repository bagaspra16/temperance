@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">My Achievements</h1>
        <p class="text-gray-300 text-sm sm:text-base">Celebrate your accomplishments and track your journey to success.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-gray-800 rounded-2xl p-4 sm:p-6 border border-pink-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs sm:text-sm">Total Achievements</p>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-4 sm:p-6 border border-pink-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs sm:text-sm">This Month</p>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $stats['this_month'] }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-4 sm:p-6 border border-pink-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-xs sm:text-sm">This Year</p>
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $stats['this_year'] }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-white text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Achievements Grid -->
    @if($achievements->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($achievements as $achievement)
                <div class="bg-gray-800 rounded-2xl overflow-hidden border border-pink-500/10 hover:border-pink-500/30 transition-all duration-300 transform hover:scale-105">
                    <!-- Certificate Header -->
                    <div class="bg-gradient-to-r from-pink-500 to-pink-700 p-4 sm:p-6 text-center">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                            <i class="fas fa-certificate text-white text-xl sm:text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-base sm:text-lg mb-2">{{ $achievement->title }}</h3>
                        <p class="text-pink-100 text-xs sm:text-sm">{{ $achievement->certificate_number }}</p>
                    </div>

                    <!-- Certificate Content -->
                    <div class="p-4 sm:p-6">
                        <div class="mb-3 sm:mb-4">
                            <span class="text-xs font-semibold px-2 sm:px-3 py-1 rounded-full mb-3 inline-block" style="background-color: {{ $achievement->goal->category->color }}20; color: {{ $achievement->goal->category->color }};">
                                {{ $achievement->goal->category->name }}
                            </span>
                        </div>

                        <div class="mb-3 sm:mb-4">
                            <p class="text-gray-300 text-xs sm:text-sm line-clamp-3">{{ $achievement->certificate_message }}</p>
                        </div>

                        <div class="mb-3 sm:mb-4 p-2 sm:p-3 bg-gradient-to-r from-green-500/10 to-blue-500/10 rounded-lg border border-green-500/20">
                            <p class="text-green-400 text-xs sm:text-sm font-medium italic">{{ $achievement->affirmation_message }}</p>
                        </div>

                        <div class="flex items-center justify-between text-xs sm:text-sm text-gray-400 mb-3 sm:mb-4">
                            <span><i class="fas fa-calendar mr-1"></i> {{ $achievement->formatted_date }}</span>
                            <span class="px-2 py-1 rounded-full text-xs {{ $achievement->status_badge_class }}">
                                {{ ucfirst($achievement->status) }}
                            </span>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('achievements.show', $achievement->id) }}" 
                               class="flex-1 bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white text-center py-2 px-3 sm:px-4 rounded-lg font-medium transition-all duration-300 text-xs sm:text-sm" onclick="showLoading('Memuat detail...', 'Mohon tunggu sebentar')">
                                <i class="fas fa-eye mr-1 sm:mr-2"></i> <span class="hidden sm:inline">View</span><span class="sm:hidden">View</span>
                            </a>
                            <button onclick="openDownloadModal('{{ route('achievements.download', $achievement->id) }}')" 
                                    class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-3 sm:px-4 rounded-lg transition-colors duration-300 text-xs sm:text-sm">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6 sm:mt-8">
            {{ $achievements->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gray-800 rounded-3xl shadow-xl p-6 sm:p-8 lg:p-12 text-center border border-pink-500/10">
            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <i class="fas fa-trophy text-white text-2xl sm:text-3xl"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">No Achievements Yet</h3>
            <p class="text-gray-300 mb-4 sm:mb-6 max-w-md mx-auto text-sm sm:text-base">
                Complete your goals to earn achievement certificates! Each finished goal will automatically generate a personalized certificate with AI-generated congratulatory messages.
            </p>
            <a href="{{ route('goals.index') }}" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 inline-flex items-center gap-2 text-sm sm:text-base" onclick="showLoading('Memuat halaman goals...', 'Mohon tunggu sebentar')">
                <i class="fas fa-bullseye"></i> <span class="hidden sm:inline">Start Setting Goals</span><span class="sm:hidden">Set Goals</span>
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
    showLoading('Mengunduh sertifikat...', 'Mohon tunggu sebentar');
    window.location.href = url;
}
</script>
@endpush 