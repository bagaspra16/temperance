@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('achievements.index') }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Achievements
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
            <!-- Achievement Card -->
            <div class="bg-gray-800 rounded-3xl p-6 mb-6 border border-gray-700 shadow-2xl">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                        <i class="fas fa-trophy text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-white mb-2">{{ $achievement->title }}</h1>
                    <div class="flex items-center justify-center gap-4 text-xs text-gray-400">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-calendar text-pink-500"></i>
                            {{ $achievement->formatted_date }}
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-user text-pink-500"></i>
                            {{ $achievement->user->name }}
                        </span>
                    </div>
                </div>

                <!-- Messages -->
                <div class="space-y-4 mb-6">
                    <!-- Certificate Message -->
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 rounded-xl p-4 border border-pink-500/20">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-certificate text-white text-xs"></i>
                            </div>
                            <h3 class="text-sm font-semibold text-white">Certificate Message</h3>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed">{{ $achievement->certificate_message }}</p>
                    </div>

                    <!-- Affirmation Message -->
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 rounded-xl p-4 border border-green-500/20">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-heart text-white text-xs"></i>
                            </div>
                            <h3 class="text-sm font-semibold text-white">Your Affirmation</h3>
                        </div>
                        <p class="text-green-300 text-sm leading-relaxed font-medium italic">{{ $achievement->affirmation_message }}</p>
                    </div>
                </div>

                <!-- Goal Info -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 rounded-xl p-4 border border-blue-500/20">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bullseye text-white text-xs"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-white">Completed Goal</h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white font-semibold text-sm">{{ $achievement->goal->title }}</p>
                            <p class="text-gray-400 text-xs">{{ $achievement->goal->description }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 rounded-full text-xs font-medium" style="background-color: {{ $achievement->goal->category->color }}20; color: {{ $achievement->goal->category->color }};">
                                {{ $achievement->goal->category->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="openDownloadModal()" class="flex-1 bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-6 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-download"></i>
                    <span>Download Certificate</span>
                </button>
                <a href="{{ route('goals.show', $achievement->goal->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-eye"></i>
                    <span>View Goal</span>
                </a>
                <button onclick="shareAchievement()" class="flex-1 bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-bold py-3 px-6 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fas fa-share-alt"></i>
                    <span>Share</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openDownloadModal() {
    window.location.href = '{{ route("achievements.download", $achievement->id) }}';
}

function shareAchievement() {
    if (navigator.share) {
        navigator.share({
            title: 'Achievement Unlocked: {{ $achievement->title }}',
            text: 'I just completed my goal and earned an achievement certificate!',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        const text = 'Check out my achievement: {{ $achievement->title }}';
        
        // Copy to clipboard
        navigator.clipboard.writeText(`${text}\n${url}`).then(() => {
            Swal.fire({
                title: 'Link Copied!',
                text: 'Achievement link has been copied to your clipboard.',
                icon: 'success',
                background: 'linear-gradient(to top right, #1f2937, #374151)',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl border border-gray-700',
                    title: 'text-2xl font-bold text-green-400 pt-4',
                    htmlContainer: 'text-lg text-gray-300 pb-4'
                }
            });
        });
    }
}
</script>
@endpush 