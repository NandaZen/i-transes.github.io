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
    <title>Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/pengguna.css">
    <link rel="stylesheet" href="../../css/sidebar_pengguna.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
  <div class="container">
      <button class="navbar-toggler" type="button" id="toggleSidebar">
          <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse justify-content-end">
          <ul class="navbar-nav me-auto">
              <li class="nav-item"><a class="nav-link" href="pengguna.php">Beranda</a></li>
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

<div class="sidebar" id="sidebar">
  <button class="close-btn" id="closeSidebar">&times;</button>
  <ul>
      <li><a href="pengguna.php" class="nav-link">Beranda</a></li>
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
    <section id="beranda" class="beranda">
        <div class="container-ber text-center">
        <h1 class="fw-bold">
          Selamat Datang,
          <span class="text-danger me-2 fw-bold">
            <?= htmlspecialchars($_SESSION['nama'] ?? 'Pengguna'); ?>!
          </span>
        </h1>
          <p class="lead">Aplikasi untuk menghitung emisi karbon kendaraan</p>
          <a href="../hitung/hitung.php" class="btn me-2" style="background-color: rgb(21, 61, 17); color: white; ">Hitung</a>
        </div>
    </section>

    <section id="grafik" class="grafik">
        <div class="grafik">
          <h2 class="fw-bold">Grafik Perjalanan!</h2>

          <div class="filter-container mb-4">
            <label for="tanggalAwal" class="fw-semibold">Tanggal Awal:</label>
            <input type="date" id="tanggalAwal" class="form-control d-inline-block me-2" style="max-width: 200px;">

            <label for="tanggalAkhir" class="fw-semibold">Tanggal Akhir:</label>
            <input type="date" id="tanggalAkhir" class="form-control d-inline-block me-2" style="max-width: 200px;">

            <button id="terapkanFilter" class="btn btn-success">Terapkan</button>
          </div>

          <div class="kontainer-grafik">
            <canvas id="myChart" style="width:100%;max-width:900px"></canvas>
          </div>
        </div>
      </section>
      
      <section id="berita" class="berita-section py-5">
        <div class="container">
          <h3 class="section-title text-center mb-5 fw-bold">Berita Terkini!</h3>
          <div class="berita-grid">

            <div class="berita-card">
              <img src="../../img/sponsor_2.jpg" alt="Berita 1" class="berita-img">
              <div class="berita-text">
                <h5 class="fw-bold">Berita 1</h5>
                <p>Ini adalah isi singkat berita pertama yang menarik untuk dibaca.</p>
                <button class="btn btn-outline-primary">Lihat</button>
              </div>
            </div>

            <div class="berita-card">
              <img src="../../img/sponsor_2.jpg" alt="Berita 2" class="berita-img">
              <div class="berita-text">
                <h5 class="fw-bold">Berita 2</h5>
                <p>Ini adalah isi singkat berita kedua yang informatif dan terbaru.</p>
                <button class="btn btn-outline-primary">Lihat</button>
              </div>
            </div>

            <div class="berita-card">
              <img src="../../img/I-TEC.png" alt="Berita 3" class="berita-img">
              <div class="berita-text">
                <h5 class="fw-bold">Berita 3</h5>
                <p>Isi singkat berita ketiga, dengan informasi terkini yang bermanfaat.</p>
                <button class="btn btn-outline-primary">Lihat</button>
              </div>
            </div>

          </div>
        </div>
      </section>
      
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.all.min.js"></script>

<script>
const ctx = document.getElementById("myChart").getContext("2d");

let chart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: [],
    datasets: [{
      backgroundColor: [],
      data: []
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      title: {
        display: true,
        text: "Emisi Karbon"
      }
    }
  }
});

document.getElementById("terapkanFilter").addEventListener("click", function () {
  const start = document.getElementById("tanggalAwal").value;
  const end = document.getElementById("tanggalAkhir").value;
  if (start && end) {
    ambilData(start, end);
  } else {
    alert("Mohon pilih tanggal awal dan akhir.");
  }
});

function ambilData(tglAwal, tglAkhir) {
  fetch(`grafik.php?tanggal_awal=${tglAwal}&tanggal_akhir=${tglAkhir}`)
    .then(res => res.json())
    .then(data => {
      const labels = data.map(item => item.tanggal);
      const emisi = data.map(item => item.emisi);
      const warna = data.map(() => getRandomColor());

      chart.data.labels = labels;
      chart.data.datasets[0].data = emisi;
      chart.data.datasets[0].backgroundColor = warna;
      chart.update();
    });
}

function getRandomColor() {
  const colors = ["#f94144", "#f3722c", "#f9c74f", "#90be6d", "#43aa8b", "#577590"];
  return colors[Math.floor(Math.random() * colors.length)];
}

window.onload = function () {
  const now = new Date();
  const akhir = now.toISOString().split("T")[0];

  const awalDate = new Date();
  awalDate.setDate(now.getDate() - 6);
  const awal = awalDate.toISOString().split("T")[0];

  document.getElementById("tanggalAwal").value = awal;
  document.getElementById("tanggalAkhir").value = akhir;

  ambilData(awal, akhir);
};

setTimeout(function() {
    var alertNode = document.querySelector('.alert');
    if (alertNode) {
      var alertInstance = bootstrap.Alert.getOrCreateInstance(alertNode);
      alertInstance.close();
    }
  }, 3000);
document.getElementById("logoutButton").addEventListener("click", function (e) {
e.preventDefault();
Swal.fire({
  title: 'keluar dari Akun',
  html: `
    <p>Apakah anda yakin akan keluar?</p>
    <img src="../../img/human.jpg" width="300" height="150" style="margin-top: 20px; border-radius:10px;">
  `,
  background: '#256020',
  color: '#fff',
  showDenyButton: true,
  denyButtonText: 'Yakin banget!',
  confirmButtonText: 'Enggak jadi deh..',
  reverseButtons: true,
  draggable: true,
  confirmButtonColor: "#b4b4b4"
}).then((result) => {
  if (result.isDenied) {
    window.location.href = "../masuk/proses_keluar.php";
  }
});
});

</script>
      
      <script src="../../js/pengguna.js"></script>
      <script src="../../js/sidebar_pengguna.js"></script>      
</body>
</html>
