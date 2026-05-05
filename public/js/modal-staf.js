document.addEventListener('DOMContentLoaded', function() {
    const formTambah = document.getElementById('formTambahStaf');
    const modalKonfirmasi = document.getElementById('modalKonfirmasi');
    const btnYa = document.getElementById('btnYa');
    const btnBatal = document.getElementById('btnBatal');
    const pesanBatal = document.getElementById('pesanBatal');

    if (formTambah && modalKonfirmasi) {
        formTambah.addEventListener('submit', function(e) {
            if (!formTambah.checkValidity()) {
                return; 
            }

            e.preventDefault();
            modalKonfirmasi.style.display = 'flex';
        });
    }

    if (btnBatal && modalKonfirmasi) {
        btnBatal.addEventListener('click', function() {
            modalKonfirmasi.style.display = 'none';
            
            if (pesanBatal) {
                pesanBatal.style.display = 'block';
                setTimeout(() => {
                    pesanBatal.style.display = 'none';
                }, 3000);
            }
        });
    }

    if (btnYa && formTambah) {
        btnYa.addEventListener('click', function() {
            formTambah.submit();
        });
    }

});