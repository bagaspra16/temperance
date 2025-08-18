@extends('layouts.legal')

@section('title', 'Privacy Policy')

@section('content')
<div class="min-h-screen">
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl pb-6">
            
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full">
                        <i class="fas fa-shield-alt text-2xl text-white"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-green-500 to-green-700 bg-clip-text text-transparent drop-shadow mb-3">
                    Privacy Policy
                </h1>
                <p class="text-lg text-gray-300 mb-4">
                    How we collect, use, and protect your personal information
                </p>
                <p class="text-sm text-gray-400">
                    Last updated: {{ date('F d, Y') }}
                </p>
            </div>

            <!-- Privacy Content -->
            <div class="bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Introduction -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">1</span>
                                Introduction
                            </h2>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                At Temperance, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our productivity application.
                            </p>
                        </section>

                        <!-- Information We Collect -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">2</span>
                                Information We Collect
                            </h2>
                            <div class="space-y-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Personal Information</h3>
                                    <ul class="list-disc list-inside text-gray-300 space-y-1 ml-4 text-sm">
                                        <li>Name and email address when you create an account</li>
                                        <li>Profile information you choose to provide</li>
                                        <li>Account preferences and settings</li>
                                        <li>Communication history with our support team</li>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Usage Information</h3>
                                    <ul class="list-disc list-inside text-gray-300 space-y-1 ml-4 text-sm">
                                        <li>Goals, tasks, and categories you create</li>
                                        <li>Time tracking data and progress information</li>
                                        <li>Journal entries and reflections</li>
                                        <li>Application usage patterns and preferences</li>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Technical Information</h3>
                                    <ul class="list-disc list-inside text-gray-300 space-y-1 ml-4 text-sm">
                                        <li>Device information and browser type</li>
                                        <li>IP address and location data</li>
                                        <li>Application logs and error reports</li>
                                        <li>Cookies and similar tracking technologies</li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <!-- How We Use Your Information -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">3</span>
                                How We Use Your Information
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                We use the information we collect to:
                            </p>
                            <ul class="list-disc list-inside text-gray-300 space-y-1 ml-4 text-sm">
                                <li>Provide and maintain our productivity services</li>
                                <li>Process your account registration and manage your account</li>
                                <li>Personalize your experience and provide relevant features</li>
                                <li>Analyze usage patterns to improve our application</li>
                                <li>Send you important updates and notifications</li>
                                <li>Provide customer support and respond to inquiries</li>
                                <li>Ensure the security and integrity of our services</li>
                                <li>Comply with legal obligations and enforce our terms</li>
                            </ul>
                        </section>

                        <!-- Information Sharing -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">4</span>
                                Information Sharing
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                We do not sell, rent, or trade your personal information to third parties. We may share your information only in the following circumstances:
                            </p>
                            <div class="space-y-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Service Providers</h3>
                                    <p class="text-gray-300 leading-relaxed text-sm">
                                        We may share information with trusted third-party service providers who assist us in operating our application, such as hosting providers, analytics services, and customer support tools.
                                    </p>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Legal Requirements</h3>
                                    <p class="text-gray-300 leading-relaxed text-sm">
                                        We may disclose your information if required by law, court order, or government regulation, or to protect our rights, property, or safety.
                                    </p>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Business Transfers</h3>
                                    <p class="text-gray-300 leading-relaxed text-sm">
                                        In the event of a merger, acquisition, or sale of assets, your information may be transferred as part of the business transaction.
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- Data Security -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">5</span>
                                Data Security
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.
                            </p>
                            <div class="space-y-3">
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Encryption:</strong> We use industry-standard encryption to protect data in transit and at rest.
                                </p>
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Access Controls:</strong> We limit access to personal information to authorized personnel only.
                                </p>
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Regular Audits:</strong> We conduct regular security assessments and updates to maintain data protection.
                                </p>
                            </div>
                        </section>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Data Retention -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">6</span>
                                Data Retention
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                We retain your personal information for as long as necessary to provide our services and fulfill the purposes outlined in this Privacy Policy.
                            </p>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                When you delete your account, we will delete or anonymize your personal information within 30 days, except where we are required to retain certain information for legal or regulatory purposes.
                            </p>
                        </section>

                        <!-- Your Rights -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">7</span>
                                Your Rights
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                You have the following rights regarding your personal information:
                            </p>
                            <ul class="list-disc list-inside text-gray-300 space-y-1 ml-4 text-sm">
                                <li><strong class="text-white">Access:</strong> Request a copy of your personal information</li>
                                <li><strong class="text-white">Correction:</strong> Update or correct inaccurate information</li>
                                <li><strong class="text-white">Deletion:</strong> Request deletion of your personal information</li>
                                <li><strong class="text-white">Portability:</strong> Request a copy of your data in a portable format</li>
                                <li><strong class="text-white">Restriction:</strong> Request restriction of processing</li>
                                <li><strong class="text-white">Objection:</strong> Object to certain types of processing</li>
                            </ul>
                            <p class="text-gray-300 leading-relaxed mt-3 text-sm">
                                To exercise these rights, please contact us using the information provided below.
                            </p>
                        </section>

                        <!-- Cookies and Tracking -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">8</span>
                                Cookies and Tracking
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                We use cookies and similar tracking technologies to enhance your experience and analyze application usage.
                            </p>
                            <div class="space-y-3">
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Essential Cookies:</strong> Required for basic application functionality
                                </p>
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Analytics Cookies:</strong> Help us understand how users interact with our application
                                </p>
                                <p class="text-gray-300 leading-relaxed text-sm">
                                    <strong class="text-white">Preference Cookies:</strong> Remember your settings and preferences
                                </p>
                            </div>
                            <p class="text-gray-300 leading-relaxed mt-3 text-sm">
                                You can control cookie settings through your browser preferences, though disabling certain cookies may affect application functionality.
                            </p>
                        </section>

                        <!-- Children's Privacy -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">9</span>
                                Children's Privacy
                            </h2>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                Our services are not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If you believe we have collected information from a child under 13, please contact us immediately.
                            </p>
                        </section>

                        <!-- International Transfers -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">10</span>
                                International Transfers
                            </h2>
                            <p class="text-gray-300 leading-relaxed text-sm">
                                Your information may be transferred to and processed in countries other than your own. We ensure that such transfers comply with applicable data protection laws and implement appropriate safeguards to protect your information.
                            </p>
                        </section>

                        <!-- Changes to Privacy Policy -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">11</span>
                                Changes to Privacy Policy
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                We may update this Privacy Policy from time to time to reflect changes in our practices or applicable laws. We will notify you of any material changes by:
                            </p>
                            <ul class="list-disc list-inside text-gray-300 space-y-1 ml-4 text-sm">
                                <li>Posting the updated policy on our application</li>
                                <li>Sending you an email notification</li>
                                <li>Displaying a notice within the application</li>
                            </ul>
                            <p class="text-gray-300 leading-relaxed mt-3 text-sm">
                                Your continued use of our services after such changes constitutes acceptance of the updated Privacy Policy.
                            </p>
                        </section>

                        <!-- Contact Information -->
                        <section class="hover:bg-gray-700 p-4 rounded-lg transition-all duration-300">
                            <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                                <span class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-xs font-bold mr-3">12</span>
                                Contact Information
                            </h2>
                            <p class="text-gray-300 leading-relaxed mb-3 text-sm">
                                If you have any questions about this Privacy Policy or our data practices, please contact us:
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