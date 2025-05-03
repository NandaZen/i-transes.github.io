<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/firstpage.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" style="color: white;" href="#">I-TransEC</a>
            <button class="navbar-toggler" type="button" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
                <div class="d-none d-lg-flex ms-3">
                    <a href="html/masuk/masuk.php" class="btn btn-outline-light me-2">Masuk</a>
                    <a href="html/daftar/daftar.php" class="btn btn-danger">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="close-btn" id="closeSidebar">&times;</button>
        <ul>
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
        <hr>
        <a href="html/masuk/masuk.php" class="btn btn-outline-light w-50 mb-2">Masuk</a>
        <a href="html/daftar/daftar.php" class="btn btn-danger w-50">Daftar</a>
    </div>

    <!-- Beranda Section -->
    <section id="beranda" class="beranda section py-5">
        <div class="container-ber text-center">
            <h1 class="fw-bold">Ketahui jumlah emisi karbon yang dihasilkan dan temukan solusi untuk menguranginya!</h1>
            <div class="btn-wrapper">
                <a href="html/hitung/hitung_gklogin.php" class="btn custom-outline-btn">Hitung Emisi Karbon kamu Sekarang!</a>
            </div>
        </div>        
    </section>

    <!-- Tentang Section -->
    <section id="tentang" class="tentang section">
        <div class="container">
          <h2 class="fw-bold text-center mb-4">Tentang Kami</h2>
      
          <!-- Konten Tentang -->
          <div class="content-row">
            <div class="img-cont">
              <img src="img/I-TEC.png" alt="Logo I-TransEC" />
            </div>
            <div class="text-container">
              <p class="text-muted text-left">
                <i>Transport Carbon Calculator</i> adalah aplikasi yang membantu pengguna menghitung jejak karbon dari aktivitas transportasi mereka, 
                seperti perjalanan menggunakan mobil, motor, atau transportasi umum. Dengan hanya memasukkan data seperti jarak perjalanan, 
                moda transportasi, dan frekuensi penggunaan, aplikasi ini memberikan gambaran total emisi karbon yang dihasilkan. Di dalam 
                aplikasi ini akan tersimpan semua data emisi karbon yang dihasilkan dari transportasi. Kemudian hasil total dari emisi karbon 
                tersebut akan dikonversi menjadi kredit karbon (<i>Carbon Credit</i>), yang kemudian bisa dijual atau dibeli dalam bentuk mata uang. 
              </p>
            </div>
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

      
    <section id="dampak" class="dampak section">
        <div class="bg-dampak"></div>
        <div class="container">
            <h2 class="fw-bold"> Dampak baik dari mengurangi emisi karbon</h2>
        </div>
    
    <div class="carousel-container">
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <div class="carousel">
            <div class="car">
                <img src="img/tanam.png" />
                <p>Bumi menjadi hijau kembali</p>
            </div>
            <div class="car">
                <img src="img/tanam_4.svg" />
                <p>Polusi udara berkurang dan atmosfer Bumi membaik.</p>
            </div>
            <div class="car">
                <img src="img/air.svg" />
                <p>Kualitas dan sumber daya alam membaik.</p>
            </div>
            <div class="car">
                <img src="img/macet.png" />
                <p>Menggurangi Kemacetan</p>
            </div>
        </div>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>
    </section>

    <section id="Donasi" class="Donasi section">
    <div class="container">
        <h2 class="fw-bold text-left mb-2">Donasi</h2>
        <div class="row g-2 justify-content-center">
            <div class="col-xxl-2 col-lg-4 col-md-6">
                <div class="card p-3 text-center">
                        <h5 class="fw-bold">Donasi 1</h5>
                    <div class="img-container">
                        <img src="img/sponsor_1.jpg" class="img-1x1">
                    </div>
                        <p>Donasi</p>
                        <button class="btn btn-outline-light">Lihat</button>
                    </div>
                </div>
                <div class="col-xxl-2 col-lg-4 col-md-6">
                    <div class="card p-3 text-center">
                        <h5 class="fw-bold">Donasi 2</h5>
                         <div class="img-container">
                            <img src="img/sponsor_2.jpg" class="img-1x1">
                        </div>
                        <p>Donasi</p>
                        <button class="btn btn-outline-light">Lihat</button>
                    </div>
                </div>
                <div class="col-xxl-2 col-lg-4 col-md-6">
                    <div class="card p-3 text-center">
                        <h5 class="fw-bold">Donasi 3</h5>
                         <div class="img-container">
                            <img src="img/sponsor_3.jpg" class="img-1x1">
                        </div>
                        <p>Donasi</p>
                        <button class="btn btn-outline-light">Lihat</button>
                    </div>
                </div>
                <div class="col-xxl-2 col-lg-4 col-md-6">
                    <div class="card p-3 text-center">
                        <h5 class="fw-bold">Donasi 4</h5>
                        <div class="img-container">
                            <img src="img/sponsor_1.jpg" class="img-1x1">
                        </div>
                        <p>Donasi</p>
                        <button class="btn btn-outline-light">Lihat</button>
                    </div>
                </div>
                <div class="col-xxl-2 col-lg-4 col-md-6">
                    <div class="card p-3 text-center">
                        <h5 class="fw-bold">Donasi 5</h5>
                        <div class="img-container">
                            <img src="img/sponsor_1.jpg" class="img-1x1">
                        </div>
                        <p>Donasi</p>
                        <button class="btn btn-outline-light">Lihat</button>
                    </div>
                </div>
                <div class="col-xxl-2 col-lg-4 col-md-6">
                    <div class="card p-3 text-center">
                        <h5 class="fw-bold">Donasi 6</h5>
                        <div class="img-container">
                            <img src="img/sponsor_1.jpg" class="img-1x1">
                        </div>
                        <p>Donasi</p>
                        <button class="btn btn-outline-light">Lihat</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="kontak section">
        <div class="container text-left">
            <h2 class="fw-bold mb-4">Kontak Kami</h2>
            <p>Silakan hubungi kami melalui:</p>
            <a href="mailto:itransec@gmail.com"> <i class="fa fa-mail-bulk"></i></a>
            <a href="https://wa.me/6281234567890"><i class="fab fa-whatsapp"></i></a>
            <a href="https://www.instagram.com/itransec/"><i class="fab fa-instagram"></i></a>
            <a href="https:"></a>
            <hr>
            <div class="credit">
                <p>© 2025 PBL 202 | I-TransEC | Mahasiswa Teknologi Rekayasa Perangkat Lunak </p>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/firstpage.js"></script>
    <script src="js/sidebar.js"></script>
</body>
</html>
