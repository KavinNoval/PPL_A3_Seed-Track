document.addEventListener('DOMContentLoaded', function() {
    
    window.showPill = function(message, type) {
        const container = document.getElementById('alert-master-container');
        if (!container) return;

        const pill = document.createElement('div');
        pill.className = `alert-3d alert-${type === 'success' ? 'success' : 'error'}`;
        pill.textContent = message;
        
        container.appendChild(pill);

        setTimeout(() => {
            pill.style.transition = "0.8s ease";
            pill.style.opacity = "0";
            pill.style.transform = "translateX(50px)";
            setTimeout(() => pill.remove(), 800);
        }, 3500);
    }
    
    const btnBukaEdit = document.getElementById('btn-buka-edit');
    const btnSimpan = document.getElementById('btn-simpan-perubahan');
    
    // --- ELEMENT LAINNYA ---
    const inputs = document.querySelectorAll('.input-lock');
    const uploadBox = document.getElementById('box-upload-foto');
    const tabsContainer = document.querySelector('.fase-tabs');
    const modalEdit = document.getElementById('modalEdit');
    const formEdit = document.getElementById('formEditMonitoring');

    // --- ELEMENT UNTUK TAMBAH MONITORING ---
    const btnAddTrigger = document.getElementById('btn-submit-trigger');
    const modalAdd = document.getElementById('modalAdd');
    const formTambah = document.getElementById('formTambahMonitoring');

    // ==========================================
    // LOGIKA HALAMAN EDIT (Fitur Unlock/Lock)
    // ==========================================
    // 1. Pas tombol "Ubah" diklik
    if (btnBukaEdit) {
        btnBukaEdit.addEventListener('click', function() {
            inputs.forEach(input => {
                input.removeAttribute('disabled');
                input.style.backgroundColor = "white"; 
                input.style.cursor = "text";
            });

            if (uploadBox) uploadBox.style.display = 'flex';
            if (tabsContainer) {
                tabsContainer.classList.remove('mode-view-tabs');
                tabsContainer.style.pointerEvents = 'auto'; // Buka gembok tab
            }

            btnBukaEdit.style.display = 'none';
            if (btnSimpan) btnSimpan.style.display = 'block';
            
            window.showPill("Mode Ubah Diaktifkan", "success");
        });
    }

    // 2. Pas tombol "Simpan Perubahan" diklik
    if (btnSimpan) {
        btnSimpan.addEventListener('click', function() {
            if (formEdit && !formEdit.checkValidity()) {
                formEdit.reportValidity();
                return;
            }
            if (modalEdit) modalEdit.style.display = 'flex';
        });
    }

    const btnConfirmEdit = document.getElementById('confirmEdit');
    if (btnConfirmEdit && formEdit) {
        btnConfirmEdit.addEventListener('click', function() {
            formEdit.submit();
        });
    }

    // ==========================================
    // LOGIKA HALAMAN TAMBAH
    // ==========================================
    if (btnAddTrigger) {
        btnAddTrigger.addEventListener('click', function() {
            if (formTambah && formTambah.checkValidity()) {
                if (modalAdd) modalAdd.style.display = 'flex';
            } else if (formTambah) {
                formTambah.reportValidity();
            }
        });
    }

    const btnConfirmAdd = document.getElementById('confirmAdd');
    if (btnConfirmAdd && formTambah) {
        btnConfirmAdd.addEventListener('click', function() {
            formTambah.submit();
        });
    }

    // ==========================================
    // FITUR TUTUP MODAL & ALERT BATAL (Shared)
    // ==========================================
    document.querySelectorAll('.close-modal, .btn-batal').forEach(btn => {
        btn.addEventListener('click', function() {
            // 1. Tutup semua modal yang lagi kebuka
            if (modalEdit) modalEdit.style.display = 'none';
            if (modalAdd) modalAdd.style.display = 'none';

            // 2. Logika Balikin Gembok (Khusus Edit)
            if (btnBukaEdit && btnSimpan && btnSimpan.style.display === 'block') {
                
                // INI JURUS RESETNYA BOY 👇
                if (formEdit) formEdit.reset();

                inputs.forEach(input => {
                    input.setAttribute('disabled', 'true');
                    input.style.backgroundColor = "#f1f5f9"; 
                    input.style.cursor = "not-allowed";
                });
                if (uploadBox) uploadBox.style.display = 'none';
                if (tabsContainer) {
                    tabsContainer.classList.add('mode-view-tabs');
                    tabsContainer.style.pointerEvents = 'none'; // Kunci lagi tab-nya
                }
                btnBukaEdit.style.display = 'block';
                btnSimpan.style.display = 'none';
            }

            // 3. Munculin Alert Batal pake Pill 3D
            window.showPill("Data monitoring batal diubah", "error");
        });
    });

    // ==========================================
    // FUNGSI CEGAT TOMBOL BACK (KHUSUS HALAMAN EDIT)
    // ==========================================
    const btnBack = document.querySelector('.back-btn-form');
    
    if (btnBack) {
        btnBack.addEventListener('click', function(e) {
            // Cek kondisi: Kalau tombol "SIMPAN" lagi muncul (lagi MODE EDIT)
            if (btnSimpan && btnSimpan.style.display === 'block') {
                
                e.preventDefault(); 

                // INI JURUS RESETNYA JUGA BOY 👇
                if (formEdit) formEdit.reset();

                document.querySelectorAll('.input-lock').forEach(input => {
                    input.setAttribute('disabled', 'true');
                    input.style.backgroundColor = "#f8fafc"; 
                    input.style.cursor = "not-allowed";
                });

                if (uploadBox) uploadBox.style.display = 'none';
                if (tabsContainer) tabsContainer.classList.add('mode-view-tabs');

                btnSimpan.style.display = 'none';
                if (btnBukaEdit) btnBukaEdit.style.display = 'block';

                window.showPill("Perubahan dibatalkan", "error");
            }
        });
    }
}); 

// ==========================================
// FUNGSI KLIK TAB FASE (Milih Fase Tanam)
// ==========================================
window.pilihFase = function(element) {
    const container = document.querySelector('.fase-tabs');
    
    if (container && container.classList.contains('mode-view-tabs')) {
        return; 
    }

    document.querySelectorAll('.fase-tab').forEach(tab => {
        tab.classList.remove('active');
    });

    element.classList.add('active');

    const faseValue = element.getAttribute('data-fase');
    const inputFase = document.getElementById('input_fase_tanam');
    if(inputFase) {
        inputFase.value = faseValue;
    }
    
    if (typeof window.showPill === 'function') {
        window.showPill(`Fase diubah ke: ${faseValue}`, 'success');
    }
};