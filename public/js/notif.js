document.addEventListener("DOMContentLoaded", function() {
    let semuaPesan = document.querySelectorAll('.pesan-otomatis');
    
    semuaPesan.forEach(function(pesan) {
        setTimeout(function() {
            pesan.style.transition = "opacity 0.5s ease";
            pesan.style.opacity = "0";
            
            setTimeout(function() {
                pesan.style.display = "none";
            }, 500);
        }, 3000); 
    });
});