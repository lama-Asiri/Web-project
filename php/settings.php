<?php
$user_id = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : 0;

if ($user_id == 0) {
    header("Location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="transition duration-300">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style1.css">
    <link id="dark-theme" rel="stylesheet" href="../styles/dark.css" disabled>

    <!-- Core Functional Scripts -->

    <script src="../scripts/theme-switch.js"></script>

    <script src="../scripts/Nav-highlight.js"></script>
    <script src="../scripts/Toast.js"></script>

    <script src="../scripts/Profile-settings.js"></script> <!-- settings.php -->

</head>

<body class="h-full text-base-content">
    <div id="settings-page" class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header id="header" class="bg-white shadow-md" role="banner">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Left: Logo + nav -->
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold text-blue-600">EduHub</h1>
                    <nav class="hidden md:flex space-x-6" role="navigation" aria-label="Main navigation">
                        <a href="../php/home.php" class="nav-link text-gray-600 hover:text-blue-600">Home</a>
                        <a href="../php/metrials-student.php" class="nav-link text-gray-600 hover:text-blue-600">Materials</a>
                        <a href="../php/faq.php" class="nav-link text-gray-600 hover:text-blue-600">FAQ</a> <!--TODO:doesnt work -->
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
                    <img id="header-profile-img"
     class="header-profile-img w-10 h-10 rounded-full"
     src="<?= isset($_COOKIE['user_image']) ? '../php/update_profile.php' . $_COOKIE['user_image'] : '../images/avtar.png' ?>"
     alt="Profile image" />

                </div>
            </div>
        </header>



        <!-- Main Content -->
        <main class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8 overflow-visible">
            <!-- Profile Section -->
            <section id="profile-section" class="bg-white rounded-lg shadow-sm mb-8 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Edit Profile</h2>
                    <div id="success-notification"
                        class="bg-green-100 text-green-700 px-4 py-2 rounded-md text-sm hidden">
                        Profile updated successfully!
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="flex items-center space-x-6">
                        <img id="profile-picture" class="w-20 h-20 rounded-full">

                        <input type="file" id="photo-upload" class="hidden" accept="image/*">
                        <button id="change-photo-btn" class="text-blue-600 text-sm hover:text-blue-700">Change
                            photo</button>
                    </div>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                            <input type="text" id="display-name-input" value="John Doe"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
                <button id="save-profile-btn"
                    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700 focus:outline-none">
                    Save Changes
                </button>

                <p id="name-warning" class="text-red-600 text-sm mt-2 hidden">Name cannot be empty or only spaces.</p>

            </section>

            <!-- Security Section -->
            <section id="security-section" class="bg-white rounded-xl shadow-sm mb-6">
  <button class="w-full px-6 py-4 flex items-center justify-between toggle-btn" data-target="security-content">
  <div class="flex items-center space-x-3">
  <i class="fa-solid fa-shield-halved text-gray-600 text-lg"></i>
  <span class="font-semibold text-gray-900 text-base">Security</span>
</div>

    <i class="fa-solid fa-chevron-down text-gray-400"></i>
  </button>
  <div id="security-content" class="hidden px-6 pb-6 space-y-6">    

    <div id="change-password-link" class="flex items-center justify-between cursor-pointer">
      <h3 class="text-sm font-medium text-gray-700">Change Password</h3>
      <i class="fa-solid fa-arrow-right text-gray-400"></i>
    </div>

    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-sm font-medium text-gray-700">Two-Factor Authentication</h3>
        <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
      </div>
      <button class="toggle-switch bg-gray-200" id="two-factor-toggle">
        <span class="switch-circle"></span>
      </button>
    </div>
  </div>
</section>


<section id="preferences-section" class="bg-white rounded-lg shadow-sm mb-8">
  <button class="w-full flex items-center justify-between px-6 py-4 toggle-btn" data-target="preferences-content">
    <div class="flex items-center space-x-3">
      <i class="fa-solid fa-sliders text-gray-600"></i>
      <span class="font-semibold text-gray-900">Preferences</span>
    </div>
    <i class="fa-solid fa-chevron-down text-gray-400"></i>
  </button>
  <div id="preferences-content" class="hidden px-6 pb-6 space-y-6">

    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-sm font-medium text-gray-700">Email Notifications</h3>
        <p class="text-sm text-gray-500">Receive email updates about your account</p>
      </div>
      <button class="toggle-switch bg-gray-200">
        <span class="switch-circle"></span>
      </button>
    </div>
  </div>
</section>


            <!-- Danger Zone Section -->
<section id="danger-zone" class="bg-white rounded-lg shadow-sm mb-6">
    <button class="w-full px-6 py-4 flex items-center justify-between toggle-btn" data-target="danger-zone-content">
        <div class="flex items-center space-x-3 text-red-600">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span class="font-semibold text-red-600">Account Actions</span>
        </div>
        <i class="fa-solid fa-chevron-down text-gray-400"></i>
    </button>
    <div id="danger-zone-content" class="hidden px-6 pb-6 space-y-8">

        <!-- Logout Section -->
        <div>
            <div class="text-red-600 flex items-center space-x-3 mb-2">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <h2 class="text-lg font-semibold">Log Out</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">If you want to end your session, you can log out below.</p>
            <a href="logout.php"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Log Out
            </a>
        </div>

        <!-- Delete Account Section -->
        <div>
            <div class="flex items-center space-x-3 text-red-600 mb-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <h2 class="text-lg font-semibold">Delete Account</h2>
            </div>
            <p class="text-sm text-gray-500 mb-4">Once you delete your account, there is no going back. Please
                be certain.</p>
                <button id="delete-account-btn"
    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
    Delete Account
</button>

        </div>
    </div>
</section>

        </main>

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="bg-white rounded-lg max-w-md w-full p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Delete Account</h3>
                        <p class="mt-2 text-sm text-gray-500">This action cannot be undone. This will permanently delete
                            your account and remove your data from our servers.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type DELETE to confirm</label>
                        <input type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button class="px-4 py-2 text-sm text-gray-700 hover:text-gray-900">Cancel</button>
                        <button
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="toast-container" class="fixed bottom-5 right-5 space-y-2 z-50"></div>
</body>

</html>