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

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="font-sans antialiased bg-black-100">
    <div class="min-h-screen">
        <nav class="bg-black-100 border-b border-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="font-bold text-xl text-pink-600">Temperance</a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('categories.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Categories
                            </a>
                            <a href="{{ route('goals.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('goals.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Goals
                            </a>
                            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tasks.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Tasks
                            </a>
                            <a href="{{ route('progress.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('progress.*') ? 'border-pink-500 text-pink-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out">
                                Progress
                            </a>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        
                        <!-- Mobile menu -->
                        <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden fixed inset-0 z-40" style="background-color: rgba(0,0,0,0.4);" @click.self="open = false">
                            <div class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-xl overflow-y-auto z-50">
                                <div class="p-6 space-y-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <h2 class="text-xl font-semibold text-gray-900">Menu</h2>
                                        <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <nav class="space-y-3">
                                        <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                            Dashboard
                                        </a>
                                        <a href="{{ route('categories.index') }}" class="block py-2.5 px-4 rounded transition {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                            Categories
                                        </a>
                                        <a href="{{ route('goals.index') }}" class="block py-2.5 px-4 rounded transition {{ request()->routeIs('goals.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                            Goals
                                        </a>
                                        <a href="{{ route('tasks.index') }}" class="block py-2.5 px-4 rounded transition {{ request()->routeIs('tasks.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                            Tasks
                                        </a>
                                        <a href="{{ route('progress.index') }}" class="block py-2.5 px-4 rounded transition {{ request()->routeIs('progress.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                                            Progress
                                        </a>
                                    </nav>
                                    
                                    <div class="pt-6 mt-6 border-t border-gray-200">
                                        <div class="flex items-center mb-4">
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold mr-3">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-3">
                                            <a href="#" class="block py-2.5 px-4 rounded text-gray-700 hover:bg-gray-50 transition">
                                                Profile
                                            </a>
                                            <a href="#" class="block py-2.5 px-4 rounded text-gray-700 hover:bg-gray-50 transition">
                                                Settings
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full text-left py-2.5 px-4 rounded text-gray-700 hover:bg-gray-50 transition">
                                                    Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>