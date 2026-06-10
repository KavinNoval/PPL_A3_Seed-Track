document.addEventListener('DOMContentLoaded', function() {
    const btnTrigger = document.getElementById('btnTriggerSimpan');
    const inputStok = document.getElementById('inputStok');
    const modal = document.getElementById('modalKonfirmasi');
    const btnBatal = document.getElementById('btnBatal');
    const btnYa = document.getElementById('btnYa');
    const form = document.getElementById('formUbahStok');
    const alertContainer = document.getElementById('alertContainer'); 
    const tooltipAlert = document.getElementById('tooltipAlert'); // Tarik elemen tooltip-nya

    // Kalo tombol SIMPAN PERUBAHAN diklik
    if (btnTrigger) {
        btnTrigger.addEventListener('click', function() {
            // Cek apakah isian stoknya kosong
            if (inputStok.value.trim() === '') {
                // TAMPILIN TOOLTIP GANTENG (Bukan alert jadul lagi)
                tooltipAlert.style.display = 'flex';
                inputStok.focus(); // Fokusin cursor balik ke inputan
            } else {
                // Kalo aman, ilangin tooltip (buat jaga-jaga) & tampilin modal
                tooltipAlert.style.display = 'none';
                modal.style.display = 'flex';
            }
        });
    }

    // Biar pinter: Pas user mulai ngetik angka, tooltipnya otomatis ilang
    if (inputStok) {
        inputStok.addEventListener('input', function() {
            tooltipAlert.style.display = 'none';
        });
    }

    // Kalo tombol Batal MERAH di dalem modal diklik
    if (btnBatal) {
        btnBatal.addEventListener('click', function() {
            modal.style.display = 'none'; 
            
            alertContainer.innerHTML = `
                <div class="alert-3d alert-error" id="alertBatal">
                    Stok produk batal diubah
                </div>
            `;
            
            setTimeout(() => {
                const alertBatal = document.getElementById('alertBatal');
                if(alertBatal) {
                    alertBatal.style.opacity = '0';
                    alertBatal.style.transition = 'opacity 0.5s';
                    setTimeout(() => alertBatal.remove(), 500); 
                }
            }, 3000);
        });
    }

    // Kalo tombol Ya IJO di dalem modal diklik
    if (btnYa) {
        btnYa.addEventListener('click', function() {
            form.submit(); 
        });
    }
});