// Password toggle
const passwordInput = document.getElementById('password');
const passwordToggle = document.getElementById('passwordToggle');
const eyeIcon = document.getElementById('eyeIcon');
const eyeOffIcon = document.getElementById('eyeOffIcon');

passwordToggle.addEventListener('click', () => {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    eyeIcon.style.display = isPassword ? 'none' : 'block';
    eyeOffIcon.style.display = isPassword ? 'block' : 'none';
});

// Form submit loading state
const loginForm = document.getElementById('loginForm');
const btnLogin = document.getElementById('btnLogin');

loginForm.addEventListener('submit', () => {
    btnLogin.classList.add('loading');
});

// Auto-dismiss error after 5 seconds
const alertError = document.getElementById('alert-error');
if (alertError) {
    setTimeout(() => {
        alertError.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        alertError.style.opacity = '0';
        alertError.style.transform = 'translateY(-10px)';
        setTimeout(() => alertError.remove(), 500);
    }, 5000);
}
