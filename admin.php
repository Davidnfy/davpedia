<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <h2>Dashboard Admin</h2>
        <div class="label-container">
    <label for="produk">Halaman Produk:</label>
    <a href="produk.php" class="button">
        <i class="fas fa-box"></i> Go to Produk
    </a>
</div>
<div class="label-container">
    <label for="detail_jualan">Halaman Detail Jualan:</label>
    <a href="detail_jualan.php" class="button">
        <i class="fas fa-chart-line"></i> Go to Detail Jualan
    </a>
    
</div>
<br>
<a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</body>
</html>