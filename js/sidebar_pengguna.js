document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const sidebar = document.getElementById("sidebar");
    const toggleSidebar = document.getElementById("toggleSidebar");
    const closeBtn = document.getElementById("closeSidebar");
    const sidebarDropdown = document.getElementById("sidebarDropdown");

    window.addEventListener("scroll", function () {
        navbar.classList.toggle("scrolled", window.scrollY > 50);
    });

    toggleSidebar?.addEventListener("click", () => {
        sidebar.classList.toggle("open");
    });

    closeBtn?.addEventListener("click", () => {
        sidebar.classList.remove("open");
    });

    document.addEventListener("click", function (event) {
        if (!sidebar.contains(event.target) && !toggleSidebar.contains(event.target)) {
            sidebar.classList.remove("open");
        }
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth < 768) sidebar.classList.remove("open");
    });

    if (window.innerWidth < 768) sidebar.classList.remove("open");

    const currentPage = window.location.pathname.split("/").pop();
    const allLinks = document.querySelectorAll("a.nav-link, a.dropdown-item, .sidebar a");

    allLinks.forEach(link => {
        const href = link.getAttribute("href");
        if (href && href.includes(currentPage)) {
            link.classList.add("active", "disabled");

            const isInSidebarDropdown = link.closest("#sidebarDropdown");
            if (isInSidebarDropdown && sidebarDropdown) {
                sidebarDropdown.style.display = "block";
            }
        }
    });
});

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
