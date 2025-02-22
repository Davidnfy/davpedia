<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$sql = "SELECT * FROM produk WHERE stok > 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="user.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
</head>
<body>

<h2>Daftar Produk</h2>
<div class="produk-container">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar Produk">
            <div class="card-content">
                <h3><?= htmlspecialchars($row['nama']) ?></h3>
                <p class="harga">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                <p class="stok">Stok: <?= htmlspecialchars($row['stok']) ?></p>
            </div>
            <div class="button-container">
                <button onclick="showModal('<?= htmlspecialchars($row['nama']) ?>', <?= $row['harga'] ?>)" class="button buy-button">
                    <i class="fas fa-shopping-cart"></i> Beli
                </button>
            </div>
        </div>
    <?php } ?>
</div>
<div id="buyModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Form Pembelian</h3>
        <form action="proses_user.php" method="POST">
            <label><i class="fas fa-user"></i> Nama:</label>
            <input type="text" name="nama" required>

            <label><i class="fas fa-map-marker-alt"></i> Alamat:</label>
            <input type="text" name="alamat" required>

            <label><i class="fas fa-calendar-alt"></i> Tanggal Pembelian:</label>
            <input type="date" name="tanggal_pembelian" required>

            <label><i class="fas fa-box"></i> Nama Produk:</label>
            <input type="text" name="barang_yang_dibeli" id="produkNama" readonly>

            <label><i class="fas fa-money-bill"></i> Harga Satuan:</label>
            <input type="text" name="harga" id="produkHarga" readonly>

            <label><i class="fas fa-sort-numeric-up"></i> Jumlah:</label>
            <input type="number" name="total_barang_yang_dibeli" id="jumlahBeli" min="1" required oninput="hitungTotal()">

            <label><i class="fas fa-money-bill-wave"></i> Total Harga:</label>
            <input type="text" name="total_harga" id="totalHarga" readonly>

            <button type="submit" name="submit"><i class="fas fa-shopping-cart"></i> Beli Sekarang</button>
        </form>
    </div>
</div>
<a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
<script>
    function showModal(nama, harga) {
    document.getElementById("buyModal").classList.add("show");
    document.getElementById("produkNama").value = nama;
    document.getElementById("produkHarga").value = harga;
}

function closeModal() {
    document.getElementById("buyModal").classList.remove("show");
}

function hitungTotal() {
    let jumlah = document.getElementById("jumlahBeli").value;
    let harga = document.getElementById("produkHarga").value;
    
    if (jumlah && harga) {
        let total = jumlah * parseFloat(harga);
        document.getElementById("totalHarga").value = "Rp " + new Intl.NumberFormat('id-ID').format(total);
    } else {
        document.getElementById("totalHarga").value = "";
    }
}
</script>
</body>
</html>
