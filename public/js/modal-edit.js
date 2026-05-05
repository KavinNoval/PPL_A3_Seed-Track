document.addEventListener('DOMContentLoaded', function() {
    
    const modalEdit = document.getElementById('modalKonfirmasiEdit');
    if (!modalEdit) return;

    const formEdit = document.querySelector("form[id^='formEdit']");
    const btnBatal = document.getElementById('btnBatalSimpan') || document.getElementById('btnBatalEdit');
    const btnYa = document.getElementById('btnYaSimpan') || document.getElementById('btnYaEdit');
    
    if (formEdit) {
        formEdit.addEventListener('submit', function(e) {
            if (!formEdit.checkValidity()) {
                return; 
            }
            
            e.preventDefault();
            modalEdit.style.display = 'flex'; 
        });
    }
    
    // batal baru
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            //nutup
            modalEdit.style.display = 'none';
            
            //pesan form
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
            formEdit.submit(); 
        });
    }

});