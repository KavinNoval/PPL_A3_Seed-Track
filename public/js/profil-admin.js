// ==========================================
// SCRIPT KHUSUS HALAMAN PROFIL ADMIN (BIASA)
// ==========================================

document.addEventListener('DOMContentLoaded', function() {

    /* =========================================
       1. FUNGSI NUTUP MODAL EDIT PROFIL
       (Klik area luar/gelap buat nutup modal)
       ========================================= */
    const modalEdit = document.getElementById('modalEditProfil');

    if (modalEdit) {
        modalEdit.addEventListener('click', function(e) {
            // Pastiin yang diklik background gelapnya, bukan dalem form-nya
            if (e.target === modalEdit) {
                modalEdit.style.display = 'none';
            }
        });
    }


    /* =========================================
       2. FUNGSI MUNCULIN TOAST SUKSES (HIJAU)
       (Nangkep lemparan dari Controller)
       ========================================= */
    const successMarker = document.getElementById('sessionSuccessMarker');

    if (successMarker) {
        const pesan = successMarker.getAttribute('data-message');
        const toast = document.getElementById('toastSukses');

        if(toast) {
            toast.innerText = pesan; // Isi teksnya sesuai attribute data-message
            toast.classList.add('tampil');

            // Ilang otomatis setelah 3 detik
            setTimeout(() => {
                toast.classList.remove('tampil');
            }, 3000);
        }
    }

});
