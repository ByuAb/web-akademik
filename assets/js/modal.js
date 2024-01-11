function show_modal(iteration) {
    // Dapatkan modal
    var modal = document.getElementById("myModal" + iteration);

    // Dapatkan elemen span yang menutup modal
    var span = document.getElementById("close" + iteration);

    // Ketika pengguna mengklik tombol, buka modal
    modal.style.display = "block";

    // Ketika pengguna klik tombol span x, tutup modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // Ketika pengguna mengklik di luar modal, tutup modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}
