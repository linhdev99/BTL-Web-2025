<?php include PATH_ROOT . '/views/admin/header.php'; ?>
<?php include PATH_ROOT . '/views/admin/sidebar.php'; ?>

<div class="admin-content container-fluid">

    <h1 class="mb-4 text-white">Đăng ký CMS</h1>

    <div class="row justify-content-center mt-4">
        <div class="col-md-4">

            <div class="card bg-dark text-white p-4 shadow">

                <?php if (!empty($_SESSION['cms_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['cms_error'];
                        unset($_SESSION['cms_error']); ?>
                    </div>
                <?php endif; ?>

                <form action="/cms/register" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-success w-100">Tạo tài khoản CMS</button>

                    <div class="text-center mt-3">
                        <a href="/cms/login" class="text-info">Đã có tài khoản? Đăng nhập</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>

<?php include PATH_ROOT . '/views/admin/footer.php'; ?>