document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const sidebar = document.getElementById("sidebar");
    const openBtn = document.getElementById("toggleSidebar");
    const closeBtn = document.getElementById("closeSidebar");

    // Navbar scroll effect
    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });

    // Buka Sidebar
    openBtn.addEventListener("click", function () {
        sidebar.classList.add("open");
    });

    // Tutup Sidebar
    closeBtn.addEventListener("click", function () {
        sidebar.classList.remove("open");
    });

    // Tutup sidebar saat klik di luar
    document.addEventListener("click", function (event) {
        if (!sidebar.contains(event.target) && !openBtn.contains(event.target)) {
            sidebar.classList.remove("open");
        }
    });
});

// Toggle Sidebar
document.getElementById('toggleSidebar').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('open');
});

// Close Sidebar
document.getElementById('closeSidebar').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('open');
});
// Ambil elemen sidebar dan tombol toggle
const sidebar = document.getElementById('sidebar');
const toggleSidebar = document.getElementById('toggleSidebar');

// Fungsi untuk menutup sidebar jika lebar layar kecil
function handleResize() {
    if (window.innerWidth < 768) {  // Untuk layar kecil, seperti mobile
        sidebar.classList.remove('open');  // Menutup sidebar
    }
}

// Tambahkan event listener untuk resize (perubahan ukuran layar)
window.addEventListener('resize', handleResize);

// Fungsi untuk toggle sidebar
toggleSidebar.addEventListener('click', function() {
    sidebar.classList.toggle('open');  // Menampilkan atau menyembunyikan sidebar
});

// Pastikan sidebar tertutup ketika pertama kali dimuat di layar kecil
handleResize();
