<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Temperance') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <style>
        /* Animated Background Styles */
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
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Floating Bubbles - Lightweight Effect */
        .bubble {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(236, 72, 153, 0.6), rgba(219, 39, 119, 0.3));
            box-shadow: 0 0 20px rgba(236, 72, 153, 0.4);
            animation: elegantFloat 60s ease-in-out infinite;
            opacity: 0.8;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .bubble {
                box-shadow: 
                    0 0 20px rgba(236, 72, 153, 0.4),
                    inset 0 0 15px rgba(255, 255, 255, 0.2),
                    0 0 30px rgba(236, 72, 153, 0.2);
                filter: blur(0.2px);
                backdrop-filter: blur(0.5px);
            }
        }

        @media (max-width: 480px) {
            .bubble {
                box-shadow: 
                    0 0 15px rgba(236, 72, 153, 0.3),
                    inset 0 0 10px rgba(255, 255, 255, 0.15),
                    0 0 20px rgba(236, 72, 153, 0.15);
                filter: blur(0.1px);
                backdrop-filter: blur(0.3px);
            }
        }

        .bubble:nth-child(1) {
            width: 60px;
            height: 60px;
            left: 15%;
            top: 20%;
            animation-delay: 0s;
            animation-duration: 22s;
        }

        .bubble:nth-child(2) {
            width: 80px;
            height: 80px;
            left: 85%;
            top: 15%;
            animation-delay: 3s;
            animation-duration: 25s;
        }

        .bubble:nth-child(3) {
            width: 45px;
            height: 45px;
            left: 25%;
            top: 65%;
            animation-delay: 6s;
            animation-duration: 20s;
        }

        .bubble:nth-child(4) {
            width: 70px;
            height: 70px;
            left: 70%;
            top: 45%;
            animation-delay: 9s;
            animation-duration: 28s;
        }

        .bubble:nth-child(5) {
            width: 55px;
            height: 55px;
            left: 45%;
            top: 80%;
            animation-delay: 12s;
            animation-duration: 21s;
        }

        .bubble:nth-child(6) {
            width: 65px;
            height: 65px;
            left: 5%;
            top: 40%;
            animation-delay: 15s;
            animation-duration: 24s;
        }

        .bubble:nth-child(7) {
            width: 50px;
            height: 50px;
            left: 60%;
            top: 70%;
            animation-delay: 7s;
            animation-duration: 23s;
        }

        .bubble:nth-child(8) {
            width: 40px;
            height: 40px;
            left: 80%;
            top: 80%;
            animation-delay: 4s;
            animation-duration: 20s;
        }

        .bubble:nth-child(9) {
            width: 35px;
            height: 35px;
            left: 35%;
            top: 30%;
            animation-delay: 10s;
            animation-duration: 22s;
        }

        .bubble:nth-child(10) {
            width: 75px;
            height: 75px;
            left: 55%;
            top: 10%;
            animation-delay: 2s;
            animation-duration: 27s;
        }

        /* Lightweight mobile optimizations */
        @media (max-width: 768px) {
            .bubble {
                opacity: 0.6;
                box-shadow: 0 0 15px rgba(236, 72, 153, 0.3);
            }
        }

        @media (max-width: 480px) {
            .bubble {
                opacity: 0.5;
                box-shadow: 0 0 10px rgba(236, 72, 153, 0.2);
            }
        }

        @keyframes elegantFloat {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
                opacity: 0.85;
            }
            10% {
                transform: translate(30px, -10px) scale(1.08) rotate(36deg);
                opacity: 0.92;
            }
            20% {
                transform: translate(60px, 20px) scale(0.97) rotate(72deg);
                opacity: 0.8;
            }
            30% {
                transform: translate(40px, 60px) scale(1.12) rotate(108deg);
                opacity: 0.95;
            }
            40% {
                transform: translate(-20px, 80px) scale(0.95) rotate(144deg);
                opacity: 0.78;
            }
            50% {
                transform: translate(-60px, 40px) scale(1.15) rotate(180deg);
                opacity: 0.93;
            }
            60% {
                transform: translate(-80px, -20px) scale(1.02) rotate(216deg);
                opacity: 0.85;
            }
            70% {
                transform: translate(-40px, -60px) scale(1.09) rotate(252deg);
                opacity: 0.9;
            }
            80% {
                transform: translate(20px, -80px) scale(0.98) rotate(288deg);
                opacity: 0.82;
            }
            90% {
                transform: translate(60px, -40px) scale(1.06) rotate(324deg);
                opacity: 0.88;
            }
            100% {
                transform: translate(0, 0) scale(1) rotate(360deg);
                opacity: 0.85;
            }
        }

        /* Mobile optimized animations */
        @media (max-width: 768px) {
            @keyframes elegantFloat {
                0% {
                    transform: translate(0, 0) rotate(0deg) scale(1);
                    opacity: 0.9;
                }
                25% {
                    transform: translate(10px, -12px) rotate(90deg) scale(1.03);
                    opacity: 0.95;
                }
                50% {
                    transform: translate(-5px, -24px) rotate(180deg) scale(0.97);
                    opacity: 0.85;
                }
                75% {
                    transform: translate(8px, -36px) rotate(270deg) scale(1.02);
                    opacity: 0.9;
                }
                100% {
                    transform: translate(0, -48px) rotate(360deg) scale(1);
                    opacity: 0.9;
                }
            }
        }

        @media (max-width: 480px) {
            @keyframes elegantFloat {
                0% {
                    transform: translate(0, 0) rotate(0deg) scale(1);
                    opacity: 0.9;
                }
                33% {
                    transform: translate(6px, -8px) rotate(120deg) scale(1.02);
                    opacity: 0.95;
                }
                66% {
                    transform: translate(-3px, -16px) rotate(240deg) scale(0.98);
                    opacity: 0.85;
                }
                100% {
                    transform: translate(0, -24px) rotate(360deg) scale(1);
                    opacity: 0.9;
                }
            }
        }

        /* Subtle glow effect */
        .glow-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: -1;
        }

        /* Ensure content is properly layered */
        .content-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        /* Underwater distortion effect */
        .underwater-distortion {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(219, 39, 119, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            animation: distortionWave 8s ease-in-out infinite;
        }

        @keyframes distortionWave {
            0%, 100% {
                transform: scale(1) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.02) rotate(1deg);
                opacity: 0.5;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(10, 10, 10, 0.8);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #6b7280, #4b5563);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #4b5563, #6b7280);
        }

        /* Mobile scrollbar optimization */
        @media (max-width: 768px) {
            ::-webkit-scrollbar {
                width: 6px;
            }
        }

        @media (max-width: 480px) {
            ::-webkit-scrollbar {
                width: 4px;
            }
        }

        /* Mobile navbar enhancements */
        @media (max-width: 768px) {
            nav {
                background: #1a202c !important;
                backdrop-filter: blur(20px) !important;
                position: sticky !important;
                top: 0 !important;
                z-index: 9999 !important;
                border-bottom: 2px solid #4a5568 !important;
            }
            
            .mobile-menu-overlay {
                background: rgba(26, 32, 44, 0.95) !important;
                z-index: 9998 !important;
            }
            
            .mobile-menu-content {
                background: #1a202c !important;
                backdrop-filter: blur(25px) !important;
                z-index: 9999 !important;
                border-left: 2px solid #4a5568 !important;
            }

            /* Ensure hamburger button is always visible */
            .hamburger-button {
                position: relative !important;
                z-index: 10000 !important;
                background: #2d3748 !important;
                border-radius: 12px !important;
                border: 2px solid #4a5568 !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5) !important;
            }

            /* Ensure all text is visible */
            nav * {
                color:rgb(180, 10, 95) !important;
            }

            /* Mobile menu text visibility */
            .mobile-menu-content * {
                color: white !important;
            }
        }

        /* Force navbar to stay on top */
        nav {
            position: sticky !important;
            top: 0 !important;
            z-index: 9999 !important;
        }

        /* Hide scrollbar for mobile navigation */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Mobile bottom navigation enhancements */
        @media (max-width: 768px) {
            nav {
                background: #000000 !important;
                backdrop-filter: blur(20px) !important;
                border-bottom: 2px solid #1a1a1a !important;
            }
            
            /* Bottom navigation styles - Sticky like header */
            .bottom-nav {
                background: rgba(0, 0, 0, 0.95) !important;
                backdrop-filter: blur(20px) !important;
                position: sticky !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 99999 !important;
                transform: translateZ(0) !important;
                will-change: transform !important;
            }
            
            /* Active state indicator */
            .nav-item-active {
                position: relative;
            }
            
            .nav-item-active::after {
                content: '';
                position: absolute;
                bottom: -8px;
                left: 50%;
                transform: translateX(-50%);
                width: 4px;
                height: 4px;
                background: #ec4899;
                border-radius: 50%;
            }
            
            /* Hover effects for bottom nav */
            .bottom-nav a:hover {
                transform: translateY(-2px);
                transition: transform 0.2s ease;
            }
            
            /* Ensure content flows naturally with sticky nav */
            main {
                padding-bottom: 1rem !important;
            }
            
            /* Prevent any element from covering the bottom nav */
            * {
                z-index: auto !important;
            }
            
            .bottom-nav {
                z-index: 99999 !important;
            }
        }
    </style>
</head>
<body class="font-sans">
    <!-- Animated Background -->
    <div class="animated-background">
        <div class="glow-effect"></div>
        <div class="underwater-distortion"></div>
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
    </div>

    <div class="content-wrapper">
    <div class="min-h-screen">
            <nav class="sticky top-0 z-[9999] bg-black/95 backdrop-blur-xl border-b border-gray-800 shadow-2xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="font-bold text-xl text-pink-600">Temperance</a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-pink-500' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('categories.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-pink-500' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Categories
                            </a>
                            <a href="{{ route('goals.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('goals.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-pink-500' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Goals
                            </a>

                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tasks.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-pink-500' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Tasks
                            </a>
                            <a href="{{ route('progress.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('progress.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-pink-500' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Progress
                            </a>
                            <a href="{{ route('achievements.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('achievements.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-pink-500' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Achievements
                            </a>
                        </div>


                    </div>

                    <!-- User Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-pink-700 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-pink-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-100 hover:text-gray-800 hover:bg-pink-600">Profile</a>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="button" onclick="showLogoutConfirmation('logout-form')" class="block w-full text-left px-4 py-2 text-sm text-gray-100 hover:text-gray-800 hover:bg-pink-600">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                        <!-- Mobile User Menu -->
                        <div class="sm:hidden flex items-center">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-pink-400 focus:outline-none bg-gray-800 p-2 rounded-lg">
                                    <div class="h-8 w-8 rounded-full bg-pink-500 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-900 rounded-lg shadow-xl py-1 z-50 border border-gray-700">
                                    <div class="px-4 py-2 border-b border-gray-700">
                                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white">Profile</a>
                                            <form method="POST" action="{{ route('logout') }}" id="mobile-logout-form">
                                                @csrf
                                        <button type="button" onclick="showLogoutConfirmation('mobile-logout-form')" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-red-600 hover:text-white">
                                                    Logout
                                                </button>
                                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>



<script>
                document.addEventListener('DOMContentLoaded', function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    @if(session('success'))
                        Toast.fire({
                            icon: 'success',
                            title: '{{ session('success') }}'
                        })
                    @endif

                    @if(session('error'))
                        Toast.fire({
                            icon: 'error',
                            title: '{{ session('error') }}'
                        })
                    @endif
                });
            </script>
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Mobile Bottom Navigation -->
        <div class="bottom-nav sm:hidden sticky bottom-0 left-0 right-0 z-[99999] bg-black/95 backdrop-blur-xl border-t border-gray-800 shadow-2xl">
            <div class="flex items-center justify-around h-16 px-4">
                <!-- Categories -->
                <a href="{{ route('categories.index') }}" 
                   class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('categories.*') ? 'text-pink-500' : 'text-gray-400 hover:text-white' }} transition-colors duration-200">
                    <i class="fas fa-tags text-xl mb-1"></i>
                    <span class="text-xs">Categories</span>
                </a>

                <!-- Goals -->
                <a href="{{ route('goals.index') }}" 
                   class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('goals.*') ? 'text-pink-500' : 'text-gray-400 hover:text-white' }} transition-colors duration-200">
                    <i class="fas fa-bullseye text-xl mb-1"></i>
                    <span class="text-xs">Goals</span>
                </a>

                <!-- Dashboard (Center) -->
                <a href="{{ route('dashboard') }}" 
                   class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('dashboard') ? 'text-pink-500' : 'text-gray-400 hover:text-white' }} transition-colors duration-200">
                    <div class="relative">
                        <i class="fas fa-tachometer-alt text-2xl mb-1"></i>
                        @if(request()->routeIs('dashboard'))
                            <div class="absolute -top-1 -right-1 w-2 h-2 bg-pink-500 rounded-full"></div>
                        @endif
                    </div>
                    <span class="text-xs">Dashboard</span>
                </a>

                <!-- Tasks -->
                <a href="{{ route('tasks.index') }}" 
                   class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('tasks.*') ? 'text-pink-500' : 'text-gray-400 hover:text-white' }} transition-colors duration-200">
                    <i class="fas fa-tasks text-xl mb-1"></i>
                    <span class="text-xs">Tasks</span>
                </a>

                <!-- Progress -->
                <a href="{{ route('progress.index') }}" 
                   class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('progress.*') ? 'text-pink-500' : 'text-gray-400 hover:text-white' }} transition-colors duration-200">
                    <i class="fas fa-chart-line text-xl mb-1"></i>
                    <span class="text-xs">Progress</span>
                </a>

                <!-- Achievements -->
                <a href="{{ route('achievements.index') }}" 
                   class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('achievements.*') ? 'text-pink-500' : 'text-gray-400 hover:text-white' }} transition-colors duration-200">
                    <i class="fas fa-trophy text-xl mb-1"></i>
                    <span class="text-xs">Achievements</span>
                </a>
            </div>
        </div>
    </div>
<script>
    function showDeleteConfirmation(formId, itemName, itemType = 'item') {
        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete this ${itemType}: "<strong>${itemName}</strong>".<br>This action cannot be undone.`,
            iconHtml: '<div class="w-24 h-24 rounded-full border-4 border-pink-500 flex items-center justify-center mx-auto animate-pulse"><i class="fas fa-trash-alt text-5xl text-pink-500"></i></div>',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete It!',
            cancelButtonText: 'Cancel',
            background: 'linear-gradient(to top right, #374151, #1f2937)',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                icon: 'no-border',
                title: 'text-3xl font-bold text-pink-400 pt-8',
                htmlContainer: 'text-lg text-gray-300 pb-4',
                actions: 'w-full flex justify-center gap-x-4 px-4',
                confirmButton: 'bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300',
                cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }

    function showLogoutConfirmation(formId) {
        Swal.fire({
            title: 'Logout from Temperance?',
            html: `Are you sure you want to logout from the application?<br><span class='text-sm text-gray-400'>All changes will be saved automatically.</span>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Logout!',
            cancelButtonText: 'Cancel',
            background: 'linear-gradient(to top right, #1f2937, #374151)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                title: 'text-2xl font-bold text-pink-400 pt-4',
                htmlContainer: 'text-lg text-gray-300 pb-4',
                actions: 'w-full flex justify-center gap-x-4 px-4',
                confirmButton: 'bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
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
    @stack('scripts')
</body>
</html>
