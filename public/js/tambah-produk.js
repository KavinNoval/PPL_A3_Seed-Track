document.addEventListener('DOMContentLoaded', function() {

    // === 1. LOGIKA PREVIEW FOTO ===
    const inputFoto = document.getElementById('foto_produk');
    const container = document.getElementById('upload-preview-container'); // Kotak pembungkus default (icon + text)
    const imgPreview = document.getElementById('preview-foto-produk');     // Tag <img> tersembunyi

    if (inputFoto && container && imgPreview) {
        inputFoto.addEventListener('change', function(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Set sumber gambar ke file yang dipilih
                    imgPreview.src = e.target.result;
                    // Tampilkan gambar
                    imgPreview.style.display = 'block';
                    // Sembunyikan ikon dan teks "Klik untuk upload foto"
                    container.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    }

    // === 2. LOGIKA VALIDASI CUSTOM & MODAL KONFIRMASI ===
    const btnTrigger = document.getElementById('btnTriggerSimpan');
    const modal = document.getElementById('modalKonfirmasi');
    const btnYa = document.getElementById('btnYaSimpan');
    const btnBatal = document.getElementById('btnBatalSimpan');
    const form = document.getElementById('formProduk');
    const alertContainer = document.getElementById('alert-container-ubah');

    if (btnTrigger && form) {
        btnTrigger.addEventListener('click', function() {
            let isValid = true;
            let firstEmptyInput = null;

            // Cari semua input & textarea yang wajib diisi
            const requiredInputs = form.querySelectorAll('[required]');

            // Bersihin tooltip oren yang lama kalo ada
            const oldTooltip = document.getElementById('tooltipAlertAdmin');
            if (oldTooltip) oldTooltip.remove();

            // Cek manual satu-satu
            for (let i = 0; i < requiredInputs.length; i++) {
                if (requiredInputs[i].type === 'file') {
                    if (requiredInputs[i].files.length === 0) {
                        isValid = false;
                        firstEmptyInput = requiredInputs[i];
                        break;
                    }
                } else if (requiredInputs[i].value.trim() === '') {
                    isValid = false;
                    firstEmptyInput = requiredInputs[i];
                    break;
                }
            }

            if (!isValid) {
                // KALO KOSONG: Bikin dan tempel Tooltip Oren
                const tooltip = document.createElement('div');
                tooltip.id = 'tooltipAlertAdmin';
                tooltip.className = 'custom-tooltip';
                tooltip.innerHTML = `<div class="tooltip-icon">!</div><span>Semua informasi harus diisi</span>`;

                // Tempel di div .form-group pembungkusnya
                const parentDiv = firstEmptyInput.closest('.form-group');
                if (parentDiv) {
                    parentDiv.style.position = 'relative';
                    parentDiv.appendChild(tooltip);
                } else {
                    // Buat file upload yang beda class div-nya
                    firstEmptyInput.parentElement.style.position = 'relative';
                    firstEmptyInput.parentElement.appendChild(tooltip);
                }

                // Fokusin layar ke inputan yang salah
                firstEmptyInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstEmptyInput.focus();

                // Ilangin pas user ngetik/upload
                firstEmptyInput.addEventListener('input', function() {
                    const t = document.getElementById('tooltipAlertAdmin');
                    if (t) t.remove();
                }, { once: true });
                firstEmptyInput.addEventListener('change', function() {
                    const t = document.getElementById('tooltipAlertAdmin');
                    if (t) t.remove();
                }, { once: true });

            } else {
                // KALO AMAN: Buka Modal
                modal.style.display = 'flex';
            }
        });
    }

    // === 3. LOGIKA TOMBOL MODAL & NOTIF MELAYANG ===
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            modal.style.display = 'none';

            if (alertContainer) {
                const pill = document.createElement('div');
                pill.className = 'alert-3d alert-error';
                pill.textContent = btnBatal.getAttribute('data-pesan') || 'Data produk batal disimpan';
                alertContainer.appendChild(pill);

                setTimeout(() => {
                    pill.style.transition = "0.8s ease";
                    pill.style.opacity = "0";
                    pill.style.transform = "translateX(50px)";
                    setTimeout(() => pill.remove(), 800);
                }, 3500);
            }
        });
    }

    if (btnYa && form) {
        btnYa.addEventListener('click', function() {
            form.submit();
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target == modal && btnBatal) {
            btnBatal.click();
        }
    });

    // === 4. LOGIKA AUTO-HIDE NOTIF DARI BACKEND ===
    const alerts = document.querySelectorAll('.alert-3d');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = "0.8s ease";
            alert.style.opacity = "0";
            alert.style.transform = "translateX(50px)";
            setTimeout(() => alert.remove(), 800);
        }, 3500);
    });
});
