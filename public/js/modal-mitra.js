document.addEventListener('DOMContentLoaded', function() {

    // ========================================================
    // 1. LOGIKA MODAL KONFIRMASI (Kodingan lu yang udah cakep)
    // ========================================================
    const formMitra = document.getElementById('formTambahMitra');
    const modalMitra = document.getElementById('modalKonfirmasiMitra');
    const btnYaMitra = document.getElementById('btnYaMitra');
    const btnBatalMitra = document.getElementById('btnBatalEdit');
    const pesanBatal = document.getElementById('pesanBatal');

    if (formMitra) {
        formMitra.addEventListener('submit', function(e) {
            if (!formMitra.checkValidity()) {
                return;
            }
            e.preventDefault();
            modalMitra.style.display = 'flex';
        });
    }

    if (btnBatalMitra) {
        btnBatalMitra.addEventListener('click', function() {
            modalMitra.style.display = 'none';
            if (pesanBatal) {
                pesanBatal.style.display = 'block';
                setTimeout(() => {
                    pesanBatal.style.display = 'none';
                }, 3000);
            }
        });
    }

    if (btnYaMitra) {
        btnYaMitra.addEventListener('click', function() {
            console.log("Gas simpan ke database!");
            formMitra.submit();
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
        kecSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';
        kelSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kelurahan --</option>';

        fetch(`/get-kecamatan/${id_kabupaten}`)
            .then(response => response.json())
            .then(data => {
                kecSelect.innerHTML = '<option value="" disabled selected>-- Pilih Kecamatan --</option>';
                data.forEach(kec => {
                    let isSelected = (kec.id_kecamatan == selected_kecamatan) ? 'selected' : '';
                    kecSelect.innerHTML += `<option value="${kec.id_kecamatan}" ${isSelected}>${kec.kecamatan}</option>`;
                });

                // Kalau ada old data kecamatan, langsung panggil kelurahannya
                if (selected_kecamatan != '') {
                    loadKelurahan(selected_kecamatan, window.oldKelurahan);
                }
            })
            .catch(error => {
                console.error('Error fetching kecamatan:', error);
                kecSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
            });
    }

    // Fungsi Fetch Kelurahan dari Controller
    function loadKelurahan(id_kecamatan, selected_kelurahan = '') {
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
                console.error('Error fetching kelurahan:', error);
                kelSelect.innerHTML = '<option value="" disabled selected>Gagal memuat data</option>';
            });
    }

    // Pas Kabupaten diganti, tarik data Kecamatannya
    if(kabSelect) {
        kabSelect.addEventListener('change', function() {
            loadKecamatan(this.value);
        });

        // Trigger load kalau pas awal buka form udah ada isinya (gara-gara error validasi Laravel old() )
        if(kabSelect.value != "") {
            loadKecamatan(kabSelect.value, window.oldKecamatan);
        }
    }

    // Pas Kecamatan diganti, tarik data Kelurahannya
    if(kecSelect) {
        kecSelect.addEventListener('change', function() {
            loadKelurahan(this.value);
        });
    }

});
