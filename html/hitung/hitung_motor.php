<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Emisi Karbon Kendaraan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/sidebar_pengguna.css">
    <link rel="stylesheet" href="../css/hitung.css">

    <!-- MapLibre CSS -->
    <link href="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container">
        <button class="navbar-toggler" type="button" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="pengguna/pengguna.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="hitung.php">Hitung Emisi</a></li>
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
        <button class="profile btn ms-2" id="profile" title="Profil">
            <i class="fas fa-user-circle fa-lg"></i>
        </button>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button class="close-btn" id="closeSidebar">&times;</button>
    <ul>
        <li><a href="pengguna/pengguna.php" class="nav-link">Beranda</a></li>
        <li><a href="hitung.php" class="nav-link">Hitung Emisi</a></li>
        <li><a href="simulasi.php" class="nav-link">Simulasi Perjalanan</a></li>
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


    <!-- Map -->
    <div class="map-cont">
        <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
    </div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
<script src="../js/sidebar_pengguna.js"></script>

<script>
// Variabel global
let map;
let carMarker;
let tracking = false;

// Inisialisasi Map
document.addEventListener("DOMContentLoaded", function () {
    map = new maplibregl.Map({
        container: 'map',
        style: 'https://api.maptiler.com/maps/streets-v2/style.json?key=nGgvCq7JSZO1z43vqQKv',
        center: [104.0305, 1.1064], // Batam
        zoom: 13,
        pitch: 85,
        bearing: -17.6,
        antialias: true,
        attributionControl: false
    });
});

// Fungsi untuk tracking
document.getElementById('btn-jalan').addEventListener('click', function() {
    const button = document.getElementById('btn-jalan');

    if (!tracking) {
        tracking = true;
        button.innerText = "Stop Perjalanan";
        button.classList.remove('btn-primary');
        button.classList.add('btn-danger');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                map.flyTo({ center: [lon, lat], zoom: 15 });

                if (carMarker) {
                    carMarker.remove();
                }

                carMarker = new maplibregl.Marker({ color: "red" })
                    .setLngLat([lon, lat])
                    .addTo(map);

                document.getElementById('status').textContent = 'Status: Perjalanan dimulai!';
                document.getElementById('result').textContent = 'Lokasi Anda: ' + lat.toFixed(5) + ', ' + lon.toFixed(5);
            }, function(error) {
                document.getElementById('status').textContent = 'Status: Gagal mendapatkan lokasi.';
            });
        } else {
            document.getElementById('status').textContent = 'Status: Geolocation tidak didukung.';
        }
    } else {
        tracking = false;
        button.innerText = "Mulai Perjalanan";
        button.classList.remove('btn-danger');
        button.classList.add('btn-primary');

        if (carMarker) {
            carMarker.remove();
            carMarker = null;
        }

        document.getElementById('status').textContent = 'Status: Perjalanan dihentikan.';
        document.getElementById('result').textContent = '-';
    }
});
</script>

</body>
</html>
