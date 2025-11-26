<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/faq" class="btn btn-secondary me-2">
                <i class="ti ti-arrow-left"></i> Quay lại
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/faq/static/add" class="btn btn-primary">
                <i class="ti ti-plus"></i> Thêm FAQ
            </a>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div class="d-flex">
            <div><i class="ti ti-check icon alert-icon"></i></div>
            <div><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách FAQ tĩnh</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Câu hỏi</th>
                            <th>Thể loại</th>
                            <th>Thứ tự</th>
                            <th>Trạng thái</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($staticFaq)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-file-text"></i>
                                    </div>
                                    <p class="empty-title">Chưa có FAQ nào</p>
                                    <div class="empty-action">
                                        <a href="<?php echo BASE_URL; ?>/cms/faq/static/add" class="btn btn-primary">
                                            <i class="ti ti-plus"></i> Thêm FAQ đầu tiên
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($staticFaq as $faq): ?>
                            <tr>
                                <td><?php echo $faq['id']; ?></td>
                                <td><?php echo escape($faq['question']); ?></td>
                                <td><?php echo escape($categoriesMap[$faq['category_id']] ?? 'N/A'); ?></td>
                                <td><?php echo $faq['ordering']; ?></td>
                                <td>
                                    <?php if ($faq['is_active']): ?>
                                        <span class="badge bg-success">Hiển thị</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap justify-content-end">
                                        <a href="<?php echo BASE_URL; ?>/cms/faq/static/edit/<?php echo $faq['id']; ?>"
                                           class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                            <i class="ti ti-edit"></i>
                                            <span>Sửa</span>
                                        </a>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/cms/faq/static/delete/<?php echo $faq['id']; ?>" class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa FAQ này?')">
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1">
                                                <i class="ti ti-trash"></i>
                                                <span>Xóa</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
