<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simulasi Mobil di Batam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/rek_keg.css" rel="stylesheet">
  <script src="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
  <link href="https://unpkg.com/maplibre-gl@2.4.0/dist/maplibre-gl.css" rel="stylesheet" />
</head>
<body>

<div class="container text-center mt-4">
  <h1 class="mb-4">Simulasi Mobil di Batam 🚗</h1>
  <button id="startButton" class="btn btn-success mb-3">Mulai Perjalanan</button>
  <div id="map"></div>
</div>

<!-- <script src="../js/rek_keg.js"></script> https://api.maptiler.com/maps/01967180-fa5e-7297-9416-b21698bfa536/?key=nGgvCq7JSZO1z43vqQKv-->
<script>
    let map;

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
            }
        }
        displayUserLocation();
    });
</script>

</body>
</html>
