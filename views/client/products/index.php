<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-funnel"></i> Bộ lọc</h5>
                    </div>
                    <div class="card-body">
                        <!-- Search -->
                        <div class="mb-4">
                            <h6>Tìm kiếm</h6>
                            <form action="<?php echo BASE_URL; ?>/products" method="GET">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           name="search"
                                           placeholder="Nhập từ khóa..."
                                           value="<?php echo isset($search) ? escape($search) : ''; ?>">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- Categories -->
                        <div class="mb-4">
                            <h6>Danh mục</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="<?php echo BASE_URL; ?>/products"
                                       class="text-decoration-none <?php echo !isset($currentCategory) ? 'text-primary fw-bold' : ''; ?>">
                                        <i class="bi bi-chevron-right"></i> Tất cả sản phẩm
                                    </a>
                                </li>
                                <?php foreach ($categories as $cat): ?>
                                    <li class="mb-2">
                                        <a href="<?php echo BASE_URL; ?>/products?category=<?php echo $cat['slug']; ?>"
                                           class="text-decoration-none <?php echo (isset($currentCategory) && $currentCategory['id'] == $cat['id']) ? 'text-primary fw-bold' : ''; ?>">
                                            <i class="bi bi-chevron-right"></i> <?php echo escape($cat['name']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Products -->
            <div class="col-lg-9">
                <!-- Breadcrumb & Title -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
                                <li class="breadcrumb-item active">Sản phẩm</li>
                            </ol>
                        </nav>
                        <h2><?php echo $pageTitle; ?></h2>
                        <?php if (isset($pagination['total'])): ?>
                            <p class="text-muted">Tìm thấy <?php echo $pagination['total']; ?> sản phẩm</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Products Grid -->
                <?php if (!empty($products)): ?>
                    <div class="row">
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <?php if (isset($product['sale_price']) && $product['sale_price'] > 0): ?>
                                        <span class="position-absolute top-0 end-0 badge bg-danger m-2">
                                            -<?php echo calculateDiscount($product['price'], $product['sale_price']); ?>%
                                        </span>
                                    <?php endif; ?>
                                    <a href="<?php echo BASE_URL; ?>/product/<?php echo $product['slug']; ?>">
                                        <div class="product-image">
                                            <img src="<?php echo getImageUrl($product['image'], 'product-placeholder.jpg'); ?>"
                                                 alt="<?php echo escape($product['name']); ?>"
                                                 class="card-img-top">
                                        </div>
                                    </a>
                                    <div class="card-body">
                                        <p class="text-muted small mb-1">
                                            <?php echo isset($product['category_name']) ? escape($product['category_name']) : 'Chưa phân loại'; ?>
                                        </p>
                                        <h5 class="card-title">
                                            <a href="<?php echo BASE_URL; ?>/product/<?php echo $product['slug']; ?>"
                                               class="text-decoration-none text-dark">
                                                <?php echo escape($product['name']); ?>
                                            </a>
                                        </h5>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <?php if ($product['sale_price']): ?>
                                                <span class="h5 text-danger mb-0"><?php echo formatPrice($product['sale_price']); ?></span>
                                                <span class="text-muted text-decoration-line-through"><?php echo formatPrice($product['price']); ?></span>
                                            <?php else: ?>
                                                <span class="h5 text-danger mb-0"><?php echo formatPrice($product['price']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php echo BASE_URL; ?>/product/<?php echo $product['slug']; ?>"
                                           class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-cart-plus"></i> Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Pagination -->
                    <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
                        <nav aria-label="Product pagination" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php if ($pagination['current_page'] > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo ($pagination['current_page'] - 1); ?><?php echo isset($search) ? '&search=' . urlencode($search) : ''; ?><?php echo isset($currentCategory) ? '&category=' . $currentCategory['slug'] : ''; ?>">
                                            Trước
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                    <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo isset($search) ? '&search=' . urlencode($search) : ''; ?><?php echo isset($currentCategory) ? '&category=' . $currentCategory['slug'] : ''; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo ($pagination['current_page'] + 1); ?><?php echo isset($search) ? '&search=' . urlencode($search) : ''; ?><?php echo isset($currentCategory) ? '&category=' . $currentCategory['slug'] : ''; ?>">
                                            Sau
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Không tìm thấy sản phẩm nào.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
