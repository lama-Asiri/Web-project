<?php
$user_id = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : 0;

if ($user_id <= 0) {
    echo json_encode(["success" => false, "error" => "Invalid user ID."]);
    exit;
}

require_once '../php/config.php';// الاتصال بقاعدة البيانات

$data = json_decode(file_get_contents("php://input"), true);
$enabled = isset($data['enabled']) ? (int)$data['enabled'] : 0;

$stmt = $pdo->prepare("UPDATE settings SET two_factor_enabled = ? WHERE user_id = ?");
$success = $stmt->execute([$enabled, $user_id]);

echo json_encode(['success' => $success]);
