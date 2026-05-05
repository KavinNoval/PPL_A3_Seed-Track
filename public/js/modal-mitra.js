document.addEventListener('DOMContentLoaded', function() {
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
});