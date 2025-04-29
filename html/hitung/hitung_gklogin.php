<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Emisi Karbon Kendaraan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/hitung_gklogin.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
</head>
<body>
    <section class="hitung">
        <h2 class="fw-bold text-center mt-3">Kalkulator Emisi Karbon Kendaraan</h2>
        <div class="map-cont">
            <div id="map" class="map"></div>
        </div>
        <div class="hitung" id="hitung">
            <div class="container-hitung">
                
                <label for="vehicleType">Pilih Jenis Kendaraan:</label>
                <select id="vehicleType" class="form-select mb-3">
                    <option value="mobil">Mobil</option>
                    <option value="motor">Motor</option>
                    <option value="bus">Bus</option>
                    <option value="truk">Truk</option>
                </select>
                
                <button class="btn-jalan" id="trackingButton" onclick="startTracking()">Mulai Perjalanan</button>
                
                <h3 class="mt-4">Hasil:</h3>
                <p id="result">-</p>
                <p id="status">Status: Menunggu untuk memulai perjalanan...</p>
            </div>
        </div>
    </section>

    <!-- Modal Login -->
    <div class="login-modal" id="loginModal">
        <form class="login-box" method="POST" action="../masuk/proses_masuk.php">
            <h2 class="text-center">Masuk Akun</h2>
            <div class="form-group">
                <label for="login_email">Email</label>
                <input type="email" class="form-control" id="login_email" name="email" required>
            </div>

            <div class="form-group">
                <label for="login_password">Kata Sandi</label>
                <input type="password" class="form-control" id="login_password" name="kata_sandi" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Masuk</button>
            <p class="text-center mt-2">
                <a href="#">Lupa Kata Sandi?</a> | <a href="../daftar/daftar.php">Daftar</a>
            </p>
        </form>
    </div>

    <!-- Modal Daftar -->
    <div class="login-modal" id="signupModal">
        <form class="login-box" method="POST" action="../daftar/daftar_akun.php">
            <h2 class="text-center">Daftar Akun</h2>
            <div class="form-group">
                <label for="signup_name">Nama Lengkap</label>
                <input type="text" class="form-control" id="signup_name" name="nama_lengkap" required>
            </div>

            <div class="form-group">
                <label for="signup_email">Email</label>
                <input type="email" class="form-control" id="signup_email" name="email" required>
            </div>

            <div class="form-group">
                <label for="signup_password">Kata Sandi</label>
                <input type="password" class="form-control" id="signup_password" name="kata_sandi" required>
            </div>

            <div class="form-group">
                <label for="signup_confirm_password">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" id="signup_confirm_password" name="konfirmasi_kata_sandi" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
            <p class="text-center mt-2">
                Sudah punya akun? <a href="../masuk/masuk.php">Masuk</a>
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="../../js/hitung_gklogin.js"></script>
</body>
</html>
