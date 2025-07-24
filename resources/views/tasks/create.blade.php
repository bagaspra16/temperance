@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="taskWizard()">
    <div class="max-w-4xl mx-auto">
        <!-- Header dengan toggle -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ url()->previous(route('tasks.index')) }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Tasks
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
                    <!-- Step 1: Task Title -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tasks text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">What task do you need to do?</h2>
                            <p class="text-gray-300">Let's break down your goal into actionable steps</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <input type="text" x-model="formData.title" placeholder="e.g., Set up project repository" 
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
                            <h2 class="text-3xl font-bold text-white mb-2">Add more details</h2>
                            <p class="text-gray-300">Describe what needs to be done for this task</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <textarea x-model="formData.description" rows="4" placeholder="What exactly needs to be done? Any specific requirements?" 
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

                    <!-- Step 3: Related Goal -->
                    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-bullseye text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">Which goal is this for?</h2>
                            <p class="text-gray-300">Connect this task to one of your goals</p>
                        </div>
                        <div class="max-w-3xl mx-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($goals as $goal)
                                <div @click="selectGoal('{{ $goal->id }}')" 
                                     :class="formData.goal_id === '{{ $goal->id }}' ? 'ring-2 ring-green-500 bg-green-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-4 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-start gap-3">
                                        <div class="w-4 h-4 rounded-full mt-1" style="background-color: {{ $goal->category->color }}"></div>
                                        <div class="flex-1">
                                            <h3 class="text-white font-medium text-sm">{{ $goal->title }}</h3>
                                            <p class="text-gray-400 text-xs">{{ $goal->category->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" :disabled="!formData.goal_id" 
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
                            <h2 class="text-3xl font-bold text-white mb-2">How urgent is this task?</h2>
                            <p class="text-gray-300">Set the priority level for this task</p>
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
                                                <p class="text-gray-300">Can be done later</p>
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
                                                <p class="text-gray-300">Should be done soon</p>
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
                                                <p class="text-gray-300">Needs immediate attention</p>
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

                    <!-- Step 5: Due Date -->
                    <div x-show="currentStep === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-alt text-2xl text-white"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-white mb-2">When is this due?</h2>
                            <p class="text-gray-300">Set a deadline for this task</p>
                        </div>
                        <div class="max-w-2xl mx-auto">
                            <div class="bg-gray-700 border-2 border-gray-600 rounded-xl p-6">
                                <label class="block text-purple-200 font-medium mb-4 text-center">Due Date</label>
                                <input type="date" x-model="formData.due_date" 
                                       class="w-full bg-gray-600 border-2 border-gray-500 text-white text-lg px-4 py-3 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300 text-center">
                            </div>
                            <div class="mt-6 flex justify-between items-center">
                                <button @click="prevStep()" class="text-gray-400 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="submitForm()" class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-bold py-3 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300">
                                    <i class="fas fa-plus-circle mr-2"></i> Create Task
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
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">Create a New Task</h1>
                    <p class="text-gray-300 mb-8">Break down your goals into actionable steps.</p>
                    <form action="{{ route('tasks.store') }}" method="POST">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="title" class="block text-pink-200 font-medium mb-2">Task Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g., Set up project repository" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="description" class="block text-pink-200 font-medium mb-2">Description</label>
                                <textarea name="description" id="description" rows="4" placeholder="Add more details about the task." class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="goal_id" class="block text-pink-200 font-medium mb-2">Related Goal</label>
                                <select name="goal_id" id="goal_id" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" required>
                                    <option value="">Select a goal</option>
                                    @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}" {{ (old('goal_id') == $goal->id || request('goal_id') == $goal->id) ? 'selected' : '' }}>
                                            {{ $goal->title }} ({{ $goal->category->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="due_date" class="block text-pink-200 font-medium mb-2">Due Date</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') ?? date('Y-m-d') }}" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                            </div>
                            
                            <div>
                                <label for="priority" class="block text-pink-200 font-medium mb-2">Priority</label>
                                <select name="priority" id="priority" class="w-full border-gray-300 bg-transparent text-white text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2">
                                <i class="fas fa-plus-circle mr-2"></i> Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for wizard submission -->
<form id="wizardForm" action="{{ route('tasks.store') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="title" x-model="formData.title">
    <input type="hidden" name="description" x-model="formData.description">
    <input type="hidden" name="goal_id" x-model="formData.goal_id">
    <input type="hidden" name="priority" x-model="formData.priority">
    <input type="hidden" name="due_date" x-model="formData.due_date">
</form>
@endsection

@push('scripts')
<script>
function taskWizard() {
    return {
        isWizardMode: true,
        currentStep: 1,
        totalSteps: 5,
        formData: {
            title: '',
            description: '',
            goal_id: '',
            priority: '',
            due_date: '{{ date('Y-m-d') }}'
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
        
        selectGoal(goalId) {
            this.formData.goal_id = goalId;
        },
        
        selectPriority(priority) {
            this.formData.priority = priority;
        },
        
        submitForm() {
            // Update hidden form values
            document.querySelector('input[name="title"]').value = this.formData.title;
            document.querySelector('input[name="description"]').value = this.formData.description;
            document.querySelector('input[name="goal_id"]').value = this.formData.goal_id;
            document.querySelector('input[name="priority"]').value = this.formData.priority;
            document.querySelector('input[name="due_date"]').value = this.formData.due_date;
            
            // Submit the form
            document.getElementById('wizardForm').submit();
        }
    }
}

function showDeleteConfirmation(formId, itemTitle, type) {
    Swal.fire({
        title: 'Delete ' + (type === 'task' ? 'Task' : 'Data') + '?',
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