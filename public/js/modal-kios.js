document.addEventListener('DOMContentLoaded', function() {

    // ========================================================
    // 1. LOGIKA MODAL KONFIRMASI KIOS (Tambah & Edit)
    // ========================================================
    // Kita pake querySelector kayak yang Mitra kemaren biar sakti (bisa nangkep formTambahKios ATAU formEditKios)
    const formKios = document.querySelector("form[id^='formTambahKios'], form[id^='formEditKios']");
    const modalKios = document.getElementById('modalKonfirmasiKios') || document.getElementById('modalKonfirmasiEdit');
    const btnYaKios = document.getElementById('btnYaKios') || document.getElementById('btnYaEdit');
    const btnBatalKios = document.getElementById('btnBatalKios') || document.getElementById('btnBatalEdit');
    const pesanBatal = document.getElementById('pesanBatal');

    if (formKios && modalKios) {
        formKios.addEventListener('submit', function(e) {
            if (!formKios.checkValidity()) {
                return;
            }
            e.preventDefault();
            modalKios.style.display = 'flex';
        });
    }

    if (btnBatalKios && modalKios) {
        btnBatalKios.addEventListener('click', function() {
            modalKios.style.display = 'none';
            if (pesanBatal) {
                pesanBatal.style.display = 'block';
                setTimeout(() => {
                    pesanBatal.style.display = 'none';
                }, 3000);
            }
        });
    }

    if (btnYaKios && formKios) {
        btnYaKios.addEventListener('click', function() {
            formKios.submit();
        });
    }

    // ========================================================
    // 2. LOGIKA DROPDOWN WILAYAH BERANTAI (AJAX)
    // ========================================================
    const kabSelect = document.getElementById('id_kabupaten');
    const kecSelect = document.getElementById('id_kecamatan');
    const kelSelect = document.getElementById('id_kelurahan');

    // Fungsi Fetch Kecamatan dari Controller
    function loadKecamatan(id_kabupaten, selected_kecamatan = '') {
        if(!kecSelect) return;
        kecSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
        if(kelSelect) kelSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelurahan --</option>';

        fetch(`/get-kecamatan/${id_kabupaten}`)
            .then(response => response.json())
            .then(data => {
                kecSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan --</option>';
                data.forEach(kec => {
                    let isSelected = (kec.id_kecamatan == selected_kecamatan) ? 'selected' : '';
                    kecSelect.innerHTML += `<option value="${kec.id_kecamatan}" ${isSelected}>${kec.kecamatan}</option>`;
                });

                // Kalau pas disubmit ternyata ada form kosong (error validasi), kelurahannya otomatis diload lagi
                if (selected_kecamatan != '') {
                    loadKelurahan(selected_kecamatan, window.oldKelurahan);
                }
            })
            .catch(error => {
                console.error("Gagal ambil data kecamatan:", error);
                kecSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
            });
    }

    // Fungsi Fetch Kelurahan dari Controller
    function loadKelurahan(id_kecamatan, selected_kelurahan = '') {
        if(!kelSelect) return;
        kelSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

        fetch(`/get-kelurahan/${id_kecamatan}`)
            .then(response => response.json())
            .then(data => {
                kelSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelurahan --</option>';
                data.forEach(kel => {
                    let isSelected = (kel.id_kelurahan == selected_kelurahan) ? 'selected' : '';
                    kelSelect.innerHTML += `<option value="${kel.id_kelurahan}" ${isSelected}>${kel.kelurahan}</option>`;
                });
            })
            .catch(error => {
                console.error("Gagal ambil data kelurahan:", error);
                kelSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
            });
    }

    // Event pas dropdown Kabupaten dipilih
    if(kabSelect) {
        kabSelect.addEventListener('change', function() {
            loadKecamatan(this.value);
        });

        // 🔴 Nembak otomatis pas halaman ke-load (dengan delay 100ms)
        setTimeout(() => {
            if(kabSelect.value && kabSelect.value != "") {
                loadKecamatan(kabSelect.value, window.oldKecamatan);
            }
        }, 100);
    }

    // Event pas dropdown Kecamatan dipilih
    if(kecSelect) {
        kecSelect.addEventListener('change', function() {
            loadKelurahan(this.value);
        });
    }

}); 
