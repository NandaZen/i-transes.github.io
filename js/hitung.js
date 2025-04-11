
let startCoords = null;
let watchID = null;

function updateFuelOptions() {
    let vehicleType = document.getElementById('vehicleType').value;
    let fuelType = document.getElementById('fuelType');
    
    fuelType.innerHTML = "";
    
    if (vehicleType === "mobil" || vehicleType === "motor") {
        fuelType.innerHTML += '<option value="2.3">Bensin</option>';
        fuelType.innerHTML += '<option value="1.9">LPG</option>';
    } else if (vehicleType === "bus" || vehicleType === "truk") {
        fuelType.innerHTML += '<option value="2.7">Diesel</option>';
    }
}

function startTracking() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            startCoords = position.coords;
            watchID = navigator.geolocation.watchPosition(updateDistance);
        }, error => {
            alert("Gagal mendapatkan lokasi: " + error.message);
        });
    } else {
        alert("Geolocation tidak didukung di browser ini.");
    }
}

function updateDistance(position) {
    if (startCoords) {
        let lat1 = startCoords.latitude;
        let lon1 = startCoords.longitude;
        let lat2 = position.coords.latitude;
        let lon2 = position.coords.longitude;

        let distance = haversineDistance(lat1, lon1, lat2, lon2);
        calculateEmissions(distance);
    }
}

function haversineDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

function calculateEmissions(distance) {
    let fuelEmissionFactor = parseFloat(document.getElementById('fuelType').value);
    let transmissionType = document.getElementById('transmissionType').value;
    
    let transmissionFactor = transmissionType === "hybrid" ? 0.8 : 1.0;
    let emissions = fuelEmissionFactor * distance * transmissionFactor;
    document.getElementById('result').innerText = `Emisi Karbon: ${emissions.toFixed(2)} kg CO₂`;
}