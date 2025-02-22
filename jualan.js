document.addEventListener("DOMContentLoaded", function() {
    let editModal = document.getElementById("editModal");
    let closeButton = document.querySelector(".close-button");

    window.openEditModal = function(id, nama, alamat, tanggal, barang, total_barang, total_harga) {
        document.getElementById("edit-id").value = id;
        document.getElementById("edit-nama").value = nama;
        document.getElementById("edit-alamat").value = alamat;
        document.getElementById("edit-tanggal").value = tanggal;
        document.getElementById("edit-barang").value = barang;
        document.getElementById("edit-total_barang").value = total_barang;
        document.getElementById("edit-total_harga").value = total_harga;

        editModal.style.display = "flex";
    };

    closeButton.addEventListener("click", function() {
        editModal.style.display = "none";
    });

    window.addEventListener("click", function(event) {
        if (event.target === editModal) {
            editModal.style.display = "none";
        }
    });
});