<nav class="navbar navbar-dark bg-dark sticky-top px-3 py-2 border-bottom border-secondary">

    <button class="navbar-brand d-flex flex-column text-start border-0 bg-transparent p-0"
        onclick="window.location.href='/cms'" style="cursor: pointer;">
        <span class="fw-bold text-info fs-5">BK Figure Lab</span>
        <small class="text-secondary">For True Figure Lovers</small>
    </button>

    <div class="d-flex align-items-center gap-3">

        <?php if (isset($_SESSION['user'])): ?>

            <span class="text-white">
                <i class="fa-solid fa-user"></i>
                <?= htmlspecialchars($_SESSION['user']['full_name'] ?? $_SESSION['user']['email']) ?>
            </span>

            <a href="/logout" class="btn btn-outline-light btn-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
            </a>

        <?php else: ?>

            <a href="/login" class="btn btn-outline-info btn-sm">
                <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
            </a>

            <a href="/register" class="btn btn-info btn-sm text-dark fw-semibold">
                <i class="fa-solid fa-user-plus"></i> Đăng ký
            </a>

        <?php endif; ?>

    </div>

</nav>