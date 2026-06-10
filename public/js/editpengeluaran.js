// 1. Fungsi Buka Modal Konfirmasi Simpan
window.bukaModalSimpan = function() {
    const form = document.getElementById('formPengeluaran');

    // Validasi form dulu biar user nggak ngasal klik
    if (form.checkValidity()) {
        document.getElementById('modalKonfirmasiSimpan').style.display = 'flex';
    } else {
        form.reportValidity();
    }
};

// 2. Fungsi Tutup Modal & Munculin Pesan Batal
window.tutupKonfirmasiSimpan = function() {
    document.getElementById('modalKonfirmasiSimpan').style.display = 'none';

    // Panggil fungsi toast buat ngasih notif batal
    tampilkanToast('Batal menyimpan perubahan', '#ef4444');
};

// 3. Fungsi Submit Form (Kalau user yakin klik Ya)
window.submitSimpan = function() {
    document.getElementById('formPengeluaran').submit();
};

// 4. Fungsi Helper buat Toast Notifikasi
window.tampilkanToast = function(pesan, warna) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed; top: 30px; right: 30px; background: ${warna}; color: white;
        padding: 16px 24px; border-radius: 12px; z-index: 99999; font-weight: 700;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2); font-family: 'Inter', sans-serif;
        transition: 0.4s ease; opacity: 0; transform: translateX(50px);
    `;
    toast.innerText = pesan;
    document.body.appendChild(toast);

    // Animasi muncul
    setTimeout(() => { toast.style.opacity = '1'; toast.style.transform = 'translateX(0)'; }, 10);

    // Animasi ilang otomatis
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
        setTimeout(() => toast.remove(), 400);
    }, 2000);
};
