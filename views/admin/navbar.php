<nav class="navbar navbar-dark bg-dark sticky-top px-3 py-2 border-bottom border-secondary">

    <button class="navbar-brand d-flex flex-column text-start border-0 bg-transparent p-0"
        onclick="window.location.href='/'" style="cursor: pointer;">
        <span class="fw-bold text-info fs-5">BK Figure Lab</span>
        <small class="text-secondary">For True Figure Lovers</small>
    </button>

    <div class="d-flex align-items-center gap-3">
        <span class="text-white">
            <i class="fa-solid fa-user"></i>
            <?= $_SESSION['user']['username'] ?? 'Admin' ?>
        </span>

        <a href="/logout" class="btn btn-outline-light btn-sm">
            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
        </a>
    </div>

</nav>