@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="taskWizard()" x-init="init()">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ url()->previous(route('tasks.index')) }}" 
                   class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base">
                    <i class="fas fa-arrow-left text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Back to Tasks</span>
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
             x-transition:enter-end="opacity-100 transform scale-100">
            
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
                    <!-- Step 1: Task Title -->
                    <div x-show="currentStep === 1" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tasks text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">What task do you need to do?</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Let's break down your goal into actionable steps</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <input type="text" 
                                   x-model="formData.title" 
                                   placeholder="e.g., Set up project repository" 
                                   class="w-full bg-gray-700 border-2 border-gray-600 text-white text-lg sm:text-xl px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition-all duration-300 text-center">
                            
                            <div class="mt-4 sm:mt-6 text-center">
                                <button @click="nextStep()" 
                                        :disabled="!formData.title.trim()" 
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
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Add more details</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Describe what needs to be done for this task</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <textarea x-model="formData.description" 
                                      rows="4" 
                                      placeholder="What exactly needs to be done? Any specific requirements?" 
                                      class="w-full bg-gray-700 border-2 border-gray-600 text-white text-base sm:text-lg px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 resize-none"></textarea>
                            
                            <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-white transition-colors duration-300 text-sm sm:text-base">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" 
                                        class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Related Goal -->
                    <div x-show="currentStep === 3" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-bullseye text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Which goal is this for?</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Connect this task to one of your goals (you can add tasks to completed goals too!)</p>
                        </div>
                        
                        <div class="max-w-3xl mx-auto">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                @foreach($goals as $goal)
                                <div @click="selectGoal('{{ $goal->id }}')" 
                                     :class="formData.goal_id === '{{ $goal->id }}' ? 'ring-2 ring-green-500 bg-green-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-3 sm:p-4 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-start gap-3">
                                        <div class="w-4 h-4 rounded-full mt-1" style="background-color: {{ $goal->category->color }}"></div>
                                        <div class="flex-1">
                                            <h3 class="text-white font-medium text-sm sm:text-base">{{ $goal->title }}</h3>
                                            <p class="text-gray-400 text-xs sm:text-sm">{{ $goal->category->name }}</p>
                                            @if($goal->isFinished())
                                                <p class="text-red-400 text-xs mt-1"><i class="fas fa-lock"></i> Goal Finished</p>
                                            @elseif($goal->isCompleted())
                                                <p class="text-blue-400 text-xs mt-1"><i class="fas fa-check-circle"></i> Goal Completed (100%)</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-white transition-colors duration-300 text-sm sm:text-base">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" 
                                        :disabled="!formData.goal_id" 
                                        class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Priority -->
                    <div x-show="currentStep === 4" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">How urgent is this task?</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Set the priority level for this task</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <div class="space-y-3 sm:space-y-4">
                                <div @click="selectPriority('low')" 
                                     :class="formData.priority === 'low' ? 'ring-2 ring-green-500 bg-green-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-4 sm:p-6 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 sm:gap-4">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-leaf text-white text-sm sm:text-base"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-bold text-base sm:text-lg">Low Priority</h3>
                                                <p class="text-gray-300 text-sm">Can be done later</p>
                                            </div>
                                        </div>
                                        <i x-show="formData.priority === 'low'" class="fas fa-check text-green-500 text-lg sm:text-xl"></i>
                                    </div>
                                </div>
                                
                                <div @click="selectPriority('medium')" 
                                     :class="formData.priority === 'medium' ? 'ring-2 ring-yellow-500 bg-yellow-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-4 sm:p-6 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 sm:gap-4">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-clock text-white text-sm sm:text-base"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-bold text-base sm:text-lg">Medium Priority</h3>
                                                <p class="text-gray-300 text-sm">Should be done soon</p>
                                            </div>
                                        </div>
                                        <i x-show="formData.priority === 'medium'" class="fas fa-check text-yellow-500 text-lg sm:text-xl"></i>
                                    </div>
                                </div>
                                
                                <div @click="selectPriority('high')" 
                                     :class="formData.priority === 'high' ? 'ring-2 ring-red-500 bg-red-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-4 sm:p-6 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3 sm:gap-4">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-fire text-white text-sm sm:text-base"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-bold text-base sm:text-lg">High Priority</h3>
                                                <p class="text-gray-300 text-sm">Needs immediate attention</p>
                                            </div>
                                        </div>
                                        <i x-show="formData.priority === 'high'" class="fas fa-check text-red-500 text-lg sm:text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-white transition-colors duration-300 text-sm sm:text-base">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" 
                                        :disabled="!formData.priority" 
                                        class="bg-gradient-to-r from-yellow-500 to-yellow-700 hover:from-yellow-600 hover:to-yellow-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Due Date -->
                    <div x-show="currentStep === 5" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-alt text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">When is this due?</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Set a deadline for this task</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <div class="bg-gray-700 border-2 border-gray-600 rounded-xl p-4 sm:p-6">
                                <label class="block text-purple-200 font-medium mb-4 text-center text-sm sm:text-base">Due Date</label>
                                <input type="date" 
                                       x-model="formData.due_date" 
                                       class="w-full bg-gray-600 border-2 border-gray-500 text-white text-base sm:text-lg px-4 py-3 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300 text-center">
                            </div>
                            
                            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-white transition-colors duration-300 text-sm sm:text-base">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="submitForm()" 
                                        class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    <i class="fas fa-plus-circle mr-2"></i> Create Task
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
             x-transition:enter-end="opacity-100 transform scale-100">
            
            <div class="bg-gray-800 rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden border border-pink-500/10">
                <div class="p-4 sm:p-6 lg:p-8">
                    <h1 class="text-3xl sm:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-2">Create a New Task</h1>
                    <p class="text-gray-300 mb-6 sm:mb-8 text-sm sm:text-base">Break down your goals into actionable steps.</p>
                    
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="bg-pink-100 border-l-4 border-pink-500 text-pink-800 p-4 mb-6 rounded-xl" role="alert">
                                <p class="font-bold">Please fix the errors below:</p>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @if($errors->has('goal_id'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-xl" role="alert">
                                <p class="font-bold">Goal Error:</p>
                                <p class="text-sm">{{ $errors->first('goal_id') }}</p>
                            </div>
                        @endif
                        
                        <div class="space-y-4 sm:space-y-6">
                            <div>
                                <label for="title" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Task Title</label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="e.g., Set up project repository" 
                                       class="w-full border-gray-300 bg-transparent text-white text-base sm:text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                       required>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4" 
                                          placeholder="Add more details about the task." 
                                          class="w-full border-gray-300 bg-transparent text-white text-base sm:text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label for="goal_id" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Related Goal</label>
                                <select name="goal_id" 
                                        id="goal_id" 
                                        class="w-full border-gray-300 bg-transparent text-white text-base sm:text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                        required>
                                    <option value="">Select a goal</option>
                                    @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}" {{ (old('goal_id') == $goal->id || request('goal_id') == $goal->id) ? 'selected' : '' }}>
                                            {{ $goal->title }} ({{ $goal->category->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <label for="due_date" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Due Date</label>
                                    <input type="date" 
                                           name="due_date" 
                                           id="due_date" 
                                           value="{{ old('due_date') ?? date('Y-m-d') }}" 
                                           class="w-full border-gray-300 bg-transparent text-white text-base sm:text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                                </div>
                                
                                <div>
                                    <label for="priority" class="block text-pink-200 font-medium mb-2 text-sm sm:text-base">Priority</label>
                                    <select name="priority" 
                                            id="priority" 
                                            class="w-full border-gray-300 bg-transparent text-white text-base sm:text-lg px-4 py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6 sm:mt-8">
                            <button type="submit" 
                                    class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-3 px-6 sm:px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-2 text-sm sm:text-base">
                                <i class="fas fa-plus-circle mr-2"></i> Create Task
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
        
        init() {
            // Ensure proper initialization
            console.log('Task wizard initialized');
            this.isWizardMode = true;
            this.currentStep = 1;
            
            // Force re-evaluation after Alpine is ready
            this.$nextTick(() => {
                console.log('Task wizard ready, isWizardMode:', this.isWizardMode);
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
        
        selectGoal(goalId) {
            console.log('Goal selected:', goalId);
            this.formData.goal_id = goalId;
        },
        
        selectPriority(priority) {
            console.log('Priority selected:', priority);
            this.formData.priority = priority;
        },
        
        submitForm() {
            console.log('Submitting form with data:', this.formData);
            
            // Create a temporary form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('tasks.store') }}';
            
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
                goal_id: this.formData.goal_id,
                priority: this.formData.priority,
                due_date: this.formData.due_date
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
window.taskWizard = taskWizard;

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
@endpush