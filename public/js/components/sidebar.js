document.addEventListener("DOMContentLoaded", function() {
    const sidenavTrigger = document.querySelector("[sidenav-trigger]");
    const sidebar = document.getElementById("sidebar");

    sidenavTrigger.addEventListener("click", function() {
        if (window.innerWidth < 1280) {
            sidebar.classList.toggle("-translate-x-full");
        }
    });

    function checkScreenSize() {
        if (window.innerWidth >= 1280) {
            sidebar.classList.remove("-translate-x-full");
        } else {
            sidebar.classList.add("-translate-x-full");
        }
    }

    checkScreenSize();
    window.addEventListener("resize", checkScreenSize);
});