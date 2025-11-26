<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h2 class="mb-4">Chi tiết đơn hàng #<?php echo $order['id']; ?></h2>
            </div>
            <div class="col-auto">
                <a href="<?php echo BASE_URL; ?>/my-orders" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Order Info -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Mã đơn hàng:</strong> #<?php echo $order['id']; ?></p>
                                <p><strong>Ngày đặt:</strong> <?php echo formatDate($order['created_at'], 'd/m/Y H:i'); ?></p>
                                <p><strong>Phương thức thanh toán:</strong> 
                                    <?php 
                                    echo $order['payment_method'] == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng';
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Trạng thái:</strong>
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
                                </p>
                                <p><strong>Tổng tiền:</strong> <span class="text-danger fs-5"><?php echo formatPrice($order['total_amount']); ?></span></p>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <h5 class="mb-3">Sản phẩm đã đặt</h5>
                        <div class="table-responsive">
                            <table class="table">
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
                                                <?php if (!empty($item['product_image'])): ?>
                                                <img src="<?php echo getImageUrl($item['product_image'], 'product-placeholder.jpg'); ?>" 
                                                     alt="" class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div><?php echo escape($item['product_name']); ?></div>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo $item['quantity']; ?></td>
                                        <td class="text-end"><?php echo formatPrice($item['product_price'] ?? $item['price'] ?? 0); ?></td>
                                        <td class="text-end"><?php echo formatPrice($item['subtotal'] ?? ($item['product_price'] ?? $item['price'] ?? 0) * $item['quantity']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Tổng cộng:</th>
                                        <th class="text-end text-danger"><?php echo formatPrice($order['total_amount']); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info & Actions -->
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Tên người nhận:</strong><br>
                        <?php echo escape($order['customer_name']); ?></p>
                        <p><strong>Email:</strong><br>
                        <?php echo escape($order['customer_email']); ?></p>
                        <?php if ($order['customer_phone']): ?>
                        <p><strong>Điện thoại:</strong><br>
                        <?php echo escape($order['customer_phone']); ?></p>
                        <?php endif; ?>
                        <?php if ($order['customer_address']): ?>
                        <p><strong>Địa chỉ:</strong><br>
                        <?php echo nl2br(escape($order['customer_address'])); ?></p>
                        <?php endif; ?>
                        <?php if ($order['notes']): ?>
                        <p><strong>Ghi chú:</strong><br>
                        <?php echo nl2br(escape($order['notes'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($order['status'] == 'pending'): ?>
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-danger w-100" onclick="cancelOrder(<?php echo $order['id']; ?>)">
                            <i class="bi bi-x-circle"></i> Hủy đơn hàng
                        </button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
function cancelOrder(orderId) {
    if (!confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
        return;
    }

    const formData = new FormData();
    formData.append('_method', 'POST');

    fetch('<?php echo BASE_URL; ?>/order/' + orderId + '/cancel', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra');
    });
}
</script>

<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
