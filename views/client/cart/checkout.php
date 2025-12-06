<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <h2 class="mb-4">Thanh toán</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Thông tin giao hàng</h5>
                        <form method="POST" action="<?php echo BASE_URL; ?>/checkout" id="checkout-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Họ tên *</label>
                                    <input type="text" class="form-control" name="customer_name"
                                           value="<?php echo isset($currentUser) ? escape($currentUser['full_name'] ?? $currentUser['name'] ?? '') : ''; ?>"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control" name="customer_email"
                                           value="<?php echo isset($currentUser) ? escape($currentUser['email'] ?? '') : ''; ?>"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại *</label>
                                    <input type="tel" class="form-control" name="customer_phone"
                                           value="<?php echo isset($currentUser) ? escape($currentUser['phone'] ?? '') : ''; ?>"
                                           required>
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
                                    <select name="payment_method" class="form-control" id="payment-method">
                                        <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                        <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                                    </select>
                                </div>
                                <div class="col-12" id="bank-info" style="display: none;">
                                    <div class="card border-info">
                                        <div class="card-body bg-light">
                                            <h6 class="card-title text-info mb-3">
                                                <i class="bi bi-bank me-2"></i>Thông tin chuyển khoản
                                            </h6>
                                            <div class="mb-2">
                                                <strong>Ngân hàng:</strong> Vietcombank
                                            </div>
                                            <div class="mb-2">
                                                <strong>Số tài khoản:</strong> 1234567890
                                            </div>
                                            <div class="mb-2">
                                                <strong>Chủ tài khoản:</strong> <?= getSiteName() ?>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Nội dung chuyển khoản:</strong> Thanh toán đơn hàng - [Họ tên của bạn]
                                            </div>
                                            <hr>
                                            <small class="text-muted">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Vui lòng chuyển khoản và giữ lại biên lai. Chúng tôi sẽ xác nhận và xử lý đơn hàng sau khi nhận được thanh toán.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Vận chuyển</label>
                                    <select name="shipping_method" class="form-control">
                                        <option value="standard">Tiêu chuẩn</option>
                                        <option value="express">Nhanh</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submit-order">
                                        <span id="submit-text">Đặt hàng</span>
                                        <span id="submit-loading" class="d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            Đang xử lý...
                                        </span>
                                    </button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.getElementById('payment-method');
    const bankInfo = document.getElementById('bank-info');
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submit-order');
    const submitText = document.getElementById('submit-text');
    const submitLoading = document.getElementById('submit-loading');

    // Toggle bank info display
    paymentMethod.addEventListener('change', function() {
        if (this.value === 'bank_transfer') {
            bankInfo.style.display = 'block';
        } else {
            bankInfo.style.display = 'none';
        }
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        console.log('Form is being submitted');
        console.log('Form action:', form.action);
        console.log('Form method:', form.method);

        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('d-none');
        submitLoading.classList.remove('d-none');

        // Form will submit normally, loading state shows user something is happening
    });
});
</script>

<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
