document.addEventListener('DOMContentLoaded', function() {

    // ========================================================
    // 1. LOGIKA MODAL KONFIRMASI (Mencegah submit otomatis)
    // ========================================================
    const modalEdit = document.getElementById('modalKonfirmasiEdit');
    const formEdit = document.getElementById('formEditMitra');
    const btnBatal = document.getElementById('btnBatalEdit');
    const btnYa = document.getElementById('btnYaEdit');

    if (formEdit && modalEdit) {
        formEdit.addEventListener('submit', function(e) {
            // Kalau form nggak valid (masih ada required kosong), biarin HTML5 jalan
            if (!formEdit.checkValidity()) return;

            // Kalau valid, tahan submit, munculin modal
            e.preventDefault();
            modalEdit.style.display = 'block';
        });
    }

    if (btnBatal && modalEdit) {
        btnBatal.addEventListener('click', function() {
            modalEdit.style.display = 'none'; // Tutup modal

            // Tampilkan Toast "Batal"
            const pesanBatal = document.getElementById('pesanBatal');
            if (pesanBatal) {
                pesanBatal.style.display = 'block';
                setTimeout(() => {
                    pesanBatal.style.display = 'none';
                }, 3000);
            }
        });
    }

    if (btnYa && formEdit) {
        btnYa.addEventListener('click', function() {
            // Lanjut proses submit ke Laravel
            formEdit.submit();
        });
    }

    // ========================================================
    // 2. LOGIKA AJAX DROPDOWN WILAYAH (Anti-Error)
    // ========================================================
    const kabSelect = document.getElementById('id_kabupaten');
    const kecSelect = document.getElementById('id_kecamatan');
    const kelSelect = document.getElementById('id_kelurahan');

    function loadKecamatan(idKab, selectedKec = '') {
        if (!idKab || !kecSelect) return;
        kecSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
        if (kelSelect) kelSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelurahan --</option>';

        fetch(`/get-kecamatan/${idKab}`)
            .then(res => res.json())
            .then(data => {
                kecSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan --</option>';
                data.forEach(kec => {
                    let isSelected = (kec.id_kecamatan == selectedKec) ? 'selected' : '';
                    kecSelect.innerHTML += `<option value="${kec.id_kecamatan}" ${isSelected}>${kec.kecamatan}</option>`;
                });

                // Kalau sedang edit/ada error validasi, otomatis panggil kelurahan dari data lama
                if (selectedKec) {
                    loadKelurahan(selectedKec, window.oldKelurahan);
                }
            })
            .catch(err => {
                console.error("Gagal load API Kecamatan:", err);
                kecSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
            });
    }

    function loadKelurahan(idKec, selectedKel = '') {
        if (!idKec || !kelSelect) return;
        kelSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

        fetch(`/get-kelurahan/${idKec}`)
            .then(res => res.json())
            .then(data => {
                kelSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelurahan --</option>';
                data.forEach(kel => {
                    let isSelected = (kel.id_kelurahan == selectedKel) ? 'selected' : '';
                    kelSelect.innerHTML += `<option value="${kel.id_kelurahan}" ${isSelected}>${kel.kelurahan}</option>`;
                });
            })
            .catch(err => {
                console.error("Gagal load API Kelurahan:", err);
                kelSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
            });
    }

    // Event listener saat user ganti Kabupaten
    if (kabSelect) {
        kabSelect.addEventListener('change', function() {
            loadKecamatan(this.value);
        });

        // Trigger otomatis saat halaman pertama kali dibuka (untuk mode Edit)
        if (kabSelect.value) {
            loadKecamatan(kabSelect.value, window.oldKecamatan);
        }
    }

    // Event listener saat user ganti Kecamatan
    if (kecSelect) {
        kecSelect.addEventListener('change', function() {
            loadKelurahan(this.value);
        });
    }
});
