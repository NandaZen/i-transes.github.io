document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Mencegah form dikirim langsung

    let isValid = true;

    // Ambil nilai input
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let confirmPassword = document.getElementById("confirmPassword").value.trim();

    // Reset error message
    document.querySelectorAll(".error-message").forEach(el => el.style.display = "none");

    // Validasi Nama
    if (name === "") {
        document.getElementById("nameError").textContent = "Nama tidak boleh kosong!";
        document.getElementById("nameError").style.display = "block";
        isValid = false;
    }

    // Validasi Email
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        document.getElementById("emailError").textContent = "Format email tidak valid!";
        document.getElementById("emailError").style.display = "block";
        isValid = false;
    }

    // Validasi Password (minimal 6 karakter)
    if (password.length < 6) {
        document.getElementById("passwordError").textContent = "Kata Sandi minimal 6 karakter!";
        document.getElementById("passwordError").style.display = "block";
        isValid = false;
    }

    let passwordPattern = /[^A-Za-z0-9]/;
    if (!passwordPattern.test(password)) {
        document.getElementById("passwordError").textContent = "Kata Sandi harus mengandung 1 huruf kapital dan 1 angka";
        document.getElementById("passwordError").style.display = "block";
        isValid = false;
    }

    // Validasi Konfirmasi Password
    if (password !== confirmPassword) {
        document.getElementById("confirmPasswordError").textContent = "Kata Sandi tidak cocok!";
        document.getElementById("confirmPasswordError").style.display = "block";
        isValid = false;
    }

    // Jika semua valid, simpan ke database atau tampilkan pesan sukses
    if (isValid) {
        alert("Pendaftaran berhasil!");
        document.getElementById("signupForm").reset(); // Reset form setelah sukses
    }
});
