<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../php/config.php'; // الاتصال بقاعدة البيانات باستخدام PDO

function uploadPDF($fileInputName, $uploadDir = '../uploads/') {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return ["success" => false, "message" => "Upload failed or file not found."];
    }

    $file = $_FILES[$fileInputName];
    $allowedMime = ['application/pdf'];
    $maxSize = 10 * 1024 * 1024;

    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, $allowedMime)) {
        return ["success" => false, "message" => "Invalid file format: $mime"];
    }

    if ($file['size'] > $maxSize) {
        return ["success" => false, "message" => "File is too large: " . round($file['size'] / (1024 * 1024), 2) . "MB"];
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = uniqid() . '_' . time() . '.' . $ext;
    $destination = $uploadDir . $newName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ["success" => true, "filename" => $newName];
    } else {
        return ["success" => false, "message" => "Failed to save file."];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'student';

    if (!$username || !$email || !$password) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    try {
        $pdo->beginTransaction(); // بدء المعاملة
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $role]);
        $userId = $pdo->lastInsertId();

        // create record at settings table
        $stmt = $pdo->prepare("INSERT INTO settings (user_id, two_factor_enabled, notification_enabled) VALUES (?, ?, ?)");
        $stmt->execute([$userId, 0, 1]);

        // If teacher, store additional data
        if ($role === 'teacher') {
            $major = $_POST['major'] ?? '';
            $degree = $_POST['degree'] ?? '';
            $cvResult = uploadPDF('cv_file');
            $certResult = uploadPDF('cert_file');
            
            if (!$cvResult['success'] || !$certResult['success']) {
                $pdo->rollBack();
                echo json_encode([
                    'success' => false,
                    'message' => $cvResult['message'] ?? $certResult['message'] ?? 'Unknown file error.'
                ]);
                exit;
            }
            
            $cv = $cvResult['filename'];
            $certi = $certResult['filename'];
            

            $tStmt = $pdo->prepare("INSERT INTO teachers (teach_id, major, degree, cv, certi) VALUES (?, ?, ?, ?, ?)");
            $tStmt->execute([$userId, $major, $degree, $cv, $certi]);
        }

        $pdo->commit(); // حفظ المعاملة
        echo json_encode(['success' => true]);

    } catch (PDOException $e) {
        $pdo->rollBack(); // إلغاء المعاملة في حالة الخطأ
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>