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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Emisi Karbon Kendaraan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/sidebar_pengguna.css">
    <link rel="stylesheet" href="../../css/rek_per.css">
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
                <li class="nav-item"><a class="nav-link" href="../pengguna/pengguna.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="../hitung/hitung.php">Hitung Emisi</a></li>
                <li class="nav-item"><a class="nav-link" href="../simulasi/simulasi.php">Simulasi Perjalanan</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Rekomendasi</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="rekomendasi_perjalanan.php">Rekomendasi Perjalanan</a></li>
                        <li><a class="dropdown-item" href="rekomendasi_kegiatan.php">Rekomendasi Kegiatan</a></li>
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

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button class="close-btn" id="closeSidebar">&times;</button>
    <ul>
        <li><a href="./pengguna/pengguna.php" class="nav-link">Beranda</a></li>
        <li><a href="../hitung/hitung.php" class="nav-link">Hitung Emisi</a></li>
        <li><a href="../simulasi/simulasi.php" class="nav-link">Simulasi Perjalanan</a></li>
        <li>
            <a href="javascript:void(0)" class="nav-link" onclick="toggleSidebarDropdown()">Rekomendasi <i class="fas fa-caret-down"></i></a>
            <ul id="sidebarDropdown" style="display: none; list-style: none; padding-left: 15px;">
                <li><a href="rekomendasi_perjalanan.php" class="nav-link">Rekomendasi Perjalanan</a></li>
                <li><a href="rekomendasi_kegiatan.php" class="nav-link">Rekomendasi Kegiatan</a></li>
            </ul>
        </li>
        <li><a href="../riwayat/riwayat.php" class="nav-link">Riwayat</a></li>
    </ul>
</div>

          
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.16/dist/sweetalert2.all.min.js"></script>
<script src="../../js/sidebar_pengguna.js"></script>
<script>
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
</body>
</html>