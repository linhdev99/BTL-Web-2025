<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="error-content">
                <h1 class="display-1 fw-bold text-danger">404</h1>
                <h2 class="mb-4">Không Tìm Thấy Trang</h2>
                <p class="lead mb-4">
                    Xin l�i, trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">
                        <i class="bi bi-house-door"></i> Về Trang Chủ
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
