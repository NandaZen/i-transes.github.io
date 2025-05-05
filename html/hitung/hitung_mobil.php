<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Emisi Karbon Kendaraan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/sidebar_pengguna.css">
    <link rel="stylesheet" href="../../css/hitung.css">

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
                <li class="nav-item"><a class="nav-link" href="../pengguna/pengguna.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="../hitung/hitung.php">Hitung Emisi</a></li>
                <li class="nav-item"><a class="nav-link" href="../simulasi/simulasi.php">Simulasi Perjalanan</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Rekomendasi</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../rekomendasi/rekomendasi_perjalanan.php">Rekomendasi Perjalanan</a></li>
                        <li><a class="dropdown-item" href="../rekomendasi/rekomendasi_kegiatan.php">Rekomendasi Kegiatan</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="../riwayat/riwayat.php">Riwayat</a></li>
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
        <li><a href="../pengguna/pengguna.php" class="nav-link">Beranda</a></li>
        <li><a href="../hitung/hitung.php" class="nav-link">Hitung Emisi</a></li>
        <li><a href="../simulasi/simulasi.php" class="nav-link">Simulasi Perjalanan</a></li>
        <li>
            <a href="javascript:void(0)" class="nav-link" onclick="toggleSidebarDropdown()">Rekomendasi <i class="fas fa-caret-down"></i></a>
            <ul id="sidebarDropdown" style="display: none; list-style: none; padding-left: 15px;">
                <li><a href="../rekomendasi/rekomendasi_perjalanan.php" class="nav-link">Rekomendasi Perjalanan</a></li>
                <li><a href="../rekomendasi/rekomendasi_kegiatan.php" class="nav-link">Rekomendasi Kegiatan</a></li>
            </ul>
        </li>
        <li><a href="../riwayat/riwayat.php" class="nav-link">Riwayat</a></li>
    </ul>
</div>


<div class="container">
    <div class="map-cont">
        <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
    </div>
    <button id="tombolSelesai" class="btn btn-danger">Selesaikan Perjalanan</button>
    <div class="hasil mt-3">
        <p id="status">Status: Memulai perjalanan...</p>
        <p id="result">Lokasi: -</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
<script src="../../js/sidebar_pengguna.js"></script>

<script>
let map;
let carMarker;
let tracking = false;
let watchId = null;
let startCoords = null;
let lastCoords = null;
let totalDistance = 0;
let routeCoordinates = [];
let routeLineAdded = false;

function haversineDistance(coords1, coords2) {
    const toRad = deg => deg * Math.PI / 180;
    const R = 6371; // km
    const dLat = toRad(coords2.latitude - coords1.latitude);
    const dLon = toRad(coords2.longitude - coords1.longitude);
    const lat1 = toRad(coords1.latitude);
    const lat2 = toRad(coords2.latitude);
    const a = Math.sin(dLat / 2) ** 2 + Math.cos(lat1) * Math.cos(lat2) * Math.sin(dLon / 2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

function updateRouteLine() {
    const geojson = {
        type: 'Feature',
        geometry: {
            type: 'LineString',
            coordinates: routeCoordinates
        }
    };

    if (!routeLineAdded && map.getSource('route') === undefined) {
        map.addSource('route', { type: 'geojson', data: geojson });

        map.addLayer({
            id: 'route',
            type: 'line',
            source: 'route',
            layout: {
                'line-join': 'round',
                'line-cap': 'round'
            },
            paint: {
                'line-color': '#ff7e00',
                'line-width': 4
            }
        });

        routeLineAdded = true;
    } else if (map.getSource('route')) {
        map.getSource('route').setData(geojson);
    }
}

function mulaiTrackingOtomatis() {
    if (!navigator.geolocation) {
        alert("Geolocation tidak didukung browser Anda.");
        return;
    }

    tracking = true;
    watchId = navigator.geolocation.watchPosition(position => {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        if (!startCoords) startCoords = { latitude: lat, longitude: lon };
        if (lastCoords) {
            const dist = haversineDistance(lastCoords, { latitude: lat, longitude: lon });
            totalDistance += dist;
        }
        lastCoords = { latitude: lat, longitude: lon };

        routeCoordinates.push([lon, lat]);
        updateRouteLine();

        map.flyTo({ center: [lon, lat], zoom: 16 });

        if (carMarker) {
            carMarker.setLngLat([lon, lat]);
        } else {
            carMarker = new maplibregl.Marker({ color: "red" }).setLngLat([lon, lat]).addTo(map);
        }

        document.getElementById('status').textContent = "Status: Perjalanan berlangsung...";
        document.getElementById('result').textContent = `Lokasi: ${lat.toFixed(5)}, ${lon.toFixed(5)}`;
    }, error => {
        document.getElementById('status').textContent = "Gagal melacak lokasi.";
    }, { enableHighAccuracy: true });
}

document.addEventListener("DOMContentLoaded", function () {
    map = new maplibregl.Map({
        container: 'map',
        style: 'https://api.maptiler.com/maps/streets-v2/style.json?key=nGgvCq7JSZO1z43vqQKv',
        center: [104.0305, 1.1064],
        zoom: 13,
        pitch: 85,
        bearing: -17.6,
        antialias: true,
        attributionControl: false
    });

    map.on('load', () => {
        mulaiTrackingOtomatis();
    });
});

document.getElementById('tombolSelesai').addEventListener('click', function () {
    if (!tracking || watchId === null) return alert("Perjalanan belum dimulai.");

    navigator.geolocation.clearWatch(watchId);
    tracking = false;

    const distance = totalDistance.toFixed(3);
    const emisiMobilPerKm = 0.110;
    const totalEmisi = (emisiMobilPerKm * totalDistance).toFixed(3);

    document.getElementById('status').textContent = "Status: Perjalanan selesai.";
    document.getElementById('result').textContent = `Jarak: ${distance} km | Emisi: ${totalEmisi} kg CO₂`;

    // Ubah warna rute menjadi hijau
    if (map.getLayer('route')) {
        map.setPaintProperty('route', 'line-color', '#008000');
        map.setPaintProperty('route', 'line-width', 5);
    }

    // Kirim data ke server
    fetch('simpan_perjalanan.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            kendaraan: 'Mobil',
            jarak: distance,
            emisi: totalEmisi
        })
    })
    .then(res => res.text())
    .then(res => console.log("Respon server:", res))
    .catch(err => console.error("Gagal kirim data:", err));
});
</script>

</body>
</html>