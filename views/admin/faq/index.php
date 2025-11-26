<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
    </div>
</div>

<div class="row row-cards">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="display-6 text-primary mb-3">
                    <i class="ti ti-category"></i>
                </div>
                <h3 class="card-title">Thể loại FAQ</h3>
                <p class="text-muted">Quản lý các thể loại cho câu hỏi thường gặp</p>
                <a href="<?php echo BASE_URL; ?>/cms/faq/category" class="btn btn-primary">
                    <i class="ti ti-arrow-right"></i> Quản lý thể loại
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="display-6 text-success mb-3">
                    <i class="ti ti-file-text"></i>
                </div>
                <h3 class="card-title">FAQ Tĩnh</h3>
                <p class="text-muted">Quản lý câu hỏi và câu trả lời tĩnh</p>
                <a href="<?php echo BASE_URL; ?>/cms/faq/static" class="btn btn-success">
                    <i class="ti ti-arrow-right"></i> Quản lý FAQ tĩnh
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="display-6 text-info mb-3">
                    <i class="ti ti-users"></i>
                </div>
                <h3 class="card-title">FAQ Người dùng</h3>
                <p class="text-muted">Xem và trả lời câu hỏi từ người dùng</p>
                <a href="<?php echo BASE_URL; ?>/cms/faq/user" class="btn btn-info">
                    <i class="ti ti-arrow-right"></i> Quản lý câu hỏi
                </a>
            </div>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
