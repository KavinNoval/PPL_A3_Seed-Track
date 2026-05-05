document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const filterDropdown = document.getElementById('filterDropdown');
    const dataCards = document.querySelectorAll('.staff-card, .mitra-card, .kios-card');

    function jalankanSaringan() {
        const keyword = searchInput ? searchInput.value.toLowerCase() : '';
        const filterValue = filterDropdown ? filterDropdown.value.toLowerCase() : 'semua';

        dataCards.forEach(card => {
            const cardText = card.innerText.toLowerCase();

            //search
            const lolosSearch = cardText.includes(keyword);

            //Filter
            let lolosFilter = true;
            if (filterValue !== 'semua') {
                if (filterValue === 'aktif') {
                    // Filter khusus buat halaman Staf
                    lolosFilter = cardText.includes('aktif') && !cardText.includes('non aktif');
                } else if (filterValue === 'ada_nib') {
                    // ADA NIB
                    lolosFilter = !cardText.includes('nib : -');
                } else if (filterValue === 'tanpa_nib') {
                    //nib-
                    lolosFilter = cardText.includes('nib : -');
                } else {
                    // Filter(Admin lapang gudang)
                    lolosFilter = cardText.includes(filterValue);
                }
            }

            if (lolosSearch && lolosFilter) {
                card.style.display = ''; 
            } else {
                card.style.display = 'none'; 
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', jalankanSaringan);
    }
    
    if (filterDropdown) {
        filterDropdown.addEventListener('change', jalankanSaringan);
    }
});