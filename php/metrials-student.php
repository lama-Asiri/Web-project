<?php
require_once 'config.php';
function subjectToClass($subject)
{
    switch (strtolower($subject)) {
        case 'mathematics':
            return 'pill-math';
        case 'physics':
            return 'pill-physics';
        case 'chemistry':
            return 'pill-chem';
        case 'biology':
            return 'pill-bio';
        case 'literature':
            return 'pill-lit';
        case 'history':
            return 'pill-hist';
        default:
            return 'bg-blue-100 text-blue-600';
    }
}

$stmt = $pdo->prepare("SELECT m.*, u.username AS uploader_name, u.profile_image AS uploader_image FROM materials m JOIN users u ON m.uploaded_by = u.user_id WHERE m.status = 'approved'");
$stmt->execute();
$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" class="transition duration-300">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduHub - Materials</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../styles/style1.css">
    <link id="dark-theme" rel="stylesheet" href="../styles/dark.css" disabled>

    <!-- Core Functional Scripts -->
    <script src="../scripts/theme-switch.js"></script>
    <script src="../scripts/Nav-highlight.js"></script>
    <script src="../scripts/Toast.js"></script>
    <script src="../scripts/Materials-handle.js"></script>
    <script src="../scripts/Materials-handler.js"></script>
    <script src="../scripts/profile-img.js"></script>
    <script src="../scripts/header-nav.js"></script>

</head>

<body class="h-full text-base-content">
    <div class="min-h-screen bg-gray-50">
        <header class="bg-white shadow-md">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold text-blue-600">EduHub</h1>
                    <nav class="hidden md:flex space-x-6">
                        <a href="../php/home.php" class="nav-link text-gray-600 hover:text-blue-600">Home</a>
                        <a href="../php/metrials-student.php" class="nav-link text-gray-600 hover:text-blue-600">Materials</a>
                        <a href="../php/faq.php" class="nav-link text-gray-600 hover:text-blue-600">FAQ</a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-600 hover:text-blue-600"><i class="fa-regular fa-bell text-xl"></i></button>
                    <button id="theme-toggle" class="text-gray-600 hover:text-blue-600 text-xl">
                        <i id="theme-icon" class="fa-regular fa-moon"></i>
                    </button>
                    <button id="settings-btn" class="text-gray-600 hover:text-blue-600">
                        <i class="fa-solid fa-cog text-xl"></i>
                    </button>
                    <img id="header-profile-img" class="w-10 h-10 rounded-full" src="<?= isset($_COOKIE['user_image']) ? '../php/' . htmlspecialchars($_COOKIE['user_image']) : '../images/avatar.png' ?>" alt="Profile image" />
                </div>
            </div>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Study Materials</h2>
                <button id="upload-btn" class="bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center space-x-2 hover:bg-blue-700 transition">
                    <i class="fa-solid fa-upload"></i><span>Upload Material</span>
                </button>
            </div>

            <div id="search-filter" class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <div class="flex-1 relative">
                        <i class="fa-solid fa-search absolute left-4 top-3.5 text-gray-400"></i>
                        <input id="search-input" type="text" placeholder="Search study materials..." class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-200">
                    </div>
                    <div class="flex space-x-4">
                        <select id="subject-filter" class="px-4 py-3 rounded-lg border border-gray-200">
                            <option>All Subjects</option>
                            <option>Mathematics</option>
                            <option>Physics</option>
                            <option>Chemistry</option>
                            <option>Biology</option>
                            <option>Literature</option>
                            <option>History</option>
                        </select>
                        <select id="grade-filter" class="px-4 py-3 rounded-lg border border-gray-200">
                            <option>All Grades</option>
                            <option>Grade 9</option>
                            <option>Grade 10</option>
                            <option>Grade 11</option>
                            <option>Grade 12</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="category-pills" class="flex flex-wrap gap-3 mb-8">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-full font-medium">All</button>
                <button class="pill-math">Mathematics</button>
                <button class="pill-physics">Physics</button>
                <button class="pill-chem">Chemistry</button>
                <button class="pill-bio">Biology</button>
                <button class="pill-lit">Literature</button>
                <button class="pill-hist">History</button>
            </div>

            <div id="upload-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative z-50">
                    <h2 class="text-xl font-semibold mb-4">Upload Material</h2>
                    <label class="block text-sm font-medium">Material Name</label>
                    <input id="material-name" type="text" class="w-full border p-2 rounded-md mb-2">
                    <label class="block text-sm font-medium">Material Description</label>
                    <textarea id="material-description" class="w-full border p-2 rounded-md mb-2"></textarea>
                    <label class="block text-sm font-medium">Subject</label>
                    <select id="material-subject" class="w-full border p-2 rounded-md mb-2">
                        <option>Mathematics</option>
                        <option>Physics</option>
                        <option>Chemistry</option>
                        <option>Biology</option>
                        <option>Literature</option>
                        <option>History</option>
                    </select>
                    <label class="block text-sm font-medium">Grade</label>
                    <select id="material-grade" class="w-full border p-2 rounded-md mb-2">
                        <option>Grade 9</option>
                        <option>Grade 10</option>
                        <option>Grade 11</option>
                        <option>Grade 12</option>
                    </select>
                    <label class="block text-sm font-medium">Upload File</label>
                    <input id="material-file" type="file" class="w-full border p-2 rounded-md">
                    <div class="flex justify-end gap-3 mt-6">
                        <button id="confirmUpload" class="bg-blue-600 text-white px-4 py-2 rounded-md">Upload</button>
                        <button id="cancel-upload" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Cancel</button>
                    </div>
                </div>
            </div>

            <div id="materials-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                <?php foreach ($materials as $material): ?>
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition" data-grade="<?= htmlspecialchars($material['grade']) ?>">
                        <div class="p-6 pb-8">
                            <div class="flex items-center justify-between mb-4">
                                <span class="<?= subjectToClass($material['subject']) ?> px-3 py-1 rounded-full text-sm">
                                    <?= htmlspecialchars($material['subject']) ?>
                                </span>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fa-regular fa-bookmark"></i>
                                </button>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($material['title']) ?></h3>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars($material['description']) ?></p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img
                                        src="<?= !empty($material['uploader_image']) ? '../uploads/imgs/' . htmlspecialchars($material['uploader_image']) : '../images/avtar.png' ?>"
                                        alt="Author"
                                        class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-medium"><?= htmlspecialchars($material['uploader_name']) ?></span>
                                </div>

                                <a href="../php/uploads_materials/<?= htmlspecialchars($material['file_path']) ?>" class="text-blue-600 hover:text-blue-700" download>
                                    <i class="fa-solid fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <footer class="bg-white border-t mt-12">
            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-600 mb-4 md:mb-0">&copy; 2025 EduHub. All rights reserved.</p>
                    <div class="flex space-x-6">
                        <span class="text-gray-600 hover:text-blue-600 cursor-pointer">Terms</span>
                        <span class="text-gray-600 hover:text-blue-600 cursor-pointer">Privacy</span>
                        <span class="text-gray-600 hover:text-blue-600 cursor-pointer">Help</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div id="toast-container" class="fixed bottom-6 right-6 space-y-3 z-50"></div>
</body>

</html>