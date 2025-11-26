<?php
include PATH_ROOT . '/views/admin/layouts/header.php';

// Get saved form data and errors from session
$formData = $_SESSION['category_form_data'] ?? [
    'name' => '',
    'slug' => '',
    'description' => ''
];
$errors = $_SESSION['category_errors'] ?? [];
$returnTo = $_SESSION['return_to'] ?? null;
unset($_SESSION['category_form_data'], $_SESSION['category_errors']);
?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">Thêm danh mục mới</h2>
        </div>
        <div class="col-auto ms-auto">
            <?php if ($returnTo): ?>
                <a href="<?php echo BASE_URL; ?>/cms/<?php echo escape($returnTo); ?>" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Quay lại
                </a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/cms/categories" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Quay lại danh sách
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="<?php echo BASE_URL; ?>/cms/categories/store">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin danh mục</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo escape($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label required">Tên danh mục</label>
                        <input type="text" class="form-control" name="name" value="<?php echo escape($formData['name']); ?>" required placeholder="VD: Mô hình Gundam">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (URL thân thiện)</label>
                        <input type="text" class="form-control" name="slug" value="<?php echo escape($formData['slug']); ?>" placeholder="VD: mo-hinh-gundam">
                        <small class="form-hint">Để trống để tự động tạo từ tên danh mục</small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description" rows="4"><?php echo escape($formData['description']); ?></textarea>
                    </div>

                    <?php if ($returnTo): ?>
                        <input type="hidden" name="return_to" value="<?php echo escape($returnTo); ?>">
                    <?php endif; ?>
                </div>
                <div class="card-footer text-end">
                    <?php if ($returnTo): ?>
                        <a href="<?php echo BASE_URL; ?>/cms/<?php echo escape($returnTo); ?>" class="btn btn-secondary">
                            Hủy
                        </a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/cms/categories" class="btn btn-secondary">
                            Hủy
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="ti ti-check"></i> Thêm danh mục
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
