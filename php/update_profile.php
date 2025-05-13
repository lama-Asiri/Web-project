<?php

$user_id = isset($_COOKIE['user_id']) ? (int)$_COOKIE['user_id'] : 0;

if ($user_id <= 0) {
    echo json_encode(["success" => false, "error" => "Invalid user ID."]);
    exit;
}

try {
    require_once '../php/config.php'; // الاتصال بقاعدة البيانات باستخدام PDO

    $name = trim($_POST['display_name']);
    $filename = null;

    // الحصول على اسم الصورة القديمة
    $stmtOld = $pdo->prepare("SELECT profile_image FROM users WHERE user_id = ?");
    $stmtOld->execute([$user_id]);
    $oldImage = $stmtOld->fetchColumn();

    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
        $fileSize = $_FILES['profile_photo']['size'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(["success" => false, "error" => "Invalid file extension. Allowed: jpg, jpeg, png, gif."]);
            exit;
        }

        if ($fileSize > 2 * 1024 * 1024) { // 2MB
            echo json_encode(["success" => false, "error" => "File size must not exceed 2MB."]);
            exit;
        }

        // حذف الصورة القديمة إن وُجدت
        if (!empty($oldImage) && file_exists($oldImage)) {
            unlink($oldImage);
        }


        $filename = 'uploads_users_image/' . uniqid() . "." . $ext;
        if (!is_dir('uploads_users_image')) {
            mkdir('uploads_users_image', 0777, true);
        }
        
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $filename);
    }

    if ($filename) {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, profile_image = ? WHERE user_id = ?");
        $stmt->execute([$name, $filename, $user_id]);
    
        // ✅ set cookie for instant profile update across site
        setcookie("user_image", $filename, time() + (30 * 24 * 60 * 60), "/");
    }
     else {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE user_id = ?");
        $stmt->execute([$name, $user_id]);
    }

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
