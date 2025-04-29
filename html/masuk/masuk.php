<?php
session_start();
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login I-TransEC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="login-container">
        <form class="login-box" method="POST" action="proses_masuk.php">
            <h2 class="text-center">Masuk Akun</h2>
            
            <div class="form-row">
                <div class="form-column">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                    </div>

                    <div class="form-group">
                        <label for="kata_sandi">Kata Sandi</label>
                        <input type="password" class="form-control" id="kata_sandi" name="kata_sandi" placeholder="Masukkan kata sandi">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Masuk</button>
                    <p class="text-center mt-2">
                        <a href="#">Lupa Kata Sandi?</a> | <a href="../daftar/daftar.php">Daftar</a>
                    </p>
                </div>

                <div class="form-column">
                    <div class="image-container">
                        <img src="../../img/human.jpg" alt="Human Image">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php if (!empty($error_message)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo $error_message; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
if (result.isConfirmed) {
window.location.href = "masuk.php";
}
});
    </script>
    <?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
