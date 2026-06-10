document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.querySelector('.search-input');
    const tableRows = document.querySelectorAll('.data-row');
    const noDataMessage = document.getElementById('noDataMessage');

    // Fungsi utama buat nyaring
    function jalankanSaringan() {
        const keyword = searchInput.value.toLowerCase();
        let adaYangSama = false;

        tableRows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            // Cek cocok apa kaga
            if (rowText.includes(keyword)) {
                row.style.display = '';
                adaYangSama = true;
            } else {
                row.style.display = 'none';
            }
        });

        // Tunjukin pesan kalau kaga ada yang cocok
        if (noDataMessage) {
            if (!adaYangSama && tableRows.length > 0) {
                noDataMessage.style.display = 'block';
            } else {
                noDataMessage.style.display = 'none';
            }
        }
    }

    // Pasang "CCTV" ke input search, panggil fungsi tiap kali ngetik
    if (searchInput) {
        searchInput.addEventListener('input', jalankanSaringan);
    }


    const alerts = document.querySelectorAll('.alert-3d');

    alerts.forEach(alert => {
        // Tunggu 3.5 detik, abis itu tiup notifnya
        setTimeout(() => {
            alert.style.transition = "0.8s ease";
            alert.style.opacity = "0";
            alert.style.transform = "translateX(50px)"; // Efek geser ke kanan dikit pas ngilang

            // Hapus elemen dari HTML abis animasinya kelar (0.8 detik kemudian)
            setTimeout(() => alert.remove(), 800);
        }, 3500);
    });
});
