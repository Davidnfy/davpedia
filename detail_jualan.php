<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM detail_jualan WHERE no=$id";
    if ($conn->query($sql)) {
        $conn->query("SET @num := 0");
        $conn->query("UPDATE detail_jualan SET no = (@num := @num + 1) ORDER BY no");
        $conn->query("ALTER TABLE detail_jualan AUTO_INCREMENT = 1");
        echo "<script>alert('Data berhasil dihapus!'); window.location='detail_jualan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $barang = $conn->real_escape_string($_POST['barang']);
    $total_barang = intval($_POST['total_barang']) ?: 0;
    $total_harga = intval($_POST['total_harga']) ?: 0;

    $sql = "UPDATE detail_jualan SET 
            nama='$nama', alamat='$alamat', tanggal_pembelian='$tanggal', 
            barang_yang_dibeli='$barang', total_barang_yang_dibeli=$total_barang, 
            total_harga=$total_harga WHERE no=$id";

    if ($conn->query($sql)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='detail_jualan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
$sql = "SELECT * FROM detail_jualan ORDER BY no ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jualan</title>
    <link rel="stylesheet" href="detail_jualan.css">
    <script src="jualan.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body>
    <h2>Halaman Detail Jualan</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tanggal Pembelian</th>
            <th>Barang yang Dibeli</th>
            <th>Total Barang</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['no'] ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= $row['tanggal_pembelian'] ?></td>
                <td><?= htmlspecialchars($row['barang_yang_dibeli']) ?></td>
                <td><?= $row['total_barang_yang_dibeli'] ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td class="action-buttons">
                    <button class="edit-btn" onclick="openEditModal(
                        <?= $row['no'] ?>, 
                        '<?= htmlspecialchars($row['nama']) ?>', 
                        '<?= htmlspecialchars($row['alamat']) ?>', 
                        '<?= $row['tanggal_pembelian'] ?>', 
                        '<?= htmlspecialchars($row['barang_yang_dibeli']) ?>', 
                        <?= $row['total_barang_yang_dibeli'] ?>, 
                        <?= $row['total_harga'] ?>
                    )">Edit</button>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['no'] ?>">
                        <button class="delete-btn" type="submit" name="delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button" onclick="closeEditModal()">&times;</span>
            <h2>Edit Detail Jualan</h2>
            <form method="POST">
                <input type="hidden" id="edit-id" name="id">
                <label>Nama:</label>
                <input type="text" id="edit-nama" name="nama" required>
                <label>Alamat:</label>
                <input type="text" id="edit-alamat" name="alamat" required>
                <label>Tanggal Pembelian:</label>
                <input type="date" id="edit-tanggal" name="tanggal" required>
                <label>Nama Produk:</label>
                <input type="text" id="edit-barang" name="barang" required>
                <label>Total Barang:</label>
                <input type="number" id="edit-total_barang" name="total_barang" required>
                <label>Total Harga:</label>
                <input type="number" id="edit-total_harga" name="total_harga" required>
                <button type="submit" name="update" class="submit-button">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <a href="admin.php" class="logout"> <i class="fas fa-sign-out-alt"></i> Kembali</a>
</body>
</html>