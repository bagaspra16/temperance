@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Write New Journal</h1>
            <a href="{{ route('journals.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-colors duration-200" onclick="showLoading('Loading page...', 'Please wait a moment')">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 mb-6 rounded-md shadow" role="alert">
                <p class="font-bold">Error</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <form method="POST" action="{{ route('journals.store') }}" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-2"></i>Date
                        </label>
                        <input type="date" 
                               id="date" 
                               name="date" 
                               value="{{ old('date', now()->format('Y-m-d')) }}"
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200"
                               required>
                        <p class="text-sm text-gray-400 mt-1">Choose the date for this journal</p>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-heading mr-2"></i>Title (Optional)
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               maxlength="100"
                               placeholder="Short title for your journal..."
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200">
                        <p class="text-sm text-gray-400 mt-1">Maximum 100 characters</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="mood" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-smile mr-2"></i>Today's Mood
                        </label>
                        <select id="mood" 
                                name="mood" 
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200"
                                required>
                            @foreach($moods as $value => $label)
                                <option value="{{ $value }}" {{ old('mood', 'calm') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-tag mr-2"></i>Category
                        </label>
                        <select id="category" 
                                name="category" 
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200"
                                required>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" {{ old('category', 'Personal') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="tags" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-hashtag mr-2"></i>Tags (Optional)
                    </label>
                    <div class="space-y-2" id="tag-container">
                        <div class="flex items-center space-x-2">
                            <input type="text" 
                                   name="tags[]" 
                                   placeholder="Example: gratitude, reflection, motivation..."
                                   class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200">
                            <button type="button" 
                                    onclick="addTagField()" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 mt-1">Maximum 5 tags, separate with comma if more than one</p>
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-edit mr-2"></i>Journal Content
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="12"
                              placeholder="Write your reflection for today... How do you feel? What did you learn? What do you want to achieve?"
                              class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200 resize-none"
                              required>{{ old('content') }}</textarea>
                    <p class="text-sm text-gray-400 mt-1">Take time to reflect on your day</p>
                </div>

                <div class="mb-8">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="important" 
                               value="1"
                               {{ old('important') ? 'checked' : '' }}
                               class="w-5 h-5 text-pink-600 bg-gray-700 border-gray-600 rounded focus:ring-pink-500 focus:ring-2">
                        <span class="text-gray-300 font-medium">
                            <i class="fas fa-star mr-2 text-yellow-400"></i>Mark as Important
                        </span>
                    </label>
                    <p class="text-sm text-gray-400 mt-1 ml-8">Important journals will be specially marked for future reference</p>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                    <a href="{{ route('journals.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200"
                       onclick="showLoading('Loading page...', 'Please wait a moment')">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    
                    <button type="submit" 
                            class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300"
                            onclick="showLoading('Saving journal...', 'Please wait a moment')">
                        <i class="fas fa-save mr-2"></i> Save Journal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let tagCount = 1;

function addTagField() {
    if (tagCount >= 5) {
        Swal.fire({
            title: 'Maximum Tags',
            text: 'You can only add a maximum of 5 tags.',
            icon: 'info',
            background: 'linear-gradient(to top right, #1f2937, #374151)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                title: 'text-xl font-bold text-blue-400',
                content: 'text-gray-300'
            }
        });
        return;
    }

    const container = document.getElementById('tag-container');
    const newField = document.createElement('div');
    newField.className = 'flex items-center space-x-2';
    newField.innerHTML = `
        <input type="text" 
               name="tags[]" 
               placeholder="Tag ${tagCount + 1}..."
               class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200">
        <button type="button" 
                onclick="removeTagField(this)" 
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-colors duration-200">
            <i class="fas fa-minus"></i>
        </button>
    `;
    container.appendChild(newField);
    tagCount++;
}

function removeTagField(button) {
    button.parentElement.remove();
    tagCount--;
}

// Auto-resize textarea
document.getElementById('content').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>
@endpush 