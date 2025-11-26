<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Đăng ký tài khoản</h2>

                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= escape($_SESSION['error']); unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo BASE_URL; ?>/register" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" required autofocus
                                       placeholder="Nhập họ và tên">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required
                                       placeholder="Nhập địa chỉ email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required minlength="6"
                                       placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirm" class="form-control" required minlength="6"
                                       placeholder="Nhập lại mật khẩu">
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Tôi đồng ý với <a href="<?php echo BASE_URL; ?>/terms" target="_blank">điều khoản sử dụng</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mb-3">
                                <i class="bi bi-person-plus"></i> Đăng ký
                            </button>

                            <div class="text-center">
                                <p class="mb-0">Đã có tài khoản?
                                    <a href="<?php echo BASE_URL; ?>/login" class="text-decoration-none">Đăng nhập ngay</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
