// Authentication and User Profile Management

// Check if user is logged in on page load
document.addEventListener('DOMContentLoaded', function() {
    checkUserLoggedIn();
});

// Function to check if user is logged in
function checkUserLoggedIn() {
    const user = JSON.parse(localStorage.getItem('currentUser'));
    
    if (user) {
        // User is logged in, update UI
        showUserProfile(user);
    } else {
        // User is not logged in, show auth buttons
        showAuthButtons();
    }
}

// Function to show user profile
function showUserProfile(user) {
    const authButtonsContainer = document.querySelector('.auth-buttons');
    const navElement = document.querySelector('nav');
    
    if (authButtonsContainer && navElement) {
        // Hide auth buttons
        authButtonsContainer.style.display = 'none';
        
        // Create user profile element if it doesn't exist
        let userProfile = document.querySelector('.user-profile');
        if (!userProfile) {
            userProfile = document.createElement('div');
            userProfile.className = 'user-profile';
            navElement.appendChild(userProfile);
            
            // Add click event for logout
            userProfile.addEventListener('click', function() {
                if (confirm('Do you want to log out?')) {
                    logout();
                }
            });
        }
        
        // Set the initial of the user's name
        const initial = user.fullname ? user.fullname.charAt(0).toUpperCase() : 'U';
        userProfile.textContent = initial;
        userProfile.style.display = 'block';
    }
}

// Function to show auth buttons
function showAuthButtons() {
    const authButtonsContainer = document.querySelector('.auth-buttons');
    const userProfile = document.querySelector('.user-profile');
    
    if (authButtonsContainer) {
        authButtonsContainer.style.display = 'flex';
    }
    
    if (userProfile) {
        userProfile.style.display = 'none';
    }
}

// Function to handle login
function login(email, password) {
    // In a real application, you would validate against a server
    // For this demo, we'll check localStorage
    const users = JSON.parse(localStorage.getItem('users')) || [];
    const user = users.find(u => u.email === email && u.password === password);
    
    if (user) {
        // Store current user in localStorage
        localStorage.setItem('currentUser', JSON.stringify(user));
        return true;
    }
    
    return false;
}

// Function to handle signup
function signup(fullname, email, password) {
    // In a real application, you would send this to a server
    // For this demo, we'll store in localStorage
    const users = JSON.parse(localStorage.getItem('users')) || [];
    
    // Check if user already exists
    if (users.some(u => u.email === email)) {
        return false; // User already exists
    }
    
    // Create new user
    const newUser = { fullname, email, password };
    users.push(newUser);
    
    // Save users array and set current user
    localStorage.setItem('users', JSON.stringify(users));
    localStorage.setItem('currentUser', JSON.stringify(newUser));
    
    return true;
}

// Function to handle logout
function logout() {
    localStorage.removeItem('currentUser');
    showAuthButtons();
    
    // Redirect to home page if not already there
    if (window.location.pathname !== '/index.html' && 
        window.location.pathname !== '/' && 
        window.location.pathname !== '/Event_Management_website/index.html') {
        window.location.href = 'index.html';
    }
}