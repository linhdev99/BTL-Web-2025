<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">Dashboard</h2>
            <div class="text-muted mt-1">Tổng quan hệ thống</div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row row-deck row-cards mb-3">
    <!-- Products -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Sản phẩm</div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/cms/products">Xem tất cả</a>
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/cms/products/add">Thêm mới</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2"><?php echo number_format($totalProducts); ?></div>
                    <div class="me-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            <i class="ti ti-trending-up"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Đơn hàng</div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/cms/orders">Xem tất cả</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2"><?php echo number_format($orderStats['total_orders'] ?? 0); ?></div>
                    <div class="me-auto">
                        <span class="text-yellow d-inline-flex align-items-center lh-1">
                            <i class="ti ti-shopping-cart"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Doanh thu</div>
                    <div class="ms-auto lh-1">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/cms/orders">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2"><?php echo formatPrice($salesStats['total_revenue'] ?? 0); ?></div>
                    <div class="me-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            <i class="ti ti-currency-dollar"></i>
                        </span>
                    </div>
                </div>
                <div class="text-muted small mt-1">
                    <?php echo number_format($salesStats['total_orders'] ?? 0); ?> đơn hàng (30 ngày qua)
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-3">
    <div class="col-md-6 col-lg-3 mb-3">
        <a href="<?php echo BASE_URL; ?>/cms/products/add" class="card card-link card-link-pop">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Thêm sản phẩm mới</div>
                    <div class="ms-auto">
                        <i class="ti ti-plus text-primary fs-1"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <a href="<?php echo BASE_URL; ?>/cms/orders" class="card card-link card-link-pop">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Quản lý đơn hàng</div>
                    <div class="ms-auto">
                        <i class="ti ti-shopping-cart text-success fs-1"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <a href="<?php echo BASE_URL; ?>/cms/faq" class="card card-link card-link-pop">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Quản lý FAQ</div>
                    <div class="ms-auto">
                        <i class="ti ti-help text-info fs-1"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <a href="<?php echo BASE_URL; ?>/cms/settings" class="card card-link card-link-pop">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Cài đặt hệ thống</div>
                    <div class="ms-auto">
                        <i class="ti ti-settings text-warning fs-1"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Orders Status -->
<div class="row mb-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Đơn hàng gần đây</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentOrders)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Chưa có đơn hàng nào</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/cms/orders/<?php echo $order['id']; ?>">
                                        <?php echo escape($order['order_code'] ?? '#' . $order['id']); ?>
                                    </a>
                                </td>
                                <td><?php echo escape($order['customer_name']); ?></td>
                                <td><?php echo formatPrice($order['total_amount']); ?></td>
                                <td>
                                    <?php
                                    $statusClass = 'secondary';
                                    $statusText = $order['status'];
                                    switch ($order['status']) {
                                        case 'pending':
                                            $statusClass = 'warning';
                                            $statusText = 'Chờ xử lý';
                                            break;
                                        case 'processing':
                                            $statusClass = 'info';
                                            $statusText = 'Đang xử lý';
                                            break;
                                        case 'completed':
                                            $statusClass = 'success';
                                            $statusText = 'Hoàn thành';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'danger';
                                            $statusText = 'Đã hủy';
                                            break;
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="<?php echo BASE_URL; ?>/cms/orders" class="btn btn-primary w-100">Xem tất cả đơn hàng</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Order Stats -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Thống kê đơn hàng</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Chờ xử lý</span>
                        <strong><?php echo number_format($orderStats['pending'] ?? 0); ?></strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: <?php echo ($orderStats['total_orders'] ?? 0) > 0 ? (($orderStats['pending'] ?? 0) / $orderStats['total_orders'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Đang xử lý</span>
                        <strong><?php echo number_format($orderStats['processing'] ?? 0); ?></strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: <?php echo ($orderStats['total_orders'] ?? 0) > 0 ? (($orderStats['processing'] ?? 0) / $orderStats['total_orders'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Hoàn thành</span>
                        <strong><?php echo number_format($orderStats['completed'] ?? 0); ?></strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?php echo ($orderStats['total_orders'] ?? 0) > 0 ? (($orderStats['completed'] ?? 0) / $orderStats['total_orders'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Đã hủy</span>
                        <strong><?php echo number_format($orderStats['cancelled'] ?? 0); ?></strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: <?php echo ($orderStats['total_orders'] ?? 0) > 0 ? (($orderStats['cancelled'] ?? 0) / $orderStats['total_orders'] * 100) : 0; ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sản phẩm sắp hết hàng</h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php if (empty($lowStockProducts)): ?>
                    <div class="list-group-item text-center text-muted">Tất cả sản phẩm đều đủ hàng</div>
                    <?php else: ?>
                        <?php foreach ($lowStockProducts as $product): ?>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong><?php echo escape($product['name']); ?></strong>
                                    <div class="text-muted small">SKU: <?php echo escape($product['sku']); ?></div>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-<?php echo $product['stock'] < 5 ? 'danger' : 'warning'; ?>">
                                        Còn <?php echo $product['stock']; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
