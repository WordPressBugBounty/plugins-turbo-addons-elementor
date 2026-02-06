document.addEventListener('DOMContentLoaded', function () { 
    // Check if the session storage flag exists
    if (sessionStorage.getItem('trad-CloseButtonDataStore')) {
        // Hide the alert if the flag is set
        document.querySelectorAll('.trad-fancy-alert-container').forEach(function(alertContainer) {
            alertContainer.style.display = 'none';
        });
    } else {
        // Add an event listener to the close button
        document.body.addEventListener('click', function (event) {
            if (event.target.classList.contains('trad-fancy-alert-close-button')) {
                const alertContainer = event.target.closest('.trad-fancy-alert-container');
                if (alertContainer) {
                    alertContainer.style.display = 'none';
                    
                    // Set a session storage flag so the alert doesn't show again
                    sessionStorage.setItem('trad-CloseButtonDataStore', 'true');
                }
            }
        });
    }
});
