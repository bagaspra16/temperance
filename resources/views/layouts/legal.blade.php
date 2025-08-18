<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Temperance') }} - @yield('title', 'Legal')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            position: relative;
        }
        .animated-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(-45deg, #0a0a0a, #1a1a1a, #0f0f0f, #000000);
            background-size: 400% 400%;
            animation: gradientShift 20s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .bubble { position: fixed; border-radius: 50%; background: radial-gradient(circle at 30% 30%, rgba(236, 72, 153, 0.6), rgba(219, 39, 119, 0.3)); box-shadow: 0 0 20px rgba(236, 72, 153, 0.4); animation: elegantFloat 60s ease-in-out infinite; opacity: 0.8; }
        .bubble:nth-child(1) { width: 60px; height: 60px; left: 15%; top: 20%; animation-delay: 0s; animation-duration: 22s; }
        .bubble:nth-child(2) { width: 80px; height: 80px; left: 85%; top: 15%; animation-delay: 3s; animation-duration: 25s; }
        .bubble:nth-child(3) { width: 45px; height: 45px; left: 25%; top: 65%; animation-delay: 6s; animation-duration: 20s; }
        .bubble:nth-child(4) { width: 70px; height: 70px; left: 70%; top: 45%; animation-delay: 9s; animation-duration: 28s; }
        .bubble:nth-child(5) { width: 55px; height: 55px; left: 45%; top: 80%; animation-delay: 12s; animation-duration: 21s; }
        .bubble:nth-child(6) { width: 65px; height: 65px; left: 5%; top: 40%; animation-delay: 15s; animation-duration: 24s; }
        .bubble:nth-child(7) { width: 50px; height: 50px; left: 60%; top: 70%; animation-delay: 7s; animation-duration: 23s; }
        .bubble:nth-child(8) { width: 40px; height: 40px; left: 80%; top: 80%; animation-delay: 4s; animation-duration: 20s; }
        .bubble:nth-child(9) { width: 35px; height: 35px; left: 35%; top: 30%; animation-delay: 10s; animation-duration: 22s; }
        .bubble:nth-child(10) { width: 75px; height: 75px; left: 55%; top: 10%; animation-delay: 2s; animation-duration: 27s; }
        .glow-effect { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.1) 0%, transparent 70%); pointer-events: none; z-index: -1; }
        .underwater-distortion { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 20% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(219, 39, 119, 0.1) 0%, transparent 50%); pointer-events: none; z-index: -1; animation: distortionWave 8s ease-in-out infinite; }
        @keyframes distortionWave { 0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.3; } 50% { transform: scale(1.02) rotate(1deg); opacity: 0.5; } }
        @keyframes elegantFloat { 0%, 100% { transform: translateY(0px) rotate(0deg); } 25% { transform: translateY(-20px) rotate(1deg); } 50% { transform: translateY(-10px) rotate(-1deg); } 75% { transform: translateY(-15px) rotate(0.5deg); } }
        .animate-fadein { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <!-- Animated Background -->
    <div class="animated-background"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="glow-effect"></div>
    <div class="underwater-distortion"></div>

    <!-- Navigation Header -->
    <nav class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('register') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-leaf text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent">
                            Temperance
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('legal.terms') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                        Terms of Service
                    </a>
                    <a href="{{ route('legal.privacy') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                        Privacy Policy
                    </a>
                    <a href="{{ route('legal.contact') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                        Contact Us
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105">
                        Sign Up
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="relative w-8 h-8 flex flex-col justify-center items-center text-gray-300 hover:text-white focus:outline-none focus:text-white transition-colors duration-200" onclick="toggleMobileMenu()" id="mobileMenuBtn">
                        <span class="w-6 h-0.5 bg-current" id="hamburger-line-1"></span>
                        <span class="w-6 h-0.5 bg-current mt-1.5" id="hamburger-line-2"></span>
                        <span class="w-6 h-0.5 bg-current mt-1.5" id="hamburger-line-3"></span>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobileMenu" class="hidden md:hidden border-t border-gray-700 transform transition-all duration-300 ease-in-out">
                <div class="px-4 py-6 space-y-4">
                    <!-- Legal Pages Section -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Legal Pages</h4>
                        <a href="{{ route('legal.terms') }}" class="flex items-center px-3 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-200 group">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-600 transition-colors duration-200">
                                <i class="fas fa-file-contract text-white text-sm"></i>
                            </div>
                            <span class="font-medium">Terms of Service</span>
                            <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-white transition-colors duration-200"></i>
                        </a>
                        <a href="{{ route('legal.privacy') }}" class="flex items-center px-3 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-200 group">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-600 transition-colors duration-200">
                                <i class="fas fa-shield-alt text-white text-sm"></i>
                            </div>
                            <span class="font-medium">Privacy Policy</span>
                            <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-white transition-colors duration-200"></i>
                        </a>
                        <a href="{{ route('legal.contact') }}" class="flex items-center px-3 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-200 group">
                            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-600 transition-colors duration-200">
                                <i class="fas fa-envelope text-white text-sm"></i>
                            </div>
                            <span class="font-medium">Contact Us</span>
                            <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-white transition-colors duration-200"></i>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-700 my-4"></div>

                    <!-- Auth Section -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Account</h4>
                        <a href="{{ route('login') }}" class="flex items-center px-3 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-200 group">
                            <div class="w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center mr-3 group-hover:bg-gray-500 transition-colors duration-200">
                                <i class="fas fa-sign-in-alt text-white text-sm"></i>
                            </div>
                            <span class="font-medium">Login</span>
                            <i class="fas fa-chevron-right text-gray-400 ml-auto group-hover:text-white transition-colors duration-200"></i>
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center px-3 py-3 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg transition-all duration-200 group hover:from-pink-600 hover:to-pink-700">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user-plus text-white text-sm"></i>
                            </div>
                            <span class="font-medium">Sign Up</span>
                            <i class="fas fa-chevron-right text-white ml-auto"></i>
                        </a>
                    </div>

                    <!-- Contact Info -->
                    <div class="border-t border-gray-700 pt-4 mt-4">
                        <div class="px-3 py-3 bg-gray-700 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-headset text-pink-500 mr-2"></i>
                                <span class="text-sm font-medium text-white">Need Help?</span>
                            </div>
                            <p class="text-xs text-gray-300 mb-2">Contact our support team</p>
                            <a href="mailto:support-temperance@gmail.com" class="text-xs text-pink-400 hover:text-pink-300 transition-colors duration-200">
                                support-temperance@gmail.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border-t border-gray-700 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-leaf text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent">
                            Temperance
                        </span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Your personal productivity companion. Track goals, manage tasks, and achieve more with our comprehensive productivity platform.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors duration-200">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors duration-200">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors duration-200">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('legal.terms') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Terms of Service</a></li>
                        <li><a href="{{ route('legal.privacy') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="{{ route('legal.contact') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Contact Us</a></li>                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('legal.contact') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Help Center</a></li>
                        <li><a href="mailto:support-temperance@gmail.com" class="text-gray-400 hover:text-white transition-colors duration-200">Email Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Temperance. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const body = document.body;
            
            // Toggle menu visibility
            menu.classList.toggle('hidden');
            
            // Toggle scroll lock
            if (menu.classList.contains('hidden')) {
                // Enable scrolling
                body.style.overflow = '';
                body.style.position = '';
            } else {
                // Disable scrolling
                body.style.overflow = 'hidden';
                body.style.position = 'fixed';
                body.style.width = '100%';
            }
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const btn = document.getElementById('mobileMenuBtn');
            
            if (!menu.contains(event.target) && !btn.contains(event.target) && !menu.classList.contains('hidden')) {
                toggleMobileMenu();
            }
        });

        // Close menu on window resize
        window.addEventListener('resize', function() {
            const menu = document.getElementById('mobileMenu');
            const body = document.body;
            if (window.innerWidth >= 768 && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                body.style.overflow = '';
                body.style.position = '';
                body.style.width = '';
            }
        });
    </script>
</body>
</html> 