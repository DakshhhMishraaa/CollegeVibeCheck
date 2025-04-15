document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");

    form.addEventListener("submit", function (e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault(); //stop the form from submitting
            alert("Passwords do not match. Please re-enter!");
            confirmPassword.focus();
        }
    });
});

const passwordField = document.getElementById('password');
const togglePassword = document.getElementById('togglePassword');

togglePassword.addEventListener('click', function () {
    const isPassword = passwordField.type === 'password';
    passwordField.type = isPassword ? 'text' : 'password';
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
