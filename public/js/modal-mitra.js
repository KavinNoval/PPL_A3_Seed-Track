document.addEventListener('DOMContentLoaded', function() {
    const formMitra = document.getElementById('formTambahMitra');
    const modalMitra = document.getElementById('modalKonfirmasiMitra');
    const btnYaMitra = document.getElementById('btnYaMitra');
    const btnBatalMitra = document.getElementById('btnBatalEdit');

    if (formMitra) {
        formMitra.addEventListener('submit', function(e) {
            e.preventDefault(); 
            modalMitra.style.display = 'flex'; 
        });
    }

    if (btnYaMitra) {
        btnYaMitra.addEventListener('click', function() {
            console.log("Gas simpan ke database!"); 
            formMitra.submit(); 
        });
    }

    if (btnBatalMitra) {
        btnBatalMitra.addEventListener('click', function() {
            modalMitra.style.display = 'none';
        });
    }
});