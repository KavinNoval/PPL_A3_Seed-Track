document.addEventListener('DOMContentLoaded', function () {
    const formEdit = document.getElementById('formPengeluaran');
    const modalKonfirmasi = document.getElementById('modalKonfirmasiSimpan');

    // Fungsi ini dipanggil pas tombol "SIMPAN PERUBAHAN" diklik
    window.bukaModalSimpan = function() {

        // 1. Bersihin balon lama biar ga numpuk
        const oldTooltip = document.querySelector('.custom-tooltip-validasi');
        if (oldTooltip) {
            oldTooltip.parentElement.style.zIndex = '1';
            oldTooltip.remove();
        }

        // 2. Cari semua input/select/textarea yang wajib diisi (ada atribut required)
        const elemenWajib = formEdit.querySelectorAll('input[required], select[required], textarea[required]');
        let semuaTerisi = true;
        let yangKosongPertama = null;

        for (let i = 0; i < elemenWajib.length; i++) {
            if (elemenWajib[i].value.trim() === '') {
                semuaTerisi = false;
                yangKosongPertama = elemenWajib[i];
                break; // Ketemu satu yang kosong, langsung stop nyari
            }
        }

        if (!semuaTerisi && yangKosongPertama) {
            // Gulung layar ke elemen yang kosong & kasih border merah
            yangKosongPertama.scrollIntoView({ behavior: 'smooth', block: 'center' });
            yangKosongPertama.focus();
            yangKosongPertama.style.border = '2px solid #ef4444';

            // Bikin elemen balonnya
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip-validasi';
            tooltip.innerHTML = `<div class="tooltip-icon">!</div><span>Semua informasi harus diisi</span>`;

            // Pasang jangkarnya (z-index tinggi biar ga ketutupan)
            const parentBox = yangKosongPertama.parentElement;
            parentBox.style.zIndex = '9999';
            parentBox.appendChild(tooltip);

            // Pas user mulai ngetik, hilangin balonnya
            yangKosongPertama.addEventListener('input', function() {
                const t = document.querySelector('.custom-tooltip-validasi');
                if(t) {
                    t.parentElement.style.zIndex = '1';
                    t.remove();
                }
                yangKosongPertama.style.border = '1px solid #cbd5e1';
            }, { once: true });

        } else {
            // 4. Kalau semua kolom beres diisi, buka modal konfirmasi "Yakin ingin menyimpan?"
            if (modalKonfirmasi) {
                modalKonfirmasi.style.display = 'flex';
            }
        }
    }

    // Aksi untuk tombol "Batal" di Modal Konfirmasi
    // Aksi untuk tombol "Batal" di Modal Konfirmasi
    window.tutupKonfirmasiSimpan = function() {
        if (modalKonfirmasi) {
            modalKonfirmasi.style.display = 'none'; // Tutup modal
        }

        // Panggil Pesan Batal (Toast Merah)
        const toastBatal = document.getElementById('toast-batal');
        if (toastBatal) {
            toastBatal.classList.add('show'); // Munculin

            // Ilangin otomatis setelah 3 detik
            setTimeout(() => {
                toastBatal.classList.remove('show');
            }, 3000);
        }
    }

    // Aksi untuk tombol "Ya" di Modal Konfirmasi
    window.submitSimpan = function() {
        if (formEdit) {
            formEdit.submit(); // Beneran kirim data ke Laravel
        }
    }

});
