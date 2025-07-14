<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Temperance') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        .content-wrapper { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .modern-card {
            background: rgba(31, 41, 55, 0.95);
            border-radius: 2rem;
            box-shadow: 0 8px 32px 0 rgba(236,72,153,0.15), 0 1.5px 8px 0 rgba(0,0,0,0.12);
            border: 1.5px solid #ec4899;
            transition: box-shadow 0.3s cubic-bezier(.4,2,.6,1), transform 0.2s;
        }
        .modern-card:hover {
            box-shadow: 0 16px 48px 0 rgba(236,72,153,0.25), 0 2px 16px 0 rgba(0,0,0,0.18);
            transform: translateY(-2px) scale(1.01);
        }
        .modern-input:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 2px #ec489933;
            background: #fff;
        }
        .modern-label {
            color: #f9fafb;
            font-weight: 500;
        }
        .modern-btn {
            background: linear-gradient(90deg, #ec4899 0%, #be185d 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 1rem;
            box-shadow: 0 2px 8px 0 rgba(236,72,153,0.15);
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .modern-btn:hover, .modern-btn:focus {
            background: linear-gradient(90deg, #be185d 0%, #ec4899 100%);
            transform: scale(1.03) translateY(-2px);
            box-shadow: 0 4px 16px 0 rgba(236,72,153,0.25);
        }
        .modern-link {
            color: #ec4899;
            font-weight: 500;
            transition: color 0.2s;
        }
        .modern-link:hover {
            color: #be185d;
            text-decoration: underline;
        }
        .animate-fadein {
            animation: fadeIn 0.7s cubic-bezier(.4,2,.6,1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: none; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br min-h-screen flex items-center justify-center p-4">
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
    </div>
    <div class="content-wrapper">
        <div class="w-full max-w-md animate-fadein">
            <div class="text-center mb-8">
                <h1 class="text-5xl font-extrabold text-pink-500 mb-2 drop-shadow-lg tracking-tight">Temperance</h1>
                <p class="text-gray-300 text-lg font-medium">Track your goals and progress</p>
            </div>
            <div class="modern-card overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-pink-400 mb-2">Welcome back</h2>
                    <p class="text-gray-400 mb-6">Please sign in to continue your journey</p>

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-pink-500 text-pink-800 p-4 rounded-lg mb-6 animate-fadein">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-pink-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <ul class="list-disc pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Email -->
                        <div class="mb-5">
                            <label for="email" class="block text-sm modern-label mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-pink-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                    class="modern-input w-full pl-10 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 bg-gray-50 transition-all duration-200">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="mb-5">
                            <div class="flex justify-between">
                                <label for="password" class="block text-sm modern-label mb-2">Password</label>
                                <a href="#" class="text-sm modern-link font-medium">Forgot password?</a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-pink-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required 
                                    class="modern-input w-full pl-10 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-pink-400 bg-gray-50 transition-all duration-200">
                            </div>
                        </div>
                        <!-- Remember Me -->
                        <div class="mb-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="rounded-md border-gray-300 text-pink-500 shadow-sm focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition-all duration-200">
                                <span class="ml-2 text-sm text-gray-400">Remember me</span>
                            </label>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="modern-btn w-full py-3 px-4 mt-2 text-lg">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" /></svg>
                            Sign in
                        </button>
                    </form>
                    
                    <!-- Registration Link -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-400">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="modern-link font-medium">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Temperance. All rights reserved.</p>
                <div class="mt-2 flex justify-center space-x-4">
                    <a href="#" class="modern-link">Privacy Policy</a>
                    <a href="#" class="modern-link">Terms of Service</a>
                    <a href="#" class="modern-link">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>