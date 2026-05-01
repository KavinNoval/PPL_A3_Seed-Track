document.addEventListener('DOMContentLoaded', function() {
    const formKios = document.getElementById('formTambahKios');
    const modalKios = document.getElementById('modalKonfirmasiKios');
    const btnBatalKios = document.getElementById('btnBatalKios');
    const btnYaKios = document.getElementById('btnYaKios');

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
        });
    }

    if (btnYaKios) {
        btnYaKios.addEventListener('click', function() {
            formKios.submit();
        });
    }
});