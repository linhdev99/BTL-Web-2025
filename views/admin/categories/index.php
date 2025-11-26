<?php
include PATH_ROOT . '/views/admin/layouts/header.php';

$successMessage = $_SESSION['success'] ?? null;
$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/categories/add" class="btn btn-primary">
                <i class="ti ti-plus"></i> Thêm danh mục
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách danh mục</h3>
            </div>

            <?php if ($successMessage): ?>
                <div class="alert alert-success alert-dismissible m-3 mb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php echo escape($successMessage); ?>
                </div>
            <?php endif; ?>

            <?php if ($errorMessage): ?>
                <div class="alert alert-danger alert-dismissible m-3 mb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?php echo escape($errorMessage); ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Số sản phẩm</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Chưa có danh mục nào
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td>
                                        <strong><?php echo escape($category['name']); ?></strong>
                                        <?php if (!empty($category['description'])): ?>
                                            <br><small class="text-muted"><?php echo escape(substr($category['description'], 0, 50)); ?><?php echo strlen($category['description']) > 50 ? '...' : ''; ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <code><?php echo escape($category['slug']); ?></code>
                                    </td>
                                    <td>
                                        <span class="badge bg-blue"><?php echo $category['product_count'] ?? 0; ?> sản phẩm</span>
                                    </td>
                                    <td>
                                        <?php if ($category['is_active']): ?>
                                            <span class="badge bg-success">Hoạt động</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Không hoạt động</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo date('d/m/Y', strtotime($category['created_at'])); ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="<?php echo BASE_URL; ?>/cms/categories/edit/<?php echo $category['id']; ?>" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                                <i class="ti ti-edit"></i>
                                                <span>Sửa</span>
                                            </a>
                                            <form method="POST" action="<?php echo BASE_URL; ?>/cms/categories/delete/<?php echo $category['id']; ?>" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?\n\nLưu ý: Các sản phẩm trong danh mục này sẽ không bị xóa, chỉ bị bỏ danh mục.');">
                                                <button type="submit" class="btn btn-sm btn-danger delete-confirm d-inline-flex align-items-center gap-1">
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
