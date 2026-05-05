document.addEventListener('DOMContentLoaded', function() {
    const formKios = document.getElementById('formTambahKios');
    const modalKios = document.getElementById('modalKonfirmasiKios');
    const btnYaKios = document.getElementById('btnYaKios');
    const btnBatalKios = document.getElementById('btnBatalKios');
    const pesanBatal = document.getElementById('pesanBatal');

    if (formKios) {
        formKios.addEventListener('submit', function(e) {
            if (!formKios.checkValidity()) {
                return; 
            }
            e.preventDefault(); 
            modalKios.style.display = 'flex'; 
        });
    }

    if (btnBatalKios) {
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

    if (btnYaKios) {
        btnYaKios.addEventListener('click', function() {
            formKios.submit(); 
        });
    }
});