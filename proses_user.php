<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_pembelian = $_POST['tanggal_pembelian'];
    $barang_yang_dibeli = $_POST['barang_yang_dibeli'];
    $total_barang_yang_dibeli = (int)$_POST['total_barang_yang_dibeli'];
    $total_harga = $_POST['total_harga'];
    $cekStokQuery = "SELECT stok FROM produk WHERE nama = '$barang_yang_dibeli'";
    $result = $conn->query($cekStokQuery);
    $row = $result->fetch_assoc();
    $stokSekarang = $row['stok'];

    if ($stokSekarang >= $total_barang_yang_dibeli) {
     
        $sql = "INSERT INTO detail_jualan (nama, alamat, tanggal_pembelian, barang_yang_dibeli, total_barang_yang_dibeli, total_harga) 
                VALUES ('$nama', '$alamat', '$tanggal_pembelian', '$barang_yang_dibeli', '$total_barang_yang_dibeli', '$total_harga')";

        if ($conn->query($sql) === TRUE) {
           

            $updateStokQuery = "UPDATE produk SET stok = stok - $total_barang_yang_dibeli WHERE nama = '$barang_yang_dibeli'";
            $conn->query($updateStokQuery);

            echo "<script>alert('Pembelian Berhasil!'); window.location.href='user.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Stok tidak mencukupi!'); window.location.href='user.php';</script>";
    }

    $conn->close();
}
?>
