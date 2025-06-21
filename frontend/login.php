
<?php include "header.php";?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>        /* Message box styling */
        .message-box {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .message-box.show {
            opacity: 1;
            visibility: visible;
        }
    </style>


    <!-- Main container for both forms -->
    <div class="bg-white p-8 sm:p-10 rounded-xl shadow-2xl w-full max-w-md mx-auto transform transition-all duration-300 ease-in-out">
        
        <!-- Tab navigation for Login/Register -->
        <div class="flex mb-8 border-b border-gray-200">
            <button id="loginTab" class="flex-1 py-3 text-lg font-medium text-center text-gray-700 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600 focus:outline-none transition-colors duration-200" onclick="showForm('login')">
                Login
            </button>
            <button id="registerTab" class="flex-1 py-3 text-lg font-medium text-center text-gray-700 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600 focus:outline-none transition-colors duration-200" onclick="showForm('register')">
                Register
            </button>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="space-y-6">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">Welcome Back!</h2>
            
            <!-- Email Input Group -->
            <div>
                <label for="login-email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                <input type="email" id="login-email" name="email" required autocomplete="email"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-base transition-colors duration-200">
            </div>

            <!-- Password Input Group -->
            <div>
                <label for="login-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="login-password" name="password" required autocomplete="current-password"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-base transition-colors duration-200">
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-gray-900">
                        Remember me
                    </label>
                </div>
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                    Forgot your password?
                </a>
            </div>

            <!-- Login Button -->
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Log in
                </button>
            </div>

            <p class="text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="#" onclick="showForm('register'); return false;" class="font-medium text-blue-600 hover:text-blue-500">
                    Register here
                </a>
            </p>
        </form>

        <!-- Register Form -->
        <form id="registerForm" class="space-y-6 hidden">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">Create an Account</h2>

            <!-- Username Input Group -->
            <div>
                <label for="register-username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="register-username" name="username" required autocomplete="username"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-base transition-colors duration-200">
            </div>
            
            <!-- Email Input Group -->
            <div>
                <label for="register-email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                <input type="email" id="register-email" name="email" required autocomplete="email"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-base transition-colors duration-200">
            </div>

            <!-- Password Input Group -->
            <div>
                <label for="register-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="register-password" name="password" required autocomplete="new-password"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-base transition-colors duration-200">
            </div>

            <!-- Confirm Password Input Group -->
            <div>
                <label for="register-confirm-password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" id="register-confirm-password" name="confirm-password" required autocomplete="new-password"
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-base transition-colors duration-200">
            </div>

            <!-- Register Button -->
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    Register
                </button>
            </div>

            <p class="text-center text-sm text-gray-600">
                Already have an account? 
                <a href="#" onclick="showForm('login'); return false;" class="font-medium text-blue-600 hover:text-blue-500">
                    Login here
                </a>
            </p>
        </form>
    </div>

    <!-- Message box for showing success/error messages -->
    <div id="messageBox" class="message-box"></div>

    <script>
        // Get references to the form elements and tabs
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const messageBox = document.getElementById('messageBox');

        // Function to display messages to the user
        function showMessage(message, type = 'info') {
            messageBox.textContent = message;
            messageBox.className = `message-box show bg-${type === 'error' ? 'red' : type === 'success' ? 'green' : 'gray'}-600`; // Update class for styling
            setTimeout(() => {
                messageBox.className = 'message-box'; // Hide after 3 seconds
            }, 3000);
        }

        // Function to show either login or register form
        function showForm(formType) {
            if (formType === 'login') {
                loginForm.classList.remove('hidden'); // Show login form
                registerForm.classList.add('hidden'); // Hide register form
                loginTab.classList.add('border-blue-600', 'text-blue-600'); // Activate login tab style
                registerTab.classList.remove('border-blue-600', 'text-blue-600'); // Deactivate register tab style
            } else {
                registerForm.classList.remove('hidden'); // Show register form
                loginForm.classList.add('hidden'); // Hide login form
                registerTab.classList.add('border-blue-600', 'text-blue-600'); // Activate register tab style
                loginTab.classList.remove('border-blue-600', 'text-blue-600'); // Deactivate login tab style
            }
        }

        // Initial call to show the login form by default and activate its tab
        document.addEventListener('DOMContentLoaded', () => {
            showForm('login');
        });

        // Event listener for Login Form submission
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            // In a real application, you would send this data to a server
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            // Simple client-side validation example
            if (!email || !password) {
                showMessage('Please fill in all fields.', 'error');
                return;
            }

            console.log('Login attempt:', { email, password });
            // Simulate successful login
            showMessage('Login successful! (This is a demo)', 'success');

            // Reset form fields
            loginForm.reset();
        });

        // Event listener for Register Form submission
        registerForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            // In a real application, you would send this data to a server
            const username = document.getElementById('register-username').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('register-confirm-password').value;

            // Simple client-side validation example
            if (!username || !email || !password || !confirmPassword) {
                showMessage('Please fill in all fields.', 'error');
                return;
            }

            if (password !== confirmPassword) {
                showMessage('Passwords do not match.', 'error');
                return;
            }

            console.log('Registration attempt:', { username, email, password });
            // Simulate successful registration
            showMessage('Registration successful! (This is a demo)', 'success');
            
            // Optionally switch to login form after successful registration
            // showForm('login'); 

            // Reset form fields
            registerForm.reset();
        });
    </script>


<?php
include 'footer.php';
?>

