/**
 * Admin Common JavaScript Functions
 * Handles CSRF tokens and common admin functionality
 */

// CSRF Token Management
window.AdminCSRF = {
    token: null,
    hash: null,
    
    init: function(token, hash) {
        this.token = token;
        this.hash = hash;
    },
    
    getHeaders: function() {
        return {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': this.hash
        };
    },
    
    getBody: function(data = {}) {
        const body = { ...data };
        body[this.token] = this.hash;
        return JSON.stringify(body);
    },
    
    fetch: function(url, options = {}) {
        const defaultOptions = {
            method: 'POST',
            headers: this.getHeaders(),
            body: this.getBody(options.data || {})
        };
        
        return fetch(url, { ...defaultOptions, ...options });
    }
};

// Common Admin Functions
window.AdminUtils = {
    // Toggle status with CSRF protection
    toggleStatus: function(url, successCallback = null) {
        if (!AdminCSRF.token) {
            console.error('CSRF token not initialized');
            return;
        }
        
        AdminCSRF.fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (successCallback) {
                        successCallback(data);
                    } else {
                        location.reload();
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status');
            });
    },
    
    // Confirm and execute action
    confirmAction: function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    },
    
    // Show success message
    showSuccess: function(message) {
        // You can customize this to use toast notifications
        alert(message);
    },
    
    // Show error message
    showError: function(message) {
        alert('Error: ' + message);
    }
};