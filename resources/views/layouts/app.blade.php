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
    
    <!-- Alpine.js Fallback -->
    <script>
        if (typeof Alpine === 'undefined') {
            console.log('Loading Alpine.js fallback...');
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js';
            script.defer = true;
            document.head.appendChild(script);
        }
    </script>
    
    <!-- Ensure Alpine.js is loaded before DOM -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Alpine === 'undefined') {
                console.error('Alpine.js not loaded');
            } else {
                console.log('Alpine.js loaded successfully');
                
                // Initialize Alpine.js components
                Alpine.nextTick(() => {
                    console.log('Alpine.js components initialized');
                });
            }
        });
    </script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <style>
        /* Loading Screen Styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .loading-overlay.show {
            display: flex;
            opacity: 1;
        }

        .loading-content {
            text-align: center;
            color: white;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(236, 72, 153, 0.3);
            border-top: 4px solid #ec4899;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        .loading-text {
            font-size: 18px;
            font-weight: 500;
            color: #ec4899;
            margin-bottom: 10px;
        }

        .loading-subtext {
            font-size: 14px;
            color: #9ca3af;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile optimizations for loading */
        @media (max-width: 768px) {
            .loading-spinner {
                width: 50px;
                height: 50px;
                border-width: 3px;
            }
            
            .loading-text {
                font-size: 16px;
            }
            
            .loading-subtext {
                font-size: 12px;
            }
        }

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

        /* Mobile Top Navigation Bar */
        .mobile-top-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid #1a1a1a;
            padding: 0.75rem 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        /* Mobile Top Navigation Content */
        .mobile-top-nav .flex {
            align-items: center;
            justify-content: space-between;
        }

        /* Mobile Top Navigation Logo */
        .mobile-top-nav a {
            transition: all 0.3s ease;
        }

        .mobile-top-nav a:hover {
            transform: scale(1.05);
        }

        /* Mobile Top Navigation User Profile */
        .mobile-top-nav .relative {
            position: relative;
        }

        .mobile-top-nav .relative button {
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .mobile-top-nav .relative button:hover {
            transform: scale(1.05);
        }

        /* Ensure mobile popup container has proper positioning */
        .mobile-top-nav .relative {
            position: relative !important;
        }

        /* Mobile Top Navigation User Avatar */
        .mobile-top-nav .w-8.h-8 {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.3);
        }

        /* Mobile Top Navigation Logo - Remove border radius for logo */
        .mobile-top-nav a img.w-8.h-8 {
            border-radius: 0 !important;
            box-shadow: none !important;
            background: none !important;
            display: block !important;
        }

        /* Additional specificity for logo container */
        .mobile-top-nav .flex.items-center.space-x-3 a img {
            border-radius: 0 !important;
            box-shadow: none !important;
            background: none !important;
        }

        /* Mobile Top Navigation User Name */
        .mobile-top-nav .text-sm.font-medium {
            font-size: 0.875rem;
            font-weight: 500;
            color: #d1d5db;
        }

        /* Mobile Top Navigation Dropdown Arrow */
        .mobile-top-nav .fas.fa-chevron-down {
            font-size: 0.75rem;
            color: #9ca3af;
            transition: transform 0.2s ease;
        }

        .mobile-top-nav button:hover .fas.fa-chevron-down {
            transform: rotate(180deg);
        }

        /* Chevron rotation for open state */
        .mobile-top-nav .fas.fa-chevron-down.rotate-180 {
            transform: rotate(180deg);
        }

        /* Ensure chevron transitions smoothly */
        .mobile-top-nav .fas.fa-chevron-down {
            transition: transform 0.2s ease;
        }

        /* Mobile User Profile Button */
        .mobile-user-btn {
            padding: 0.5rem;
            border-radius: 0.5rem;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(55, 65, 81, 0.2);
        }

        .mobile-user-btn:hover {
            background: rgba(236, 72, 153, 0.1);
            border-color: rgba(236, 72, 153, 0.3);
        }

        /* Mobile User Avatar */
        .mobile-user-avatar {
            position: relative;
            overflow: hidden;
        }

        .mobile-user-avatar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), transparent);
            border-radius: 50%;
        }

        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border-top: 2px solid #1a1a1a;
            padding: 0.75rem 0;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Mobile Bottom Navigation Icons */
        .mobile-bottom-nav a {
            position: relative;
            transition: all 0.3s ease;
        }

        .mobile-bottom-nav a:hover {
            transform: translateY(-2px);
        }

        .mobile-bottom-nav a.active {
            transform: translateY(-2px);
        }

        .mobile-bottom-nav a.active::after {
            content: '';
            position: absolute;
            bottom: -0.75rem;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: #ec4899;
            border-radius: 50%;
        }

        /* Desktop Sidebar */
        .desktop-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5rem;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border-right: 2px solid #1a1a1a;
            z-index: 50;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Desktop Sidebar Navigation */
        .desktop-sidebar nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-top: 1.5rem;
            padding-bottom: 6rem;
            min-height: 0;
            overflow-y: auto;
            margin-bottom: auto;
        }

        /* Ensure user profile section stays at bottom */
        .desktop-sidebar .flex-shrink-0:last-child {
            margin-top: auto;
        }

        /* Desktop Sidebar User Profile */
        .desktop-sidebar .user-profile-section {
            flex-shrink: 0;
            position: relative;
            padding: 1rem 0.5rem 1.5rem 0.5rem;
            width: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid #374151;
            margin-top: auto;
            align-self: flex-end;
        }

        /* Ensure user profile stays at bottom */
        .desktop-sidebar .mt-auto {
            margin-top: auto !important;
        }

        /* Force user profile to bottom */
        .desktop-sidebar > div:last-child {
            margin-top: auto !important;
        }

        /* Ensure user profile section is at the very bottom */
        .desktop-sidebar .flex-shrink-0:last-child {
            margin-top: auto !important;
            position: absolute !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            background: rgba(0, 0, 0, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-top: 1px solid #374151 !important;
            padding: 1rem 0.5rem 1.5rem 0.5rem !important;
        }

        /* User Profile Bottom - Fixed at very bottom */
        .user-profile-bottom {
            position: absolute !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            background: rgba(0, 0, 0, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-top: 1px solid #374151 !important;
            padding: 1rem 0.5rem 1.5rem 0.5rem !important;
            z-index: 10 !important;
        }

        /* Desktop Sidebar User Profile Button */
        .user-profile-bottom button {
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            margin: 0 auto;
        }

        .user-profile-bottom button:hover {
            transform: scale(1.1);
        }

        /* Desktop Sidebar User Avatar */
        .user-profile-bottom .w-8.h-8 {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.4);
            transition: all 0.3s ease;
        }

        .user-profile-bottom button:hover .w-8.h-8 {
            box-shadow: 0 6px 16px rgba(236, 72, 153, 0.6);
        }

        /* User Profile Button Styling */
        .user-profile-btn {
            border-radius: 0.75rem;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(55, 65, 81, 0.3);
        }

        .user-profile-btn:hover {
            background: rgba(236, 72, 153, 0.1);
            border-color: rgba(236, 72, 153, 0.3);
        }

        /* User Avatar Styling */
        .user-avatar {
            position: relative;
            overflow: hidden;
        }

        .user-avatar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), transparent);
            border-radius: 50%;
        }

        /* User Profile Popup Content Styling */
        .user-profile-popup .px-6,
        .mobile-user-popup .px-6,
        .desktop-user-popup .px-6 {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .user-profile-popup .py-4,
        .mobile-user-popup .py-4,
        .desktop-user-popup .py-4 {
            padding-top: 0.875rem;
            padding-bottom: 0.875rem;
        }

        /* User Info Header Styling */
        .user-profile-popup .border-b,
        .mobile-user-popup .border-b,
        .desktop-user-popup .border-b {
            border-bottom: 1px solid rgba(75, 85, 99, 0.6);
            margin-bottom: 0.75rem;
        }

        /* User Avatar in Popup */
        .user-profile-popup .w-12.h-12,
        .mobile-user-popup .w-12.h-12,
        .desktop-user-popup .w-12.h-12 {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.125rem;
            box-shadow: 0 6px 16px rgba(236, 72, 153, 0.6);
            background: linear-gradient(135deg, #ec4899, #db2777);
            position: relative;
            overflow: hidden;
        }

        .user-profile-popup .w-12.h-12::before,
        .mobile-user-popup .w-12.h-12::before,
        .desktop-user-popup .w-12.h-12::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.2), transparent);
            border-radius: 50%;
        }

        /* User Name in Popup */
        .user-profile-popup .text-white.font-semibold,
        .mobile-user-popup .text-white.font-semibold,
        .desktop-user-popup .text-white.font-semibold {
            font-size: 1rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }

        /* User Email in Popup */
        .user-profile-popup .text-gray-400.text-sm,
        .mobile-user-popup .text-gray-400.text-sm,
        .desktop-user-popup .text-gray-400.text-sm {
            font-size: 0.875rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        /* Online Status in Popup */
        .user-profile-popup .text-green-400.text-xs,
        .mobile-user-popup .text-green-400.text-xs,
        .desktop-user-popup .text-green-400.text-xs {
            font-size: 0.75rem;
            font-weight: 500;
            color: #4ade80;
        }

        /* Online Status Indicator */
        .mobile-user-popup .w-2.h-2.bg-green-500 {
            width: 0.5rem;
            height: 0.5rem;
            background: #4ade80;
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(74, 222, 128, 0.6);
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            margin-right: 0.25rem;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        /* Online status spacing */
        .mobile-user-popup .flex.items-center.mt-1 .w-2.h-2.bg-green-500 {
            margin-right: 0.25rem;
        }

        /* Menu Items in Popup */
        .user-profile-popup .px-2,
        .mobile-user-popup .px-2,
        .desktop-user-popup .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .user-profile-popup .py-2,
        .mobile-user-popup .py-2,
        .desktop-user-popup .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        /* Menu Item Styling */
        .user-profile-popup a,
        .mobile-user-popup a,
        .desktop-user-popup a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #d1d5db;
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            margin-bottom: 0.25rem;
        }

        .user-profile-popup a:hover,
        .mobile-user-popup a:hover,
        .desktop-user-popup a:hover {
            background: rgba(75, 85, 99, 0.6);
            color: #ffffff;
            transform: translateX(4px);
        }

        /* Menu Item Icons */
        .user-profile-popup .w-8.h-8,
        .mobile-user-popup .w-8.h-8,
        .desktop-user-popup .w-8.h-8 {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .user-profile-popup a:hover .w-8.h-8,
        .mobile-user-popup a:hover .w-8.h-8,
        .desktop-user-popup a:hover .w-8.h-8 {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            transform: scale(1.05);
        }

        .user-profile-popup button:hover .w-8.h-8,
        .mobile-user-popup button:hover .w-8.h-8,
        .desktop-user-popup button:hover .w-8.h-8 {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            transform: scale(1.05);
        }

        /* Menu Item Text */
        .user-profile-popup .font-medium,
        .mobile-user-popup .font-medium,
        .desktop-user-popup .font-medium {
            font-weight: 500;
            font-size: 0.875rem;
            color: #d1d5db;
        }

        .user-profile-popup .text-xs.text-gray-500,
        .mobile-user-popup .text-xs.text-gray-500,
        .desktop-user-popup .text-xs.text-gray-500 {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.125rem;
            font-weight: 400;
        }

        /* Menu Item Hover Text */
        .mobile-user-popup a:hover .font-medium,
        .mobile-user-popup button:hover .font-medium {
            color: #ffffff;
        }

        .mobile-user-popup a:hover .text-xs.text-gray-500,
        .mobile-user-popup button:hover .text-xs.text-gray-500 {
            color: #d1d5db;
        }

        /* Logout Section */
        .user-profile-popup .border-t,
        .mobile-user-popup .border-t,
        .desktop-user-popup .border-t {
            border-top: 1px solid rgba(75, 85, 99, 0.6);
            margin-top: 0.5rem;
            padding-top: 0.5rem;
        }

        /* Logout Button */
        .user-profile-popup button,
        .mobile-user-popup button,
        .desktop-user-popup button {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
        }

        .user-profile-popup button:hover,
        .mobile-user-popup button:hover,
        .desktop-user-popup button:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            transform: translateX(4px);
        }

        /* Logout button specific styling */
        .mobile-user-popup button:hover .font-medium {
            color: #ef4444;
        }

        .mobile-user-popup button:hover .text-xs.text-gray-500 {
            color: #fca5a5;
        }

        /* Mobile Popup Specific Styling */
        .mobile-user-popup {
            backdrop-filter: blur(25px);
            border: 1px solid rgba(55, 65, 81, 0.8);
        }





        .mobile-user-popup .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        .mobile-user-popup .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .mobile-user-popup .border-b {
            border-bottom: 1px solid rgba(75, 85, 99, 0.6);
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
        }

        /* User info header specific styling */
        .mobile-user-popup .space-x-4 > div:first-child {
            flex-shrink: 0;
        }

        .mobile-user-popup .space-x-4 > div:last-child {
            flex: 1;
            min-width: 0;
        }

        .mobile-user-popup .border-t {
            border-top: 1px solid rgba(75, 85, 99, 0.6);
            margin-top: 0.5rem;
            padding-top: 0.5rem;
        }

        .mobile-user-popup a {
            border-radius: 0.75rem;
            margin-bottom: 0.375rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .mobile-user-popup a:hover {
            background: rgba(75, 85, 99, 0.6);
            transform: translateX(4px);
        }

        .mobile-user-popup a:last-of-type {
            margin-bottom: 0;
        }

        .mobile-user-popup button {
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .mobile-user-popup button:hover {
            background: rgba(239, 68, 68, 0.15);
            transform: translateX(4px);
        }

        /* Menu item spacing */
        .mobile-user-popup .px-2 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .mobile-user-popup .py-2 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        /* Chevron icon styling */
        .mobile-user-popup .fas.fa-chevron-right {
            font-size: 0.75rem;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .mobile-user-popup a:hover .fas.fa-chevron-right,
        .mobile-user-popup button:hover .fas.fa-chevron-right {
            color: #ffffff;
            transform: translateX(2px);
        }

        /* Icon colors for different menu items */
        .mobile-user-popup .bg-gradient-to-br.from-blue-500.to-blue-600 {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .mobile-user-popup .bg-gradient-to-br.from-purple-500.to-purple-600 {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .mobile-user-popup .bg-gradient-to-br.from-green-500.to-green-600 {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .mobile-user-popup .bg-gradient-to-br.from-red-500.to-red-600 {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        /* Responsive Popup Adjustments */
        @media (max-width: 640px) {
            .mobile-user-popup {
                width: 16rem;
                max-width: 80vw;
                right: 0.25rem;
                margin-top: 0.375rem;
            }

            .mobile-user-popup .px-6 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .mobile-user-popup .py-4 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }

            .mobile-user-popup a {
                padding: 0.5rem 0.75rem;
                margin-bottom: 0.125rem;
            }

            .mobile-user-popup .w-8.h-8 {
                width: 1.75rem;
                height: 1.75rem;
                margin-right: 0.625rem;
            }

            .mobile-user-popup .w-12.h-12 {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 1rem;
            }

            .mobile-user-popup .text-white.font-semibold {
                font-size: 0.875rem;
            }

            .mobile-user-popup .text-gray-400.text-sm {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .mobile-user-popup {
                width: 14rem;
                max-width: 85vw;
                right: 0.125rem;
            }

            .mobile-user-popup .px-6 {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .mobile-user-popup .py-4 {
                padding-top: 0.625rem;
                padding-bottom: 0.625rem;
            }

            .mobile-user-popup a {
                padding: 0.375rem 0.625rem;
            }

            .mobile-user-popup .w-8.h-8 {
                width: 1.5rem;
                height: 1.5rem;
                margin-right: 0.5rem;
            }

            .mobile-user-popup .w-12.h-12 {
                width: 2.25rem;
                height: 2.25rem;
                font-size: 0.875rem;
            }

            .mobile-user-popup .text-white.font-semibold {
                font-size: 0.8125rem;
            }

            .mobile-user-popup .text-gray-400.text-sm {
                font-size: 0.6875rem;
            }

            .mobile-user-popup .text-green-400.text-xs {
                font-size: 0.625rem;
            }
        }

        /* Desktop Popup Positioning Fix */
        @media (min-width: 1024px) {
            .desktop-user-popup {
                left: 100%;
                margin-left: 1rem;
                bottom: 0;
            }
        }

        /* Ensure popup doesn't overflow screen */
        .user-profile-popup,
        .mobile-user-popup,
        .desktop-user-popup {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Prevent popup from overlapping with main content */
        .mobile-user-popup {
            max-width: calc(100vw - 2rem);
            right: 0.5rem;
        }

        /* Mobile Popup Positioning Fix */
        .mobile-user-popup {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            z-index: 10000;
            transform-origin: top right;
        }

        @media (max-width: 640px) {
            .mobile-user-popup {
                max-width: calc(100vw - 1rem);
                right: 0.25rem;
            }
        }

        @media (max-width: 480px) {
            .mobile-user-popup {
                max-width: calc(100vw - 0.5rem);
                right: 0.125rem;
            }
        }

        /* Ensure mobile popup doesn't overlap with bottom navigation */
        @media (max-width: 640px) {
            .mobile-user-popup {
                position: absolute;
                top: 100%;
                right: 0;
                margin-top: 0.5rem;
                width: 16rem;
                max-width: 80vw;
                transform-origin: top right;
            }
        }

        @media (max-width: 480px) {
            .mobile-user-popup {
                position: absolute;
                top: 100%;
                right: 0;
                margin-top: 0.5rem;
                width: 14rem;
                max-width: 85vw;
                transform-origin: top right;
            }
        }

        /* Custom scrollbar for popup */
        .user-profile-popup::-webkit-scrollbar,
        .mobile-user-popup::-webkit-scrollbar,
        .desktop-user-popup::-webkit-scrollbar {
            width: 4px;
        }

        .user-profile-popup::-webkit-scrollbar-track,
        .mobile-user-popup::-webkit-scrollbar-track,
        .desktop-user-popup::-webkit-scrollbar-track {
            background: rgba(75, 85, 99, 0.3);
            border-radius: 2px;
        }

        .user-profile-popup::-webkit-scrollbar-thumb,
        .mobile-user-popup::-webkit-scrollbar-thumb,
        .desktop-user-popup::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 2px;
        }

        .user-profile-popup::-webkit-scrollbar-thumb:hover,
        .mobile-user-popup::-webkit-scrollbar-thumb:hover,
        .desktop-user-popup::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.7);
        }

        /* Ensure popup is visible on larger screens */
        @media (min-width: 1280px) {
            .desktop-sidebar .user-profile-popup {
                left: 100%;
                margin-left: 1rem;
            }
        }

        /* Adjust popup position for smaller screens */
        @media (max-width: 1366px) {
            .desktop-sidebar .user-profile-popup {
                left: 100%;
                margin-left: 0.5rem;
                width: 16rem;
            }
        }

        /* Fix popup positioning */
        .desktop-sidebar .user-profile-section .absolute {
            position: absolute !important;
            bottom: 0 !important;
            left: 100% !important;
            margin-left: 1rem !important;
            z-index: 1000 !important;
            background: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border-radius: 1rem !important;
            border: 1px solid #374151 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        }

        /* Ensure proper spacing for navigation items */
        .desktop-sidebar nav a {
            margin-bottom: 0.5rem;
        }

        /* Hover effects for sidebar items */
        .desktop-sidebar nav a:hover {
            background: rgba(236, 72, 153, 0.1);
            border-radius: 0.75rem;
        }

        .desktop-sidebar nav a.active {
            background: rgba(236, 72, 153, 0.2);
            border-radius: 0.75rem;
        }

        /* Main Content Area */
        .main-content {
            min-height: 100vh;
            padding-bottom: 5rem; /* Space for mobile bottom nav */
        }

        @media (max-width: 1023px) {
            .main-content {
                padding-top: 4rem; /* Space for fixed mobile top nav */
            }
        }

        @media (min-width: 1024px) {
            .main-content {
                margin-left: 5rem;
                padding-bottom: 0;
                padding-top: 0;
            }
        }

        /* User Profile Popup */
        .user-profile-popup {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 18rem;
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            border: 1px solid #374151;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            z-index: 1000;
        }

        /* Mobile User Popup - Clean CSS without display/visibility overrides */
        .mobile-user-popup {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 16rem;
            max-width: 85vw;
            background: rgba(40, 44, 52, 0.98);
            backdrop-filter: blur(25px);
            border-radius: 1rem;
            border: 1px solid rgba(55, 65, 81, 0.8);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
            z-index: 10000;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        @media (max-width: 640px) {
            .mobile-user-popup {
                width: 14rem;
                max-width: 90vw;
                right: 0.25rem;
                margin-top: 0.375rem;
            }
        }
        @media (max-width: 480px) {
            .mobile-user-popup {
                width: 12rem;
                max-width: 95vw;
                right: 0.125rem;
            }
        }





        /* Desktop User Popup */
        .desktop-user-popup {
            position: absolute;
            bottom: 0;
            left: 100%;
            margin-left: 1rem;
            width: 16rem;
            background: rgba(31, 41, 55, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 0.75rem;
            border: 1px solid #374151;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.4);
            z-index: 1000;
            overflow: hidden;
        }

        /* Hide Alpine.js elements until they are initialized */
        [x-cloak] {
            display: none !important;
        }







        /* Calendar Modal Mobile Optimizations */
        .calendar-modal-mobile {
            padding: 0.5rem;
        }

        @media (max-width: 640px) {
            .calendar-modal-mobile {
                padding: 0.25rem;
            }
            
            .calendar-modal-content {
                max-height: 90vh;
                overflow-y: auto;
            }
        }

        @media (max-width: 480px) {
            .calendar-modal-mobile {
                padding: 0.125rem;
            }
            
            .calendar-modal-content {
                max-height: 95vh;
                margin: 0.25rem;
            }
        }

        /* Prevent body scroll when modal is open */
        body.modal-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
        }

        /* Custom scrollbar for modal content */
        .modal-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #6B7280 #374151;
        }

        .modal-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .modal-scrollbar::-webkit-scrollbar-track {
            background: rgba(55, 65, 81, 0.3);
            border-radius: 8px;
        }

        .modal-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #6B7280 0%, #9CA3AF 100%);
            border-radius: 8px;
        }

        .modal-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #9CA3AF 0%, #D1D5DB 100%);
        }

        /* Calendar Modal Responsive Enhancements */
        #dateModal {
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }

        @media (max-width: 640px) {
            #dateModal {
                padding: 0.25rem;
            }
        }

        @media (max-width: 480px) {
            #dateModal {
                padding: 0.125rem;
            }
        }

        .calendar-modal-content {
            transform-origin: center;
            margin: auto;
            max-width: 90vw;
            max-height: 90vh;
        }

        @media (max-width: 640px) {
            .calendar-modal-content {
                max-width: 95vw;
                max-height: 95vh;
                margin: 0.25rem;
            }
        }

        @media (max-width: 480px) {
            .calendar-modal-content {
                max-width: 98vw;
                max-height: 98vh;
                margin: 0.125rem;
            }
        }

        /* Enhanced Mobile Modal Optimizations */
        @media (max-width: 640px) {
            .calendar-modal-mobile .grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .calendar-modal-mobile .bg-gray-700\/50 {
                min-height: 200px;
            }
            
            .calendar-modal-mobile h3 {
                font-size: 0.875rem;
            }
            
            .calendar-modal-mobile .text-xs {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .calendar-modal-mobile .grid {
                gap: 0.5rem;
            }
            
            .calendar-modal-mobile .bg-gray-700\/50 {
                min-height: 150px;
            }
            
            .calendar-modal-mobile h3 {
                font-size: 0.8125rem;
            }
            
            .calendar-modal-mobile .text-xs {
                font-size: 0.6875rem;
            }
        }

        /* Modal Animation Improvements */
        .calendar-modal-content {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Ensure modal backdrop is properly positioned */
        #dateModal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
        }

        /* Online status spacing for mobile popup */
        .mobile-user-popup .flex.items-center.mt-1 .w-2.h-2.bg-green-500 {
            margin-right: 0.25rem !important;
        }




    </style>
</head>
<body class="font-sans">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Memproses...</div>
            <div class="loading-subtext">Mohon tunggu sebentar</div>
        </div>
    </div>

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
        <!-- Mobile Top Navigation Bar -->
        <div class="mobile-top-nav lg:hidden">
            <div class="flex items-center justify-between">
                <!-- Logo and App Name -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('readme-logo.png') }}" alt="Logo" class="w-10 h-10">
                        <span class="text-lg font-bold bg-gradient-to-r from-pink-500 to-pink-700 bg-clip-text text-transparent">
                            Temperance
                        </span>
                    </a>
                </div>

                <!-- User Profile Button -->
                <div class="relative" x-data="{ open: false }" x-init="console.log('Mobile user profile initialized, open:', open)">
                    <button @click="open = !open; console.log('Mobile button clicked, open:', open)" 
                            class="flex items-center space-x-2 text-gray-300 hover:text-white transition-colors duration-200 mobile-user-btn"
                            type="button">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center shadow-lg mobile-user-avatar">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-sm font-medium hidden sm:block">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <!-- User Profile Popup -->
                    <div x-show="open" 
                         x-cloak
                         @click.away="open = false"
                         @keydown.escape.window="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 transform translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 transform translate-y-2"

                         class="absolute top-full right-0 mt-2 w-72 bg-gray-800 rounded-xl shadow-2xl py-4 z-50 border border-gray-700 mobile-user-popup">
                        
                        <!-- User Info Header -->
                        <div class="px-6 py-4 border-b border-gray-600">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center shadow-lg">
                                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-white font-semibold text-base">{{ Auth::user()->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-0.5 animate-pulse"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="px-2 py-2">
                            <a href="#" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-300">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-medium">Profile Settings</span>
                                    <p class="text-xs text-gray-500">Manage your account</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-300">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-cog text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-medium">Preferences</span>
                                    <p class="text-xs text-gray-500">Customize your experience</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-300">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-question-circle text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-medium">Help & Support</span>
                                    <p class="text-xs text-gray-500">Get assistance</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                            </a>
                        </div>
                        
                        <!-- Logout Section -->
                        <div class="px-2 py-2 border-t border-gray-600">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" 
                                        onclick="showLogoutConfirmation('logout-form')" 
                                        class="group w-full flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-300">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center mr-3 shadow-md">
                                        <i class="fas fa-sign-out-alt text-white text-sm"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <span class="font-medium">Sign Out</span>
                                        <p class="text-xs text-gray-500">Logout from your account</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div class="desktop-sidebar hidden lg:block">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-gray-700 flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-12 h-12 transition-all duration-300 transform hover:scale-110">
                    <img src="{{ asset('readme-logo.png') }}" alt="Logo" class="w-10 h-10">
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-2 py-6 space-y-4 overflow-y-auto">
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center justify-center w-12 h-12 mx-auto {{ request()->routeIs('dashboard') ? 'text-pink-500 active' : 'text-gray-400 hover:text-pink-500' }} transition-all duration-300 transform hover:scale-110"
                   title="Dashboard">
                    <i class="fas fa-tachometer-alt text-xl"></i>
                </a>

                <a href="{{ route('categories.index') }}" 
                   class="group flex items-center justify-center w-12 h-12 mx-auto {{ request()->routeIs('categories.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-pink-500' }} transition-all duration-300 transform hover:scale-110"
                   title="Categories">
                    <i class="fas fa-tags text-xl"></i>
                </a>

                <a href="{{ route('goals.index') }}" 
                   class="group flex items-center justify-center w-12 h-12 mx-auto {{ request()->routeIs('goals.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-pink-500' }} transition-all duration-300 transform hover:scale-110"
                   title="Goals">
                    <i class="fas fa-bullseye text-xl"></i>
                </a>

                <a href="{{ route('tasks.index') }}" 
                   class="group flex items-center justify-center w-12 h-12 mx-auto {{ request()->routeIs('tasks.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-pink-500' }} transition-all duration-300 transform hover:scale-110"
                   title="Tasks">
                    <i class="fas fa-tasks text-xl"></i>
                </a>

                <a href="{{ route('progress.index') }}" 
                   class="group flex items-center justify-center w-12 h-12 mx-auto {{ request()->routeIs('progress.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-pink-500' }} transition-all duration-300 transform hover:scale-110"
                   title="Progress">
                    <i class="fas fa-chart-line text-xl"></i>
                </a>

                <a href="{{ route('journals.index') }}" 
                   class="group flex items-center justify-center w-12 h-12 mx-auto {{ request()->routeIs('journals.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-pink-500' }} transition-all duration-300 transform hover:scale-110"
                   title="Journals">
                    <i class="fas fa-book-open text-xl"></i>
                </a>

                <a href="{{ route('achievements.index') }}" 
                   class="group flex items-center justify-center w-12 h-12 mx-auto {{ request()->routeIs('achievements.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-pink-500' }} transition-all duration-300 transform hover:scale-110"
                   title="Achievements">
                    <i class="fas fa-trophy text-xl"></i>
                </a>
            </nav>

            <!-- User Profile Section - Fixed at Bottom -->
            <div class="user-profile-bottom">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="group flex items-center justify-center w-12 h-12 mx-auto text-gray-400 hover:text-pink-500 transition-all duration-300 transform hover:scale-110 user-profile-btn" 
                            title="User Profile">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center shadow-lg user-avatar">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </button>
                    
                    <!-- Desktop User Profile Popup -->
                    <div x-show="open" 
                         x-cloak
                         @click.away="open = false"
                         @keydown.escape.window="open = false"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95 transform"
                         x-transition:enter-end="opacity-100 scale-100 transform"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100 transform"
                         x-transition:leave-end="opacity-0 scale-95 transform"
                         class="absolute bottom-0 left-full ml-4 w-72 bg-gray-800 rounded-xl shadow-2xl py-4 z-50 border border-gray-700 desktop-user-popup">
                        
                        <!-- User Info Header -->
                        <div class="px-6 py-4 border-b border-gray-700">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-pink-700 flex items-center justify-center shadow-lg">
                                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-white font-semibold text-base">{{ Auth::user()->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="px-2 py-2">
                            <a href="#" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-300">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-medium">Profile Settings</span>
                                    <p class="text-xs text-gray-500">Manage your account</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-300">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-cog text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-medium">Preferences</span>
                                    <p class="text-xs text-gray-500">Customize your experience</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                            </a>
                            
                            <a href="#" class="group flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg transition-all duration-300">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mr-3 shadow-md">
                                    <i class="fas fa-question-circle text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="font-medium">Help & Support</span>
                                    <p class="text-xs text-gray-500">Get assistance</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                            </a>
                        </div>
                        
                        <!-- Logout Section -->
                        <div class="px-2 py-2 border-t border-gray-700">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                @csrf
                                <button type="button" 
                                        onclick="showLogoutConfirmation('logout-form-desktop')" 
                                        class="group w-full flex items-center px-4 py-3 text-gray-300 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-300">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center mr-3 shadow-md">
                                        <i class="fas fa-sign-out-alt text-white text-sm"></i>
                                    </div>
                                    <div class="flex-1 text-left">
                                        <span class="font-medium">Sign Out</span>
                                        <p class="text-xs text-gray-500">Logout from your account</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            <!-- Mobile Bottom Navigation -->
            <div class="mobile-bottom-nav lg:hidden">
                <div class="flex items-center justify-around">
                    <a href="{{ route('categories.index') }}" 
                       class="flex items-center justify-center flex-1 py-3 {{ request()->routeIs('categories.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-white' }} transition-colors duration-200"
                       title="Categories">
                        <i class="fas fa-tags text-xl"></i>
                    </a>

                    <a href="{{ route('goals.index') }}" 
                       class="flex items-center justify-center flex-1 py-3 {{ request()->routeIs('goals.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-white' }} transition-colors duration-200"
                       title="Goals">
                        <i class="fas fa-bullseye text-xl"></i>
                    </a>

                    <a href="{{ route('journals.index') }}" 
                       class="flex items-center justify-center flex-1 py-3 {{ request()->routeIs('journals.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-white' }} transition-colors duration-200"
                       title="Journals">
                        <i class="fas fa-book-open text-xl"></i>
                    </a>

                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center justify-center flex-1 py-3 {{ request()->routeIs('dashboard') ? 'text-pink-500 active' : 'text-gray-400 hover:text-white' }} transition-colors duration-200"
                       title="Dashboard">
                        <div class="relative">
                            <i class="fas fa-tachometer-alt text-xl"></i>
                            @if(request()->routeIs('dashboard'))
                                <div class="absolute -top-1 -right-1 w-2 h-2 bg-pink-500 rounded-full"></div>
                            @endif
                        </div>
                    </a>

                    <a href="{{ route('tasks.index') }}" 
                       class="flex items-center justify-center flex-1 py-3 {{ request()->routeIs('tasks.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-white' }} transition-colors duration-200"
                       title="Tasks">
                        <i class="fas fa-tasks text-xl"></i>
                    </a>

                    <a href="{{ route('progress.index') }}" 
                       class="flex items-center justify-center flex-1 py-3 {{ request()->routeIs('progress.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-white' }} transition-colors duration-200"
                       title="Progress">
                        <i class="fas fa-chart-line text-xl"></i>
                    </a>

                    <a href="{{ route('achievements.index') }}" 
                       class="flex items-center justify-center flex-1 py-3 {{ request()->routeIs('achievements.*') ? 'text-pink-500 active' : 'text-gray-400 hover:text-white' }} transition-colors duration-200"
                       title="Achievements">
                        <i class="fas fa-trophy text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

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

        // Loading Screen Functions
        function showLoading(message = 'Memproses...', subMessage = 'Mohon tunggu sebentar') {
            const overlay = document.getElementById('loadingOverlay');
            const loadingText = overlay.querySelector('.loading-text');
            const loadingSubtext = overlay.querySelector('.loading-subtext');
            
            loadingText.textContent = message;
            loadingSubtext.textContent = subMessage;
            overlay.classList.add('show');
        }

        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.remove('show');
        }

        // Auto-hide loading after page load
        window.addEventListener('load', function() {
            setTimeout(hideLoading, 500);
        });

        // Show loading for navigation links
        document.addEventListener('DOMContentLoaded', function() {
            // Desktop navigation links
            const navLinks = document.querySelectorAll('.desktop-sidebar nav a[href]');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.href && !this.href.includes('#')) {
                        showLoading('Memuat halaman...', 'Mohon tunggu sebentar');
                    }
                });
            });

            // Mobile bottom navigation links
            const bottomNavLinks = document.querySelectorAll('.mobile-bottom-nav a[href]');
            bottomNavLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.href && !this.href.includes('#')) {
                        showLoading('Memuat halaman...', 'Mohon tunggu sebentar');
                    }
                });
            });

            // Form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        const buttonText = submitButton.textContent.trim();
                        if (buttonText.includes('Create') || buttonText.includes('Buat') || buttonText.includes('Tambah')) {
                            showLoading('Membuat data...', 'Mohon tunggu sebentar');
                        } else if (buttonText.includes('Update') || buttonText.includes('Update') || buttonText.includes('Simpan')) {
                            showLoading('Menyimpan perubahan...', 'Mohon tunggu sebentar');
                        } else if (buttonText.includes('Delete') || buttonText.includes('Hapus')) {
                            showLoading('Menghapus data...', 'Mohon tunggu sebentar');
                        } else {
                            showLoading('Memproses...', 'Mohon tunggu sebentar');
                        }
                    } else {
                        showLoading('Memproses...', 'Mohon tunggu sebentar');
                    }
                });
            });
        });

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
                    showLoading('Menghapus data...', 'Mohon tunggu sebentar');
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
                    showLoading('Logging out...', 'Mohon tunggu sebentar');
                    document.getElementById(formId).submit();
                }
            });
        }

        // Global loading functions
        window.showLoading = showLoading;
        window.hideLoading = hideLoading;

        // Add click event listeners for debugging
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, checking Alpine.js...');
            
            // Wait for Alpine.js to be ready
            setTimeout(() => {
                if (typeof Alpine !== 'undefined') {
                    console.log('Alpine.js is available');
                    
                    const userButtons = document.querySelectorAll('[x-data*="open"] button');
                    console.log('Found user buttons:', userButtons.length);
                    
                    userButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            console.log('User profile button clicked');
                            const parent = this.closest('[x-data*="open"]');
                            if (parent && window.Alpine) {
                                const component = Alpine.$data(parent);
                                console.log('Current open state:', component.open);
                                

                            }
                        });
                    });
                } else {
                    console.error('Alpine.js not available');
                }
            }, 100);
        });


    </script>
    @stack('scripts')
</body>
</html>

