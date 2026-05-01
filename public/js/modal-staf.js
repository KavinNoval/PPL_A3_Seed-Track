document.addEventListener('DOMContentLoaded', function() {
    const formStaf = document.getElementById('formTambahStaf');
    const modalStaf = document.getElementById('modalKonfirmasi');
    const btnYaStaf = document.getElementById('btnYa');

    if (formStaf) {
        formStaf.addEventListener('submit', function(e) {
            if (!formStaf.checkValidity()) {
                return; 
            }
            
            e.preventDefault();
            modalStaf.style.display = 'flex'; 
        });
    }

    if (btnYaStaf) {
        btnYaStaf.addEventListener('click', function() {
            formStaf.submit(); 
        });
    }
});