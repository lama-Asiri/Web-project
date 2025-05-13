<?php
require_once '../php/config.php'; // Adjust the path to your DB config if needed

$username = 'Lama Admin';
$email = 'lama@admin.com';
$rawPassword = '@Dmin123';
$role = 'admin';

// Hash the password securely
$hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

// Insert into database
try {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword, $role]);
    echo "✅ Admin user created successfully!";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
