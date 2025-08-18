@extends('layouts.app')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-6 sm:py-8">
    <div class="w-full">
        <div class="flex items-center justify-between mb-4 sm:mb-6 md:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow">Edit Journal</h1>
            <a href="{{ route('journals.show', $journal->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 sm:py-2.5 md:py-3 px-3 sm:px-4 md:px-6 rounded-lg shadow-lg transition-colors duration-200 text-xs sm:text-sm md:text-base" onclick="showLoading('Loading page...', 'Please wait a moment')">
                <i class="fas fa-arrow-left mr-1 sm:mr-2 text-xs sm:text-sm"></i> Back
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
            <form method="POST" action="{{ route('journals.update', $journal->id) }}" class="p-4 sm:p-6 md:p-8 lg:p-12">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-2"></i>Date
                        </label>
                        <input type="date" 
                               id="date" 
                               name="date" 
                               value="{{ old('date', $journal->date->format('Y-m-d')) }}"
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
                               value="{{ old('title', $journal->title) }}"
                               maxlength="100"
                               placeholder="Short title for your journal..."
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200">
                        <p class="text-sm text-gray-400 mt-1">Maximum 100 characters</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="mood" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-smile mr-2"></i>Today's Mood
                        </label>
                        <select id="mood" 
                                name="mood" 
                                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200"
                                required>
                            @foreach($moods as $value => $label)
                                <option value="{{ $value }}" {{ old('mood', $journal->mood) == $value ? 'selected' : '' }}>
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
                                <option value="{{ $value }}" {{ old('category', $journal->category) == $value ? 'selected' : '' }}>
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
                        @if($journal->tags && count($journal->tags) > 0)
                            @foreach($journal->tags as $index => $tag)
                                <div class="flex items-center space-x-2">
                                    <input type="text" 
                                           name="tags[]" 
                                           value="{{ $tag }}"
                                           placeholder="Tag {{ $index + 1 }}..."
                                           class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200">
                                    @if($index > 0)
                                        <button type="button" 
                                                onclick="removeTagField(this)" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-colors duration-200">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    @else
                                        <button type="button" 
                                                onclick="addTagField()" 
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-colors duration-200">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
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
                        @endif
                    </div>
                    <p class="text-sm text-gray-400 mt-1">Maximum 5 tags, separate with comma if more than one</p>
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-edit mr-2"></i>Journal Content
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="16"
                              placeholder="Write your reflection for today... How do you feel? What did you learn? What do you want to achieve?"
                              class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors duration-200 resize-none"
                              required>{{ old('content', $journal->content) }}</textarea>
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-400">
                        <span class="flex items-center"><i class="fas fa-info-circle mr-1"></i>Use the toolbar above to format your text</span>
                        <span class="flex items-center"><i class="fas fa-bold mr-1"></i>Bold</span>
                        <span class="flex items-center"><i class="fas fa-italic mr-1"></i>Italic</span>
                        <span class="flex items-center"><i class="fas fa-underline mr-1"></i>Underline</span>
                        <span class="flex items-center"><i class="fas fa-list mr-1"></i>Lists</span>
                        <span class="flex items-center"><i class="fas fa-quote-left mr-1"></i>Quotes</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-1">Take time to reflect on your day</p>
                </div>

                <div class="mb-8">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="important" 
                               value="1"
                               {{ old('important', $journal->important) ? 'checked' : '' }}
                               class="w-5 h-5 text-pink-600 bg-gray-700 border-gray-600 rounded focus:ring-pink-500 focus:ring-2">
                        <span class="text-gray-300 font-medium">
                            <i class="fas fa-star mr-2 text-yellow-400"></i>Mark as Important
                        </span>
                    </label>
                    <p class="text-sm text-gray-400 mt-1 ml-8">Important journals will be specially marked for future reference</p>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                    <a href="{{ route('journals.show', $journal->id) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200"
                       onclick="showLoading('Loading page...', 'Please wait a moment')">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
                    
                    <button type="submit" 
                            class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-300"
                            onclick="showLoading('Saving changes...', 'Please wait a moment')">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<style>
/* Full width layout improvements */
@media (min-width: 1024px) {
    .container {
        max-width: 100%;
        padding-left: 2rem;
        padding-right: 2rem;
    }
    
    textarea#content {
        min-height: 500px;
    }
}

@media (min-width: 1280px) {
    .container {
        padding-left: 3rem;
        padding-right: 3rem;
    }
    
    textarea#content {
        min-height: 600px;
    }
}

@media (min-width: 1536px) {
    .container {
        padding-left: 4rem;
        padding-right: 4rem;
    }
    
    textarea#content {
        min-height: 700px;
    }
}
</style>
@endpush

@push('scripts')
<script>
let tagCount = {{ $journal->tags ? count($journal->tags) : 1 }};

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

// Initialize TinyMCE
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('content');
    textarea.style.minHeight = '400px';
    
    // Initialize TinyMCE
    tinymce.init({
        selector: '#content',
        height: 400,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
                'bold italic underline strikethrough | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | blockquote | code | help',
        content_style: `
            body { 
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
                font-size: 14px; 
                line-height: 1.6; 
                color: #D1D5DB; 
                background-color: #374151; 
                margin: 0; 
                padding: 16px; 
            }
            p { margin: 0 0 16px 0; }
            h1, h2, h3, h4, h5, h6 { 
                color: #F9FAFB; 
                margin: 16px 0 8px 0; 
                font-weight: 600; 
            }
            h1 { font-size: 24px; }
            h2 { font-size: 20px; }
            h3 { font-size: 18px; }
            h4 { font-size: 16px; }
            h5 { font-size: 14px; }
            h6 { font-size: 12px; }
            blockquote { 
                border-left: 4px solid #EC4899; 
                padding: 8px 16px; 
                margin: 16px 0; 
                background-color: rgba(236, 72, 153, 0.1); 
                border-radius: 4px; 
                font-style: italic; 
                color: #9CA3AF; 
            }
            ul, ol { 
                margin: 16px 0; 
                padding-left: 24px; 
            }
            li { 
                margin: 4px 0; 
                line-height: 1.6; 
            }
            code { 
                background-color: #1F2937; 
                padding: 2px 6px; 
                border-radius: 4px; 
                font-family: 'Courier New', monospace; 
                color: #F3F4F6; 
                font-size: 13px; 
            }
            pre { 
                background-color: #1F2937; 
                padding: 16px; 
                border-radius: 8px; 
                overflow-x: auto; 
                margin: 16px 0; 
                border: 1px solid #4B5563; 
            }
            pre code { 
                background: none; 
                padding: 0; 
                border-radius: 0; 
                color: #F3F4F6; 
            }
            strong { color: #F9FAFB; font-weight: 600; }
            em { color: #D1D5DB; font-style: italic; }
            u { text-decoration: underline; color: #F9FAFB; }
            s { text-decoration: line-through; color: #9CA3AF; }
            a { color: #EC4899; text-decoration: underline; }
            a:hover { color: #F472B6; }
            table { 
                border-collapse: collapse; 
                width: 100%; 
                margin: 16px 0; 
                background-color: #374151; 
                border-radius: 8px; 
                overflow: hidden; 
            }
            th, td { 
                border: 1px solid #4B5563; 
                padding: 12px; 
                text-align: left; 
            }
            th { 
                background-color: #4B5563; 
                font-weight: 600; 
                color: #F9FAFB; 
            }
            .highlight { 
                background-color: #FEF3C7; 
                color: #92400E; 
                padding: 2px 6px; 
                border-radius: 4px; 
            }
        `,
        skin: 'oxide-dark',
        content_css: 'dark',
        branding: false,
        promotion: false,
        setup: function(editor) {
            // Auto-save content to textarea
            editor.on('change', function() {
                editor.save();
            });
        }
    });
});
</script>
@endpush 