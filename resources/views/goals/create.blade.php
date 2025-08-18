@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="goalWizard()" x-init="init()">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('goals.index') }}" 
                   class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base"
                   onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                    <i class="fas fa-arrow-left text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Back to Goals</span>
                    <span class="sm:hidden">Back</span>
                </a>
            </div>
            
            <!-- Mode Toggle Button -->
            <div class="flex items-center gap-2">
                <button @click="toggleMode()" 
                        data-toggle-mode
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
                    <!-- Step 1: Goal Title -->
                    <div x-show="currentStep === 1" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-4 sm:mb-6 md:mb-8">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-gradient-to-br from-pink-500 to-pink-700 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                <i class="fas fa-bullseye text-lg sm:text-xl md:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-1 sm:mb-2">What's your goal?</h2>
                            <p class="text-gray-300 text-xs sm:text-sm md:text-base">Let's start with the basics. What do you want to achieve?</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <input type="text" 
                                   x-model="formData.title" 
                                   placeholder="e.g., Learn Laravel from scratch" 
                                   class="w-full bg-gray-700 border-2 border-gray-600 text-white text-base sm:text-lg md:text-xl px-3 sm:px-4 md:px-6 py-2.5 sm:py-3 md:py-4 rounded-xl shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition-all duration-300 text-center">
                            
                            <div class="mt-3 sm:mt-4 md:mt-6 text-center">
                                <button @click="nextStep()" 
                                        :disabled="!formData.title.trim()" 
                                        class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-2 sm:py-2.5 md:py-3 px-4 sm:px-6 md:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-xs sm:text-sm md:text-base">
                                    Continue <i class="fas fa-arrow-right ml-1 sm:ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Description -->
                    <div x-show="currentStep === 2" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-4 sm:mb-6 md:mb-8">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                <i class="fas fa-align-left text-lg sm:text-xl md:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-1 sm:mb-2">Tell us more about it</h2>
                            <p class="text-gray-300 text-xs sm:text-sm md:text-base">Describe what you want to accomplish in detail</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <textarea x-model="formData.description" 
                                      rows="4" 
                                      placeholder="What exactly do you want to achieve? What's your motivation?" 
                                      class="w-full bg-gray-700 border-2 border-gray-600 text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 md:px-6 py-2.5 sm:py-3 md:py-4 rounded-xl shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-300 resize-none"></textarea>
                            
                            <div class="mt-3 sm:mt-4 md:mt-6 flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-white transition-colors duration-300 text-xs sm:text-sm md:text-base">
                                    <i class="fas fa-arrow-left mr-1 sm:mr-2"></i> Back
                                </button>
                                <button @click="nextStep()" 
                                        class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 sm:py-2.5 md:py-3 px-4 sm:px-6 md:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-xs sm:text-sm md:text-base">
                                    Continue <i class="fas fa-arrow-right ml-1 sm:ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Category -->
                    <div x-show="currentStep === 3" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-folder text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Choose a category</h2>
                            <p class="text-gray-300 text-sm sm:text-base">Where does this goal belong?</p>
                        </div>
                        
                        <div class="max-w-3xl mx-auto">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                                @foreach($categories as $category)
                                <div @click="selectCategory('{{ $category->id }}')" 
                                     :class="formData.category_id === '{{ $category->id }}' ? 'ring-2 ring-green-500 bg-green-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-3 sm:p-4 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-white font-medium text-sm sm:text-base">{{ $category->name }}</span>
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
                                        :disabled="!formData.category_id" 
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
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-flag text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Set priority level</h2>
                            <p class="text-gray-300 text-sm sm:text-base">How important is this goal to you?</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <div class="space-y-3 sm:space-y-4">
                                <div @click="selectPriority('low')" 
                                     :class="formData.priority === 'low' ? 'ring-2 ring-green-500 bg-green-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-3 sm:p-4 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
                                            <i class="fas fa-flag text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-white font-semibold text-sm sm:text-base">Low Priority</h3>
                                            <p class="text-gray-400 text-xs sm:text-sm">Nice to have, but not urgent</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div @click="selectPriority('medium')" 
                                     :class="formData.priority === 'medium' ? 'ring-2 ring-yellow-500 bg-yellow-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-3 sm:p-4 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full bg-yellow-500 flex items-center justify-center">
                                            <i class="fas fa-flag text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-white font-semibold text-sm sm:text-base">Medium Priority</h3>
                                            <p class="text-gray-400 text-xs sm:text-sm">Important and should be done soon</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div @click="selectPriority('high')" 
                                     :class="formData.priority === 'high' ? 'ring-2 ring-red-500 bg-red-500/10' : 'hover:bg-gray-700'"
                                     class="bg-gray-700 border-2 border-gray-600 rounded-xl p-3 sm:p-4 cursor-pointer transition-all duration-300 transform hover:scale-105">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full bg-red-500 flex items-center justify-center">
                                            <i class="fas fa-flag text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-white font-semibold text-sm sm:text-base">High Priority</h3>
                                            <p class="text-gray-400 text-xs sm:text-sm">Critical and needs immediate attention</p>
                                        </div>
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
                                        class="bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    Continue <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Timeline -->
                    <div x-show="currentStep === 5" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-x-4" 
                         x-transition:enter-end="opacity-100 transform translate-x-0">
                        
                        <div class="text-center mb-6 sm:mb-8">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-alt text-xl sm:text-2xl text-white"></i>
                            </div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Set your timeline</h2>
                            <p class="text-gray-300 text-sm sm:text-base">When do you want to achieve this goal?</p>
                        </div>
                        
                        <div class="max-w-2xl mx-auto">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-300 font-medium mb-2 text-sm sm:text-base">Start Date</label>
                                    <input type="date" 
                                           x-model="formData.start_date" 
                                           value="{{ date('Y-m-d') }}"
                                           @change="updateEndDateMin()"
                                           class="w-full bg-gray-700 border-2 border-gray-600 text-white px-4 py-3 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300">
                                </div>
                                
                                <div>
                                    <label class="block text-gray-300 font-medium mb-2 text-sm sm:text-base">End Date</label>
                                    <input type="date" 
                                           x-model="formData.end_date" 
                                           :min="formData.start_date"
                                           class="w-full bg-gray-700 border-2 border-gray-600 text-white px-4 py-3 rounded-xl shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transition-all duration-300">
                                </div>
                            </div>
                            
                            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <button @click="prevStep()" 
                                        class="text-gray-400 hover:text-white transition-colors duration-300 text-sm sm:text-base">
                                    <i class="fas fa-arrow-left mr-2"></i> Back
                                </button>
                                <button @click="submitForm()" 
                                        class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                                    <i class="fas fa-plus-circle mr-2"></i> Create Goal
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
                <div class="p-3 sm:p-4 md:p-6 lg:p-8">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent mb-1 sm:mb-2">Create a New Goal</h1>
                    <p class="text-gray-300 mb-4 sm:mb-6 md:mb-8 text-xs sm:text-sm md:text-base">Set a new goal and start your journey to success.</p>
                    
                    <form action="{{ route('goals.store') }}" method="POST" onsubmit="showLoading('Membuat goal...', 'Mohon tunggu sebentar')">
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
                        
                        <div class="space-y-3 sm:space-y-4 md:space-y-6">
                            <div>
                                <label for="title" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Goal Title</label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}" 
                                       class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                       placeholder="e.g., Learn Laravel from scratch" 
                                       required>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Description</label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="4" 
                                          class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                          placeholder="What exactly do you want to achieve?">{{ old('description') }}</textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                                <div>
                                    <label for="category_id" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Category</label>
                                    <select name="category_id" 
                                            id="category_id" 
                                            class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                            required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="priority" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Priority</label>
                                    <select name="priority" 
                                            id="priority" 
                                            class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" 
                                            required>
                                        <option value="">Select priority</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                                <div>
                                    <label for="start_date" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">Start Date</label>
                                    <input type="date" 
                                           name="start_date" 
                                           id="start_date" 
                                           value="{{ old('start_date', date('Y-m-d')) }}" 
                                           class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                                </div>
                                
                                <div>
                                    <label for="end_date" class="block text-pink-200 font-medium mb-1 sm:mb-2 text-xs sm:text-sm md:text-base">End Date</label>
                                    <input type="date" 
                                           name="end_date" 
                                           id="end_date" 
                                           value="{{ old('end_date') }}" 
                                           min="{{ date('Y-m-d') }}"
                                           class="w-full border-gray-300 bg-transparent text-white text-sm sm:text-base md:text-lg px-3 sm:px-4 py-2.5 sm:py-3 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-4 mt-4 sm:mt-6 md:mt-8">
                            <a href="{{ route('goals.index') }}" 
                               class="text-gray-400 hover:text-white font-semibold transition-colors duration-300 text-xs sm:text-sm md:text-base" 
                               onclick="showLoading('Memuat halaman...', 'Mohon tunggu sebentar')">
                                <i class="fas fa-arrow-left mr-1 sm:mr-2"></i> Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 text-white font-bold py-2 sm:py-2.5 md:py-3 px-4 sm:px-6 md:px-8 rounded-2xl shadow-xl transform hover:scale-105 transition-transform duration-300 flex items-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base">
                                <i class="fas fa-plus-circle"></i> Create Goal
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
        
        init() {
            // Ensure proper initialization
            console.log('Goal wizard initialized');
            this.isWizardMode = true;
            this.currentStep = 1;
            
            // Set default start date to today
            if (!this.formData.start_date) {
                this.formData.start_date = '{{ date('Y-m-d') }}';
            }
            
            // Initialize end date min attribute
            this.$nextTick(() => {
                this.updateEndDateMin();
            });
            
            // Force re-evaluation after Alpine is ready
            this.$nextTick(() => {
                console.log('Goal wizard ready, isWizardMode:', this.isWizardMode);
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
        
        selectCategory(categoryId) {
            console.log('Category selected:', categoryId);
            this.formData.category_id = categoryId;
        },
        
        selectPriority(priority) {
            console.log('Priority selected:', priority);
            this.formData.priority = priority;
        },
        
        updateEndDateMin() {
            // Set minimum end date to start date
            const endDateInput = document.querySelector('[x-model="formData.end_date"]');
            if (endDateInput && this.formData.start_date) {
                endDateInput.min = this.formData.start_date;
            }
        },
        
        submitForm() {
            console.log('Submitting form with data:', this.formData);
            showLoading('Membuat goal...', 'Mohon tunggu sebentar');
            
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
            Object.keys(this.formData).forEach(key => {
                if (this.formData[key]) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = this.formData[key];
                    form.appendChild(input);
                }
            });
            
            document.body.appendChild(form);
            form.submit();
        }
    }
}

// Ensure function is available globally
window.goalWizard = goalWizard;

// Set default start date to today when page loads
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    
    // Set for traditional form
    const traditionalStartDate = document.getElementById('start_date');
    if (traditionalStartDate && !traditionalStartDate.value) {
        traditionalStartDate.value = today;
    }
    
    // Set for wizard form (if not already set by Alpine.js)
    const wizardStartDate = document.querySelector('[x-model="formData.start_date"]');
    if (wizardStartDate && !wizardStartDate.value) {
        wizardStartDate.value = today;
    }
    
    // Set min attribute for end date in traditional form
    const traditionalEndDate = document.getElementById('end_date');
    if (traditionalEndDate) {
        traditionalEndDate.min = today;
    }
    
    // Add event listener to update end date min when start date changes
    if (traditionalStartDate) {
        traditionalStartDate.addEventListener('change', function() {
            if (traditionalEndDate) {
                traditionalEndDate.min = this.value;
            }
        });
    }
});
</script>
@endpush