<?php 
require_once '../php/config.php';
// ✅ Start session BEFORE doing anything else
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (!$email || !$password) {
        echo json_encode(["success" => false, "message" => "Invalid input."]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION['user_id'] = $user['user_id']; // ✅ Store login in session

        $expire = time() + (30 * 24 * 60 * 60); // 30 days

        // Shared cookie setup
        setcookie("user_id", $user["user_id"], $expire, "/");
        setcookie("user_email", $user["email"], $expire, "/");
        setcookie("user_role", $user["role"], $expire, "/");

        // Role-based redirection
        if ($user["role"] === 'admin') {
            echo json_encode([
                "success" => true,
                "message" => "Login successful.",
                "redirect" => "admin-dashboard.php"
            ]);
        } elseif ($user["role"] === 'student') {
            echo json_encode([
                "success" => true,
                "message" => "Login successful.",
                "redirect" => "home.php"
            ]);
        } elseif ($user["role"] === 'teacher') {
            if ($user["status"] === 'approved') {
                echo json_encode([
                    "success" => true,
                    "message" => "Login successful.",
                    "redirect" => "home.php"
                ]);
            } elseif ($user["status"] === 'pending') {
                echo json_encode(["success" => false, "message" => "Your request is currently being reviewed by admin."]);
            } elseif ($user["status"] === 'rejected') {
                echo json_encode(["success" => false, "message" => "Your request has been denied by admin."]);
            } else {
                echo json_encode(["success" => false, "message" => "Unknown teacher status."]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid email or password."]);
    }

    exit;
}
?>
