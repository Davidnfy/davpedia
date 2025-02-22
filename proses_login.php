<?php
session_start();
$admin_username = "admin";
$admin_password = "admin123";
$user_username = "user";
$user_password = "user123";
$username = $_POST['username'];
$password = $_POST['password'];

if ($username == $admin_username && $password == $admin_password) {
    $_SESSION['username'] = $username; 
    $_SESSION['role'] = 'admin'; 
    header("Location: admin.php"); 
} elseif ($username == $user_username && $password == $user_password) {
    $_SESSION['username'] = $username; 
    $_SESSION['role'] = 'user'; 
    header("Location: user.php"); 
} else {
    header("Location: login.php?error=invalid");
    exit();
}
?>