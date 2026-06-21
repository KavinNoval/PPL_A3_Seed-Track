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

        if(displayTotal) displayTotal.innerText = 'Rp. ' + new Intl.NumberFormat('id-ID').format(grandTotal);
        if(inputTotalBayar) inputTotalBayar.value = grandTotal;
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


    // ==========================================
    // 2. FUNGSI TOAST POP-UP (BATAL EDIT FULL)
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
    // 3. FUNGSI MODAL & VALIDASI BALON ORANYE
    // ==========================================
    const formEdit = document.getElementById('formTransaksi'); // Pastiin ID form lu bener 'formTransaksi'
    const modalKonfirmasi = document.getElementById('modalKonfirmasiSimpan');

    window.bukaModalSimpan = function() {
        if(!formEdit) return;

        // Bersihin balon oranye lama
        const oldTooltip = document.querySelector('.custom-tooltip-validasi');
        if (oldTooltip) {
            oldTooltip.parentElement.style.zIndex = '1';
            oldTooltip.remove();
        }

        const elemenWajib = formEdit.querySelectorAll('input[required], select[required], textarea[required]');
        let semuaTerisi = true;
        let yangKosongPertama = null;

        for (let i = 0; i < elemenWajib.length; i++) {
            if (elemenWajib[i].value.trim() === '') {
                semuaTerisi = false;
                yangKosongPertama = elemenWajib[i];
                break;
            }
        }

        // Kalau ada yang kosong, keluarin BALON ORANYE
        if (!semuaTerisi && yangKosongPertama) {
            yangKosongPertama.scrollIntoView({ behavior: 'smooth', block: 'center' });
            yangKosongPertama.focus();
            yangKosongPertama.style.border = '2px solid #ef4444';

            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip-validasi';
            tooltip.innerHTML = `<div class="tooltip-icon">!</div><span>Semua informasi harus diisi</span>`;

            // Pasang jangkar
            const parentBox = yangKosongPertama.parentElement;
            parentBox.style.position = 'relative'; // PASTIIN INI ADA
            parentBox.style.zIndex = '9999';
            parentBox.appendChild(tooltip);

            // Hilangin pas ngetik
            yangKosongPertama.addEventListener('input', function() {
                const t = document.querySelector('.custom-tooltip-validasi');
                if(t) {
                    t.parentElement.style.zIndex = '1';
                    t.remove();
                }
                yangKosongPertama.style.border = '1px solid #cbd5e1';
            }, { once: true });

        } else {
            // Kalau semua udah diisi, buka modal nanya "Yakin ingin menyimpan?"
            if(modalKonfirmasi) modalKonfirmasi.style.display = 'flex';
        }
    };

    window.submitSimpan = function() {
        if(formEdit) formEdit.submit();
    };

    window.tutupKonfirmasiSimpan = function() {
        if(modalKonfirmasi) modalKonfirmasi.style.display = 'none';

        // Bikin Toast Merah "Data batal diubah" pas klik Batal di modal
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed; top: 30px; right: 30px; background: #ef4444; color: white;
            padding: 16px 24px; border-radius: 12px; z-index: 99999; font-weight: 700;
            font-family: 'Inter', sans-serif; box-shadow: 0 10px 25px rgba(239, 68, 68, 0.4);
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); opacity: 0; transform: translateX(50px);
        `;
        toast.innerText = 'Data transaksi batal diubah';
        document.body.appendChild(toast);

        setTimeout(() => { toast.style.opacity = '1'; toast.style.transform = 'translateX(0)'; }, 10);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(50px)';
            setTimeout(() => toast.remove(), 400);
        }, 2000);
    };

});
