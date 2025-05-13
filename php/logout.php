<?php
session_start(); // Start the session to access session variables

// 🧹 Clear all session variables
$_SESSION = array();

// 🧨 Delete the session cookie (very important!)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 💣 Destroy the session
session_destroy();

// 🗑️ Clear custom login cookies
setcookie("user_id", "", time() - 3600, "/");
setcookie("user_email", "", time() - 3600, "/");
setcookie("user_role", "", time() - 3600, "/");

// 🔁 Redirect to login page
header("Location: ../php/login.php");
exit;
