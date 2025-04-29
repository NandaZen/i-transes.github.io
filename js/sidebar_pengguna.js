document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const sidebar = document.getElementById("sidebar");
    const toggleSidebar = document.getElementById("toggleSidebar");
    const closeBtn = document.getElementById("closeSidebar");
    const sidebarDropdown = document.getElementById("sidebarDropdown");

    // 1. Tambah efek scroll di navbar
    window.addEventListener("scroll", function () {
        navbar.classList.toggle("scrolled", window.scrollY > 50);
    });

    // 2. Toggle sidebar buka/tutup
    toggleSidebar?.addEventListener("click", () => {
        sidebar.classList.toggle("open");
    });

    closeBtn?.addEventListener("click", () => {
        sidebar.classList.remove("open");
    });

    // 3. Tutup sidebar kalau klik di luar area
    document.addEventListener("click", function (event) {
        if (!sidebar.contains(event.target) && !toggleSidebar.contains(event.target)) {
            sidebar.classList.remove("open");
        }
    });

    // 4. Auto tutup sidebar saat resize ke mobile
    window.addEventListener("resize", () => {
        if (window.innerWidth < 768) sidebar.classList.remove("open");
    });

    // 5. Inisialisasi awal sidebar hidden di mobile
    if (window.innerWidth < 768) sidebar.classList.remove("open");

    // 6. Tandai halaman aktif
    const currentPage = window.location.pathname.split("/").pop();
    const allLinks = document.querySelectorAll("a.nav-link, a.dropdown-item, .sidebar a");

    allLinks.forEach(link => {
        const href = link.getAttribute("href");
        if (href && href.includes(currentPage)) {
            link.classList.add("active", "disabled");

            // 7. Buka dropdown sidebar kalau item aktif ada di dalamnya
            const isInSidebarDropdown = link.closest("#sidebarDropdown");
            if (isInSidebarDropdown && sidebarDropdown) {
                sidebarDropdown.style.display = "block";
            }
        }
    });
});

// 8. Fungsi untuk toggle dropdown sidebar manual
function toggleSidebarDropdown() {
    const dropdown = document.getElementById("sidebarDropdown");
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }
}

const profiles = document.querySelectorAll('.profile');

profiles.forEach(profile => {
    profile.addEventListener('click', function() {
        this.classList.toggle('active');
    });
});
