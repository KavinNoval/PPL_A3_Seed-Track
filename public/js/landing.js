// ==========================================
// FITUR MODAL DETAIL PRODUK KATALOG
// ==========================================

// FUNGSI GLOBAL (Ditaruh di luar DOMContentLoaded biar bisa dipanggil dari HTML)
function bukaModalProduk(element) {
    // 1. Ambil data dari elemen kartu yang diklik
    const nama = element.getAttribute('data-nama');
    const harga = element.getAttribute('data-harga');
    const stok = element.getAttribute('data-stok');
    const foto = element.getAttribute('data-foto');
    const deskripsi = element.getAttribute('data-deskripsi');

    // 2. Tembakin datanya ke dalem modal
    document.getElementById('detailNama').innerText = nama;
    document.getElementById('detailHarga').innerText = harga;
    document.getElementById('detailStok').innerText = stok;
    document.getElementById('detailFoto').src = foto;

    // Kasih fallback gambar bawaan kalau fotonya error/kosong
    document.getElementById('detailFoto').onerror = function() {
        this.src = '/images/Logo ST.png';
    };

    document.getElementById('detailDeskripsi').innerText = deskripsi;

    // 3. Munculin modalnya
    document.getElementById('modalDetailProduk').style.display = 'flex';
}

function tutupModalProduk() {
    document.getElementById('modalDetailProduk').style.display = 'none';
}

// EVENT LISTENER KETIKA HALAMAN SELESAI DIMUAT
document.addEventListener('DOMContentLoaded', function() {

    // Fitur tambahan: Nutup modal kalau pengunjung ngeklik area gelap di luar kotak putih
    const modalDetail = document.getElementById('modalDetailProduk');

    if (modalDetail) {
        window.addEventListener('click', function(e) {
            if (e.target === modalDetail) {
                modalDetail.style.display = 'none';
            }
        });
    }

});
