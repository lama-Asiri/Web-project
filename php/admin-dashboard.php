<!DOCTYPE html>
<html lang="en" class="transition duration-300">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduHub - Dashboard</title>

  <!-- Load TailwindCSS and Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Light and Dark Mode CSS -->
  <link rel="stylesheet" href="../styles/style1.css" />
  <link id="dark-theme" rel="stylesheet" href="../styles/dark.css" disabled />

  <!-- JS Scripts -->
  <script defer src="../scripts/theme-switch.js"></script>
  <script defer src="../scripts/Nav-highlight.js"></script>
  <script defer src="../scripts/Toast.js"></script>
  <script defer src="../scripts/profile-img.js"></script>
  <script defer src="../scripts/Admin-Dashboard.js"></script>


</head>

<body class="bg-gray-50 text-base-content">

<header class="bg-white shadow-md">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <div class="flex items-center space-x-8">
      <h1 class="text-2xl font-bold text-blue-600">EduHub Admin</h1>
      <nav class="hidden md:flex space-x-6">
        <a href="../php/admin-dashboard.php" class="nav-link text-gray-600 hover:text-blue-600">Dashboard</a>
        <a href="../php/material-approval.php" class="nav-link text-gray-600 hover:text-blue-600">Material Approval</a>
      </nav>
    </div>
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

<main class="container mx-auto px-6 py-8">

<!-- Dashboard Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
  <div class="bg-white rounded-xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Total Users</p>
    <h3 id="total-users" class="text-2xl font-bold">0</h3>
  </div>
  <div class="bg-white rounded-xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Total Teachers</p>
    <h3 id="total-teachers" class="text-2xl font-bold">0</h3>
  </div>
  <div class="bg-white rounded-xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Total Students</p>
    <h3 id="total-students" class="text-2xl font-bold">0</h3>
  </div>
  <div class="bg-white rounded-xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Pending Materials</p>
    <h3 id="pending-materials" class="text-2xl font-bold">0</h3>
  </div>
  <div class="bg-white rounded-xl p-6 shadow-sm">
    <p class="text-sm text-gray-500">Approved Materials</p>
    <h3 id="active-materials" class="text-2xl font-bold">0</h3>
  </div>
</div>

  <!-- Search -->
  <input type="text" placeholder="Search users..." class="w-full p-3 border rounded-lg mb-4" />

  <!-- Students Table -->
  <div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-xl font-bold mb-6">Students Management</h2>
    <div class="overflow-x-auto">
      <table data-type="student" class="w-full text-left table-fixed">
        <thead>
          <tr class="border-b">
            <th class="py-3 w-[300px]">Student</th>
            <th class="py-3 w-[150px]">Status</th>
            <th class="py-3 w-[150px]">Actions</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <!-- Teachers Table -->
  <div class="bg-white rounded-xl shadow-sm p-6 my-8">
    <h2 class="text-xl font-bold mb-6">Teachers Management</h2>
    <div class="overflow-x-auto">
      <table data-type="teacher" class="w-full text-left table-fixed">
        <thead>
          <tr class="border-b">
            <th class="py-3 w-[300px]">Teacher</th>
            <th class="py-3 w-[150px]">Status</th>
            <th class="py-3 w-[150px]">Actions</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

 

 <!-- Admins Table -->
<div class="bg-white rounded-xl shadow-sm p-6 my-8">
  <!-- Title + Add Admin Button -->
  <div class="mb-6 flex items-center justify-between">
  <h2 class="text-xl font-bold">Admins Management</h2>
  <button id="addAdminBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add New Admin
  </button>
  </div>
   
    <div class="overflow-x-auto">
  <table data-type="admin" class="w-full text-left table-fixed">
  <thead>
  <tr class="border-b">
  <th class="py-3 w-[300px]">Admin</th>
  <th class="py-3 w-[150px]">Status</th>
  <th class="py-3 w-[150px]">Actions</th>
  </tr>
  </thead>
  <tbody></tbody>
  </table>
  </div>
  </div>

  <!-- Edit Modal -->
  <div id="studentModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div id="studentBox" class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 w-full max-w-lg mx-auto">
      <h2 class="text-xl font-semibold mb-4">Edit User</h2>
      <form id="studentForm" class="space-y-4">
        <div>
          <label for="studentName" class="block text-sm font-medium">Name</label>
          <input id="studentName" type="text" class="w-full border p-2 rounded-md bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
          <label for="studentEmail" class="block text-sm font-medium">Email</label>
          <input id="studentEmail" type="email" class="w-full border p-2 rounded-md bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex justify-end gap-3 mt-6">
          <button type="button" onclick="closeStudentModal()" class="px-4 py-2 rounded-md bg-red-100 text-red-600 dark:bg-red-700 dark:text-white">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Add Admin Modal -->
  <div id="adminModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white text-black p-6 rounded-lg shadow-lg w-[400px]">
      <h2 class="text-xl font-bold mb-4">Add New Admin</h2>
      <form id="adminForm" class="space-y-4">
        <div>
          <label for="newAdminName" class="block text-sm font-medium">Name</label>
          <input type="text" id="newAdminName" name="newAdminName" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
        </div>
        <div>
          <label for="newAdminEmail" class="block text-sm font-medium">Email</label>
          <input type="email" id="newAdminEmail" name="newAdminEmail" class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
        </div>
        <div>
          <label for="newAdminPassword" class="block text-sm font-medium">Password</label>
          <input type="password" id="newAdminPassword" name="newAdminPassword" class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
        </div>
        <div>
          <label for="newAdminStatus" class="block text-sm font-medium">Status</label>
          <select id="newAdminStatus" name="newAdminStatus" class="w-full border border-gray-300 rounded px-3 py-2 mt-1">
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
          </select>
        </div>
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" onclick="closeAdminModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded">
            Cancel
          </button>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>

</main>
</body>
</html>
