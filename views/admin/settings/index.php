<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cài đặt hệ thống</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Chức năng đang được phát triển. Hiện tại vui lòng sử dụng trang admin cũ:</p>
                <a href="<?php echo BASE_URL; ?>/admin/settings.php" class="btn btn-primary">
                    <i class="ti ti-external-link"></i> Mở trang Settings (Admin cũ)
                </a>
            </div>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
