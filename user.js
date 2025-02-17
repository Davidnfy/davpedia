function showModal(nama, harga) {
    document.getElementById("buyModal").classList.add("show");
    document.getElementById("produkNama").value = nama;
    document.getElementById("produkHarga").value = harga;
}

function closeModal() {
    document.getElementById("buyModal").classList.remove("show");
}
