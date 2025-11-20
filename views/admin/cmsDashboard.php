<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="admin-content container-fluid">

    <h1 class="mb-4 text-white"><?= $page_title ?></h1>

    <div class="card bg-secondary bg-opacity-25 shadow-sm p-4">

        <p class="mb-4 text-white">Chào mừng đến Dashboard CMS!</p>

        <?php if (!empty($stats)): ?>
            <div class="row g-3">

                <!-- Tổng sản phẩm -->
                <div class="col-md-3">
                    <div class="card text-bg-primary shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm</h5>
                            <div class="display-6 fw-bold"><?= $stats['total_products'] ?></div>
                        </div>
                    </div>
                </div>

                <!-- Tổng người dùng -->
                <div class="col-md-3">
                    <div class="card text-bg-success shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Người dùng</h5>
                            <div class="display-6 fw-bold"><?= $stats['total_users'] ?></div>
                        </div>
                    </div>
                </div>

                <!-- Tổng đơn hàng -->
                <div class="col-md-3">
                    <div class="card text-bg-warning shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Đơn hàng</h5>
                            <div class="display-6 fw-bold"><?= $stats['total_orders'] ?></div>
                        </div>
                    </div>
                </div>

                <!-- Doanh thu tháng -->
                <div class="col-md-3">
                    <div class="card text-bg-info shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Doanh thu tháng</h5>
                            <div class="fs-4 fw-bold">
                                <?= number_format($stats['total_revenue'] ?? 0) ?>đ
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>

</div>

<?php include 'footer.php'; ?>