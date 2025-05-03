<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Simulasi Emisi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/hitung_gklogin.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
</head>
<body class="pt-5">
<nav style="
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: #256020;
  padding: 6px 12px;
  z-index: 1100;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  backdrop-filter: blur(6px);
">
  <button id="btnBack" style="
    font-size: 22px;
    color: white;
    background: none;
    border: none;
    cursor: pointer;
  " title="Kembali">&#10005;</button>
</nav>


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
          <th>Emisi (garam CO₂)</th>
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
  <script>
    let map, asalMarker, tujuanMarker, asalLatLng, tujuanLatLng, router;
    const emisiPerKm = {
      Mobil: 0.110,
      Motor: 0.046,
      "Mobil Hybrid": 0.026,
      Busway: 0.088
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
            const totalEmisiKg = jarakKm * emisi;
            tbody.innerHTML += `
            <tr>
                <td>${kendaraan}</td>
                <td>${jarakKm.toFixed(2)}</td>
                <td>${totalEmisiKg.toFixed(2)} g</td>
            </tr>
            `;
        }
        }


document.getElementById("btnBack").addEventListener("click", function () {
  window.history.back();
});

</script>
</body>
</html>