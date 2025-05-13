<?php
session_start();

header('Content-Type: application/json');

require_once '../php/config.php';

// Get user ID from cookie
$user_id = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : 0;

// Validate
if ($user_id <= 0) {
    echo json_encode(["success" => false, "error" => "Invalid user ID."]);
    exit;
}

// Fetch user info
$stmt = $pdo->prepare("SELECT role, profile_image FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(["success" => false, "error" => "User not found."]);
    exit;
}

// Delete profile image
if (!empty($user['profile_image']) && file_exists($user['profile_image'])) {
    unlink($user['profile_image']);
}

// If user is a teacher, delete teacher info
if ($user['role'] === 'teacher') {
    $teacherStmt = $pdo->prepare("SELECT cv_file, cert_file FROM teachers WHERE user_id = ?");
    $teacherStmt->execute([$user_id]);
    $teacher = $teacherStmt->fetch();

    if ($teacher) {
        if (!empty($teacher['cv_file']) && file_exists("uploads/" . $teacher['cv_file'])) {
            unlink("uploads/" . $teacher['cv_file']);
        }
        if (!empty($teacher['cert_file']) && file_exists("uploads/" . $teacher['cert_file'])) {
            unlink("uploads/" . $teacher['cert_file']);
        }

        $deleteTeacher = $pdo->prepare("DELETE FROM teachers WHERE user_id = ?");
        $deleteTeacher->execute([$user_id]);
    }
}

// Delete user settings (if any)
$deleteSettings = $pdo->prepare("DELETE FROM settings WHERE user_id = ?");
$deleteSettings->execute([$user_id]);

// Delete the user
$deleteUser = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
$success = $deleteUser->execute([$user_id]);

if ($success) {
    // Destroy session if exists
    $_SESSION = [];
    session_destroy();

    // Remove cookies
    setcookie("user_id", "", time() - 3600, "/");
    setcookie("user_email", "", time() - 3600, "/");
    setcookie("user_role", "", time() - 3600, "/");
}

echo json_encode(["success" => $success]);
?>
