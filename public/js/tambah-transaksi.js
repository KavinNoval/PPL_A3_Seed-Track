document.addEventListener('DOMContentLoaded', function() {

    // === 1. DEKLARASI ELEMENT STEP & TOMBOL ===
    const step1 = document.getElementById('step1_pelanggan');
    const step2 = document.getElementById('step2_transaksi');
    const btnLanjut = document.getElementById('btnLanjut');

    // Ini tombol back bulat di pojok kiri atas yang udah pinter
    const btnBackTop = document.getElementById('btnBackTop');

    const formBuatTransaksi = document.getElementById('formBuatTransaksi');

    // === 2. UBAH TEKS VALIDASI KOSONG ===
    const requiredInputs = document.querySelectorAll('input[required], select[required]');
    requiredInputs.forEach(input => {
        input.addEventListener('invalid', function() {
            this.setCustomValidity('Semua informasi harus diisi');
        });
        input.addEventListener('input', function() {
            this.setCustomValidity('');
        });
    });

    // === 3. LOGIKA PINDAH STEP (LANJUT) ===
    if (btnLanjut) {
        btnLanjut.addEventListener('click', function() {
            const tgl = document.getElementById('inp_tgl').value;
            const tipe = document.getElementById('inp_tipe').value;
            const nama = document.getElementById('inp_nama').value;
            const telp = document.getElementById('inp_telp').value;

            if (tgl === '' || tipe === '' || nama === '' || telp === '') {
                formBuatTransaksi.reportValidity(); // Trigger error browser
            } else {
                step1.style.display = 'none';
                step2.style.display = 'block';
            }
        });
    }

    // === 4. LOGIKA TOMBOL BACK PINTER (KIRI ATAS) ===
    if (btnBackTop) {
        btnBackTop.addEventListener('click', function() {
            // Cek apakah user lagi di Step 2 (Form Transaksi)
            if (step2.style.display === 'block') {
                // Kalo iya, balikin ke Step 1 (Form Pelanggan)
                step2.style.display = 'none';
                step1.style.display = 'block';
            } else {
                // Kalo udah di Step 1, lempat ke URL Daftar Transaksi sesuai Role
                window.location.href = this.getAttribute('data-url');
            }
        });
    }

    // === 5. LOGIKA TAMBAH BARIS PRODUK (DINAMIS) ===
    const btnTambahProduk = document.getElementById('btn-tambah-produk');
    const wadahProduk = document.getElementById('wadah-semua-produk');

    if(btnTambahProduk && wadahProduk) {
        btnTambahProduk.addEventListener('click', function() {
            const barisPertama = wadahProduk.querySelector('.baris-produk');
            const barisBaru = barisPertama.cloneNode(true);

            barisBaru.querySelector('.pilih-produk').selectedIndex = 0;
            barisBaru.querySelector('.input-jumlah').value = '';
            barisBaru.querySelector('.hidden_harga').value = '0';
            barisBaru.querySelector('.hidden_subtotal').value = '0';

            const btnHapus = barisBaru.querySelector('.btn-hapus-baris');
            btnHapus.style.display = 'block';

            btnHapus.addEventListener('click', function() {
                barisBaru.remove();
                kalkulasiTotal();
            });

            const newInputs = barisBaru.querySelectorAll('input[required], select[required]');
            newInputs.forEach(input => {
                input.addEventListener('invalid', function() {
                    this.setCustomValidity('Semua informasi harus diisi');
                });
                input.addEventListener('input', function() {
                    this.setCustomValidity('');
                });
            });

            wadahProduk.appendChild(barisBaru);
        });
    }

    // === 6. LOGIKA MODAL SIMPAN ===
    const btnSimpan = document.getElementById('btnSimpan');
    const modalSimpan = document.getElementById('modalSimpan');
    const btnYaSimpan = document.getElementById('btnYaSimpan');
    const btnBatalSimpan = document.getElementById('btnBatalSimpan');
    const toastBatal = document.getElementById('toast-batal');

    if (btnSimpan && modalSimpan) {
        btnSimpan.addEventListener('click', function(e) {
            e.preventDefault();
            if (formBuatTransaksi.checkValidity()) {
                modalSimpan.style.display = 'flex';
            } else {
                formBuatTransaksi.reportValidity();
            }
        });
    }

    if (btnYaSimpan && formBuatTransaksi) {
        btnYaSimpan.addEventListener('click', function() {
            formBuatTransaksi.submit();
        });
    }

    if (btnBatalSimpan) {
        btnBatalSimpan.addEventListener('click', function() {
            modalSimpan.style.display = 'none';
            if (toastBatal) {
                toastBatal.classList.add('show');
                setTimeout(() => {
                    toastBatal.classList.remove('show');
                }, 3000);
            }
        });
    }
});

// === 7. FUNGSI HITUNG MATEMATIKA & CEK STOK ===
window.kalkulasiTotal = function() {
    let grandTotal = 0;
    const semuaBaris = document.querySelectorAll('.baris-produk');

    semuaBaris.forEach(baris => {
        const select = baris.querySelector('.pilih-produk');
        const inputJumlah = baris.querySelector('.input-jumlah');
        const hiddenHarga = baris.querySelector('.hidden_harga');
        const hiddenSubtotal = baris.querySelector('.hidden_subtotal');

        if(select && inputJumlah) {
            const opsiTerpilih = select.options[select.selectedIndex];
            let harga = 0;
            let stokMaksimal = 0;

            if (opsiTerpilih && opsiTerpilih.value !== "") {
                harga = parseFloat(opsiTerpilih.getAttribute('data-harga')) || 0;
                stokMaksimal = parseInt(opsiTerpilih.getAttribute('data-stok')) || 0;
            }

            let qty = parseFloat(inputJumlah.value) || 0;

            if (qty > stokMaksimal && opsiTerpilih.value !== "") {
                alert(`Waduh, stok ${opsiTerpilih.text.split('(')[0]} hanya ${stokMaksimal} `);
                qty = stokMaksimal;
                inputJumlah.value = qty;
            }

            const subtotal = harga * qty;

            if (hiddenHarga) hiddenHarga.value = harga;
            if (hiddenSubtotal) hiddenSubtotal.value = subtotal;

            grandTotal += subtotal;
        }
    });

    const displayTotal = document.getElementById('display_total');
    if (displayTotal) {
        displayTotal.value = 'Rp. ' + new Intl.NumberFormat('id-ID').format(grandTotal);
    }

    document.getElementById('hidden_tagihan').value = grandTotal;
    document.getElementById('hidden_total_bayar').value = grandTotal;
}
