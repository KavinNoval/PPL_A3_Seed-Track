document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. FITUR SEARCH & FILTER
    // ==========================================
    const searchInput  = document.querySelector('.search-pill input');
    const filterSelect = document.getElementById('filterTipePelanggan');
    const tableRows    = document.querySelectorAll('.table-st tbody tr');

    function jalankanFilter() {
        const searchTerm  = searchInput  ? searchInput.value.toLowerCase().trim() : '';
        const filterValue = filterSelect ? filterSelect.value.toLowerCase()       : '';
        let visibleCount  = 0;

        tableRows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            const rowText  = row.innerText.toLowerCase();
            const tipeCell = row.cells[1] ? row.cells[1].innerText.toLowerCase() : '';
            const cocokKetik  = rowText.includes(searchTerm);
            const cocokFilter = filterValue === '' || tipeCell.includes(filterValue);

            if (cocokKetik && cocokFilter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        let emptyMessageRow = document.getElementById('search-empty-msg');
        if (visibleCount === 0 && (searchTerm !== '' || filterValue !== '')) {
            if (!emptyMessageRow) {
                const tbody = document.querySelector('.table-st tbody');
                const tr = document.createElement('tr');
                tr.id = 'search-empty-msg';
                tr.innerHTML = `<td colspan="6" style="text-align:center;color:#64748b;padding:40px 0;font-weight:600;">Data tidak ditemukan.</td>`;
                tbody.appendChild(tr);
            } else {
                emptyMessageRow.style.display = '';
            }
        } else if (emptyMessageRow) {
            emptyMessageRow.style.display = 'none';
        }
    }

    if (searchInput)  searchInput.addEventListener('input',  jalankanFilter);
    if (filterSelect) filterSelect.addEventListener('change', jalankanFilter);


    // ==========================================
    // 2. MODAL DETAIL TRANSAKSI & LINK EDIT
    // ==========================================
    const modalDetail = document.getElementById('modalDetail');
    const btnTriggers = document.querySelectorAll('.btn-detail-trigger');

    if (modalDetail && btnTriggers.length > 0) {

        btnTriggers.forEach(btn => {
            btn.addEventListener('click', function () {

                // Isi field info pelanggan
                document.getElementById('det_tgl').value   = this.dataset.tgl   || '-';
                document.getElementById('det_tipe').value  = this.dataset.tipe  || '-';
                document.getElementById('det_nama').value  = this.dataset.nama  || '-';
                document.getElementById('det_telp').value  = this.dataset.telp  || '-';
                document.getElementById('det_bayar').value = this.dataset.bayar || '-';
                document.getElementById('det_total').value = this.dataset.total || 'Rp. 0';

                // 👇 INI DIA KUNCI TOMBOL EDIT-NYA 👇
                const btnEditModal = document.getElementById('btnEditTransaksiModal');
                if (btnEditModal && this.dataset.urledit) {
                    btnEditModal.href = this.dataset.urledit;
                }

                // Isi daftar produk
                const listContainer = document.getElementById('det_list_produk');
                listContainer.innerHTML = '';

                try {
                    const produks = JSON.parse(this.dataset.produks || '[]');
                    if (produks.length > 0) {
                        produks.forEach((p) => {
                            const subtotalRp = new Intl.NumberFormat('id-ID').format(p.subtotal);
                            const item = document.createElement('div');
                            item.style.cssText = 'display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px dashed #cbd5e1;';
                            item.innerHTML = `
                                <div>
                                    <div style="font-size:14px;font-weight:700;color:#1e293b;">${p.nama}</div>
                                    <div style="font-size:13px;color:#64748b;">Jumlah: ${p.jumlah} pcs</div>
                                </div>
                                <div style="font-weight:800;color:#A3B87A;font-size:15px;">Rp. ${subtotalRp}</div>
                            `;
                            listContainer.appendChild(item);
                        });
                        listContainer.lastElementChild.style.borderBottom = 'none';
                    } else {
                        listContainer.innerHTML = '<div style="text-align:center;color:#64748b;font-size:13px;padding:10px;">Tidak ada detail produk.</div>';
                    }
                } catch (e) {
                    console.error('Gagal membaca data produk:', e);
                    listContainer.innerHTML = '<div style="text-align:center;color:red;font-size:13px;padding:10px;">Data produk tidak terbaca.</div>';
                }

                // Set action form hapus
                const formHapus = document.getElementById('formHapusTransaksi');
                if (formHapus && this.dataset.url) {
                    formHapus.action = this.dataset.url;
                }

                // Reset: viewDetail tampil, modalKonfirmasi tersembunyi
                document.getElementById('viewDetail').style.display      = 'block';
                document.getElementById('modalKonfirmasi').style.display = 'none';

                // Tampilkan modal
                modalDetail.style.display = 'flex';
            });
        });

        // Tutup modal saat klik area gelap
        modalDetail.addEventListener('click', function (e) {
            if (e.target === modalDetail) {
                modalDetail.style.display = 'none';
            }
        });
    }


    // ==========================================
    // 3. SORTIR NAMA PELANGGAN (A-Z / Z-A)
    // ==========================================
    const btnSortNama    = document.getElementById('btnSortNama');
    const tbodyTransaksi = document.querySelector('.table-st tbody');
    let isAscending      = true;

    if (btnSortNama && tbodyTransaksi) {
        btnSortNama.addEventListener('click', function () {
            const rows = Array.from(tbodyTransaksi.querySelectorAll('tr'))
                .filter(row => !row.querySelector('td[colspan]'));

            rows.sort((a, b) => {
                const namaA = a.cells[2].innerText.toLowerCase().trim();
                const namaB = b.cells[2].innerText.toLowerCase().trim();
                if (namaA < namaB) return isAscending ? -1 :  1;
                if (namaA > namaB) return isAscending ?  1 : -1;
                return 0;
            });

            isAscending = !isAscending;
            btnSortNama.setAttribute('title', isAscending ? 'Sortir A-Z' : 'Sortir Z-A');
            rows.forEach(row => tbodyTransaksi.appendChild(row));
        });
    }

});


// ==========================================
// 4. FUNGSI GLOBAL KONFIRMASI HAPUS
// ==========================================

function tampilKonfirmasi() {
    document.getElementById('modalKonfirmasi').style.display = 'flex';
}

function batalHapus() {
    document.getElementById('modalKonfirmasi').style.display = 'none';
    document.getElementById('modalDetail').style.display     = 'flex';
    document.getElementById('viewDetail').style.display      = 'block';

    // Toast notif batal
    const toast = document.getElementById('toast-js');
    if (toast) {
        toast.innerText   = 'Data transaksi batal dihapus';
        toast.className   = 'toast-alert toast-danger show';
        setTimeout(() => { toast.classList.remove('show'); }, 3000);
    }
}

function submitHapus() {
    document.getElementById('formHapusTransaksi').submit();
}
