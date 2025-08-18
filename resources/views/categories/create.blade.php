@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="categoryWizard()" x-init="init()">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('categories.index') }}" 
                   class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base"
                   onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                    <i class="fas fa-arrow-left text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Back to Categories</span>
                    <span class="sm:hidden">Back</span>
                </a>
            </div>
            
            <!-- Mode Toggle Button -->
            <div class="flex items-center gap-2">
                <button @click="toggleMode()" 
                        class="bg-gray-700 hover:bg-gray-600 text-white px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded-lg transition-all duration-300 flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base transform hover:scale-105">
                    <i class="fas fa-magic text-xs sm:text-sm"></i>
                    <span x-text="isWizardMode ? 'Switch to Form' : 'Switch to Wizard'" class="hidden sm:inline"></span>
                    <span x-text="isWizardMode ? 'Form' : 'Wizard'" class="sm:hidden"></span>
                </button>
            </div>
        </div>

        <!-- Wizard Mode -->
        <div x-show="isWizardMode" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 transform scale-95" 
             x-transition:enter-end="opacity-100 transform scale-100"
             data-wizard-mode>
            
            <div class="bg-gray-800 rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
                <!-- Progress Bar -->
                <div class="bg-gray-700 p-3 sm:p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-pink-200 text-xs sm:text-sm font-medium">
                            Step <span x-text="currentStep"></span> of <span x-text="totalSteps"></span>
                        </span>
                        <span class="text-pink-200 text-xs sm:text-sm font-medium" 
                              x-text="Math.round((currentStep / totalSteps) * 100) + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-600 rounded-full h-2">
                        <div class="bg-gradient-to-r from-pink-500 to-pink-700 h-2 rounded-full transition-all duration-500" 
                             :style="`width: ${(currentStep / totalSteps) * 100}%`"></div>
                    </div>
                </div>

                <!-- Step Content -->
                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Step 1: Category Name -->
                    <div x-show="currentStep === 1" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-folder text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">What's your category name?</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Give your new category a memorable name</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <input type="text" 
                                   x-model="formData.name" 
                                   placeholder="e.g., Fitness, Work, Personal Growth" 
                                   class="w-full bg-gray-700 border-2 border-gray-600 text-white text-lg sm:text-xl px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition-all duration-300 text-center">
                            
                            <div class="mt-4 sm:mt-6 text-center">
                                <button @click="nextStep()" 
                                        :disabled="!formData.name.trim()" 
                                        class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Description -->
                    <div x-show="currentStep === 2" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-align-left text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Describe your category</h2>
                            <p class="text-gray-300 text-sm sm:text-base">What kind of goals will this category contain?</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <textarea x-model="formData.description" 
                                      rows="4" 
                                      placeholder="What is this category about? What types of goals belong here?" 
                                      class="w-full bg-gray-700 border-2 border-gray-600 text-white text-base sm:text-lg px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 resize-none"></textarea>
                            
                            <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-pink-600 transition-colors duration-300 text-sm sm:text-base">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" 
                                        class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Color Selection -->
                    <div x-show="currentStep === 3" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-palette text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Choose a color</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Pick a color that represents your category</p>
                        </div>
                        
                        <div class="max-w-3xl mx-auto">
                            <!-- Color Grid -->
                            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
                                <div @click="selectColor('#3b82f6')" 
                                     :class="formData.color === '#3b82f6' ? 'ring-4 ring-blue-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#3b82f6'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#ef4444')" 
                                     :class="formData.color === '#ef4444' ? 'ring-4 ring-red-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-red-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#ef4444'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#10b981')" 
                                     :class="formData.color === '#10b981' ? 'ring-4 ring-green-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-green-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#10b981'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#f59e0b')" 
                                     :class="formData.color === '#f59e0b' ? 'ring-4 ring-yellow-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-yellow-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#f59e0b'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#8b5cf6')" 
                                     :class="formData.color === '#8b5cf6' ? 'ring-4 ring-purple-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-purple-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#8b5cf6'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#ec4899')" 
                                     :class="formData.color === '#ec4899' ? 'ring-4 ring-pink-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-pink-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#ec4899'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#06b6d4')" 
                                     :class="formData.color === '#06b6d4' ? 'ring-4 ring-cyan-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-cyan-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#06b6d4'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#84cc16')" 
                                     :class="formData.color === '#84cc16' ? 'ring-4 ring-lime-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-lime-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#84cc16'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#f97316')" 
                                     :class="formData.color === '#f97316' ? 'ring-4 ring-orange-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-orange-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#f97316'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#6b7280')" 
                                     :class="formData.color === '#6b7280' ? 'ring-4 ring-gray-500 scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-500 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#6b7280'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#000000')" 
                                     :class="formData.color === '#000000' ? 'ring-4 ring-black scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-black rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#000000'" class="fas fa-check text-white text-sm sm:text-xl"></i>
                                </div>
                                <div @click="selectColor('#ffffff')" 
                                     :class="formData.color === '#ffffff' ? 'ring-4 ring-white scale-110' : 'hover:scale-105'"
                                     class="w-12 h-12 sm:w-16 sm:h-16 bg-white border-2 border-gray-300 rounded-xl cursor-pointer transition-all duration-300 flex items-center justify-center">
                                    <i x-show="formData.color === '#ffffff'" class="fas fa-check text-gray-800 text-sm sm:text-xl"></i>
                                </div>
                            </div>
                            
                            <!-- Custom Color Picker -->
                            <div class="mt-6 text-center">
                                <label class="block text-green-200 font-medium mb-2 text-sm sm:text-base">Or choose a custom color</label>
                                <input type="color" 
                                       x-model="formData.color" 
                                       class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl cursor-pointer border-2 border-gray-600">
                            </div>
                            
                            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-pink-600 transition-colors duration-300 text-sm sm:text-base">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="submitForm()" 
                                        class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    <i class="fas fa-plus-circle mr-2"></i> Create Category
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Traditional Form Mode -->
        <div x-show="!isWizardMode" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 transform scale-95" 
             x-transition:enter-end="opacity-100 transform scale-100"
             data-form-mode
             style="display: none;">
            
            <div class="bg-gray-800 rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
                <div class="p-4 sm:p-6 lg:p-8">
                    <h1 class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">Create a New Category</h1>
                    <p class="text-gray-300 mb-6 sm:mb-8 text-sm sm:text-base">Organize your goals with a fresh category.</p>
                    
                    <form action="{{ route('categories.store') }}" method="POST" onsubmit="showLoading('Membuat kategori...', 'Mohon tunggu sebentar')">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                                <p class="font-bold">Oops! Something went wrong.</p>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="space-y-4 sm:space-y-6">
                            <div>
                                <label for="name" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Category Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}" 
                                       class="w-full border-gray-300 bg-transparent text-white text-base sm:text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                       placeholder="e.g., Fitness, Work, Personal Growth" 
                                       required>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4" 
                                          class="w-full border-gray-300 bg-transparent text-white text-base sm:text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                          placeholder="What is this category about?">{{ old('description') }}</textarea>
                            </div>
                            
                            <div>
                                <label for="color" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Color</label>
                                <input type="color" 
                                       name="color" 
                                       id="color" 
                                       value="{{ old('color', '#3b82f6') }}" 
                                       class="w-full h-12 p-1 border border-gray-500 rounded-lg shadow-sm cursor-pointer">
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6 sm:mt-8">
                            <a href="{{ route('categories.index') }}" 
                               class="text-gray-400 hover:text-white font-semibold transition-colors duration-300 text-sm sm:text-base" 
                               onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                                <i class="fas fa-arrow-left mr-2"></i> Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-6 sm:px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2 text-sm sm:text-base">
                                <i class="fas fa-plus-circle"></i> Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
        
        init() {
            // Ensure proper initialization
            console.log('Category wizard initialized');
            this.isWizardMode = true;
            this.currentStep = 1;
            
            // Force re-evaluation after Alpine is ready
            this.$nextTick(() => {
                console.log('Category wizard ready, isWizardMode:', this.isWizardMode);
            });
        },
        
        toggleMode() {
            console.log('Toggling mode from:', this.isWizardMode);
            this.isWizardMode = !this.isWizardMode;
            console.log('Mode toggled to:', this.isWizardMode);
        },
        
        nextStep() {
            if (this.currentStep < this.totalSteps) {
                console.log('Moving from step', this.currentStep, 'to', this.currentStep + 1);
                this.currentStep++;
            }
        },
        
        prevStep() {
            if (this.currentStep > 1) {
                console.log('Moving from step', this.currentStep, 'to', this.currentStep - 1);
                this.currentStep--;
            }
        },
        
        selectColor(color) {
            console.log('Color selected:', color);
            this.formData.color = color;
        },
        
        submitForm() {
            console.log('Submitting form with data:', this.formData);
            showLoading('Membuat kategori...', 'Mohon tunggu sebentar');
            
            // Create a temporary form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('categories.store') }}';
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            // Add form data
            const formData = {
                name: this.formData.name,
                description: this.formData.description,
                color: this.formData.color
            };
            
            Object.keys(formData).forEach(key => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = formData[key];
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    }
}

// Ensure function is available globally
window.categoryWizard = categoryWizard;

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
            showLoading('Menghapus kategori...', 'Mohon tunggu sebentar');
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endpush