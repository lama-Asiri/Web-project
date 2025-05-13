<!DOCTYPE html>
<html lang="en" class="transition duration-300">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduHub - Welcome</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="../styles/style1.css" />
  <link id="dark-theme" rel="stylesheet" href="../styles/dark.css" disabled>
  <script src="https://cdn.tailwindcss.com"></script>
 
  <!-- Core Functional Scripts -->

<script src="../scripts/theme-switch.js"></script>
<script src="../scripts/theme-toggle.js"></script>
<script src="../scripts/Nav-highlight.js"></script>
<script src="../scripts/Toast.js"></script>


</head>

<body class="bg-gray-50 text-base-content min-h-screen">
  <!-- Header -->
  <header id="header" class="bg-white shadow-md" role="banner">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <!-- Left: Logo + Nav Links -->
      <div class="flex items-center space-x-8">
        <h1 class="text-2xl font-bold text-blue-600">EduHub</h1>
        <nav class="hidden md:flex space-x-6" role="navigation" aria-label="Main navigation">
          <a href="../php/welcome.php" class="nav-link text-gray-600 hover:text-blue-600">Home</a>
    
          <a href="../php/faq.php" class="nav-link text-gray-600 hover:text-blue-600">FAQ</a>
        </nav>
      </div>

      <!-- Right: Auth Links -->
      <div class="flex items-center space-x-4">
        <a href="../php/login.php" class="nav-link text-gray-600 hover:text-blue-600 font-medium">Login</a>
        <a href="../php/signup.php"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
          Sign Up
        </a>
        <button id="theme-toggle" aria-label="Toggle Dark Mode" class="text-gray-600 hover:text-blue-600 text-xl">
          <i id="theme-icon" class="fa-regular fa-moon"></i>
        </button>

      </div>
    </div>
  </header>





  <!-- Hero Section -->
  <section class="bg-blue-600 text-white py-24 text-center">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold mb-4">Welcome to EduHub</h2>
      <p class="text-lg max-w-2xl mx-auto mb-8">
        Learn at your pace, explore curated study materials, and enhance your skills — anywhere, anytime.
      </p>
      <a href="../php/login.php"
        class="inline-block bg-white text-blue-600 font-semibold px-8 py-3 rounded-full shadow hover:bg-gray-100 transition">
        Start Learning
      </a>

      <p class="text-sm text-white/80 mt-4">
        Don’t have an account?
        <a href="../php/signup.php" class="underline font-medium">Sign up here</a>
      </p>
    </div>
  </section>
  <div id="toast-container" class="fixed bottom-5 right-5 space-y-2 z-50"></div>
</body>
<footer class="bg-white border-t text-center text-gray-500 py-4 text-sm mt-12">
  &copy; 2025 EduHub. All rights reserved.
</footer>

</html>