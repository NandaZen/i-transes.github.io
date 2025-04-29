<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Emisi Karbon Kendaraan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/sidebar_pengguna.css">
    <link rel="stylesheet" href="../css/rek_per.css">
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

    
    <div class="map-tb">
        <iframe src="https://www.google.com/maps/d/embed?mid=1YsIbrT0lcckAWC0RlwUQtzhf2kw&ehbc=2E312F" width="640" height="480"></iframe>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sidebar_pengguna.js"></script>
</body>
</html>