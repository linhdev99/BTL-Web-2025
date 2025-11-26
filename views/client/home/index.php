<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Chào mừng đến với Toy Model Shop</h1>
                <p class="lead mb-4">Khám phá bộ sưu tập mô hình đồ chơi chất lượng cao với giá tốt nhất</p>
                <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary btn-lg">Xem sản phẩm</a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo BASE_URL; ?>/public/images/hero-banner.jpg" alt="Hero Banner" class="img-fluid rounded" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="fw-bold">Sản phẩm nổi bật</h2>
            <p class="text-muted">Những sản phẩm được yêu thích nhất</p>
        </div>

        <?php if (!empty($featuredProducts)): ?>
            <div class="row g-4">
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card product-card h-100">
                            <a href="<?php echo BASE_URL; ?>/product/<?php echo escape($product['slug']); ?>">
                                <img src="<?php echo BASE_URL; ?>/public/uploads/products/<?php echo escape($product['image']); ?>"
                                     class="card-img-top"
                                     alt="<?php echo escape($product['name']); ?>"
                                     onerror="this.src='<?php echo BASE_URL; ?>/public/images/no-image.jpg'">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php echo BASE_URL; ?>/product/<?php echo escape($product['slug']); ?>" class="text-decoration-none text-dark">
                                        <?php echo escape($product['name']); ?>
                                    </a>
                                </h5>
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-tag"></i> <?php echo escape($product['category_name']); ?>
                                </p>
                                <p class="card-text text-truncate" style="max-height: 2.4em;">
                                    <?php echo escape(truncateText($product['description'], 80)); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-bold fs-5">
                                        <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                                    </span>
                                    <a href="<?php echo BASE_URL; ?>/product/<?php echo escape($product['slug']); ?>" class="btn btn-sm btn-outline-primary">
                                        Chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5">
                <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary btn-lg">Xem tất cả sản phẩm</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Chưa có sản phẩm nổi bật nào.
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
