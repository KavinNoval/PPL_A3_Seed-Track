// ==========================================
// SCRIPT KHUSUS HALAMAN EDIT PROFIL
// ==========================================

document.addEventListener('DOMContentLoaded', function() {

    /* =========================================
       1. FITUR UPLOAD & HAPUS LOGO
       ========================================= */
    const uploadLogo = document.getElementById('uploadLogo');
    const previewImg = document.getElementById('previewImgLogo');
    const btnHapus = document.querySelector('.btn-logo-hapus');
    const btnUpload = document.getElementById('btnUploadTrigger');

    // Trigger klik input file sembunyi pas tombol "Ganti Logo" diklik
    if(btnUpload) {
        btnUpload.addEventListener('click', function() {
            if(uploadLogo) uploadLogo.click();
        });
    }

    // Fitur buat ganti logo otomatis pas pilih file
    if (uploadLogo && previewImg) {
        uploadLogo.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Fitur buat hapus logo / balik ke default
    if (btnHapus && previewImg) {
        btnHapus.addEventListener('click', function() {
            // Pastiin path '/images/Logo ST.png' bener sesuai folder lu ya
            previewImg.src = '/images/Logo ST.png';
            if(uploadLogo) uploadLogo.value = ''; // Kosongin input file-nya
        });
    }


    /* =========================================
       2. LOGIKA MODAL KONFIRMASI & TOAST MERAH
       ========================================= */

    // Fungsi khusus munculin Toast Merah (Error / Batal)
    function tampilkanToastError(pesan) {
        const toast = document.getElementById('toastNotif');
        if(toast) {
            toast.innerText = pesan;
            toast.classList.add('tampil');
            setTimeout(() => { toast.classList.remove('tampil'); }, 3000); // Ilang 3 detik
        }
    }

    const btnSimpan = document.getElementById('btnSimpanProfil');
    const modalKonfirmasi = document.getElementById('modalKonfirmasiSimpan');
    const btnBatal = document.getElementById('btnBatalSimpan');
    const btnYa = document.getElementById('btnYaSimpan');
    const formEdit = document.getElementById('formEditProfil');

    // Tombol "Simpan Perubahan" diklik -> Cek form kosong -> Muncul Modal
    if(btnSimpan) {
        btnSimpan.addEventListener('click', function() {
            const wajibIsi = document.querySelectorAll('.wajib-isi');
            let kosong = false;

            wajibIsi.forEach(input => {
                if (input.value.trim() === "") kosong = true;
            });

            if (kosong) {
                tampilkanToastError("Semua informasi wajib diisi!");
            } else {
                if(modalKonfirmasi) modalKonfirmasi.style.display = 'flex';
            }
        });
    }

    // Tombol "Batal" di Modal Konfirmasi diklik
    if(btnBatal) {
        btnBatal.addEventListener('click', function() {
            if(modalKonfirmasi) modalKonfirmasi.style.display = 'none';
            tampilkanToastError("Data profil perusahaan batal diubah");
        });
    }

    // Tombol "Ya" di Modal Konfirmasi diklik
    if(btnYa) {
        btnYa.addEventListener('click', function() {
            if(modalKonfirmasi) modalKonfirmasi.style.display = 'none';
            if(formEdit) formEdit.submit(); // Kirim data ke database!
        });
    }
});
