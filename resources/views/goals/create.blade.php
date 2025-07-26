@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="goalWizard()">
    <div class="max-w-4xl mx-auto">
        <!-- Header dengan toggle -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('goals.index') }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Goals
            </a>
            <div class="flex items-center gap-4">
                <button @click="toggleMode()" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center gap-2">
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
                    <!-- Step 1: Goal Title -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-bullseye text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">What's your goal?</h2>
                            <p class="text-gray-300">Let's start with the basics. What do you want to achieve?</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <input type="text" x-model="formData.title" placeholder="e.g., Learn Laravel from scratch" 
                                   class="w-full bg-gray-700 border-2 border-gray-600 text-white text-xl px-6 py-4 rounded-xl shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition-all duration-300 text-center">
                            <div class="mt-4 text-center">
                                <button @click="nextStep()" :disabled="!formData.title.trim()" 
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
                            <h2 class="text-3xl font-bold text-white mb-2">Tell us more about it</h2>
                            <p class="text-gray-300">Describe what you want to accomplish in detail</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <textarea x-model="formData.description" rows="4" placeholder="What exactly do you want to achieve? What's your motivation?" 
                                      class="w-full bg-gray-700 border-2 border-gray-600 text-white text-lg px-6 py-4 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 resize-none"></textarea>
                            <div class="mt-4 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Category -->
                    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-folder text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">Choose a category</h2>
                            <p class="text-gray-300">Where does this goal belong?</p>
                        </div>
                        <div class="max-w-3xl mx-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($categories as $category)
                                <div @click="selectCategory('{{ $category->id }}')" 
                                     :class="formData.category_id === '{{ $category->id }}' ? 'ring-2 ring-green-500 bg-green-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-4 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-white font-medium">{{ $category->name }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" :disabled="!formData.category_id" 
                                        class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Priority -->
                    <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">How important is this?</h2>
                            <p class="text-gray-300">Set the priority level for your goal</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <div class="space-y-4">
                                <div @click="selectPriority('low')" 
                                     :class="formData.priority === 'low' ? 'ring-2 ring-green-500 bg-green-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-6 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-leaf text-white"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-bold text-lg">Low Priority</h3>
                                                <p class="text-gray-300">Take your time, no rush</p>
                                            </div>
                                        </div>
                                        <i x-show="formData.priority === 'low'" class="fas fa-check text-green-500 text-xl"></i>
                                    </div>
                                </div>
                                
                                <div @click="selectPriority('medium')" 
                                     :class="formData.priority === 'medium' ? 'ring-2 ring-yellow-500 bg-yellow-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-6 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-clock text-white"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-bold text-lg">Medium Priority</h3>
                                                <p class="text-gray-300">Important but not urgent</p>
                                            </div>
                                        </div>
                                        <i x-show="formData.priority === 'medium'" class="fas fa-check text-yellow-500 text-xl"></i>
                                    </div>
                                </div>
                                
                                <div @click="selectPriority('high')" 
                                     :class="formData.priority === 'high' ? 'ring-2 ring-red-500 bg-red-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-6 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-fire text-white"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-bold text-lg">High Priority</h3>
                                                <p class="text-gray-300">Urgent and important</p>
                                            </div>
                                        </div>
                                        <i x-show="formData.priority === 'high'" class="fas fa-check text-red-500 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" :disabled="!formData.priority" 
                                        class="bg-gradient-to-r from-yellow-500 to-yellow-700 hover:from-yellow-600 hover:to-yellow-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Timeline -->
                    <div x-show="currentStep === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-alt text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">Set your timeline</h2>
                            <p class="text-gray-300">When do you want to start and finish?</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-purple-200 font-medium mb-2">Start Date</label>
                                    <input type="date" x-model="formData.start_date" 
                                           class="w-full bg-gray-700 border-2 border-gray-600 text-white text-lg px-4 py-3 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300">
                                </div>
                                <div>
                                    <label class="block text-purple-200 font-medium mb-2">Target Date</label>
                                    <input type="date" x-model="formData.end_date" 
                                           class="w-full bg-gray-700 border-2 border-gray-600 text-white text-lg px-4 py-3 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="submitForm()" class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    <i class="fas fa-rocket mr-2"></i> Create Goal
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
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">Create a New Goal</h1>
                    <p class="text-gray-300 mb-8">Let's set up your next big achievement.</p>
                    <form action="{{ route('goals.store') }}" method="POST">
                        @csrf
                        @if ($errors->any())
                            <div class="bg-pink-100 border-l-4 border-pink-500 text-pink-800 p-4 mb-6 rounded-xl" role="alert">
                                <p class="font-bold">Please fix the errors below:</p>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="md:col-span-3">
                                <label for="title" class="block text-pink-200 font-medium mb-2">Goal Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g., Learn Laravel from scratch" class="w-full border-gray-50 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                            </div>
                            <div class="md:col-span-3">
                                <label for="description" class="block text-pink-200 font-medium mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" placeholder="Describe what you want to accomplish." class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <label for="category_id" class="block text-pink-200 font-medium mb-2">Category</label>
                                <select name="category_id" id="category_id" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id') == $category->id || request('category_id') == $category->id) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="priority" class="block text-pink-200 font-medium mb-2">Priority</label>
                                <select name="priority" id="priority" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                            <div>
                                <label for="start_date" class="block text-pink-200 font-medium mb-2">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') ?? date('Y-m-d') }}" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="end_date" class="block text-pink-200 font-medium mb-2">Target Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                            </div>
                            <input type="hidden" name="progress_percent" value="0">
                            <input type="hidden" name="status" value="not_started">
                        </div>
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                                <i class="fas fa-check"></i> Create Goal
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
function goalWizard() {
    return {
        isWizardMode: true,
        currentStep: 1,
        totalSteps: 5,
        formData: {
            title: '',
            description: '',
            category_id: '',
            priority: '',
            start_date: '{{ date('Y-m-d') }}',
            end_date: ''
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
        
        selectCategory(categoryId) {
            this.formData.category_id = categoryId;
        },
        
        selectPriority(priority) {
            this.formData.priority = priority;
        },
        
        submitForm() {
            // Create a temporary form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('goals.store') }}';
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
            
            // Add form data
            const formData = {
                title: this.formData.title,
                description: this.formData.description,
                category_id: this.formData.category_id,
                priority: this.formData.priority,
                start_date: this.formData.start_date,
                end_date: this.formData.end_date,
                progress_percent: '0',
                status: 'not_started'
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

function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'goal' ? 'Goal' : 'Data') + '?',
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
@endpush