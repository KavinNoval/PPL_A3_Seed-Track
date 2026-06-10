document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // 1. LOGIKA HITUNG PRODUK OTOMATIS
    // ==========================================
    const container = document.getElementById('produk-container');
    const btnTambah = document.getElementById('btnTambahRow');
    const displayTotal = document.getElementById('displayTotal');
    const inputTotalBayar = document.getElementById('inputTotalBayar');

    const templateElement = document.getElementById('row-template');
    const rowTemplate = templateElement ? templateElement.innerHTML : '';

    function hitungTotal() {
        let grandTotal = 0;
        const rows = container.querySelectorAll('.produk-row');

        rows.forEach(row => {
            const select = row.querySelector('.select-produk');
            const qtyInput = row.querySelector('.input-qty');
            const subtotalView = row.querySelector('.input-subtotal-view');
            const hargaSatuanInput = row.querySelector('.input-harga-satuan');

            if(select && qtyInput && select.value && qtyInput.value) {
                const option = select.options[select.selectedIndex];
                const harga = parseFloat(option.getAttribute('data-harga')) || 0;
                const qty = parseFloat(qtyInput.value) || 0;
                const subtotal = harga * qty;

                hargaSatuanInput.value = harga;
                subtotalView.value = new Intl.NumberFormat('id-ID').format(subtotal);
                grandTotal += subtotal;
            }
        });

        displayTotal.innerText = 'Rp. ' + new Intl.NumberFormat('id-ID').format(grandTotal);
        inputTotalBayar.value = grandTotal;
    }

    if (btnTambah) {
        btnTambah.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'produk-row';
            newRow.innerHTML = rowTemplate;
            container.appendChild(newRow);
            hitungTotal();
        });
    }

    if (container) {
        container.addEventListener('input', function(e) {
            if(e.target.classList.contains('select-produk') || e.target.classList.contains('input-qty')) {
                hitungTotal();
            }
        });

        container.addEventListener('click', function(e) {
            if(e.target.classList.contains('btn-hapus-row')) {
                const rows = container.querySelectorAll('.produk-row');
                if(rows.length > 1) {
                    e.target.closest('.produk-row').remove();
                    hitungTotal();
                } else {
                    alert("Minimal harus ada 1 produk yang dibeli!");
                }
            }
        });
    }

    // Hitung pertama kali load biar totalnya sinkron
    hitungTotal();
});

// ==========================================
// 2. FUNGSI TOAST POP-UP (BATAL EDIT)
// ==========================================
window.batalEdit = function(urlKembali) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed; top: 30px; right: 30px; background: #ef4444; color: white;
        padding: 16px 24px; border-radius: 12px; z-index: 99999; font-weight: 700;
        font-family: 'Inter', sans-serif; box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); opacity: 0; transform: translateX(50px);
    `;
    toast.innerText = 'Data transaksi batal diedit';
    document.body.appendChild(toast);

    setTimeout(() => { toast.style.opacity = '1'; toast.style.transform = 'translateX(0)'; }, 10);
    setTimeout(() => { window.location.href = urlKembali; }, 1500);
};

// ==========================================
// 3. FUNGSI MODAL KONFIRMASI SIMPAN
// ==========================================
window.bukaModalSimpan = function() {
    const form = document.getElementById('formTransaksi');

    // Cek dulu apakah semua field yang wajib udah diisi
    if (form.checkValidity()) {
        document.getElementById('modalKonfirmasiSimpan').style.display = 'flex';
    } else {
        form.reportValidity(); // Minta browser ngasih tau input mana yang belum diisi
    }
};

window.submitSimpan = function() {
    document.getElementById('formTransaksi').submit(); // Eksekusi kirim data
};

// 👇 INI YANG DIUBAH: Pas klik Batal di modal, keluarin Toast Merah! 👇
window.tutupKonfirmasiSimpan = function() {
    // 1. Tutup modal pop-up nya
    document.getElementById('modalKonfirmasiSimpan').style.display = 'none';

    // 2. Bikin Toast Notif Merah
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed; top: 30px; right: 30px; background: #ef4444; color: white;
        padding: 16px 24px; border-radius: 12px; z-index: 99999; font-weight: 700;
        font-family: 'Inter', sans-serif; box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); opacity: 0; transform: translateX(50px);
    `;
    toast.innerText = 'Data transaksi batal diubah';
    document.body.appendChild(toast);

    // Animasi masuk (geser dari kanan)
    setTimeout(() => { toast.style.opacity = '1'; toast.style.transform = 'translateX(0)'; }, 10);

    // Hilang otomatis setelah 2 detik (nggak usah pindah halaman, biar bisa lanjut ngedit)
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
        setTimeout(() => toast.remove(), 400); // Bersihin dari memori
    }, 2000);
};
