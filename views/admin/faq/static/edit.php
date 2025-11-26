<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/faq/static" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form method="POST" action="<?php echo BASE_URL; ?>/cms/faq/static/edit/<?php echo $faq['id']; ?>">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin FAQ</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label required">Thể loại</label>
                        <select class="form-select" name="category_id" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $faq['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo escape($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Câu hỏi</label>
                        <input type="text" class="form-control" name="question" value="<?php echo escape($faq['question']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Câu trả lời</label>
                        <textarea class="form-control" name="answer" rows="5" required><?php echo escape($faq['answer']); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Thứ tự hiển thị</label>
                                <input type="number" class="form-control" name="ordering" value="<?php echo $faq['ordering']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" name="is_active" value="1" <?php echo $faq['is_active'] ? 'checked' : ''; ?>>
                                    <span class="form-check-label">Hiển thị</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="<?php echo BASE_URL; ?>/cms/faq/static" class="btn btn-link">Hủy</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Cập nhật FAQ
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
