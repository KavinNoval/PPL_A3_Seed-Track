document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. FUNGSI NOTIF MELAYANG (PILL)
    // ==========================================
    window.showPill = function (message, type) {

        const container = document.getElementById('alert-master-container');

        if (!container) return;

        container.innerHTML = '';

        const pill = document.createElement('div');

        pill.className = `alert-3d alert-${type === 'success' ? 'success' : 'error'}`;

        pill.textContent = message;

        container.appendChild(pill);

        autoRemovePill(pill);
    };

    function autoRemovePill(element) {

        setTimeout(() => {

            if (element && element.parentNode) {

                element.style.transition = "0.8s ease";
                element.style.opacity = "0";
                element.style.transform = "translateX(50px)";

                setTimeout(() => {

                    if (element && element.parentNode) {
                        element.remove();
                    }

                }, 800);
            }

        }, 3500);
    }

    // SAPU NOTIF BAWAAN LARAVEL
    document.querySelectorAll('#alert-master-container .alert-3d')
        .forEach(alert => autoRemovePill(alert));

    // ==========================================
    // 2. DEKLARASI ELEMENT
    // ==========================================
    const btnBukaEdit = document.getElementById('btn-buka-edit');
    const btnSimpan = document.getElementById('btn-simpan-perubahan');

    const inputs = document.querySelectorAll('.input-lock');

    const uploadOptions = document.querySelector('.upload-options.mode-view-hide');

    const modalEdit = document.getElementById('modalEdit');

    const formEdit = document.getElementById('formEditMonitoring');

    const preview = document.getElementById('preview_foto_mantap');

    const buntelanAwal = document.getElementById('buntelan_awal');

    const previewOriginalSrc = preview ? preview.src : "";

    // ==========================================
    // 3. FUNGSI MODE VIEW
    // ==========================================
    function aktifkanModeView() {

        inputs.forEach(input => {

            input.setAttribute('disabled', 'true');

            input.style.backgroundColor = "#f8fafc";

            input.style.cursor = "not-allowed";
        });

        if (uploadOptions) {
            uploadOptions.style.display = 'none';
        }

        if (btnSimpan) {
            btnSimpan.style.display = 'none';
        }

        if (btnBukaEdit) {
            btnBukaEdit.style.display = 'block';
        }
    }

    // ==========================================
    // 4. FUNGSI MODE EDIT
    // ==========================================
    function aktifkanModeEdit() {

        inputs.forEach(input => {

            input.removeAttribute('disabled');

            input.style.backgroundColor = "white";

            input.style.cursor = "text";
        });

        if (uploadOptions) {
            uploadOptions.style.display = 'flex';
        }

        if (btnBukaEdit) {
            btnBukaEdit.style.display = 'none';
        }

        if (btnSimpan) {
            btnSimpan.style.display = 'block';
        }
    }

    // ==========================================
    // 5. VALIDASI CUSTOM
    // ==========================================
    function checkValidityCustom(formElement, tooltipIdText) {

        let isValid = true;

        let firstEmptyInput = null;

        const requiredInputs = formElement.querySelectorAll('[required]:not([disabled])');

        const oldTooltip = document.getElementById(tooltipIdText);

        if (oldTooltip) {
            oldTooltip.remove();
        }

        for (let i = 0; i < requiredInputs.length; i++) {

            if (requiredInputs[i].type === 'file') {

                if (requiredInputs[i].files.length === 0 && !preview.src) {

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

        if (!isValid && firstEmptyInput) {

            const tooltip = document.createElement('div');

            tooltip.id = tooltipIdText;

            tooltip.className = 'custom-tooltip';

            tooltip.innerHTML = `
                <div class="tooltip-icon">!</div>
                <span>Semua informasi harus diisi</span>
            `;

            const parentDiv = firstEmptyInput.closest('.form-group');

            if (parentDiv) {

                parentDiv.style.position = 'relative';

                parentDiv.appendChild(tooltip);
            }

            firstEmptyInput.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            firstEmptyInput.focus();

            firstEmptyInput.addEventListener('input', function () {

                const t = document.getElementById(tooltipIdText);

                if (t) {
                    t.remove();
                }

            }, { once: true });
        }

        return isValid;
    }

    // ==========================================
    // 6. TOMBOL UBAH
    // ==========================================
    if (btnBukaEdit) {

        btnBukaEdit.addEventListener('click', function () {

            aktifkanModeEdit();

            window.showPill("Mode Ubah Diaktifkan", "success");
        });
    }

    // ==========================================
    // 7. TOMBOL SIMPAN
    // ==========================================
    if (btnSimpan) {

        btnSimpan.addEventListener('click', function (e) {

            e.preventDefault();

            if (formEdit && checkValidityCustom(formEdit, 'tooltipEditMonitoring')) {

                if (modalEdit) {

                    modalEdit.style.display = 'flex';
                }
            }
        });
    }

    // ==========================================
    // 8. KONFIRMASI SIMPAN
    // ==========================================
    const btnConfirmEdit = document.getElementById('confirmEdit');

    if (btnConfirmEdit && formEdit) {

        btnConfirmEdit.addEventListener('click', function () {

            formEdit.submit();
        });
    }

    // ==========================================
    // 9. TUTUP MODAL
    // ==========================================
    document.querySelectorAll('.close-modal, .btn-batal').forEach(btn => {

    btn.addEventListener('click', function () {

        // Kalau modal edit kebuka
        if (modalEdit && modalEdit.style.display === 'flex') {

            // Cuma tutup modal
            modalEdit.style.display = 'none';

            // Tetap di mode edit
            // Tidak reset
            // Tidak balik mode lihat

            window.showPill("Data monitoring batal diubah", "error");
            }
        });
    });

    // ==========================================
    // 10. TOMBOL BACK
    // ==========================================
    const btnBack = document.querySelector('.back-btn-form');

    if (btnBack) {

        btnBack.addEventListener('click', function (e) {

            // Kalau masih mode edit
            if (btnSimpan && btnSimpan.style.display === 'block') {

                e.preventDefault();

                // Reset form ke data awal
                formEdit.reset();

                // Balik ke mode lihat
                aktifkanModeView();

                // Balikin preview foto asli
                if (preview) {

                    preview.src = previewOriginalSrc;

                    if (!previewOriginalSrc) {

                        preview.style.display = 'none';

                        if (buntelanAwal) {
                            buntelanAwal.style.display = 'flex';
                        }

                    } else {

                        preview.style.display = 'block';

                        if (buntelanAwal) {
                            buntelanAwal.style.display = 'none';
                        }
                    }
                }

                window.showPill("Perubahan dibatalkan", "error");
            }
        });
    }

    // ==========================================
    // 11. PREVIEW FOTO
    // ==========================================
    window.sihirPreviewEdit = function (event) {

        const input = event.target;

        const preview = document.getElementById('preview_foto_mantap');

        const buntelanAwal = document.getElementById('buntelan_awal');

        if (input.files && input.files[0]) {

            const reader = new FileReader();

            reader.onload = function (e) {

                preview.src = e.target.result;

                preview.style.display = 'block';

                if (buntelanAwal) {
                    buntelanAwal.style.display = 'none';
                }
            };

            reader.readAsDataURL(input.files[0]);
        }
    };

    // ==========================================
    // 12. TRIGGER KAMERA DAN GALERI
    // ==========================================
    window.bukaGaleri = function () {
        let inputFoto = document.getElementById('foto_upload_utama');
        if (inputFoto) {
            inputFoto.removeAttribute('capture');
            inputFoto.click();
        }
    };

    window.bukaKamera = function () {
        let inputFoto = document.getElementById('foto_upload_utama');
        if (inputFoto) {
            inputFoto.setAttribute('capture', 'environment');
            inputFoto.click();
        }
    };

    // ==========================================
    // 13. LOGIKA HALAMAN TAMBAH MONITORING
    // ==========================================
    const btnSimpanTambah = document.getElementById('btn-submit-trigger');
    const formTambah = document.getElementById('formTambahMonitoring');
    const modalAdd = document.getElementById('modalAdd');
    const btnConfirmAdd = document.getElementById('confirmAdd');

    // Kalo tombol SIMPAN diklik, validasi form terus buka Modal Add
    if (btnSimpanTambah) {
        btnSimpanTambah.addEventListener('click', function (e) {
            e.preventDefault();
            // Pake fungsi validasi lu yang canggih itu
            if (formTambah && checkValidityCustom(formTambah, 'tooltipTambahMonitoring')) {
                if (modalAdd) {
                    modalAdd.style.display = 'flex';
                }
            }
        });
    }

    // Kalo di modal klik "YA", baru formnya di-submit beneran
    if (btnConfirmAdd && formTambah) {
        btnConfirmAdd.addEventListener('click', function () {
            formTambah.submit();
        });
    }

    // Biar tombol Batal di modalAdd bisa nutup modalnya
    document.querySelectorAll('.close-modal, .btn-batal').forEach(btn => {
        btn.addEventListener('click', function () {
            if (modalAdd && modalAdd.style.display === 'flex') {
                modalAdd.style.display = 'none';
                if(typeof window.showPill === 'function') {
                    window.showPill("Batal menambahkan data", "error");
                }
            }
        });
    });

});
