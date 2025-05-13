<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['checkLogin']) && $_GET['checkLogin'] === 'true') {
    error_log("🔍 Checking login session...");
    error_log("Session ID: " . session_id());
    error_log("Session user_id: " . ($_SESSION['user_id'] ?? 'NOT SET'));

    echo json_encode(['isLoggedIn' => isset($_SESSION['user_id'])]);
    exit;
}

// (rest of your POST logic stays the same)


// إرسال الأسئلة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require 'config.php';

  $subject = trim($_POST['subject'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $question = trim($_POST['question'] ?? '');

  if (!$subject || !$email || !$question) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit;
  }

  try {
    $stmt = $pdo->prepare("INSERT INTO faq (subject, email, question) VALUES (?, ?, ?)");
    $stmt->execute([$subject, $email, $question]);
    echo json_encode(['success' => true, 'message' => 'Your question has been submitted successfully!']);
  } catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
  }
}
?>
