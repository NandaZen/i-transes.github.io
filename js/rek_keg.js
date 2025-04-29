// Inisialisasi Peta
const map = new maplibregl.Map({
    container: 'map',
    style: 'https://api.maptiler.com/maps/streets-v2/style.json?key=YOUR_API_KEY', // GANTI dengan API key kamu
    center: [104.0305, 1.1064], // Batam
    zoom: 13,
    pitch: 60, // Biar keliatan 3D
    bearing: -17.6,
    antialias: true
});

// Siapkan rute (koordinat)
const route = [
    [104.0305, 1.1064],
    [104.0330, 1.1080],
    [104.0355, 1.1100],
    [104.0380, 1.1130],
    [104.0405, 1.1155]
];

// Buat Marker Mobil
const car = new maplibregl.Marker({ color: "red" })
    .setLngLat(route[0])
    .addTo(map);

// Fungsi untuk menggerakkan mobil
let counter = 0;
function moveCar() {
    if (counter < route.length) {
        car.setLngLat(route[counter]);
        counter++;
        setTimeout(moveCar, 1000); // Ubah delay di sini (ms) buat atur kecepatan
    }
}

// Tombol Mulai
document.getElementById('startButton').addEventListener('click', function() {
    counter = 0;
    moveCar();
});
