<?php
require 'config.php';
header('Content-Type: application/json');

// ✅ Add new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_admin') {
  $username = $_POST['username'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $status = $_POST['status'] ?? 'pending';

  if (!$username || !$email || !$password) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
  }

  try {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, status) VALUES (?, ?, ?, 'admin', ?)");
    $stmt->execute([$username, $email, $hashedPassword, $status]);
    echo json_encode(['success' => true]);
  } catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
  }
  exit;
}

// ✅ Update user status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_status') {
  $user_id = $_POST['user_id'] ?? 0;
  $new_status = $_POST['status'] ?? '';

  if (!$user_id || !in_array($new_status, ['approved', 'pending'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit;
  }

  try {
    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE user_id = ?");
    $stmt->execute([$new_status, $user_id]);
    echo json_encode(['success' => true]);
  } catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
  }
  exit;
}

// ✅ Update user info
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_user_info') {
  $user_id = $_POST['user_id'] ?? 0;
  $username = $_POST['username'] ?? '';
  $email = $_POST['email'] ?? '';

  if (!$user_id || !$username || !$email) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit;
  }

  try {
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE user_id = ?");
    $stmt->execute([$username, $email, $user_id]);
    echo json_encode(['success' => true]);
  } catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
  }
  exit;
}

// ✅ Delete user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete_user') {
  $user_id = $_POST['user_id'] ?? 0;

  if (!$user_id) {
    echo json_encode(['success' => false, 'error' => 'Missing user ID']);
    exit;
  }

  try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);

    echo json_encode(['success' => true]);
  } catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
  }
  exit;
}

// ✅ Fetch all data
try {
  $total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
  $total_students = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();  
  $total_teachers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'")->fetchColumn();
  $pending_materials = $pdo->query("SELECT COUNT(*) FROM materials WHERE status = 'pending'")->fetchColumn();
  $active_materials = $pdo->query("SELECT COUNT(*) FROM materials WHERE status = 'approved'")->fetchColumn();

  $stmtStudents = $pdo->prepare("SELECT user_id AS id, username, email, status, profile_image FROM users WHERE role = 'student'");
  $stmtStudents->execute();
  $students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);

  $stmtTeachers = $pdo->prepare("SELECT user_id AS id, username, email, status, role, profile_image FROM users WHERE role = 'teacher'");
  $stmtTeachers->execute();
  $teachers = $stmtTeachers->fetchAll(PDO::FETCH_ASSOC);

  $stmtAdmins = $pdo->prepare("SELECT user_id AS id, username, email, status, profile_image FROM users WHERE role = 'admin'");
  $stmtAdmins->execute();
  $admins = $stmtAdmins->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([
    "stats" => [
      "total_users" => (int)$total_users,
      "total_teachers" => (int)$total_teachers,
      "total_students" => (int)$total_students,
      "pending_materials" => (int)$pending_materials,
      "active_materials" => (int)$active_materials,
    ],
    "students" => $students,
    "teachers" => $teachers,
    "admins" => $admins
  ]);
  
} catch (Exception $e) {
  echo json_encode(["error" => $e->getMessage()]);
}
?>
