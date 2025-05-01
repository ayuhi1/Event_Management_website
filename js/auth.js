// Authentication and User Profile Management

// Check if user is logged in on page load
document.addEventListener('DOMContentLoaded', function() {
    checkUserLoggedIn();
});

// check if user is logged in
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
            
            // Create dropdown menu
            const profileDropdown = document.createElement('div');
            profileDropdown.className = 'profile-dropdown';
            
            // Add logout option
            const logoutLink = document.createElement('a');
            logoutLink.href = '#';
            logoutLink.className = 'logout-btn';
            logoutLink.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            logoutLink.addEventListener('click', function(e) {
                e.preventDefault();
                logout();
            });
            
            // Append elements
            profileDropdown.appendChild(logoutLink);
            userProfile.appendChild(profileDropdown);
            navElement.appendChild(userProfile);
            
            // Add click event to toggle active class
            userProfile.addEventListener('click', function() {
                userProfile.classList.toggle('active');
            });
        }
        
        // Set the initial of the user's name
        const initial = user.fullname ? user.fullname.charAt(0).toUpperCase() : 'U';
        userProfile.textContent = initial;
        
        // Re-append the dropdown
        let profileDropdown = userProfile.querySelector('.profile-dropdown');
        if (!profileDropdown) {
            profileDropdown = document.createElement('div');
            profileDropdown.className = 'profile-dropdown';
            
            // Add logout option
            const logoutLink = document.createElement('a');
            logoutLink.href = '#';
            logoutLink.className = 'logout-btn';
            logoutLink.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            logoutLink.addEventListener('click', function(e) {
                e.preventDefault();
                logout();
            });
            
            profileDropdown.appendChild(logoutLink);
            userProfile.appendChild(profileDropdown);
            
            // Add click event to toggle active class
            userProfile.addEventListener('click', function() {
                userProfile.classList.toggle('active');
            });
        }
        
        userProfile.style.display = 'flex';
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
function login(email, password, userType) {
    // Send login request to server
    return fetch('auth/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            password: password,
            userType: userType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store current user in localStorage
            localStorage.setItem('currentUser', JSON.stringify(data.user));
            // Redirect to appropriate page
            window.location.href = data.redirect;
            return true;
        } else {
            // Show custom popup for error message
            showErrorPopup(data.message);
            return false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorPopup('An error occurred during login. Please try again.');
        return false;
    });
}


// Function to handle signup
function signup(fullname, email, password, userType) {
    // Send signup request to server
    return fetch('auth/signup.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            fullname: fullname,
            email: email,
            password: password,
            userType: userType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store current user in localStorage
            localStorage.setItem('currentUser', JSON.stringify(data.user));
            // Redirect to appropriate page
            window.location.href = data.redirect;
            return true;
        } else {
            // Show custom popup for error message
            showErrorPopup(data.message);
            return false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorPopup('An error occurred during signup. Please try again.');
        return false;
    });
}

// Function to handle logout
function logout() {
    localStorage.removeItem('currentUser');
    showAuthButtons();
    
    // Redirect to home page if not already there
    if (window.location.pathname !== '/index.php' && 
        window.location.pathname !== '/' && 
        window.location.pathname !== '/Event_Management_website/index.php') {
        window.location.href = 'index.php';
    }
}

// Function to show error popup
function showErrorPopup(message) {
    // Remove any existing error popups
    const existingPopup = document.querySelector('.error-popup');
    if (existingPopup) {
        existingPopup.remove();
    }
    
    // Create popup container
    const popup = document.createElement('div');
    popup.className = 'error-popup';
    
    // Create popup content
    const popupContent = document.createElement('div');
    popupContent.className = 'error-popup-content';
    
    // Add message
    const messageElement = document.createElement('p');
    messageElement.textContent = message;
    
    // Add close button
    const closeButton = document.createElement('button');
    closeButton.textContent = 'OK';
    closeButton.addEventListener('click', function() {
        popup.remove();
    });
    
    // Assemble popup
    popupContent.appendChild(messageElement);
    popupContent.appendChild(closeButton);
    popup.appendChild(popupContent);
    
    // Add to document
    document.body.appendChild(popup);
    
    // Auto-close after 5 seconds
    setTimeout(function() {
        if (document.body.contains(popup)) {
            popup.remove();
        }
    }, 5000);
}
//show password
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const showPasswordCheckbox = document.getElementById('showPassword');

    if (passwordInput && showPasswordCheckbox) {
        showPasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    }
});