@extends('layouts.legal')

@section('title', 'Terms of Service')

@section('content')
<div class="min-h-screen">
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl pb-6">
            
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full">
                        <i class="fas fa-file-contract text-2xl text-white"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-500 to-blue-700 bg-clip-text text-transparent drop-shadow mb-3">
                    Terms of Service
                </h1>
                <p class="text-lg text-gray-300 mb-4">
                    Please read these terms carefully before using Temperance
                </p>
                <p class="text-sm text-gray-400">
                    Last updated: {{ date('F d, Y') }}
                </p>
            </div>

            <!-- Terms Content -->
            <div class="bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Introduction -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">1</span>
                                Introduction
                            </h2>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                Welcome to Temperance. These Terms of Service ("Terms") govern your use of our productivity application and services. By accessing or using Temperance, you agree to be bound by these Terms and our Privacy Policy.
                            </p>
                        </section>

                        <!-- Acceptance of Terms -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">2</span>
                                Acceptance of Terms
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                By creating an account or using our services, you acknowledge that you have read, understood, and agree to be bound by these Terms. If you do not agree to these Terms, please do not use our services.
                            </p>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                We reserve the right to modify these Terms at any time. We will notify users of any material changes via email or through our application.
                            </p>
                        </section>

                        <!-- User Accounts -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">3</span>
                                User Accounts
                            </h2>
                            <div class="space-y-3">
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Account Creation:</strong> You must provide accurate, current, and complete information when creating your account. You are responsible for maintaining the confidentiality of your account credentials.
                                </p>
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Account Security:</strong> You are responsible for all activities that occur under your account. Notify us immediately of any unauthorized use of your account.
                                </p>
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Account Termination:</strong> We reserve the right to terminate or suspend your account at any time for violation of these Terms.
                                </p>
                            </div>
                        </section>

                        <!-- Acceptable Use -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">4</span>
                                Acceptable Use
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                You agree to use Temperance only for lawful purposes and in accordance with these Terms. You agree not to:
                            </p>
                            <ul class="list-disc list-inside text-gray-300 space-y-1 ml-4 text-sm">
                                <li>Use the service for any illegal or unauthorized purpose</li>
                                <li>Violate any applicable laws or regulations</li>
                                <li>Infringe upon the rights of others</li>
                                <li>Attempt to gain unauthorized access to our systems</li>
                                <li>Interfere with or disrupt the service</li>
                                <li>Share your account credentials with others</li>
                                <li>Use the service to store or transmit malicious code</li>
                            </ul>
                        </section>

                        <!-- Privacy and Data -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">5</span>
                                Privacy and Data
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                Your privacy is important to us. Our collection and use of personal information is governed by our Privacy Policy, which is incorporated into these Terms by reference.
                            </p>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                You retain ownership of your data. We will not sell, rent, or share your personal information with third parties except as described in our Privacy Policy.
                            </p>
                        </section>

                        <!-- Intellectual Property -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">6</span>
                                Intellectual Property
                            </h2>
                            <div class="space-y-3">
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Our Rights:</strong> Temperance and its original content, features, and functionality are owned by us and are protected by international copyright, trademark, and other intellectual property laws.
                                </p>
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Your Content:</strong> You retain ownership of any content you create using our service. By using our service, you grant us a limited license to store and process your content to provide the service.
                                </p>
                            </div>
                        </section>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Service Availability -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">7</span>
                                Service Availability
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                We strive to provide reliable service but cannot guarantee uninterrupted access. We may perform maintenance, updates, or modifications that temporarily affect service availability.
                            </p>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                We are not liable for any damages resulting from service interruptions, data loss, or other technical issues.
                            </p>
                        </section>

                        <!-- Limitation of Liability -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">8</span>
                                Limitation of Liability
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                To the maximum extent permitted by law, Temperance shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or use.
                            </p>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                Our total liability to you for any claims arising from these Terms or your use of our service shall not exceed the amount you paid us in the 12 months preceding the claim.
                            </p>
                        </section>

                        <!-- Indemnification -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">9</span>
                                Indemnification
                            </h2>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                You agree to indemnify and hold harmless Temperance, its officers, directors, employees, and agents from any claims, damages, or expenses arising from your use of the service or violation of these Terms.
                            </p>
                        </section>

                        <!-- Governing Law -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">10</span>
                                Governing Law
                            </h2>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                These Terms shall be governed by and construed in accordance with the laws of Indonesia. Any disputes arising from these Terms shall be resolved in the courts of Indonesia.
                            </p>
                        </section>

                        <!-- Contact Information -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">11</span>
                                Contact Information
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                If you have any questions about these Terms of Service, please contact us:
                            </p>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <p class="text-gray-300 text-sm"><strong class="text-white">Email:</strong> support-temperance@gmail.com</p>
                                <p class="text-gray-300 text-sm"><strong class="text-white">Website:</strong> www.temperance.com</p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 