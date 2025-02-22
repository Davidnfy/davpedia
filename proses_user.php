<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $tanggal_pembelian = $conn->real_escape_string($_POST['tanggal_pembelian']);
    $barang_yang_dibeli = $conn->real_escape_string($_POST['barang_yang_dibeli']);
    $total_barang_yang_dibeli = isset($_POST['total_barang_yang_dibeli']) ? (int)$_POST['total_barang_yang_dibeli'] : 0;
    $total_harga = isset($_POST['total_harga']) && $_POST['total_harga'] !== '' ? (int)$_POST['total_harga'] : 0;

    $cekStokQuery = "SELECT stok FROM produk WHERE nama = ?";
    $stmt = $conn->prepare($cekStokQuery);
    $stmt->bind_param("s", $barang_yang_dibeli);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stokSekarang = (int)$row['stok'];

        if ($stokSekarang >= $total_barang_yang_dibeli && $total_barang_yang_dibeli > 0) {
            $sql = "INSERT INTO detail_jualan (nama, alamat, tanggal_pembelian, barang_yang_dibeli, total_barang_yang_dibeli, total_harga) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssii", $nama, $alamat, $tanggal_pembelian, $barang_yang_dibeli, $total_barang_yang_dibeli, $total_harga);

            if ($stmt->execute()) {
                $updateStokQuery = "UPDATE produk SET stok = stok - ? WHERE nama = ?";
                $stmt = $conn->prepare($updateStokQuery);
                $stmt->bind_param("is", $total_barang_yang_dibeli, $barang_yang_dibeli);
                $stmt->execute();

                echo "<script>alert('Pembelian Berhasil!'); window.location.href='user.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menyimpan data!'); window.location.href='user.php';</script>";
            }
        } else {
            echo "<script>alert('Stok tidak mencukupi atau jumlah barang tidak valid!'); window.location.href='user.php';</script>";
        }
    } else {
        echo "<script>alert('Barang tidak ditemukan di database!'); window.location.href='user.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
