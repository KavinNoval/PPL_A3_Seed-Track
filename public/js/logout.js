document.addEventListener('DOMContentLoaded', function() {
    const trigger = document.getElementById('btnLogoutTrigger');
    const modal = document.getElementById('modalLogout');
    const btnYa = document.getElementById('btnYaLogout');
    const btnBatal = document.getElementById('btnBatalLogout');
    const form = document.getElementById('formLogout');

    if (trigger) {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'flex';
        });
    }

    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    if (btnYa) {
        btnYa.addEventListener('click', function() {
            form.submit();
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});