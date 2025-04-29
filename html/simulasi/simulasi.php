<?php

session_start();
require_once '../../koneksi.php';

if (!isset($_SESSION['peran']) || !in_array($_SESSION['peran'], ['pengguna'])) {
    $_SESSION['login_error'] = 'Anda tidak memiliki akses ke halaman ini.';
    header("Location: ../masuk/masuk.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Simulasi Emisi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/sidebar_pengguna.css">
  <link rel="stylesheet" href="../../css/simulasi.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
</head>
<body class="pt-5">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
  <div class="container">
      <!-- Toggle Sidebar Button -->
      <button class="navbar-toggler" type="button" id="toggleSidebar">
          <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse justify-content-end">
          <ul class="navbar-nav me-auto">
              <li class="nav-item"><a class="nav-link" href="pengguna/pengguna.php">Beranda</a></li>
              <li class="nav-item"><a class="nav-link" href="../hitung/hitung.php">Hitung Emisi</a></li>
              <li class="nav-item"><a class="nav-link" href="simulasi.php">Simulasi Perjalanan</a></li>
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

<div class="container">
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
      <li><a href="pengguna/pengguna.php" class="nav-link">Beranda</a></li>
      <li><a href="../hitung/hitung.php" class="nav-link">Hitung Emisi</a></li>
      <li><a href="simulasi.php" class="nav-link">Simulasi Perjalanan</a></li>
      <li>
          <a href="javascript:void(0)" class="nav-link" onclick="toggleSidebarDropdown()">Rekomendasi <i class="fas fa-caret-down"></i></a>
          <ul id="sidebarDropdown" style="display: none; list-style: none; padding-left: 15px;">
              <li><a href="../rekomendasi_perjalanan.php" class="nav-link">Rekomendasi Perjalanan</a></li>
              <li><a href="../rekomendasi_kegiatan.php" class="nav-link">Rekomendasi Kegiatan</a></li>
          </ul>
      </li>
      <li><a href="riwayat.php" class="nav-link">Riwayat</a></li>
  </ul>
</div>
    

  <!-- Peta -->
  <div id="map"></div>

  <!-- Tombol Pilih Lokasi -->
  <div class="lokasi-control">
    <button id="btnAsal"><i class="fas fa-location-arrow me-1"></i> Lokasi Asal</button>
    <button id="btnTujuan"><i class="fas fa-map-marker-alt me-1"></i> Lokasi Tujuan</button>
  </div>

  <!-- Hasil -->
  <div class="result-box">
    <h5 class="text-center mb-2">Perkiraan Emisi Karbon</h5>
    <table class="table table-bordered text-center">
      <thead class="table-dark">
        <tr>
          <th>Kendaraan</th>
          <th>Jarak (km)</th>
          <th>Emisi (gram CO₂)</th>
        </tr>
      </thead>
      <tbody id="tabel-emisi"></tbody>
    </table>
    
  </div>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.all.min.js"></script>
  <script src="../../js/sidebar_pengguna.js"></script>
  <script>
    let map, asalMarker, tujuanMarker, asalLatLng, tujuanLatLng, router;
    const emisiPerKm = {
      Mobil: 250,
      Motor: 90,
      "Mobil Hybrid": 120,
      Busway: 60
    };
    let modePilih = null;

    map = L.map('map').setView([1.0902852345908899, 104.02480998542111], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attributionControl: false
    }).addTo(map);

    const bounds = L.latLngBounds(
      [0.800, 103.700],
      [1.320, 104.400]
    );
    map.setMaxBounds(bounds);

    map.locate({ setView: true, maxZoom: 15 });
    map.on('locationfound', function (e) {
      asalLatLng = e.latlng;
      asalMarker = L.marker(asalLatLng).addTo(map).bindPopup('Lokasi Anda (Asal)').openPopup();
    });

    map.on('locationerror', function () {
      alert("Gagal mendeteksi lokasi.");
    });

    document.getElementById("btnAsal").addEventListener("click", () => {
      modePilih = 'asal';
      toggleActive('btnAsal');
    });

    document.getElementById("btnTujuan").addEventListener("click", () => {
      modePilih = 'tujuan';
      toggleActive('btnTujuan');
    });

    function toggleActive(id) {
      document.getElementById("btnAsal").classList.remove("active");
      document.getElementById("btnTujuan").classList.remove("active");
      if (id) document.getElementById(id).classList.add("active");
    }

    map.on('click', function (e) {
      if (!bounds.contains(e.latlng)) {
        alert("Pilih lokasi hanya di wilayah Batam.");
        return;
      }

      if (modePilih === 'asal') {
        if (asalMarker) map.removeLayer(asalMarker);
        asalLatLng = e.latlng;
        asalMarker = L.marker(asalLatLng).addTo(map).bindPopup("Lokasi Asal").openPopup();
      } else if (modePilih === 'tujuan') {
        if (tujuanMarker) map.removeLayer(tujuanMarker);
        tujuanLatLng = e.latlng;
        tujuanMarker = L.marker(tujuanLatLng).addTo(map).bindPopup("Lokasi Tujuan").openPopup();
      }

      toggleActive();
      modePilih = null;

      if (asalLatLng && tujuanLatLng) {
        if (router) map.removeControl(router);
        router = L.Routing.control({
          waypoints: [asalLatLng, tujuanLatLng],
          lineOptions: { styles: [{ color: 'blue', weight: 5 }] },
          routeWhileDragging: false,
          createMarker: () => null
        }).addTo(map);

        router.on('routesfound', function(e) {
          const jarakKm = e.routes[0].summary.totalDistance / 1000;
          tampilkanEmisi(jarakKm);
        });
      }
    });

    function tampilkanEmisi(jarakKm) {
      const tbody = document.getElementById("tabel-emisi");
      tbody.innerHTML = "";
      for (const [kendaraan, emisi] of Object.entries(emisiPerKm)) {
        const totalEmisi = jarakKm * emisi;
        tbody.innerHTML += `
          <tr>
            <td>${kendaraan}</td>
            <td>${jarakKm.toFixed(2)}</td>
            <td>${totalEmisi.toFixed(0)}</td>
          </tr>
        `;
      }
    }
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