<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hidden Wonders</title>
  <link rel="stylesheet" href="../css/tes.css" />
</head>
<body>

  <header class="navbar">
    <div class="logo">Logo</div>
    <button class="menu-toggle" id="menuToggle">&#9776;</button>
    <nav class="menu" id="mainMenu">
      <a href="#">Destinations</a>
      <a href="#">Stories</a>
      <a href="#">Tips</a>
      <a href="#">Contact</a>
    </nav>
    <button class="signin">Sign In</button>
  </header>

  <aside class="sidebar" id="sidebar">
    <button class="close-btn" id="closeSidebar">&times;</button>
    <nav class="sidebar-nav">
      <a href="#">Destinations</a>
      <a href="#">Stories</a>
      <a href="#">Tips</a>
      <a href="#">Contact</a>
      <a href="#">Sign In</a>
    </nav>
  </aside>

  <main class="content">
    <section class="hero">
      <h1>Discover the World's <span>Hidden</span> Wonders</h1>
      <p>Find the unique moments and hidden gems that ignite unforgettable experiences...</p>
      <button>Plan your trip</button>
      <div class="hero-images">
        <div class="img-box large"><img src="../img/background.jpg" alt=""></div>
        <div class="img-box"><img src="../img/background.jpg" alt=""></div>
        <div class="img-box"><img src="../img/background.jpg" alt=""></div>
      </div>
    </section>

    <section class="top-destinations">
      <h2>Top Destinations</h2>
      <div class="destinations-grid">
        <div class="card">Golden Bridge, Vietnam</div>
        <div class="card">Dubrovnik, Croatia</div>
        <div class="card">Cappadocia, Turkey</div>
      </div>
    </section>

    <section class="latest-stories">
      <h2>Latest Stories</h2>
      <div class="stories-list">
        <div class="story main-story"></div>
        <div class="story"></div>
        <div class="story"></div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <p>© 2025 Hidden Wonders. All rights reserved.</p>
  </footer>

  <script src="../js/tes.js"></script>
</body>
</html>
