<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/orders" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Order Info -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Thông tin đơn hàng</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="mb-2">
                            <strong>Mã đơn hàng:</strong> <?php echo escape($order['order_code'] ?? '#' . $order['id']); ?>
                        </div>
                        <div class="mb-2">
                            <strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?>
                        </div>
                        <div class="mb-2">
                            <strong>Phương thức thanh toán:</strong>
                            <?php
                            $paymentMethodText = 'Không xác định';
                            switch ($order['payment_method'] ?? 'cod') {
                                case 'cod':
                                    $paymentMethodText = 'COD (Thanh toán khi nhận hàng)';
                                    break;
                                case 'bank_transfer':
                                    $paymentMethodText = 'Chuyển khoản ngân hàng';
                                    break;
                                case 'momo':
                                    $paymentMethodText = 'Ví MoMo';
                                    break;
                                case 'vnpay':
                                    $paymentMethodText = 'VNPay';
                                    break;
                            }
                            echo $paymentMethodText;
                            ?>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <strong>Trạng thái đơn hàng:</strong>
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
                        </div>
                        <div class="mb-2">
                            <strong>Trạng thái thanh toán:</strong>
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
                        </div>
                        <div class="mb-2">
                            <strong>Tổng tiền:</strong> <span class="text-primary"><?php echo formatPrice($order['total_amount']); ?></span>
                        </div>
                    </div>
                </div>
                <?php if (!empty($order['note'])): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <strong>Ghi chú:</strong><br>
                            <?php echo nl2br(htmlspecialchars($order['note'], ENT_QUOTES, 'UTF-8')); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Order Items -->
                <h4 class="mb-3">Sản phẩm</h4>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($item['product_image']): ?>
                                        <img src="<?php echo BASE_URL . '/' . $item['product_image']; ?>" alt="" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div><?php echo escape($item['product_name']); ?></div>
                                    </div>
                                </td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end"><?php echo formatPrice($item['price']); ?></td>
                                <td class="text-end"><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Tổng cộng:</th>
                                <th class="text-end text-primary"><?php echo formatPrice($order['total_amount']); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Info & Actions -->
    <div class="col-md-4">
        <!-- Customer Info -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Thông tin khách hàng</h3>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Tên:</strong><br>
                    <?php echo escape($order['customer_name']); ?>
                </div>
                <div class="mb-2">
                    <strong>Email:</strong><br>
                    <?php echo escape($order['customer_email']); ?>
                </div>
                <?php if ($order['customer_phone']): ?>
                <div class="mb-2">
                    <strong>Điện thoại:</strong><br>
                    <?php echo escape($order['customer_phone']); ?>
                </div>
                <?php endif; ?>
                <?php if ($order['customer_address']): ?>
                <div class="mb-2">
                    <strong>Địa chỉ:</strong><br>
                    <?php echo nl2br(escape($order['customer_address'])); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Update Order Status -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Cập nhật trạng thái đơn hàng</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/cms/orders/<?php echo $order['id']; ?>/update-status">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                            <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                            <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                            <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-check"></i> Cập nhật trạng thái
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Payment Status -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật trạng thái thanh toán</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/cms/orders/<?php echo $order['id']; ?>/update-payment-status">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái thanh toán</label>
                        <select name="payment_status" class="form-select" required>
                            <option value="pending" <?php echo ($order['payment_status'] ?? 'pending') == 'pending' ? 'selected' : ''; ?>>Chờ thanh toán</option>
                            <option value="paid" <?php echo ($order['payment_status'] ?? '') == 'paid' ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="failed" <?php echo ($order['payment_status'] ?? '') == 'failed' ? 'selected' : ''; ?>>Thất bại</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="ti ti-currency-dollar"></i> Cập nhật thanh toán
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
