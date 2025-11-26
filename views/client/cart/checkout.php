<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <h2 class="mb-4">Thanh toán</h2>
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Thông tin giao hàng</h5>
                        <form method="POST" action="<?php echo BASE_URL; ?>/checkout">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Họ tên *</label>
                                    <input type="text" class="form-control" name="customer_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control" name="customer_email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại *</label>
                                    <input type="tel" class="form-control" name="customer_phone" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Địa chỉ *</label>
                                    <textarea class="form-control" name="customer_address" rows="3" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea class="form-control" name="notes" rows="2"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hình thức thanh toán</label>
                                    <select name="payment_method" class="form-control">
                                        <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                        <option value="bank">Chuyển khoản ngân hàng</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Vận chuyển</label>
                                    <select name="shipping_method" class="form-control">
                                        <option value="standard">Tiêu chuẩn</option>
                                        <option value="express">Nhanh</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">Đặt hàng</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Đơn hàng của bạn</h5>
                        <hr>
                        <?php foreach ($cartItems as $item): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?php echo escape($item['product']['name']); ?> x<?php echo $item['quantity']; ?></span>
                                <span><?php echo formatPrice($item['subtotal']); ?></span>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-danger"><?php echo formatPrice($total); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
