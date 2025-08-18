@extends('layouts.legal')

@section('title', 'Contact Us')

@section('content')
<div class="min-h-screen">
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl pb-6">
            
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full">
                        <i class="fas fa-envelope text-2xl text-white"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-500 to-purple-700 bg-clip-text text-transparent drop-shadow mb-3">
                    Contact Us
                </h1>
                <p class="text-lg text-gray-300 mb-4">
                    Get in touch with our support team
                </p>
            </div>

            <!-- Contact Content -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                
                <!-- Contact Information -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700">
                    <h2 class="text-2xl font-bold text-white mb-6">Get in Touch</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium">Email Support</h4>
                                <p class="text-gray-400">support-temperance@gmail.com</p>
                                <p class="text-sm text-gray-500">Response within 24 hours</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium">Support Hours</h4>
                                <p class="text-gray-400">Monday - Friday: 9:00 AM - 6:00 PM (WIB)</p>
                                <p class="text-gray-400">Saturday: 9:00 AM - 2:00 PM (WIB)</p>
                                <p class="text-gray-400">Sunday: Closed</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-globe text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-medium">Website</h4>
                                <p class="text-gray-400">www.temperance.com</p>
                                <p class="text-sm text-gray-500">Visit our main website</p>
                            </div>
                        </div>


                    </div>


                </div>

                <!-- Contact Form -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700">
                    <h2 class="text-2xl font-bold text-white mb-6">Send us a Message</h2>
                    
                    <form class="space-y-6" id="contactForm">
                        <div>
                            <label class="block text-white font-medium mb-2">Name *</label>
                            <input type="text" name="name" required 
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                   placeholder="Your full name">
                        </div>

                        <div>
                            <label class="block text-white font-medium mb-2">Email *</label>
                            <input type="email" name="email" required 
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                   placeholder="your.email@example.com">
                        </div>

                        <div>
                            <label class="block text-white font-medium mb-2">Subject *</label>
                            <select name="subject" required 
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300">
                                <option value="">Select a subject</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Account Issues">Account Issues</option>
                                <option value="Feature Request">Feature Request</option>
                                <option value="Bug Report">Bug Report</option>
                                <option value="Billing Question">Billing Question</option>
                                <option value="Privacy Concern">Privacy Concern</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-white font-medium mb-2">Priority</label>
                            <select name="priority" 
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300">
                                <option value="Low">Low - General question</option>
                                <option value="Medium">Medium - Feature request</option>
                                <option value="High">High - Technical issue</option>
                                <option value="Urgent">Urgent - Account security</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-white font-medium mb-2">Message *</label>
                            <textarea name="message" rows="5" required 
                                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 resize-none"
                                      placeholder="Please describe your issue or question in detail..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="newsletter" id="newsletter" 
                                   class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                            <label for="newsletter" class="ml-2 text-sm text-gray-300">
                                Subscribe to our newsletter for updates and tips
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>

            </div>

            <!-- FAQ Section -->
            <div class="mt-8 bg-gray-800 rounded-xl p-6 shadow-2xl border border-gray-700">
                <h2 class="text-xl font-bold text-white mb-4 text-center">Frequently Asked Questions</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h3 class="text-lg font-semibold text-white mb-2">How quickly will I get a response?</h3>
                            <p class="text-gray-300 text-sm">We typically respond within 24 hours during business days. For urgent issues, use our emergency support channel.</p>
                        </div>
                        
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Can I request a feature?</h3>
                            <p class="text-gray-300 text-sm">Absolutely! We welcome feature requests. Please use the "Feature Request" subject when contacting us.</p>
                        </div>
                        
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h3 class="text-lg font-semibold text-white mb-2">What if I forgot my password?</h3>
                            <p class="text-gray-300 text-sm">Use the "Forgot Password" link on the login page. If you're still having issues, contact our support team.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Is my data secure?</h3>
                            <p class="text-gray-300 text-sm">Yes, we use industry-standard encryption and security measures to protect your data. See our Privacy Policy for details.</p>
                        </div>
                        
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Can I export my data?</h3>
                            <p class="text-gray-300 text-sm">Yes, you can export your data in various formats. Contact us for assistance with data export.</p>
                        </div>
                        
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Do you offer refunds?</h3>
                            <p class="text-gray-300 text-sm">We offer a 30-day money-back guarantee. Contact our billing team for refund requests.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Contact form handling
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show success message
    Swal.fire({
        title: 'Message Sent Successfully!',
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
</script>
@endpush
@endsection 