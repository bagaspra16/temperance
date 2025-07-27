@extends('layouts.app')

@section('content')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-4 {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('achievements.show', $achievement->id) }}" class="text-pink-500 hover:text-pink-700 font-semibold transition-colors duration-300 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to Achievement
        </a>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- Achievement Info Card -->
        <div class="bg-gray-800 rounded-2xl p-6 mb-8 border border-gray-700">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white mb-3">{{ $achievement->title }}</h2>
                    <div class="flex items-center gap-6 text-gray-300">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-pink-500"></i>
                            <span>{{ $achievement->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-pink-500"></i>
                            <span>{{ $achievement->formatted_date }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-tag text-pink-500"></i>
                            <span class="px-3 py-1 rounded-full text-sm" style="background-color: {{ $achievement->goal->category->color }}20; color: {{ $achievement->goal->category->color }};">
                                {{ $achievement->goal->category->name }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-400">Certificate No.</p>
                    <p class="text-lg font-mono text-pink-500">{{ $achievement->certificate_number }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Template Selection -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">Choose Template Style</h3>
                    <p class="text-gray-400 mb-6">Select your preferred certificate design. Each template is optimized for different use cases.</p>
                </div>

                <div class="space-y-4">
                    <!-- Traditional Template -->
                    <div class="template-option bg-gray-800 rounded-xl p-6 cursor-pointer border-2 border-transparent hover:border-pink-500 transition-all duration-300" data-template="traditional">
                        <div class="flex items-start gap-4">
                            <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-certificate text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-white mb-2">Traditional Certificate</h4>
                                <p class="text-gray-300 mb-3">Classic certificate layout with elegant design, perfect for printing and framing. Features a professional look with golden accents.</p>
                                <div class="flex items-center gap-4 text-sm text-gray-400">
                                    <span><i class="fas fa-expand-arrows-alt mr-1"></i> 1200 x 800 px</span>
                                    <span><i class="fas fa-print mr-1"></i> Print Ready</span>
                                    <span><i class="fas fa-star mr-1"></i> Professional</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rectangle Template -->
                    <div class="template-option bg-gray-800 rounded-xl p-6 cursor-pointer border-2 border-transparent hover:border-pink-500 transition-all duration-300" data-template="rectangle">
                        <div class="flex items-start gap-4">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-square text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-white mb-2">Square Layout</h4>
                                <p class="text-gray-300 mb-3">Modern square design with clean aesthetics, great for social media sharing and digital display. Perfect for LinkedIn and professional networks.</p>
                                <div class="flex items-center gap-4 text-sm text-gray-400">
                                    <span><i class="fas fa-expand-arrows-alt mr-1"></i> 1000 x 1000 px</span>
                                    <span><i class="fas fa-share-alt mr-1"></i> Social Media</span>
                                    <span><i class="fas fa-palette mr-1"></i> Modern</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instagram Template -->
                    <div class="template-option bg-gray-800 rounded-xl p-6 cursor-pointer border-2 border-transparent hover:border-pink-500 transition-all duration-300" data-template="instagram">
                        <div class="flex items-start gap-4">
                                                    <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-gray-700 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-mobile-alt text-white text-2xl"></i>
                        </div>
                                                    <div class="flex-1">
                            <h4 class="text-lg font-semibold text-white mb-2">Mobile Portrait</h4>
                            <p class="text-gray-300 mb-3">Mobile-friendly portrait design with modern styling. Perfect for phone screens, social media stories, and mobile sharing.</p>
                            <div class="flex items-center gap-4 text-sm text-gray-400">
                                <span><i class="fas fa-expand-arrows-alt mr-1"></i> 1080 x 1920 px</span>
                                <span><i class="fas fa-mobile-alt mr-1"></i> Mobile Ready</span>
                                <span><i class="fas fa-palette mr-1"></i> Modern</span>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Download Button -->
                <div class="pt-6">
                    <button id="downloadBtn" onclick="downloadCertificate()" disabled class="w-full bg-gradient-to-r from-pink-500 to-pink-700 hover:from-pink-600 hover:to-pink-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-4 px-8 rounded-xl shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                        <i class="fas fa-download text-xl"></i>
                        <span class="text-lg">Download Certificate</span>
                    </button>
                    <p class="text-center text-sm text-gray-400 mt-3">High-quality PNG format • Ready for sharing</p>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">Certificate Preview</h3>
                    <p class="text-gray-400 mb-6">See how your certificate will look before downloading.</p>
                </div>

                <div id="certificatePreview" class="bg-white rounded-2xl overflow-hidden shadow-2xl border-4 border-gray-700 flex items-center justify-center">
                    <!-- Preview content will be loaded here -->
                    <div class="flex items-center justify-center text-gray-500">
                        <div class="text-center">
                            <i class="fas fa-image text-6xl mb-4 text-gray-300"></i>
                            <p class="text-lg font-medium text-gray-400">Select a template to see preview</p>
                            <p class="text-sm text-gray-500 mt-2">Choose from the options on the left</p>
                        </div>
                    </div>
                </div>

                <!-- Template Info -->
                <div id="templateInfo" class="bg-gray-800 rounded-xl p-4 border border-gray-700">
                    <h4 class="font-semibold text-white mb-2">Template Information</h4>
                    <div class="space-y-2 text-sm text-gray-300">
                        <div id="templateDetails">
                            <p>Select a template to view details</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Certificate Templates (Hidden) -->
<div class="hidden">
    <!-- Traditional Template -->
    <div id="traditionalTemplate" class="certificate-template">
        <div class="certificate-container" style="width: 480px; height: 320px; background: linear-gradient(135deg, #1f2937 0%, #374151 100%); border: 4px solid #ec4899; position: relative; font-family: 'Inter', sans-serif; transform: scale(0.8); transform-origin: center;">
            <!-- Border Pattern -->
            <div class="absolute inset-2 border-2 border-pink-500"></div>
            
            <!-- Header -->
            <div class="absolute top-6 left-0 right-0 text-center">
                <h1 class="text-xl font-bold text-pink-400 mb-2">Certificate of Achievement</h1>
                <div class="w-44 h-0.5 bg-gradient-to-r from-pink-500 to-pink-600 mx-auto mt-2"></div>
            </div>

            <!-- Content -->
            <div class="absolute top-20 left-4 right-4 text-center">
                <p class="text-xs text-gray-200 mb-3 leading-relaxed line-clamp-3">{{ $achievement->certificate_message }}</p>
                
                <!-- Achievement Details -->
                <div class="bg-gray-800 bg-opacity-90 p-3 mb-3 border border-pink-500/30">
                    <h2 class="text-sm font-bold text-pink-400 mb-1">{{ $achievement->title }}</h2>
                    <p class="text-xs text-gray-300">Awarded to <span class="font-bold text-pink-400">{{ $achievement->user->name }}</span></p>
                    <p class="text-xs text-gray-400">on {{ $achievement->formatted_date }}</p>
                </div>

                <!-- Certificate Number -->
                <p class="text-xs text-gray-300">Certificate No: {{ $achievement->certificate_number }}</p>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-2 left-2 w-4 h-4 border border-pink-500"></div>
            <div class="absolute top-2 right-2 w-4 h-4 border border-pink-500"></div>
            <div class="absolute bottom-2 left-2 w-4 h-4 border border-pink-500"></div>
            <div class="absolute bottom-2 right-2 w-4 h-4 border border-pink-500"></div>
        </div>
    </div>

    <!-- Rectangle Template -->
    <div id="rectangleTemplate" class="certificate-template">
        <div class="certificate-container" style="width: 400px; height: 400px; background: linear-gradient(135deg, #1f2937 0%, #374151 100%); position: relative; font-family: 'Inter', sans-serif; transform: scale(0.8); transform-origin: center;">

            <!-- Content -->
            <div class="absolute inset-6 bg-gray-800 p-6 flex flex-col justify-center items-center text-center border border-pink-500/30">
                <div class="w-18 h-18 flex items-center justify-center mb-8">
                    <i class="fas fa-trophy text-pink-500 text-3xl mt-5"></i>
                </div>
                
                <h1 class="text-xl font-bold text-pink-400 mb-3">Achievement Unlocked!</h1>
                
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-white mb-2">{{ $achievement->title }}</h2>
                    <p class="text-sm text-gray-300 leading-relaxed line-clamp-3">{{ $achievement->certificate_message }}</p>
                </div>

                <div class="bg-gradient-to-r from-pink-500/20 to-pink-600/20 p-3 mb-3 border border-pink-500/30">
                    <p class="text-sm font-semibold text-pink-400 mb-1">Congratulations, {{ $achievement->user->name }}!</p>
                    <p class="text-xs text-gray-300">{{ $achievement->formatted_date }}</p>
                </div>

                <p class="text-xs text-gray-400">Certificate #{{ $achievement->certificate_number }}</p>
            </div>
        </div>
    </div>

    <!-- Mobile Portrait Template -->
    <div id="instagramTemplate" class="certificate-template">
        <div class="certificate-container" style="width: 432px; height: 768px; background: linear-gradient(135deg, #1f2937 0%, #374151 100%); position: relative; font-family: 'Inter', sans-serif; transform: scale(0.8); transform-origin: center;">

            <!-- Main Content -->
            <div class="absolute inset-3 bg-gray-800 rounded-2xl p-6 flex flex-col justify-center items-center text-center border border-pink-500/30">
                <!-- Header -->
                <div class="mb-6">
                    <div class="w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-trophy text-pink-500 text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-pink-400 mb-2">Achievement</h1>

                </div>

                <!-- Achievement Content -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-white mb-3">{{ $achievement->title }}</h2>
                    <p class="text-sm text-gray-300 leading-relaxed mb-4 line-clamp-4">{{ $achievement->certificate_message }}</p>
                    
                    <div class="bg-gradient-to-r from-pink-500/20 to-pink-600/20 rounded-lg p-4 mb-4 border border-pink-500/30">
                        <p class="text-lg font-bold text-pink-400 mb-2">🎉 {{ $achievement->user->name }}</p>
                        <p class="text-sm text-gray-300">{{ $achievement->formatted_date }}</p>
                    </div>
                </div>

                <!-- Affirmation -->
                <div class="bg-gradient-to-r from-pink-500/10 to-pink-600/10 rounded-lg p-4 mb-6 border border-pink-500/20">
                    <p class="text-sm font-medium text-pink-300 italic line-clamp-3">{{ $achievement->affirmation_message }}</p>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-between w-full text-xs text-gray-400">
                    <span>#{{ $achievement->certificate_number }}</span>
                    <span>🏆 Achievement</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Full-size templates for download (hidden) -->
    <div class="hidden">
        <!-- Traditional Template Full Size -->
        <div id="traditionalTemplateFull" class="certificate-template">
            <div class="certificate-container" style="width: 1200px; height: 800px; background: linear-gradient(135deg, #1f2937 0%, #374151 100%); border: 8px solid #ec4899; position: relative; font-family: 'Inter', sans-serif;">
                <!-- Border Pattern -->
                <div class="absolute inset-4 border-2 border-pink-500"></div>
                
                <!-- Header -->
                <div class="absolute top-20 left-0 right-0 text-center">
                    <h1 class="text-6xl font-bold text-pink-400 mb-6">Certificate of Achievement</h1>
                    <div class="w-1/3 h-1 bg-gradient-to-r from-pink-500 to-pink-600 mx-auto mt-7"></div>
                </div>

                <!-- Content -->
                <div class="absolute top-60 left-20 right-20 text-center">
                    <p class="text-2xl text-gray-200 mb-10 leading-relaxed">{{ $achievement->certificate_message }}</p>
                    
                    <!-- Achievement Details -->
                    <div class="bg-gray-800 bg-opacity-90 p-8 mb-10 border border-pink-500/30">
                        <h2 class="text-3xl font-bold text-pink-400 mb-4">{{ $achievement->title }}</h2>
                        <p class="text-xl text-gray-300">Awarded to <span class="font-bold text-pink-400">{{ $achievement->user->name }}</span></p>
                        <p class="text-lg text-gray-400 mt-2">on {{ $achievement->formatted_date }}</p>
                    </div>

                    <!-- Certificate Number -->
                    <p class="text-lg text-gray-300">Certificate No: {{ $achievement->certificate_number }}</p>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute top-8 left-8 w-12 h-12 border-4 border-pink-500"></div>
                <div class="absolute top-8 right-8 w-12 h-12 border-4 border-pink-500"></div>
                <div class="absolute bottom-8 left-8 w-12 h-12 border-4 border-pink-500"></div>
                <div class="absolute bottom-8 right-8 w-12 h-12 border-4 border-pink-500"></div>
            </div>
        </div>

        <!-- Rectangle Template Full Size -->
        <div id="rectangleTemplateFull" class="certificate-template">
            <div class="certificate-container" style="width: 1000px; height: 1000px; background: linear-gradient(135deg, #1f2937 0%, #374151 100%); position: relative; font-family: 'Inter', sans-serif;">

                <!-- Content -->
                <div class="absolute inset-16 bg-gray-800 p-12 flex flex-col justify-center items-center text-center border border-pink-500/30">
                    <div class="w-24 h-24 flex items-center justify-center mb-8">
                        <i class="fas fa-trophy text-pink-500 text-7xl"></i>
                    </div>
                    
                    <h1 class="text-4xl font-bold text-pink-400 mb-6">Achievement Unlocked!</h1>
                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-white mb-4">{{ $achievement->title }}</h2>
                        <p class="text-lg text-gray-300 leading-relaxed">{{ $achievement->certificate_message }}</p>
                    </div>

                    <div class="bg-gradient-to-r from-pink-500/20 to-pink-600/20 p-6 mb-6 border border-pink-500/30">
                        <p class="text-xl font-semibold text-pink-400 mb-2">Congratulations, {{ $achievement->user->name }}!</p>
                        <p class="text-lg text-gray-300">{{ $achievement->formatted_date }}</p>
                    </div>

                    <p class="text-sm text-gray-400">Certificate #{{ $achievement->certificate_number }}</p>
                </div>
            </div>
        </div>

        <!-- Mobile Portrait Template Full Size -->
        <div id="instagramTemplateFull" class="certificate-template">
            <div class="certificate-container" style="width: 1080px; height: 1920px; background: linear-gradient(135deg, #1f2937 0%, #374151 100%); position: relative; font-family: 'Inter', sans-serif;">

                <!-- Main Content -->
                <div class="absolute inset-8 bg-gray-800 rounded-3xl p-12 flex flex-col justify-center items-center text-center border border-pink-500/30">
                    <!-- Header -->
                    <div class="mb-12">
                        <div class="w-32 h-32 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-trophy text-pink-500 text-7xl"></i>
                        </div>
                        <h1 class="text-5xl font-bold text-pink-400 mb-4">Achievement</h1>
                    </div>

                    <!-- Achievement Content -->
                    <div class="mb-12">
                        <h2 class="text-4xl font-bold text-white mb-6">{{ $achievement->title }}</h2>
                        <p class="text-2xl text-gray-300 leading-relaxed mb-8">{{ $achievement->certificate_message }}</p>
                        
                        <div class="bg-gradient-to-r from-pink-500/20 to-pink-600/20 rounded-2xl p-8 mb-8 border border-pink-500/30">
                            <p class="text-3xl font-bold text-pink-400 mb-4">🎉 {{ $achievement->user->name }}</p>
                            <p class="text-2xl text-gray-300">{{ $achievement->formatted_date }}</p>
                        </div>
                    </div>

                    <!-- Affirmation -->
                    <div class="bg-gradient-to-r from-pink-500/10 to-pink-600/10 rounded-xl p-6 mb-8 border border-pink-500/20">
                        <p class="text-2xl font-medium text-pink-300 italic">{{ $achievement->affirmation_message }}</p>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-between w-full text-lg text-gray-400">
                        <span>#{{ $achievement->certificate_number }}</span>
                        <span>🏆 Achievement</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
let selectedTemplate = null;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Template selection
    document.querySelectorAll('.template-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.template-option').forEach(opt => {
                opt.classList.remove('border-pink-500');
                opt.classList.add('border-transparent');
            });
            
            // Add active class to selected option
            this.classList.remove('border-transparent');
            this.classList.add('border-pink-500');
            
            selectedTemplate = this.dataset.template;
            updatePreview();
            updateTemplateInfo();
            enableDownloadButton();
        });
    });
});

function updatePreview() {
    const preview = document.getElementById('certificatePreview');
    const template = document.getElementById(selectedTemplate + 'Template');
    
    if (template) {
        const clone = template.cloneNode(true);
        clone.classList.remove('hidden');
        
        // Clear previous content
        preview.innerHTML = '';
        
        // Add the template
        preview.appendChild(clone);
        
        // Center the certificate in preview
        const certificateContainer = preview.querySelector('.certificate-container');
        if (certificateContainer) {
            certificateContainer.style.margin = 'auto';
            certificateContainer.style.display = 'block';
        }
    }
}

function updateTemplateInfo() {
    const templateInfo = document.getElementById('templateDetails');
    const info = getTemplateInfo(selectedTemplate);
    templateInfo.innerHTML = info;
}

function getTemplateInfo(template) {
    const info = {
        traditional: `
            <div class="space-y-2">
                <p><strong>Format:</strong> Landscape (1200 x 800 px)</p>
                <p><strong>Best for:</strong> Printing, framing, professional display</p>
                <p><strong>Features:</strong> Classic design, golden accents, elegant typography</p>
                <p><strong>Quality:</strong> High-resolution, print-ready</p>
            </div>
        `,
        rectangle: `
            <div class="space-y-2">
                <p><strong>Format:</strong> Square (1000 x 1000 px)</p>
                <p><strong>Best for:</strong> Social media, LinkedIn, digital portfolios</p>
                <p><strong>Features:</strong> Modern design, clean layout, professional look</p>
                <p><strong>Quality:</strong> High-resolution, optimized for screens</p>
            </div>
        `,
        instagram: `
            <div class="space-y-2">
                <p><strong>Format:</strong> Portrait (1080 x 1920 px)</p>
                <p><strong>Best for:</strong> Mobile screens, social media stories, phone sharing</p>
                <p><strong>Features:</strong> Modern design, mobile-optimized, portrait layout</p>
                <p><strong>Quality:</strong> High-resolution, perfect for mobile viewing</p>
            </div>
        `
    };
    
    return info[template] || '<p>Select a template to view details</p>';
}

function enableDownloadButton() {
    const downloadBtn = document.getElementById('downloadBtn');
    downloadBtn.disabled = false;
    downloadBtn.classList.remove('opacity-50', 'cursor-not-allowed');
}

function downloadCertificate() {
    if (!selectedTemplate) {
        Swal.fire({
            title: 'Please Select Template',
            text: 'Please choose a certificate template first.',
            icon: 'warning',
            background: 'linear-gradient(to top right, #1f2937, #374151)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                title: 'text-2xl font-bold text-yellow-400 pt-4',
                htmlContainer: 'text-lg text-gray-300 pb-4'
            }
        });
        return;
    }

    // Show loading
    Swal.fire({
        title: 'Generating Certificate...',
        html: 'Creating your high-quality certificate...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-blue-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4'
        }
    });

    // Generate certificate
    fetch('{{ route("achievements.generate", $achievement->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            template: selectedTemplate
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            generatePNG();
        } else {
            throw new Error('Failed to generate certificate data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Failed to generate certificate. Please try again.',
            icon: 'error',
            background: 'linear-gradient(to top right, #1f2937, #374151)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                title: 'text-2xl font-bold text-red-400 pt-4',
                htmlContainer: 'text-lg text-gray-300 pb-4'
            }
        });
    });
}

function generatePNG() {
    // Create a temporary container for the full-size certificate
    const tempContainer = document.createElement('div');
    tempContainer.style.position = 'absolute';
    tempContainer.style.left = '-9999px';
    tempContainer.style.top = '-9999px';
    document.body.appendChild(tempContainer);

    // Get the full-size template
    const fullTemplate = document.getElementById(selectedTemplate + 'TemplateFull');
    if (!fullTemplate) {
        Swal.fire({
            title: 'Error',
            text: 'Certificate template not found.',
            icon: 'error',
            background: 'linear-gradient(to top right, #1f2937, #374151)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                title: 'text-2xl font-bold text-red-400 pt-4',
                htmlContainer: 'text-lg text-gray-300 pb-4'
            }
        });
        return;
    }

    // Clone the full-size template
    const fullCertificate = fullTemplate.cloneNode(true);
    fullCertificate.classList.remove('hidden');
    tempContainer.appendChild(fullCertificate);

    const certificateElement = fullCertificate.querySelector('.certificate-container');
    
    if (!certificateElement) {
        Swal.fire({
            title: 'Error',
            text: 'Certificate container not found.',
            icon: 'error',
            background: 'linear-gradient(to top right, #1f2937, #374151)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                title: 'text-2xl font-bold text-red-400 pt-4',
                htmlContainer: 'text-lg text-gray-300 pb-4'
            }
        });
        return;
    }

    // Configure html2canvas for high quality
    const options = {
        scale: 2, // Higher resolution
        useCORS: true,
        allowTaint: true,
        backgroundColor: null,
        width: certificateElement.offsetWidth,
        height: certificateElement.offsetHeight,
        logging: false
    };

    html2canvas(certificateElement, options).then(canvas => {
        // Convert to blob
        canvas.toBlob(function(blob) {
            // Create download link
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `achievement-certificate-${selectedTemplate}-{{ $achievement->certificate_number }}.png`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            // Clean up temporary container
            document.body.removeChild(tempContainer);

            // Success message
            Swal.fire({
                title: 'Certificate Downloaded!',
                html: 'Your high-quality certificate has been downloaded successfully.',
                icon: 'success',
                background: 'linear-gradient(to top right, #1f2937, #374151)',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl border border-gray-700',
                    title: 'text-2xl font-bold text-green-400 pt-4',
                    htmlContainer: 'text-lg text-gray-300 pb-4'
                }
            });
        }, 'image/png', 1.0);
    }).catch(error => {
        console.error('Error generating PNG:', error);
        document.body.removeChild(tempContainer);
        Swal.fire({
            title: 'Error',
            text: 'Failed to generate PNG. Please try again.',
            icon: 'error',
            background: 'linear-gradient(to top right, #1f2937, #374151)',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-gray-700',
                title: 'text-2xl font-bold text-red-400 pt-4',
                htmlContainer: 'text-lg text-gray-300 pb-4'
            }
        });
    });
}
</script>
@endpush 