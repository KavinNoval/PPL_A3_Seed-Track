document.addEventListener('DOMContentLoaded', function() {

    // === 1. FITUR SEARCH KATALOG PRODUK REAL-TIME (CUMA NAMA PRODUK) ===
    const searchInput = document.querySelector('.search-input');
    const produkCards = document.querySelectorAll('.produk-card');
    const gridContainer = document.querySelector('.produk-grid');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            produkCards.forEach(card => {
                // Sekarang murni cuma ngambil dari data-nama aja
                const namaProduk = card.getAttribute('data-nama').toLowerCase();

                // Kalo yang diketik ada di nama produk, munculin kartunya
                if (namaProduk.includes(searchTerm)) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Handle pesan error kalo produknya kaga ketemu
            let emptyMsg = document.getElementById('search-empty-produk');

            if (visibleCount === 0 && searchTerm !== '') {
                if (!emptyMsg) {
                    emptyMsg = document.createElement('div');
                    emptyMsg.id = 'search-empty-produk';
                    emptyMsg.style = 'grid-column: 1 / -1; text-align: center; padding: 60px 0; color: #64748b; font-weight: 600; font-size: 1.1rem;';
                    emptyMsg.innerHTML = `
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="2" style="margin-bottom: 10px;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <p style="margin:0;">Produk yang dicari tidak ditemukan.</p>
                    `;
                    gridContainer.appendChild(emptyMsg);
                } else {
                    emptyMsg.style.display = 'block';
                }
            } else if (emptyMsg) {
                emptyMsg.style.display = 'none';
            }
        });
    }

    // === 2. LOGIKA MODAL DETAIL PRODUK ===
    const modal = document.getElementById('modalDetail');
    const cardsDetail = document.querySelectorAll('.btn-show-detail');
    const btnTutup = document.getElementById('btn-tutup-modal');
    const btnUbah = document.getElementById('mdl-btn-ubah');

    if (cardsDetail.length > 0 && modal) {
        cardsDetail.forEach(card => {
            card.addEventListener('click', function() {
                // Ambil data dari atribut HTML kartu
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const stok = this.getAttribute('data-stok');
                const desc = this.getAttribute('data-deskripsi');
                const harga = this.getAttribute('data-harga');
                const foto = this.getAttribute('data-foto');
                let keunggulan = this.getAttribute('data-keunggulan');

                // Isi elemen Modal
                document.getElementById('mdl-nama').textContent = nama;
                document.getElementById('mdl-stok').textContent = stok + " pcs";
                document.getElementById('mdl-deskripsi').textContent = desc;
                document.getElementById('mdl-harga').textContent = "Rp " + harga + "/Pcs";
                document.getElementById('mdl-foto').src = foto;

                // Update link tombol Ubah
                if (btnUbah) {
                    btnUbah.href = '/ubah-produk/' + id;
                }

                // Mecah text keunggulan jadi list bullets
                const listKeunggulan = document.getElementById('mdl-keunggulan');
                listKeunggulan.innerHTML = '';

                if (keunggulan) {
                    const points = keunggulan.split('\n');
                    points.forEach(point => {
                        if (point.trim() !== '') {
                            let li = document.createElement('li');
                            li.textContent = point.trim();
                            listKeunggulan.appendChild(li);
                        }
                    });
                }

                // Munculin Modal
                modal.style.display = 'flex';
            });
        });
    }

    // Event Tutup Modal (Klik luar area putih)
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    // Event Tutup Modal (Tombol Tutup)
    if (btnTutup && modal) {
        btnTutup.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    // === 3. LOGIKA AUTO-HIDE NOTIFIKASI 3D PILL ===
    // Ini biar notif di pojok kanan bawah logo ilang otomatis
    const alerts = document.querySelectorAll('.alert-3d');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = "0.8s ease";
            alert.style.opacity = "0";
            alert.style.transform = "translateX(50px)"; // Efek geser dikit pas ilang

            // Hapus dari HTML biar kaga menuh-menuhin halaman
            setTimeout(() => alert.remove(), 800);
        }, 3000);
    });
});
