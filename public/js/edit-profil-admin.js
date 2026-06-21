document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. FUNGSI TOAST NOTIFIKASI (Buat Batal/Sukses aja)
    // ==========================================
    function showToast(message, type = 'error') {
        const toast = document.getElementById('toastNotif');
        if (!toast) return;

        toast.textContent = message;

        if (type === 'error') {
            toast.style.backgroundColor = '#ef4444';
        } else if (type === 'success') {
            toast.style.backgroundColor = '#48bb78';
        }

        toast.style.color = 'white';
        toast.style.padding = '15px 25px';
        toast.style.borderRadius = '12px';
        toast.style.fontWeight = '700';
        toast.style.position = 'fixed';
        toast.style.top = '30px';
        toast.style.right = '30px';
        toast.style.zIndex = '10000';
        toast.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        toast.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(0)';

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(50px)';
        }, 3000);
    }

    // ==========================================
    // 2. LOGIKA VALIDASI TOOLTIP & MODAL KONFIRMASI
    // ==========================================
    const btnSimpan = document.getElementById('btnSimpanProfil');
    const formEdit = document.getElementById('formEditProfil');
    const modalKonfirmasi = document.getElementById('modalKonfirmasiSimpan');
    const btnYaSimpan = document.getElementById('btnYaSimpan');
    const btnBatalSimpan = document.getElementById('btnBatalSimpan');

    const inputsWajib = document.querySelectorAll('.wajib-isi');

    if (btnSimpan) {
        btnSimpan.addEventListener('click', function(e) {
            e.preventDefault();

            let isValid = true;
            let firstEmpty = null;

            // Bersihin tooltip lama kalau ada sisa
            const oldTooltip = document.getElementById('customTooltipValidasi');
            if (oldTooltip) oldTooltip.remove();

            // Pengecekan input kosong
            for (let i = 0; i < inputsWajib.length; i++) {
                if (inputsWajib[i].value.trim() === '') {
                    isValid = false;
                    firstEmpty = inputsWajib[i];
                    break;
                }
            }

            if (!isValid && firstEmpty) {
                // BIKIN TOOLTIP ORANYE PERSIS KAYAK GAMBAR 1
                const tooltip = document.createElement('div');
                tooltip.id = 'customTooltipValidasi';
                tooltip.className = 'custom-tooltip-validasi';
                tooltip.innerHTML = `<div class="tooltip-icon">!</div><span>Semua informasi harus diisi</span>`;

                // Tempel tooltipnya ke pembungkus input yang kosong
                const parent = firstEmpty.parentElement;
                parent.style.position = 'relative';
                parent.appendChild(tooltip);

                // Arahin layar ke sana & fokus
                firstEmpty.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstEmpty.focus();

                // Ilangin tooltip pas user ngetik sesuatu
                firstEmpty.addEventListener('input', function() {
                    const t = document.getElementById('customTooltipValidasi');
                    if (t) t.remove();
                }, { once: true });

            } else {
                // KALAU VALID SEMUA, BUKA MODAL KONFIRMASI
                if (modalKonfirmasi) {
                    modalKonfirmasi.style.display = 'flex';
                }
            }
        });
    }

    // ==========================================
    // 3. AKSI TOMBOL DI MODAL KONFIRMASI
    // ==========================================
    if (btnYaSimpan && formEdit) {
        btnYaSimpan.addEventListener('click', function() {
            formEdit.submit();
        });
    }

    if (btnBatalSimpan && modalKonfirmasi) {
        btnBatalSimpan.addEventListener('click', function() {
            modalKonfirmasi.style.display = 'none';
            showToast('Data profil batal diubah', 'error');
        });
    }

    if (modalKonfirmasi) {
        modalKonfirmasi.addEventListener('click', function(e) {
            if (e.target === modalKonfirmasi) {
                modalKonfirmasi.style.display = 'none';
                showToast('Penyimpanan dibatalkan', 'error');
            }
        });
    }

    // ==========================================
    // 4. PREVIEW LOGO SEBELUM UPLOAD
    // ==========================================
    const btnUploadTrigger = document.getElementById('btnUploadTrigger');
    const uploadLogo = document.getElementById('uploadLogo');
    const previewImgLogo = document.getElementById('previewImgLogo');
    const btnLogoHapus = document.querySelector('.btn-logo-hapus');
    const defaultLogoUrl = previewImgLogo ? previewImgLogo.src : '';

    if (btnUploadTrigger && uploadLogo) {
        btnUploadTrigger.addEventListener('click', function() {
            uploadLogo.click();
        });
    }

    if (uploadLogo && previewImgLogo) {
        uploadLogo.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImgLogo.src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    if (btnLogoHapus && uploadLogo && previewImgLogo) {
        btnLogoHapus.addEventListener('click', function() {
            uploadLogo.value = '';
            previewImgLogo.src = defaultLogoUrl;
        });
    }
});
