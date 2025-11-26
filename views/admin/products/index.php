<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>

        <!-- Nút điều hướng -->
        <div class="col-auto ms-auto d-flex gap-2">
            <a href="<?php echo BASE_URL; ?>/cms/categories" class="btn btn-secondary">
                <i class="ti ti-category"></i> Danh mục
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/products/add" class="btn btn-primary">
                <i class="ti ti-plus"></i> Thêm sản phẩm
            </a>
        </div>
    </div>
</div>

<!-- Search -->
<div class="row mb-3">
    <div class="col-12">
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo escape($search); ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách sản phẩm</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>SKU</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-package"></i>
                                    </div>
                                    <p class="empty-title">Chưa có sản phẩm nào</p>
                                    <p class="empty-subtitle text-muted">
                                        <a href="<?php echo BASE_URL; ?>/cms/products/add">Thêm sản phẩm đầu tiên</a>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td>
                                    <?php if ($product['image']): ?>
                                        <img src="<?php echo BASE_URL . '/' . $product['image']; ?>" alt="" width="50" height="50" style="object-fit: cover;" class="rounded">
                                    <?php else: ?>
                                        <div class="avatar avatar-sm">
                                            <i class="ti ti-photo"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/cms/products/<?php echo $product['id']; ?>/edit" class="text-reset">
                                        <?php echo escape($product['name']); ?>
                                    </a>
                                </td>
                                <td><?php echo escape($product['sku'] ?? 'N/A'); ?></td>
                                <td><?php echo formatPrice($product['price']); ?></td>
                                <td>
                                    <span class="badge <?php echo $product['stock'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $product['stock']; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo ($product['is_active'] ?? 0) == 1 ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo ($product['is_active'] ?? 0) == 1 ? 'Hoạt động' : 'Không hoạt động'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap justify-content-end">
                                        <a href="<?php echo BASE_URL; ?>/cms/products/<?php echo $product['id']; ?>/edit" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                            <i class="ti ti-edit"></i>
                                            <span>Sửa</span>
                                        </a>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/cms/products/<?php echo $product['id']; ?>/delete" style="display: inline;">
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

            <!-- Pagination -->
            <?php if (!empty($products) && $pagination['total_pages'] > 1): ?>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">
                    Hiển thị <?php echo ($pagination['current_page'] - 1) * $pagination['per_page'] + 1; ?>
                    đến <?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total']); ?>
                    trong tổng số <?php echo $pagination['total']; ?> sản phẩm
                </p>
                <ul class="pagination m-0 ms-auto">
                    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
