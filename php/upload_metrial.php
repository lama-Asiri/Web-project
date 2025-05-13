<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Force JSON response
header('Content-Type: application/json');

// DB connection
require 'config.php';

// Only handle POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Validate inputs
$title        = $_POST['title'] ?? '';
$description  = $_POST['description'] ?? '';
$subject      = $_POST['subject'] ?? '';
$grade        = $_POST['grade'] ?? '';
$uploader_id  = $_POST['uploader_id'] ?? '';
$file         = $_FILES['file'] ?? null;

if (!$title || !$description || !$subject || !$grade || !$uploader_id || !$file) {
    echo json_encode(['success' => false, 'message' => 'Missing fields']);
    exit;
}

// Upload file
$uploadDir = '../php/uploads_materials/';
$fileName = uniqid() . '_' . basename($file['name']);
$targetFile = $uploadDir . $fileName;

if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    exit;
}

// Get user role
$stmt = $pdo->prepare("SELECT role FROM users WHERE user_id = ?");
$stmt->execute([$uploader_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Invalid user']);
    exit;
}

$role = $user['role'] ?? 'student';
$status = ($role === 'teacher' || $role === 'admin') ? 'approved' : 'pending';


// Insert into database
$stmt = $pdo->prepare("INSERT INTO materials 
    (title, description, subject, grade, file_path, status, uploaded_by)
    VALUES (?, ?, ?, ?, ?, ?, ?)");


$success = $stmt->execute([
    $title,
    $description,
    $subject,
    $grade,
    $fileName,
    $status,
    $uploader_id
]);

if (!$success) {
    $error = $stmt->errorInfo();
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $error[2]]);
    exit;
}

// 🎉 Success
echo json_encode([
    'success' => true,
    'message' => 'Material uploaded successfully',
    'material' => [
        'title' => $title,
        'description' => $description,
        'subject' => $subject,
        'grade' => $grade,
        'file_path' => $fileName,
        'status' => $status, // ✅ This is the fix!
        'uploader_name' => $user['username'] ?? 'You',
        'uploader_image' => $user['profile_image'] ?? null
    ]
]);

exit;

?>