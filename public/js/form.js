document.getElementById('togglePassword').addEventListener('click', function (e) {
    const passwordInput = document.getElementById('password');
    const passwordType = passwordInput.getAttribute('type');

    if (passwordType === 'password') {
        passwordInput.setAttribute('type', 'text');
    } else {
        passwordInput.setAttribute('type', 'password');
    }

    this.querySelector('svg').classList.toggle('bi-eye');
    this.querySelector('svg').classList.toggle('bi-eye-slash');
});