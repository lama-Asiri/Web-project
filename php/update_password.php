<?php
$user_id = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : 0;

if ($user_id <= 0) {
    echo json_encode(["success" => false, "error" => "Invalid user ID."]);
    exit;
}

require_once '../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['currentPassword'], $data['newPassword'], $data['confirmPassword'])) {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
        exit;
    }

    $currentPassword = $data['currentPassword'];
    $newPassword = $data['newPassword'];
    $confirmPassword = $data['confirmPassword'];

    if (!$user_id) {
        echo json_encode(["status" => "error", "message" => "User not logged in"]);
        exit;
    }

    try {

        // جلب كلمة المرور الحالية من قاعدة البيانات
        $stmt = $pdo->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            echo json_encode(["status" => "error", "message" => "Current password is incorrect"]);
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            echo json_encode(["status" => "error", "message" => "Passwords do not match"]);
            exit;
        }

        // تحديث كلمة المرور
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $update->execute([$hashedPassword, $user_id]);

        echo json_encode(["status" => "success"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
}
