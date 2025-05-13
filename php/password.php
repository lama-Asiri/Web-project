<?php
?>
<!DOCTYPE html>
<html lang="en" class="transition duration-300">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>change-password-page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style1.css">
    <link id="dark-theme" rel="stylesheet" href="../styles/dark.css" disabled>
    
    <!-- Core Functional Scripts -->

<script src="../scripts/theme-switch.js"></script>
<script src="../scripts/theme-toggle.js"></script>
<script src="../scripts/Nav-highlight.js"></script>
<script src="../scripts/Toast.js"></script>
<script src="../scripts/password-validation.js"></script>     <!-- password.html -->
<script src="../scripts/profile-img.js"></script>
<script src="../scripts/Profile-settings.js"></script>  
</head>

<body class="h-full text-base-content">
    <header id="header" class="bg-white shadow-md" role="banner">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Left: Logo + nav -->
            <div class="flex items-center space-x-8">
                <h1 class="text-2xl font-bold text-blue-600">EduHub</h1>
                <nav class="hidden md:flex space-x-6" role="navigation" aria-label="Main navigation">
                    <a href="../php/home.php" class="nav-link text-gray-600 hover:text-blue-600">Home</a>
                    <a href="../php/metrials-student.php" class="nav-link text-gray-600 hover:text-blue-600">Materials</a>
                    <a href="../php/faq.php" class="nav-link text-gray-600 hover:text-blue-600">FAQ</a>
                </nav>
            </div>

            <!-- Right: Icons -->
            <div class="flex items-center space-x-4">
                <button aria-label="Notifications" class="text-gray-600 hover:text-blue-600">
                    <i class="fa-regular fa-bell text-xl"></i>
                </button>
                <button id="theme-toggle" aria-label="Toggle Dark Mode"
                    class="text-gray-600 hover:text-blue-600 text-xl">
                    <i id="theme-icon" class="fa-regular fa-moon"></i>
                </button>

                <button id="settings-btn" aria-label="Settings" class="text-gray-600 hover:text-blue-600">
                    <i class="fa-solid fa-cog text-xl"></i>
                </button>
                <img id="header-profile-img" class="header-profile-img w-10 h-10 rounded-full" alt="Profile image" />
            </div>
        </div>
    </header>




    <div id="change-password-page" class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <div id="header" class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Change Password</h1>
                <p class="mt-2 text-gray-600">Please enter your current password and choose a new one</p>
            </div>

            <div id="password-form" class="bg-white p-8 rounded-xl shadow-sm">
                <div id="current-password-field" class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <div class="relative">
                        <input  id="current-password" type="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter current password">
                        <button class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div  class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input id="new-password" type="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter new password">
                        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div id="confirm-password-field" class="mb-6">
  <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
  <div class="relative">
    <input id="confirm-password" type="password"
           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
           placeholder="Confirm new password">
    <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
      <i class="fa-regular fa-eye"></i>
    </button>
  </div>
</div>



                <div id="password-strength" class="mb-6">
                    <p class="text-sm font-medium text-gray-700 mb-2">Password Strength</p>
                    <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div id="strength-bar" class="h-full bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="mt-2 flex items-center gap-2 text-sm text-gray-600">
                        <i class="fa-solid fa-circle-check"></i>
                        <span id="strength-text" class="whitespace-nowrap">Very Weak</span>
                    </div>
                </div>


                <div id="password-requirements" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-2">Password Requirements:</p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-green-500"></i>
                            At least 8 characters
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-green-500"></i>
                            Include uppercase &amp; lowercase letters
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-green-500"></i>
                            Include at least one number
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-green-500"></i>
                            Include at least one special character
                        </li>
                    </ul>
                </div>

                <div id="action-buttons" class="flex gap-4">
                    <button  id="save-password-btn" type="button"
                        class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-colors font-medium">
                        Save Changes
                    </button>
                    <button
                        class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 transition-colors font-medium">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="toast-container" class="fixed bottom-6 right-6 space-y-3 z-50"></div>

</body>

</html>