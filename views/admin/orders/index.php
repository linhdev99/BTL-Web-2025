<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
    </div>
</div>

<!-- Search and Status Filter -->
<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="<?php echo BASE_URL; ?>/cms/orders" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo mã đơn, tên, email, SĐT..." value="<?php echo escape($search ?? ''); ?>">
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-search"></i> Tìm kiếm
            </button>
            <?php if ($search): ?>
            <a href="<?php echo BASE_URL; ?>/cms/orders" class="btn btn-outline-secondary">
                <i class="ti ti-x"></i> Xóa
            </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="col-md-6">
        <div class="btn-list justify-content-end">
            <a href="<?php echo BASE_URL; ?>/cms/orders" class="btn <?php echo !$currentStatus ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Tất cả
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/orders?status=pending" class="btn <?php echo $currentStatus == 'pending' ? 'btn-warning' : 'btn-outline-warning'; ?>">
                Chờ xử lý
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/orders?status=processing" class="btn <?php echo $currentStatus == 'processing' ? 'btn-info' : 'btn-outline-info'; ?>">
                Đang xử lý
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/orders?status=completed" class="btn <?php echo $currentStatus == 'completed' ? 'btn-success' : 'btn-outline-success'; ?>">
                Hoàn thành
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/orders?status=cancelled" class="btn <?php echo $currentStatus == 'cancelled' ? 'btn-danger' : 'btn-outline-danger'; ?>">
                Đã hủy
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách đơn hàng</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thanh toán</th>
                            <th>Ngày đặt</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-shopping-cart"></i>
                                    </div>
                                    <p class="empty-title">Chưa có đơn hàng nào</p>
                                    <p class="empty-subtitle text-muted">
                                        Các đơn hàng sẽ hiển thị ở đây
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/cms/orders/<?php echo $order['id']; ?>" class="text-reset">
                                        <?php echo escape($order['order_code'] ?? '#' . $order['id']); ?>
                                    </a>
                                </td>
                                <td>
                                    <div><?php echo escape($order['customer_name'] ?? 'N/A'); ?></div>
                                    <div class="text-muted"><?php echo escape($order['customer_email'] ?? ''); ?></div>
                                </td>
                                <td class="text-end"><?php echo formatPrice($order['total_amount']); ?></td>
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
                                <td>
                                    <?php
                                    $paymentStatusClass = 'secondary';
                                    $paymentStatusText = $order['payment_status'] ?? 'pending';
                                    switch ($order['payment_status'] ?? 'pending') {
                                        case 'pending':
                                            $paymentStatusClass = 'warning';
                                            $paymentStatusText = 'Chờ thanh toán';
                                            break;
                                        case 'paid':
                                            $paymentStatusClass = 'success';
                                            $paymentStatusText = 'Đã thanh toán';
                                            break;
                                        case 'failed':
                                            $paymentStatusClass = 'danger';
                                            $paymentStatusText = 'Thất bại';
                                            break;
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $paymentStatusClass; ?>"><?php echo $paymentStatusText; ?></span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/cms/orders/<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="ti ti-eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($orders) && $pagination['total_pages'] > 1): ?>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">
                    Hiển thị <?php echo ($pagination['current_page'] - 1) * $pagination['per_page'] + 1; ?>
                    đến <?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total']); ?>
                    trong tổng số <?php echo $pagination['total']; ?> đơn hàng
                </p>
                <ul class="pagination m-0 ms-auto">
                    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $currentStatus ? '&status=' . urlencode($currentStatus) : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
