<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $sql = "DELETE FROM produk WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk!');</script>";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $harga = $conn->real_escape_string($_POST['harga']);
    $stok = $conn->real_escape_string($_POST['stok']);
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = basename($_FILES['gambar']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $gambar;
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $sql = "UPDATE produk SET nama='$nama', harga='$harga', stok='$stok', gambar='$target_file' WHERE id='$id'";
        } else {
            echo "<script>alert('Gagal mengunggah gambar!');</script>";
            exit();
        }
    } else {
        $sql = "UPDATE produk SET nama='$nama', harga='$harga', stok='$stok' WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Produk berhasil diperbarui!'); window.location='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui produk!');</script>";
    }
}
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="produk.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="produk.js" defer></script>
</head>
<body>
<h2>Daftar Produk</h2>
<a href="tambah_produk.php" class="button tambah">Tambah Produk</a><br><br>
<div class="produk-container">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class='card'>
            <img src="<?= $row['gambar'] ?>" alt='Gambar Produk'>
            <div class='card-content'>
                <h3><?= htmlspecialchars($row['nama']) ?></h3>
                <p class='harga'>Rp <?= number_format($row['harga'], 2, ',', '.') ?></p>
                <p class='stok'>Stok: <?= $row['stok'] ?></p>
            </div>
            <div class='button-container'>
                <button onclick="showEditModal('<?= $row['id'] ?>', '<?= htmlspecialchars($row['nama']) ?>', '<?= $row['harga'] ?>', '<?= $row['stok'] ?>', '<?= $row['gambar'] ?>')" class='button edit-button'>
                    <i class='fas fa-edit'></i> Edit
                </button>
                <button onclick="confirmDelete('<?= $row['id'] ?>')" class='button delete-button'>
                    <i class='fas fa-trash'></i> Hapus
                </button>
            </div>
        </div>
    <?php } ?>
</div>
<a href="admin.php" class="button kembali"> <i class="fas fa-sign-out-alt"></i> Kembali</a><br><br>
</body>
</html>