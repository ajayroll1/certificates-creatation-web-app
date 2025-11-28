// Main JavaScript File

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Confirm delete actions
    const deleteLinks = document.querySelectorAll('a[href*="delete"]');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this certificate?')) {
                e.preventDefault();
            }
        });
    });

    // Auto-generate certificate number
    const certificateNumberInput = document.getElementById('certificate_number');
    if (certificateNumberInput && !certificateNumberInput.value) {
        const generateBtn = document.createElement('button');
        generateBtn.type = 'button';
        generateBtn.className = 'btn btn-sm btn-outline-secondary mt-2';
        generateBtn.innerHTML = '<i class="fas fa-magic me-2"></i>Auto Generate';
        generateBtn.onclick = function() {
            const year = new Date().getFullYear();
            const random = Math.floor(Math.random() * 10000).toString().padStart(5, '0');
            certificateNumberInput.value = `CERT-${year}-${random}`;
        };
        certificateNumberInput.parentElement.appendChild(generateBtn);
    }
});