<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<?php include __DIR__ . '/../partials/sidebar.php'; ?>

<div class="content">
    <h1><?= $page_title ?></h1>

    <div class="dashboard-box">
        <p>Chào mừng đến Dashboard CMS!</p>

        <?php if (!empty($stats)): ?>
            <div class="stats">
                <div class="stat-item">Sản phẩm: <?= $stats['total_products'] ?></div>
                <div class="stat-item">Người dùng: <?= $stats['total_users'] ?></div>
                <div class="stat-item">Đơn hàng: <?= $stats['total_orders'] ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>