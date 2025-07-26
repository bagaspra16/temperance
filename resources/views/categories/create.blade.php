@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="categoryWizard()">
    <div class="max-w-4xl mx-auto">
        <!-- Header dengan toggle -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('categories.index') }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Categories
            </a>
            <div class="flex items-center gap-4">
                <button @click="toggleMode()" class="bg-gray-700 hover:bg-gradient-to-r from-pink-500 to-pink-700 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center gap-2">
                    <i class="fas fa-magic"></i>
                    <span x-text="isWizardMode ? 'Switch to Form' : 'Switch to Wizard'"></span>
                </button>
            </div>
        </div>

        <!-- Wizard Mode -->
        <div x-show="isWizardMode" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
                <!-- Progress Bar -->
                <div class="bg-gray-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-pink-200 text-sm font-medium">Step <span x-text="currentStep"></span> of <span x-text="totalSteps"></span></span>
                        <span class="text-pink-200 text-sm font-medium" x-text="Math.round((currentStep / totalSteps) * 100) + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-600 rounded-full h-2">
                        <div class="bg-gradient-to-r from-pink-500 to-pink-700 h-2 rounded-full transition-all duration-500" :style="`width: ${(currentStep / totalSteps) * 100}%`"></div>
                    </div>
                </div>

                <!-- Step Content -->
                <div class="p-8">
                    <!-- Step 1: Category Name -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-folder text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">What's your category name?</h2>
                            <p class="text-gray-300">Give your new category a memorable name</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <input type="text" x-model="formData.name" placeholder="e.g., Fitness, Work, Personal Growth" 
                                   class="w-full bg-gray-700 border-2 border-gray-600 text-white text-xl px-6 py-4 rounded-xl shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition-all duration-300 text-center">
                            <div class="mt-4 text-center">
                                <button @click="nextStep()" :disabled="!formData.name.trim()" 
                                        class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Description -->
                    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-align-left text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">Describe your category</h2>
                            <p class="text-gray-300">What kind of goals will this category contain?</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <textarea x-model="formData.description" rows="4" placeholder="What is this category about? What types of goals belong here?" 
                                      class="w-full bg-gray-700 border-2 border-gray-600 text-white text-lg px-6 py-4 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 resize-none"></textarea>
                            <div class="mt-4 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-pink-600 transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Color Selection -->
                    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-palette text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">Choose a color</h2>
                            <p class="text-gray-300">Pick a color that represents your category</p>
                        </div>
                        <div class="max-w-3xl mx-auto">
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                <div @click="selectColor('#3b82f6')" 
                                     :class="formData.color === '#3b82f6' ? 'ring-4 ring-blue-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-blue-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#3b82f6'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#ef4444')" 
                                     :class="formData.color === '#ef4444' ? 'ring-4 ring-red-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-red-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#ef4444'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#10b981')" 
                                     :class="formData.color === '#10b981' ? 'ring-4 ring-green-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-green-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#10b981'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#f59e0b')" 
                                     :class="formData.color === '#f59e0b' ? 'ring-4 ring-yellow-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-yellow-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#f59e0b'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#8b5cf6')" 
                                     :class="formData.color === '#8b5cf6' ? 'ring-4 ring-purple-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-purple-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#8b5cf6'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#ec4899')" 
                                     :class="formData.color === '#ec4899' ? 'ring-4 ring-pink-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-pink-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#ec4899'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#06b6d4')" 
                                     :class="formData.color === '#06b6d4' ? 'ring-4 ring-cyan-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-cyan-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#06b6d4'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#84cc16')" 
                                     :class="formData.color === '#84cc16' ? 'ring-4 ring-lime-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-lime-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#84cc16'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#f97316')" 
                                     :class="formData.color === '#f97316' ? 'ring-4 ring-orange-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-orange-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#f97316'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#6b7280')" 
                                     :class="formData.color === '#6b7280' ? 'ring-4 ring-gray-500 scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-gray-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#6b7280'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#000000')" 
                                     :class="formData.color === '#000000' ? 'ring-4 ring-black scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-black rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#000000'" class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div @click="selectColor('#ffffff')" 
                                     :class="formData.color === '#ffffff' ? 'ring-4 ring-white scale-110' : 'hover:scale-105'"
                                     class="w-16 h-16 bg-white border-2 border-gray-300 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#ffffff'" class="fas fa-check text-gray-800 text-xl"></i>
                                </div>
                            </div>
                            
                            <!-- Custom Color Picker -->
                            <div class="mt-6 text-center">
                                <label class="block text-green-200 font-medium mb-2">Or choose a custom color</label>
                                <input type="color" x-model="formData.color" 
                                       class="w-20 h-20 rounded-xl cursor-pointer border-2 border-gray-600">
                            </div>
                            
                            <div class="mt-6 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-pink-600 transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="submitForm()" class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    <i class="fas fa-plus-circle mr-2"></i> Create Category
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Traditional Form Mode -->
        <div x-show="!isWizardMode" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <div class="bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
                <div class="p-8">
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">Create a New Category</h1>
                    <p class="text-gray-300 mb-8">Organize your goals with a fresh category.</p>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                                <p class="font-bold">Oops! Something went wrong.</p>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-pink-200 font-medium mb-2">Category Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" placeholder="e.g., Fitness, Work, Personal Growth" required>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="description" class="block text-pink-200 font-medium mb-2">Description</label>
                                <textarea name="description" id="description" rows="4" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" placeholder="What is this category about?">{{ old('description') }}</textarea>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="color" class="block text-pink-200 font-medium mb-2">Color</label>
                                <input type="color" name="color" id="color" value="{{ old('color', '#3b82f6') }}" class="w-full h-12 p-1 border border-gray-500 rounded-lg shadow-sm cursor-pointer">
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mt-8">
                            <a href="{{ route('categories.index') }}" class="text-gray-400 hover:text-white font-semibold transition-colors duration-300">
                                <i class="fas fa-arrow-left mr-2"></i> Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                                <i class="fas fa-plus-circle"></i> Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for wizard submission -->
<form id="wizardForm" action="{{ route('categories.store') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="name" x-model="formData.name">
    <input type="hidden" name="description" x-model="formData.description">
    <input type="hidden" name="color" x-model="formData.color">
</form>
@endsection

@push('scripts')
<script>
function categoryWizard() {
    return {
        isWizardMode: true,
        currentStep: 1,
        totalSteps: 3,
        formData: {
            name: '',
            description: '',
            color: '#3b82f6'
        },
        
        toggleMode() {
            this.isWizardMode = !this.isWizardMode;
        },
        
        nextStep() {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
            }
        },
        
        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },
        
        selectColor(color) {
            this.formData.color = color;
        },
        
        submitForm() {
            // Update hidden form values
            document.querySelector('input[name="name"]').value = this.formData.name;
            document.querySelector('textarea[name="description"]').value = this.formData.description;
            document.querySelector('input[name="color"]').value = this.formData.color;
            
            // Submit the form
            document.getElementById('wizardForm').submit();
        }
    }
}

function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'category' ? 'Category' : 'Data') + '?',
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
            document.getElementById(formId).submit();
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush