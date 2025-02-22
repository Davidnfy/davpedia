<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok']; 
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO produk (nama, harga, stok, gambar) VALUES ('$nama', '$harga', '$stok', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            header("Location: produk.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="tambah_produk.css">
    <link href="https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <h2>Tambah Produk</h2>
    <form action="" method="POST" enctype="multipart/form-data">

        <div class="input-container">
            <i class="fas fa-box"></i>
            <input type="text" name="nama" placeholder="Nama Produk" required>
        </div>

        <div class="input-container">
            <i class="fas fa-tag"></i>
            <input type="number" name="harga" placeholder="Harga" required>
        </div>

        <div class="input-container">
            <i class="fas fa-warehouse"></i>
            <input type="number" name="stok" placeholder="Stok" required>
        </div>

        <div class="input-container">
            <i class="fas fa-image"></i>
            <input class="file-input" type="file" name="gambar" accept="image/*" required>
        </div>

        <button type="submit">Tambah Produk</button>
    </form>
    
    <a href="produk.php" class="back-link">Kembali ke Daftar Produk</a>
</div>

</body>
</html>