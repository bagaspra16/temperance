/**
 * Temperance Application JavaScript
 */

// Global Loading Screen Management
class LoadingManager {
    constructor() {
        this.overlay = document.getElementById('loadingOverlay');
        this.loadingText = this.overlay?.querySelector('.loading-text');
        this.loadingSubtext = this.overlay?.querySelector('.loading-subtext');
        this.isVisible = false;
        this.timeoutId = null;
    }

    show(message = 'Memproses...', subMessage = 'Mohon tunggu sebentar') {
        if (!this.overlay) return;
        
        if (this.loadingText) this.loadingText.textContent = message;
        if (this.loadingSubtext) this.loadingSubtext.textContent = subMessage;
        
        this.overlay.classList.add('show');
        this.isVisible = true;
        
        // Clear any existing timeout
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
            this.timeoutId = null;
        }
    }

    hide() {
        if (!this.overlay) return;
        
        this.overlay.classList.remove('show');
        this.isVisible = false;
        
        // Clear any existing timeout
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
            this.timeoutId = null;
        }
    }

    hideWithDelay(delay = 500) {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
        }
        
        this.timeoutId = setTimeout(() => {
            this.hide();
        }, delay);
    }
}

// Initialize loading manager
const loadingManager = new LoadingManager();

// Global loading functions
window.showLoading = (message, subMessage) => loadingManager.show(message, subMessage);
window.hideLoading = () => loadingManager.hide();

// Enhanced form submission handling
document.addEventListener('DOMContentLoaded', function() {
    // Handle all form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const buttonText = submitButton.textContent.trim();
                if (buttonText.includes('Create') || buttonText.includes('Buat') || buttonText.includes('Tambah')) {
                    loadingManager.show('Membuat data...', 'Mohon tunggu sebentar');
                } else if (buttonText.includes('Update') || buttonText.includes('Update') || buttonText.includes('Simpan')) {
                    loadingManager.show('Menyimpan perubahan...', 'Mohon tunggu sebentar');
                } else if (buttonText.includes('Delete') || buttonText.includes('Hapus')) {
                    loadingManager.show('Menghapus data...', 'Mohon tunggu sebentar');
                } else {
                    loadingManager.show('Memproses...', 'Mohon tunggu sebentar');
                }
            } else {
                loadingManager.show('Memproses...', 'Mohon tunggu sebentar');
            }
        });
    });

    // Handle navigation links
    const navLinks = document.querySelectorAll('a[href]:not([href^="#"]):not([href^="javascript:"]):not([onclick])');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Skip if it's a download link or external link
            if (this.href.includes('download') || this.href.includes('mailto:') || this.href.includes('tel:')) {
                return;
            }
            
            // Skip if it's already handled by onclick
            if (this.hasAttribute('onclick')) {
                return;
            }
            
            loadingManager.show('Memuat halaman...', 'Mohon tunggu sebentar');
        });
    });

    // Handle AJAX requests
    const originalFetch = window.fetch;
    window.fetch = function(...args) {
        loadingManager.show('Memproses...', 'Mohon tunggu sebentar');
        return originalFetch.apply(this, args)
            .finally(() => {
                loadingManager.hideWithDelay(500);
            });
    };

    // Handle XMLHttpRequest
    const originalXHROpen = XMLHttpRequest.prototype.open;
    const originalXHRSend = XMLHttpRequest.prototype.send;
    
    XMLHttpRequest.prototype.open = function() {
        this._loadingShown = false;
        return originalXHROpen.apply(this, arguments);
    };
    
    XMLHttpRequest.prototype.send = function() {
        if (!this._loadingShown) {
            loadingManager.show('Memproses...', 'Mohon tunggu sebentar');
            this._loadingShown = true;
        }
        
        this.addEventListener('loadend', function() {
            loadingManager.hideWithDelay(500);
        });
        
        return originalXHRSend.apply(this, arguments);
    };

    // Auto-hide loading after page load
    window.addEventListener('load', function() {
        loadingManager.hideWithDelay(500);
    });
});

// Enhanced SweetAlert2 confirmations with loading
window.showDeleteConfirmation = function(formId, itemName, itemType = 'item') {
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
            loadingManager.show('Menghapus data...', 'Mohon tunggu sebentar');
            document.getElementById(formId).submit();
        }
    });
};

window.showLogoutConfirmation = function(formId) {
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
            loadingManager.show('Logging out...', 'Mohon tunggu sebentar');
            document.getElementById(formId).submit();
        }
    });
};

// Enhanced task status change confirmations
window.showStartConfirmation = function(taskId, taskTitle) {
    Swal.fire({
        title: 'Start Task?',
        html: `Task <strong>"${taskTitle}"</strong> will be started and status will change to <b>in progress</b>.`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes, Start!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-blue-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
            cancelButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            loadingManager.show('Memulai task...', 'Mohon tunggu sebentar');
            document.getElementById('start-task-form-' + taskId).submit();
        }
    });
};

window.showCompleteConfirmation = function(taskId, taskTitle) {
    Swal.fire({
        title: 'Complete Task?',
        html: `Task <strong>"${taskTitle}"</strong> will be marked as completed.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Complete!',
        cancelButtonText: 'Cancel',
        background: 'linear-gradient(to top right, #1f2937, #374151)',
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-700',
            title: 'text-2xl font-bold text-pink-400 pt-4',
            htmlContainer: 'text-lg text-gray-300 pb-4',
            actions: 'w-full flex justify-center gap-x-4 px-4',
            confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg',
            cancelButton: 'bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            loadingManager.show('Menyelesaikan task...', 'Mohon tunggu sebentar');
            document.getElementById('finish-task-form-' + taskId).submit();
        }
    });
};

// Utility functions
window.openDownloadModal = function(url) {
    loadingManager.show('Mengunduh sertifikat...', 'Mohon tunggu sebentar');
    window.location.href = url;
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any additional components here
    console.log('Temperance application initialized');
});