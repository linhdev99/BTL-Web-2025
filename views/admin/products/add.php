<?php
include PATH_ROOT . '/views/admin/layouts/header.php';

// Get saved form data and errors from session
$formData = $_SESSION['form_data'] ?? [
    'name' => '',
    'slug' => '',
    'sku' => '',
    'category_id' => '',
    'price' => '',
    'sale_price' => '',
    'stock' => '',
    'description' => '',
    'content' => '',
    'status' => 'active',
    'is_featured' => 0,
    'is_new' => 0
];
$errors = $_SESSION['errors'] ?? [];
$successMessage = $_SESSION['success'] ?? null;
$newCategoryId = $_SESSION['new_category_id'] ?? null;

// Auto-select newly created category
if ($newCategoryId && empty($formData['category_id'])) {
    $formData['category_id'] = $newCategoryId;
}

unset($_SESSION['form_data'], $_SESSION['errors'], $_SESSION['success'], $_SESSION['new_category_id']);
?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/products" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<form method="POST" action="<?php echo BASE_URL; ?>/cms/products/store" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Info -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Thông tin cơ bản</h3>
                </div>
                <div class="card-body">
                    <?php if ($successMessage): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?php echo escape($successMessage); ?>
                        </div>
                    <?php endif; ?>

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
                        <label class="form-label required">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="name" value="<?php echo escape($formData['name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (URL thân thiện)</label>
                        <input type="text" class="form-control" name="slug" value="<?php echo escape($formData['slug']); ?>">
                        <small class="form-hint">Để trống để tự động tạo từ tên sản phẩm</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Mã SKU</label>
                                <input type="text" class="form-control" name="sku" value="<?php echo escape($formData['sku']); ?>" required placeholder="VD: GUNDAM-001">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Danh mục</label>
                                <div class="input-group">
                                    <select class="form-select" name="category_id" id="category_select" required>
                                        <option value="">Chọn danh mục</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat['id']; ?>" <?php echo $formData['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                                <?php echo escape($cat['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <a href="<?php echo BASE_URL; ?>/cms/categories/add?return_to=products/add" class="btn btn-primary">
                                        <i class="ti ti-plus"></i> Thêm mới
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" name="description" rows="3"><?php echo escape($formData['description']); ?></textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Nội dung chi tiết</label>
                        <textarea class="form-control" name="content" rows="8"><?php echo escape($formData['content']); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Giá & Kho hàng</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">Giá gốc (₫)</label>
                                <input type="number" class="form-control" name="price" value="<?php echo $formData['price']; ?>" required min="0" step="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Giá khuyến mãi (₫)</label>
                                <input type="number" class="form-control" name="sale_price" value="<?php echo $formData['sale_price']; ?>" min="0" step="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">Số lượng</label>
                                <input type="number" class="form-control" name="stock" value="<?php echo $formData['stock']; ?>" required min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Image -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Hình ảnh</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Chọn ảnh sản phẩm</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <small class="form-hint">JPG, PNG hoặc GIF. Tối đa 5MB</small>
                    </div>
                </div>
            </div>

            <!-- Status & Options -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Trạng thái & Tùy chọn</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option value="active" <?php echo $formData['status'] == 'active' ? 'selected' : ''; ?>>Hoạt động</option>
                            <option value="inactive" <?php echo $formData['status'] == 'inactive' ? 'selected' : ''; ?>>Không hoạt động</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_featured" value="1" <?php echo $formData['is_featured'] ? 'checked' : ''; ?>>
                            <span class="form-check-label">Sản phẩm nổi bật</span>
                        </label>
                    </div>

                    <div class="mb-0">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_new" value="1" <?php echo $formData['is_new'] ? 'checked' : ''; ?>>
                            <span class="form-check-label">Sản phẩm mới</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-check"></i> Thêm sản phẩm
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
