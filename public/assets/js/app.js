(function () {
    var sidebar = document.getElementById('sidebar');
    var toggle = document.getElementById('sidebarToggle');

    if (!sidebar || !toggle) {
        return;
    }

    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('is-open');
    });
})();
