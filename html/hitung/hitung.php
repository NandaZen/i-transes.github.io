<?php
session_start();
require_once '../../koneksi.php';

$success_message = '';
$error_message = '';

if (isset($_SESSION['login_success'])) {
    $success_message = $_SESSION['login_success'];
    unset($_SESSION['login_success']);
}

if (!isset($_SESSION['peran']) || !in_array($_SESSION['peran'], ['pengguna'])) {
    $_SESSION['login_error'] = 'Anda tidak memiliki akses ke halaman ini.';
    header("Location: ../masuk/masuk.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Hitung Emisi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css" rel="stylesheet" />
    <script src="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
    <link rel="stylesheet" href="../../css/sidebar_pengguna.css">
    <link rel="stylesheet" href="../../css/hitung_utama.css">

</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
  <div class="container">
      <!-- Toggle Sidebar Button -->
      <button class="navbar-toggler" type="button" id="toggleSidebar">
          <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse justify-content-end">
          <ul class="navbar-nav me-auto">
              <li class="nav-item"><a class="nav-link" href="../pengguna/pengguna.php">Beranda</a></li>
              <li class="nav-item"><a class="nav-link" href="hitung.php">Hitung Emisi</a></li>
              <li class="nav-item"><a class="nav-link" href="../simulasi/simulasi.php">Simulasi Perjalanan</a></li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                      data-bs-toggle="dropdown" aria-expanded="false">Rekomendasi</a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="rekomendasi_perjalanan.php">Rekomendasi Perjalanan</a></li>
                      <li><a class="dropdown-item" href="rekomendasi_kegiatan.php">Rekomendasi Kegiatan</a></li>
                  </ul>
              </li>
              <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
          </ul>
      </div>
      <div class="dropdown d-flex align-items-center">
      <?php if (isset($_SESSION['nama'])): ?>
        <span class="text-white me-2 fw-semibold"><?php echo $_SESSION['nama']; ?></span>
      <?php endif; ?>
        <button class="btn profile ms-2 dropdown-toggle" id="profile" title="Profil" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle fa-lg"></i>
        </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
            <li><a class="dropdown-item" href="../kelola/kelola_akun.php">Kelola Akun</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><button class="dropdown-item" id="logoutButton">Keluar</button></li>
          </ul>
      </div>
  </div>
</nav>

<div class="container mt-3">
  <?php if (!empty($success_message)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $success_message; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $error_message; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <button class="close-btn" id="closeSidebar">&times;</button>
  <ul>
      <li><a href="../pengguna/pengguna.php" class="nav-link">Beranda</a></li>
      <li><a href="hitung.php" class="nav-link">Hitung Emisi</a></li>
      <li><a href="../simulasi/simulasi.php" class="nav-link">Simulasi Perjalanan</a></li>
      <li>
          <a href="javascript:void(0)" class="nav-link" onclick="toggleSidebarDropdown()">Rekomendasi <i class="fas fa-caret-down"></i></a>
          <ul id="sidebarDropdown" style="display: none; list-style: none; padding-left: 15px;">
              <li><a href="rekomendasi_perjalanan.php" class="nav-link">Rekomendasi Perjalanan</a></li>
              <li><a href="rekomendasi_kegiatan.php" class="nav-link">Rekomendasi Kegiatan</a></li>
          </ul>
      </li>
      <li><a href="riwayat.php" class="nav-link">Riwayat</a></li>
  </ul>
</div>

<div class="chart">
    <div></div>
</div>

<div class="map-cont">
    <div class="map">
        <div id="map" style="border-radius: 25px; border: black 1px solid;"></div>
    </div>
</div>

<section class="kendaraan">
    <div class="pilih-kendaraan">
        <div class="mobil">
            <img src="../../img/mobil.png">
        </div>
        <div class="motor">
            <img src="../../img/motor.png">
        </div>
    </div>
</section>

<button id="tombolPilih" class="btn btn-success"></button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.all.min.js"></script>
<script src="../../js/sidebar_pengguna.js"></script>

<script>
    let map;
    const mobil = document.querySelector('.mobil');
    const motor = document.querySelector('.motor');
    const tombol = document.getElementById('tombolPilih');
    
document.addEventListener("DOMContentLoaded", function() {
    map = new maplibregl.Map({
        container: 'map',
        style: 'https://api.maptiler.com/maps/streets-v2/style.json?key=nGgvCq7JSZO1z43vqQKv',
        center: [104.0305, 1.0964],
        zoom: 13,
        pitch: 60, 
        bearing: -17.6,
        antialias: true,
        attributionControl: false
    });

    function displayUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;

                map.flyTo({ center: [lon, lat], zoom: 18 });

                new maplibregl.Marker({ color: "red" })
                    .setLngLat([lon, lat])
                    .addTo(map);

            }, function(error) {
                console.error("Geolocation error: " + error.message);
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        } else {
            console.error('Geolocation tidak didukung.');
            tombol.disabled = false;
            tombol.innerText = "Lokasi Tidak Tersedia";
        }
        tombol.disabled = true;
        tombol.innerText = "Pilih Kendaraan";

        mobil.addEventListener('click', function () {
            tombol.disabled = false;
            tombol.innerText = "Mulai Hitung Emisi 🚗";
            tombol.onclick = function () {
                window.location.href = "hitung_mobil.php";
            };
        });

        motor.addEventListener('click', function () {
            tombol.disabled = false;
            tombol.innerText = "Mulai Hitung Emisi 🏍️";
            tombol.onclick = function () {
                window.location.href = "hitung_motor.php";
            };
        });
    }
    displayUserLocation();
});
const logoutButton = document.getElementById('logoutButton');

logoutButton.addEventListener('click', function() {
Swal.fire({
  title: 'Yakin mau keluar?',
  text: "Anda akan logout dari aplikasi.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Ya, keluar!',
  cancelButtonText: 'Tidak, batalkan',
  reverseButtons: true,
  confirmButtonColor: '#d33'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = "../masuk/proses_keluar.php";
  }
});
});
</script>

</body>
</html>
