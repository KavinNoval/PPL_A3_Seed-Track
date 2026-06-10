document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. SEARCH & FILTER (Universal)
    // ==========================================
    const inputCari = document.getElementById('inputCari');
    const filterKategori = document.getElementById('filterKategori');

    function filterTable() {
        const tbody = document.getElementById('tbody-pengeluaran');
        if (!tbody) return; // Kalau tabel gak ada, ya udah stop aja

        const rows = tbody.querySelectorAll('tr');
        const cari = inputCari ? inputCari.value.toLowerCase() : '';
        const kategori = filterKategori ? filterKategori.value.toLowerCase() : '';

        rows.forEach(row => {
            // Abaikan baris "Data Kosong"
            if (row.querySelector('td[colspan]')) return;

            const teks = row.innerText.toLowerCase();
            const cocok = teks.includes(cari) && (kategori === '' || teks.includes(kategori));
            row.style.display = cocok ? '' : 'none';
        });
    }

    if (inputCari) inputCari.addEventListener('input', filterTable);
    if (filterKategori) filterKategori.addEventListener('change', filterTable);


    // ==========================================
    // 2. MODAL KONFIRMASI HAPUS
    // ==========================================
    const modalHapus = document.getElementById('modalHapus');
    const btnYaHapus = document.getElementById('btnYaHapus');
    const formHapus = document.getElementById('formHapusPengeluaran');
    let urlHapus = '';

    window.konfirmasiHapus = function (url) {
        urlHapus = url;
        if (modalHapus) modalHapus.style.display = 'flex';
    };

    if (btnYaHapus && formHapus) {
        btnYaHapus.addEventListener('click', function () {
            formHapus.action = urlHapus;
            formHapus.submit();
        });
    }

    const btnBatalHapus = document.getElementById('btnBatalHapus');
    if (btnBatalHapus && modalHapus) {
        btnBatalHapus.addEventListener('click', function () {
            modalHapus.style.display = 'none';
        });
    }

    if (modalHapus) {
        modalHapus.addEventListener('click', function (e) {
            if (e.target === modalHapus) modalHapus.style.display = 'none';
        });
    }


    // ==========================================
    // 3. MODAL LIHAT NOTA
    // ==========================================
    const modalNota = document.getElementById('modalNota');
    const gambarNota = document.getElementById('gambarNota');
    const btnTutupNota = document.getElementById('btnTutupNota');

    window.lihatNota = function (url) {
        if (gambarNota) gambarNota.src = url;
        if (modalNota) modalNota.style.display = 'flex';
    };

    if (btnTutupNota && modalNota) {
        btnTutupNota.addEventListener('click', function () {
            modalNota.style.display = 'none';
            if (gambarNota) gambarNota.src = '';
        });
    }

    if (modalNota) {
        modalNota.addEventListener('click', function (e) {
            if (e.target === modalNota) {
                modalNota.style.display = 'none';
                if (gambarNota) gambarNota.src = '';
            }
        });
    }


    // ==========================================
    // 4. MODAL TAMBAH PENGELUARAN & PREVIEW
    // ==========================================
    const modalTambah = document.getElementById('modalTambahPengeluaran');
    const formTambah = document.getElementById('formTambahPengeluaran');

    window.bukaModalTambah = function() {
        if (modalTambah) modalTambah.style.display = 'flex';
    };

    window.tutupModalTambah = function() {
        if (modalTambah) modalTambah.style.display = 'none';
        if (formTambah) formTambah.reset();

        const namaFile = document.getElementById('nama_file_pilih');
        const wadahPreview = document.getElementById('wadah_preview_gambar');
        const gambarPreview = document.getElementById('preview_gambar_tambah');

        if (namaFile) { namaFile.style.display = 'none'; namaFile.textContent = ''; }
        if (wadahPreview) wadahPreview.style.display = 'none';
        if (gambarPreview) gambarPreview.src = '';

        if (typeof window.showToast === 'function') {
            window.showToast("Data pengeluaran batal disimpan", "danger");
        }
    };

    window.sihirPreviewGambar = function(input) {
        const namaFileText = document.getElementById('nama_file_pilih');
        const wadahPreview = document.getElementById('wadah_preview_gambar');
        const gambarPreview = document.getElementById('preview_gambar_tambah');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (namaFileText) {
                namaFileText.textContent = file.name;
                namaFileText.style.display = 'block';
            }

            if (file.type.match('image.*')) {
                const pembacaFile = new FileReader();
                pembacaFile.onload = function(e) {
                    if (gambarPreview) gambarPreview.src = e.target.result;
                    if (wadahPreview) wadahPreview.style.display = 'block';
                };
                pembacaFile.readAsDataURL(file);
            } else {
                if (wadahPreview) wadahPreview.style.display = 'none';
            }
        }
    };


    // ==========================================
    // 5. TOAST NOTIFICATION
    // ==========================================
    window.showToast = function(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast-alert toast-${type} show`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    };


    // ==========================================
    // 6. CUSTOM VALIDASI TOOLTIP
    // ==========================================
    if (formTambah) {
        formTambah.addEventListener('submit', function (e) {
            let isValid = true;
            let firstEmpty = null;
            const requiredElements = formTambah.querySelectorAll('[required]');

            const oldTooltip = document.getElementById('customTooltipValidasi');
            if(oldTooltip) oldTooltip.remove();

            for (let i = 0; i < requiredElements.length; i++) {
                if (!requiredElements[i].value.trim()) {
                    isValid = false;
                    firstEmpty = requiredElements[i];
                    break;
                }
            }

            if (!isValid && firstEmpty) {
                e.preventDefault();
                const tooltip = document.createElement('div');
                tooltip.id = 'customTooltipValidasi';
                tooltip.className = 'custom-tooltip-validasi';
                tooltip.innerHTML = `<div class="tooltip-icon">!</div><span>Semua informasi harus diisi</span>`;

                const parent = firstEmpty.parentElement;
                parent.style.position = 'relative';
                parent.appendChild(tooltip);
                firstEmpty.focus();

                firstEmpty.addEventListener('input', function() {
                    const t = document.getElementById('customTooltipValidasi');
                    if(t) t.remove();
                }, {once: true});
            }
        });
    }
});
