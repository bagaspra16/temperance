// Temperance App JavaScript

// Include Axios from CDN
if (typeof axios === 'undefined') {
    // Create a script element to load Axios
    const axiosScript = document.createElement('script');
    axiosScript.src = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
    axiosScript.async = true;
    document.head.appendChild(axiosScript);
    
    // Configure Axios once it's loaded
    axiosScript.onload = function() {
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    };
} else {
    // Axios is already loaded
    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}

// CSRF Token handling
document.addEventListener('DOMContentLoaded', function() {
    // Get the CSRF token from the meta tag
    const token = document.head.querySelector('meta[name="csrf-token"]');
    
    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found');
    }
});