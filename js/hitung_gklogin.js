let map, asalMarker, tujuanMarker, asalLatLng, tujuanLatLng, router;
let trackingActive = false;
let watchId = null;
let totalDistance = 0;
let lastPosition = null;

const emisiPerKm = {
    mobil: 250,
    motor: 90,
    bus: 60,
    truk: 300
};

// Inisialisasi Map
map = L.map('map').setView([1.0903, 104.0248], 13);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

const bounds = L.latLngBounds([0.800, 103.700], [1.320, 104.400]);
map.setMaxBounds(bounds);

map.locate({ setView: true, maxZoom: 15 });
map.on('locationfound', function (e) {
    asalLatLng = e.latlng;
    asalMarker = L.marker(asalLatLng).addTo(map).bindPopup('Lokasi Anda (Asal)').openPopup();
});
map.on('locationerror', function () {
    alert("Gagal mendeteksi lokasi.");
});
const trackingButton = document.getElementById('trackingButton');

// Fungsi Mulai Perjalanan
function startTracking() {
    if (!trackingActive) {
        trackingActive = true;
        totalDistance = 0;
        lastPosition = null;
        document.getElementById('status').textContent = "Tracking dimulai...";

        watchId = navigator.geolocation.watchPosition(positionUpdate, positionError, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 10000
        });

        // Update tombol
        trackingButton.textContent = "Stop Perjalanan";
        trackingButton.style.backgroundColor = "#c61a09";
        trackingButton.onclick = stopTracking;
    }
}

// Fungsi Update Lokasi
function positionUpdate(position) {
    const { latitude, longitude } = position.coords;
    const currentLatLng = L.latLng(latitude, longitude);

    if (lastPosition) {
        const distance = currentLatLng.distanceTo(lastPosition);
        totalDistance += distance;
    }

    lastPosition = currentLatLng;
    map.panTo(currentLatLng);
}

// Fungsi Jika Gagal Tracking
function positionError(error) {
    console.error("Error saat tracking:", error.message);
}

// Fungsi Stop Tracking
function stopTracking() {
    if (trackingActive) {
        navigator.geolocation.clearWatch(watchId);
        trackingActive = false;

        const vehicleType = document.getElementById('vehicleType').value;
        const distanceInKm = totalDistance / 1000;
        const emisi = distanceInKm * (emisiPerKm[vehicleType] || 250);

        document.getElementById('result').innerHTML = `
            Total Jarak: ${distanceInKm.toFixed(2)} km<br>
            Estimasi Emisi: ${emisi.toFixed(2)} gram CO₂
        `;
        document.getElementById('status').textContent = "Tracking berhenti.";

        trackingButton.textContent = "Mulai Perjalanan";
        trackingButton.style.backgroundColor = "#28a745";
        trackingButton.onclick = startTracking;
    }
}