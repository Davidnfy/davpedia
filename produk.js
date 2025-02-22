function showEditModal(id, nama, harga, stok, gambar) {
    document.getElementById('editId').value = id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editStok').value = stok;
    document.getElementById('editGambarPreview').src = gambar;
    document.getElementById('editModal').style.display = "flex";
}

function closeModal() {
    document.getElementById('editModal').style.display = "none";
}

function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
        window.location.href = "produk.php?delete=" + id;
    }
}