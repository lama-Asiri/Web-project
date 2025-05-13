<?php
require_once '../php/config.php'; // الاتصال بقاعدة البيانات

$user_id = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : 0;

if ($user_id <= 0) {
    echo json_encode(["success" => false, "error" => "Invalid user ID."]);
    exit;
}

$stmt = $pdo->prepare("SELECT users.username, users.profile_image, settings.two_factor_enabled, settings.notification_enabled FROM users LEFT JOIN settings ON users.user_id = settings.user_id WHERE users.user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode([
        "success" => true,
        "name" => $user['username'],
        "photo" => $user['profile_image'] ? '../php/' . $user['profile_image'] : null,
        "two_factor_enabled" => $user['two_factor_enabled'] ? $user['two_factor_enabled'] : null,
        "notification_enabled" => $user['notification_enabled'] ? $user['notification_enabled'] : null
    ]);
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}
?>
