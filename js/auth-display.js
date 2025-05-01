// Function to check if user is logged in and display appropriate UI elements
document.addEventListener('DOMContentLoaded', function() {
    checkAuthStatus();
});

function checkAuthStatus() {
    // Check if user is logged in (using localStorage)
    const user = JSON.parse(localStorage.getItem('currentUser'));
    
    // Get UI elements
    const authButtonsContainer = document.querySelector('.auth-buttons');
    const userProfile = document.querySelector('.user-profile');
    
    if (user) {
        // User is logged in, show profile icon
        if (authButtonsContainer) authButtonsContainer.style.display = 'none';
        if (userProfile) userProfile.style.display = 'flex';
    } else {
        // User is not logged in, show login/signup buttons
        if (authButtonsContainer) authButtonsContainer.style.display = 'flex';
        if (userProfile) userProfile.style.display = 'none';
    }
}

// Function to handle logout
function handleLogout() {
    // Clear user data from localStorage
    localStorage.removeItem('currentUser');
    
    // Update UI
    checkAuthStatus();
    
    // Redirect to home page
    window.location.href = 'index.php';
}

// Add event listener to logout button if it exists
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            handleLogout();
        });
    }
});