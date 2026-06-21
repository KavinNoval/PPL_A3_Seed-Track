document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. SEARCH & FILTER (Universal)
    // ==========================================
    const inputCari = document.getElementById('inputCari');
    const filterKategori = document.getElementById('filterKategori');
    const filterBulan = document.getElementById('filterBulan');

    function filterTable() {
        const tbody = document.getElementById('tbody-pengeluaran');
        if (!tbody) return;

        const rows = tbody.querySelectorAll('tr');
        const cari = inputCari ? inputCari.value.toLowerCase() : '';
        const kategori = filterKategori ? filterKategori.value.toLowerCase() : '';
        const bulan = filterBulan ? filterBulan.value.toLowerCase() : '';

        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;

            const teksBaris = row.innerText.toLowerCase();
            const teksTanggal = row.querySelector('.td-tanggal') ? row.querySelector('.td-tanggal').innerText.toLowerCase() : '';

            const cocokCari = teksBaris.includes(cari);
            const cocokKategori = kategori === '' || teksBaris.includes(kategori);
            const cocokBulan = bulan === '' || teksTanggal.includes(bulan);

            row.style.display = (cocokCari && cocokKategori && cocokBulan) ? '' : 'none';
        });
    }

    if (inputCari) inputCari.addEventListener('input', filterTable);
    if (filterKategori) filterKategori.addEventListener('change', filterTable);
    if (filterBulan) filterBulan.addEventListener('change', filterTable);


    // ==========================================
    // 2. MODAL TAMBAH & VALIDASI (FIX BALON ORANYE)
    // ==========================================
    const modalTambah = document.getElementById('modalTambahPengeluaran');
    const btnTriggerSimpan = document.getElementById('btn-trigger-simpan');
    const formTambah = document.getElementById('formTambahPengeluaran');
    const modalKonfirmasi = document.getElementById('modalKonfirmasiSimpan');

    window.bukaModalTambah = function() {
        if (modalTambah) modalTambah.style.display = 'flex';
    }
    window.tutupModalTambah = function() {
        if (modalTambah) modalTambah.style.display = 'none';
    }

    if (btnTriggerSimpan && formTambah) {
        btnTriggerSimpan.addEventListener('click', function(e) {
            e.preventDefault();

            // Hapus balon lama biar ga numpuk
            const oldTooltip = document.querySelector('.custom-tooltip-validasi');
            if (oldTooltip) oldTooltip.remove();

            const elemenWajib = formTambah.querySelectorAll('input[required], select[required], textarea[required]');
            let semuaTerisi = true;
            let yangKosongPertama = null;

            for (let i = 0; i < elemenWajib.length; i++) {
                if (elemenWajib[i].value.trim() === '') {
                    semuaTerisi = false;
                    yangKosongPertama = elemenWajib[i];
                    break;
                }
            }

            if (!semuaTerisi && yangKosongPertama) {
                // Arahin layar ke input yang kosong & kasih garis merah
                yangKosongPertama.scrollIntoView({ behavior: 'smooth', block: 'center' });
                yangKosongPertama.focus();
                yangKosongPertama.style.border = '2px solid #ef4444';

                // BIKIN BALON ORANYE (Nama class udah di-match sama CSS lu)
                const tooltip = document.createElement('div');
                tooltip.className = 'custom-tooltip-validasi';
                tooltip.innerHTML = `<div class="tooltip-icon">!</div><span>Semua informasi harus diisi</span>`;

                // Set jangkar langsung dari JS
                yangKosongPertama.parentElement.style.position = 'relative';
                yangKosongPertama.parentElement.appendChild(tooltip);

                // Ilangin balon dan garis merah pas mulai ngetik
                yangKosongPertama.addEventListener('input', function() {
                    const t = document.querySelector('.custom-tooltip-validasi');
                    if(t) t.remove();
                    yangKosongPertama.style.border = '1px solid #cbd5e1';
                }, { once: true });

            } else {
                if (modalKonfirmasi) {
                    modalKonfirmasi.style.display = 'flex';
                }
            }
        });
    }

    const btnYaSimpan = document.getElementById('btnYaSimpan');
    if (btnYaSimpan && formTambah) {
        btnYaSimpan.addEventListener('click', function() {
            formTambah.submit();
        });
    }

    const btnBatalSimpan = document.getElementById('btnBatalSimpan');
    if (btnBatalSimpan && modalKonfirmasi) {
        btnBatalSimpan.addEventListener('click', function() {
            // 1. Tutup pop-up konfirmasinya
            modalKonfirmasi.style.display = 'none';

            // 2. Bikin notif pop-up (Toast) Merah lewat JS
            let toastBatal = document.getElementById('toast-batal-dinamis');
            if (!toastBatal) {
                toastBatal = document.createElement('div');
                toastBatal.id = 'toast-batal-dinamis';
                toastBatal.className = 'toast-alert toast-danger';
                toastBatal.innerHTML = 'Data pengeluaran batal disimpan';
                document.body.appendChild(toastBatal);
            }

            // 3. Munculin animasinya
            setTimeout(() => { toastBatal.classList.add('show'); }, 10);

            // 4. Ilangin otomatis setelah 3 detik
            setTimeout(() => {
                toastBatal.classList.remove('show');
            }, 3000);
        });
    }


    // ==========================================
    // 3. PREVIEW GAMBAR SEBELUM UPLOAD
    // ==========================================
    window.sihirPreviewGambar = function(input) {
        const wadah = document.getElementById('wadah_preview_gambar');
        const gambar = document.getElementById('preview_gambar_tambah');
        const namaFile = document.getElementById('nama_file_pilih');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            namaFile.style.display = 'block';
            namaFile.textContent = "File terpilih: " + file.name;

            if (file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    gambar.src = e.target.result;
                    wadah.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                wadah.style.display = 'none';
            }
        } else {
            wadah.style.display = 'none';
            namaFile.style.display = 'none';
        }
    }


    // ==========================================
    // 4. BUKA MODAL LIHAT NOTA BUKTI (CUMA NAMPILIN GAMBAR)
    // ==========================================
    window.lihatNota = function(url) {
        const modal = document.getElementById('modalLihatNota');
        const img = document.getElementById('gambarNotaBesar');

        // Langsung tembak src gambarnya dan tampilin modal
        img.src = url;
        modal.style.display = 'flex';
    }

    window.tutupNota = function() {
        document.getElementById('modalLihatNota').style.display = 'none';
    }

});
