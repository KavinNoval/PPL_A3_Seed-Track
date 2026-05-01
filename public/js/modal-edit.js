document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Cari pop-up konfirmasinya
    const modalEdit = document.getElementById('modalKonfirmasiEdit');

    // 2. Deteksi otomatis Form-nya
    if (!modalEdit) return;

    const formEdit = document.querySelector("form[id^='formEdit']");

    const btnBatal = document.getElementById('btnBatalSimpan') || document.getElementById('btnBatalEdit');
    const btnYa = document.getElementById('btnYaSimpan') || document.getElementById('btnYaEdit');
    const btnTampilkanModal = document.getElementById('btnTampilkanModal');

    if (btnTampilkanModal) {
        btnTampilkanModal.addEventListener('click', function() {
            modalEdit.style.display = 'block';
        });
    } 
    else if (formEdit) {
        formEdit.addEventListener('submit', function(e) {
            e.preventDefault();
            modalEdit.style.display = 'block'; 
        });
    }
    
    // Pas tombol Batal diklik
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            modalEdit.style.display = 'none';
        });
    }

    // Pas tombol Ya diklik
    if (btnYa && formEdit) {
        btnYa.addEventListener('click', function() {
            formEdit.submit(); 
        });
    }

});