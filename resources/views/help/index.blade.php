@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Main Content -->
    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl pb-8">
            
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full">
                        <i class="fas fa-question-circle text-3xl text-white"></i>
                    </div>
                </div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-4">
                    Help & Support Center
                </h1>
                <p class="text-xl text-gray-300 mb-8">
                    Find the help you need to use Temperance optimally
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" 
                               id="searchHelp" 
                               placeholder="Search for help..." 
                               class="w-full px-6 py-4 pl-12 text-gray-900 bg-white rounded-xl shadow-lg focus:ring-4 focus:ring-pink-300 focus:outline-none transition-all duration-300 border border-gray-300">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <div id="searchResults" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-xl z-50 hidden border border-gray-200">
                            <div class="p-4">
                                <div id="searchResultsContent" class="text-left">
                                    <!-- Search results will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-6 text-center">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 cursor-pointer group" onclick="scrollToSection('getting-started')">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-rocket text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Getting Started</h3>
                        <p class="text-gray-400 text-sm">Complete guide to start using Temperance</p>
                    </div>

                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 cursor-pointer group" onclick="scrollToSection('features')">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-star text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Features Guide</h3>
                        <p class="text-gray-400 text-sm">Learn all available features in the application</p>
                    </div>

                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 cursor-pointer group" onclick="scrollToSection('faq')">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-question text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">FAQ</h3>
                        <p class="text-gray-400 text-sm">Frequently asked questions</p>
                    </div>

                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 cursor-pointer group" onclick="scrollToSection('contact')">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Contact Us</h3>
                        <p class="text-gray-400 text-sm">Contact our support team</p>
                    </div>
                </div>
            </div>

            <!-- Getting Started Section -->
            <div id="getting-started" class="mb-12 help-section">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-4">Getting Started</h2>
                    <p class="text-gray-400 text-lg">Complete guide to start your productivity journey</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-gray-800 rounded-xl p-8 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="category create start organize">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold">1</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Create Categories</h3>
                        </div>
                        <p class="text-gray-400 mb-4">Start by creating categories to organize your goals and tasks. Categories help you group activities based on life areas or projects.</p>
                        <div class="bg-gray-700 rounded-lg p-4">
                            <h4 class="text-white font-medium mb-2">Tips:</h4>
                            <ul class="text-gray-300 text-sm space-y-1">
                                <li>• Use clear and descriptive names</li>
                                <li>• Choose different colors for each category</li>
                                <li>• Examples: "Health", "Career", "Education"</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-gray-800 rounded-xl p-8 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="goals objectives set define priority">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold">2</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Set Goals</h3>
                        </div>
                        <p class="text-gray-400 mb-4">Define specific objectives you want to achieve. Goals provide direction and motivation to reach desired outcomes.</p>
                        <div class="bg-gray-700 rounded-lg p-4">
                            <h4 class="text-white font-medium mb-2">Tips:</h4>
                            <ul class="text-gray-300 text-sm space-y-1">
                                <li>• Use SMART method (Specific, Measurable, Achievable)</li>
                                <li>• Set realistic deadlines</li>
                                <li>• Choose appropriate priorities</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-gray-800 rounded-xl p-8 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="tasks create time tracking">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold">3</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Create Tasks</h3>
                        </div>
                        <p class="text-gray-400 mb-4">Break down goals into smaller, manageable tasks. Tasks help you track progress in detail.</p>
                        <div class="bg-gray-700 rounded-lg p-4">
                            <h4 class="text-white font-medium mb-2">Tips:</h4>
                            <ul class="text-gray-300 text-sm space-y-1">
                                <li>• Create specific and measurable tasks</li>
                                <li>• Set realistic time estimates</li>
                                <li>• Use time tracking features</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-gray-800 rounded-xl p-8 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="progress monitor track advancement">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold">4</span>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Monitor Progress</h3>
                        </div>
                        <p class="text-gray-400 mb-4">Monitor your progress through dashboard and reports. Progress tracking helps you stay motivated and identify areas for improvement.</p>
                        <div class="bg-gray-700 rounded-lg p-4">
                            <h4 class="text-white font-medium mb-2">Tips:</h4>
                            <ul class="text-gray-300 text-sm space-y-1">
                                <li>• Review progress regularly</li>
                                <li>• Use journal features for reflection</li>
                                <li>• Celebrate small achievements</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Guide Section -->
            <div id="features" class="mb-12 help-section">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-4">Features Guide</h2>
                    <p class="text-gray-400 text-lg">Explore all available features in Temperance</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Categories -->
                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="categories organize filter">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-tags text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Categories</h3>
                        <p class="text-gray-400 text-sm mb-4">Organize goals and tasks with customizable categories.</p>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li>• Customize colors and names</li>
                            <li>• Filter by category</li>
                            <li>• Statistics per category</li>
                        </ul>
                    </div>

                    <!-- Goals -->
                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="goals objectives priority deadline">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-bullseye text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Goals</h3>
                        <p class="text-gray-400 text-sm mb-4">Set and manage long-term objectives with priority system.</p>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li>• Priority system (Low, Medium, High)</li>
                            <li>• Deadline tracking</li>
                            <li>• Progress visualization</li>
                        </ul>
                    </div>

                    <!-- Tasks -->
                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="tasks time tracking status">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-tasks text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Tasks</h3>
                        <p class="text-gray-400 text-sm mb-4">Manage daily tasks with time tracking and status management.</p>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li>• Automatic time tracking</li>
                            <li>• Status management</li>
                            <li>• Deadline reminders</li>
                        </ul>
                    </div>

                    <!-- Progress -->
                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="progress chart analytics">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Progress</h3>
                        <p class="text-gray-400 text-sm mb-4">Monitor progress with informative data visualization.</p>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li>• Progress charts</li>
                            <li>• Time analytics</li>
                            <li>• Performance insights</li>
                        </ul>
                    </div>

                    <!-- Journals -->
                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="journals jurnal refleksi mood ai">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-book-open text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Journals</h3>
                        <p class="text-gray-400 text-sm mb-4">Record reflections and insights for personal growth.</p>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li>• Rich text editor</li>
                            <li>• Mood tracking</li>
                            <li>• AI-powered insights</li>
                        </ul>
                    </div>

                    <!-- Achievements -->
                    <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 help-item" data-keywords="achievements pencapaian badges gamification">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-trophy text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Achievements</h3>
                        <p class="text-gray-400 text-sm mb-4">Celebrate achievements with gamification system.</p>
                        <ul class="text-gray-300 text-sm space-y-2">
                            <li>• Achievement badges</li>
                            <li>• Progress milestones</li>
                            <li>• Motivation system</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div id="faq" class="mb-12 help-section">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-4">Frequently Asked Questions</h2>
                    <p class="text-gray-400 text-lg">Find answers to commonly asked questions</p>
                </div>

                <div class="max-w-4xl mx-auto space-y-6">
                    <!-- FAQ Item 1 -->
                    <div class="bg-gray-800 rounded-xl overflow-hidden help-item" data-keywords="time tracking timer otomatis">
                        <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-700 transition-colors duration-300" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-white">How to use time tracking?</h3>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                        </button>
                        <div class="px-6 pb-4 hidden">
                            <p class="text-gray-400">Time tracking in Temperance works automatically. When you start a task, the timer will run automatically. You can stop the timer anytime by clicking the stop button. Time spent will be saved and can be viewed on the Progress page.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="bg-gray-800 rounded-xl overflow-hidden help-item" data-keywords="data aman keamanan enkripsi">
                        <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-700 transition-colors duration-300" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-white">Is my data secure?</h3>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                        </button>
                        <div class="px-6 pb-4 hidden">
                            <p class="text-gray-400">Yes, your data is very secure. Temperance uses end-to-end encryption and follows the highest security standards. Your data can only be accessed by you and will not be shared with third parties.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="bg-gray-800 rounded-xl overflow-hidden help-item" data-keywords="prioritas goals high medium low">
                        <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-700 transition-colors duration-300" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-white">How to set goal priorities?</h3>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                        </button>
                        <div class="px-6 pb-4 hidden">
                            <p class="text-gray-400">When creating or editing a goal, you can select priority from the dropdown menu. Available options are Low, Medium, and High. These priorities will help you focus on the most important goals.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="bg-gray-800 rounded-xl overflow-hidden help-item" data-keywords="batasan jumlah goals tasks limit">
                        <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-700 transition-colors duration-300" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-white">Is there a limit on the number of goals or tasks?</h3>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                        </button>
                        <div class="px-6 pb-4 hidden">
                            <p class="text-gray-400">There is no limit on the number of goals or tasks you can create. However, we recommend not creating too many goals at once to stay focused and achieve optimal results.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="bg-gray-800 rounded-xl overflow-hidden help-item" data-keywords="journal jurnal refleksi mood">
                        <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-700 transition-colors duration-300" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-white">How to use the Journal feature?</h3>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                        </button>
                        <div class="px-6 pb-4 hidden">
                            <p class="text-gray-400">The Journal feature allows you to record daily reflections, insights, and feelings. You can write with a rich text editor, track mood, and get AI insights to help with your personal growth.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 6 -->
                    <div class="bg-gray-800 rounded-xl overflow-hidden help-item" data-keywords="achievements badges milestone motivasi">
                        <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-700 transition-colors duration-300" onclick="toggleFAQ(this)">
                            <h3 class="text-lg font-semibold text-white">How to earn achievements?</h3>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                        </button>
                        <div class="px-6 pb-4 hidden">
                            <p class="text-gray-400">Achievements are automatically awarded when you reach certain milestones, such as completing a number of tasks, achieving goals, or using the application consistently. This system is designed to motivate you to stay productive.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div id="contact" class="mb-12 help-section">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent drop-shadow mb-4">Contact Us</h2>
                    <p class="text-gray-400 text-lg">Need further assistance? Contact our support team</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Contact Info -->
                    <div class="bg-gray-800 rounded-xl p-8">
                        <h3 class="text-2xl font-semibold text-white mb-6">Get in Touch</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium">Email Support</h4>
                                    <p class="text-gray-400">support-temperance@gmail.com</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium">Response Time</h4>
                                    <p class="text-gray-400">Within 24 hours</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-globe text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium">Website</h4>
                                    <p class="text-gray-400">www.temperance.com</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 p-6 bg-gray-700 rounded-lg">
                            <h4 class="text-white font-medium mb-3">Support Hours</h4>
                            <p class="text-gray-400 text-sm">
                                Monday - Friday: 9:00 AM - 6:00 PM (WIB)<br>
                                Saturday: 9:00 AM - 2:00 PM (WIB)<br>
                                Sunday: Closed
                            </p>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-gray-800 rounded-xl p-8">
                        <h3 class="text-2xl font-semibold text-white mb-6">Send us a Message</h3>
                        
                        <form class="space-y-6" id="contactForm">
                            <div>
                                <label class="block text-white font-medium mb-2">Name</label>
                                <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-white font-medium mb-2">Email</label>
                                <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-white font-medium mb-2">Subject</label>
                                <select name="subject" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                    <option value="">Select a subject</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Technical Support">Technical Support</option>
                                    <option value="Feature Request">Feature Request</option>
                                    <option value="Bug Report">Bug Report</option>
                                    <option value="Account Issues">Account Issues</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-white font-medium mb-2">Message</label>
                                <textarea name="message" rows="4" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Describe your issue or question..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Additional Resources -->
            <!-- <div class="text-center">
                <h2 class="text-2xl font-bold text-white mb-6">Additional Resources</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="#" class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-video text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Video Tutorials</h3>
                        <p class="text-gray-400 text-sm">Learn how to use Temperance features through video tutorials</p>
                    </a>

                    <a href="#" class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">User Guide</h3>
                        <p class="text-gray-400 text-sm">Complete application usage guide in PDF format</p>
                    </a>

                    <a href="#" class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">Community</h3>
                        <p class="text-gray-400 text-sm">Join the Temperance user community</p>
                    </a>
                </div>
            </div> -->
        </div>
    </div>
</div>



<script>
// Enhanced search functionality with smooth highlighting
let searchTimeout;
const searchInput = document.getElementById('searchHelp');
const searchResults = document.getElementById('searchResults');
const searchResultsContent = document.getElementById('searchResultsContent');

searchInput.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const searchTerm = e.target.value.toLowerCase();
    

    
    searchTimeout = setTimeout(() => {
        if (searchTerm.length < 2) {
            searchResults.classList.add('hidden');
            resetAllItems();
            return;
        }
        
        performSmoothSearch(searchTerm);
    }, 300);
});

// Hide search results when clicking outside
document.addEventListener('click', function(e) {
    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
        searchResults.classList.add('hidden');
    }
});

function performSmoothSearch(searchTerm) {
    const helpItems = document.querySelectorAll('.help-item');
    const results = [];
    
    helpItems.forEach(item => {
        const keywords = item.getAttribute('data-keywords') || '';
        const text = item.textContent.toLowerCase();
        const title = item.querySelector('h3')?.textContent.toLowerCase() || '';
        
        if (text.includes(searchTerm) || keywords.includes(searchTerm) || title.includes(searchTerm)) {
            results.push({
                element: item,
                title: title,
                relevance: calculateRelevance(searchTerm, text, keywords, title)
            });
        }
    });
    
    // Sort by relevance
    results.sort((a, b) => b.relevance - a.relevance);
    
    if (results.length > 0) {
        displaySearchResults(results.slice(0, 5), searchTerm);
        highlightMatchingItems(results);
    } else {
        searchResults.classList.add('hidden');
        resetAllItems();
    }
}

function calculateRelevance(searchTerm, text, keywords, title) {
    let relevance = 0;
    
    // Title match gets highest priority
    if (title.includes(searchTerm)) relevance += 10;
    
    // Keywords match gets high priority
    if (keywords.includes(searchTerm)) relevance += 8;
    
    // Text content match
    if (text.includes(searchTerm)) relevance += 5;
    
    // Exact word match gets bonus
    const words = searchTerm.split(' ');
    words.forEach(word => {
        if (text.includes(word)) relevance += 2;
    });
    
    return relevance;
}

function displaySearchResults(results, searchTerm) {
    searchResultsContent.innerHTML = '';
    
    results.forEach(result => {
        const resultItem = document.createElement('div');
        resultItem.className = 'p-3 hover:bg-gray-100 rounded cursor-pointer transition-colors duration-200';
        resultItem.innerHTML = `
            <div class="font-medium text-gray-900">${highlightText(result.title, searchTerm)}</div>
            <div class="text-sm text-gray-600 mt-1">Click to view details</div>
        `;
        
        resultItem.addEventListener('click', () => {
            smoothScrollToElement(result.element);
            searchResults.classList.add('hidden');
            searchInput.value = '';
        });
        
        searchResultsContent.appendChild(resultItem);
    });
    
    searchResults.classList.remove('hidden');
}

function highlightText(text, searchTerm) {
    if (!searchTerm) return text;
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    return text.replace(regex, '<mark class="bg-pink-200 px-1 rounded text-pink-800">$1</mark>');
}

function highlightMatchingItems(results) {
    // First, reset all items to normal state
    resetAllItems();
    
    // Then highlight matching results with subtle animation
    results.forEach((result, index) => {
        setTimeout(() => {
            const element = result.element;
            element.style.transition = 'all 0.3s ease';
            element.style.transform = 'scale(1.01)';
            element.style.boxShadow = '0 4px 12px rgba(236, 72, 153, 0.2)';
            element.style.border = '1px solid rgba(236, 72, 153, 0.3)';
        }, index * 100);
    });
}

function resetAllItems() {
    document.querySelectorAll('.help-item').forEach(item => {
        item.style.transition = 'all 0.3s ease';
        item.style.transform = 'scale(1)';
        item.style.boxShadow = '';
        item.style.border = '';
        item.style.backgroundColor = '';
        item.style.position = '';
        item.style.zIndex = '';
        item.style.animation = '';
    });
}

function smoothScrollToElement(element) {
    // Add a brief highlight effect before scrolling
    element.style.transition = 'all 0.3s ease';
    element.style.boxShadow = '0 0 20px rgba(236, 72, 153, 0.4)';
    element.style.transform = 'scale(1.02)';
    
    setTimeout(() => {
        element.scrollIntoView({ 
            behavior: 'smooth',
            block: 'center'
        });
        
        // Remove highlight effect after scrolling
        setTimeout(() => {
            element.style.boxShadow = '';
            element.style.transform = 'scale(1)';
        }, 2000);
    }, 300);
}



// FAQ toggle functionality
function toggleFAQ(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Smooth scroll to sections
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

// Contact form handling
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show success message
    Swal.fire({
        title: 'Message Sent!',
        text: 'Thank you for contacting us. We will get back to you within 24 hours.',
        icon: 'success',
        confirmButtonText: 'OK',
        background: 'linear-gradient(to top right, #374151, #1f2937)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-green-400',
            htmlContainer: 'text-lg text-gray-300',
            confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
        },
        buttonsStyling: false
    });
    
    // Reset form
    this.reset();
});

// Add loading animation for page transitions
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in animation to sections
    const sections = document.querySelectorAll('.help-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            section.style.transition = 'all 0.6s ease-out';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Add hover effects to help items
    document.querySelectorAll('.help-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endsection 