<?php
include PATH_ROOT . '/app/views/layouts/header.php';
?>

<section class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/products">Sản phẩm</a></li>
                <?php if (isset($product['category_name']) && $product['category_name']): ?>
                    <li class="breadcrumb-item">
                        <a href="<?php echo BASE_URL; ?>/products?category=<?php echo $product['category_slug']; ?>">
                            <?php echo escape($product['category_name']); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?php echo escape($product['name']); ?></li>
            </ol>
        </nav>

        <!-- Product Detail -->
        <div class="row mb-5">
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="product-gallery">
                    <div class="main-image mb-3">
                        <img src="<?php echo getImageUrl($product['image'], 'product-placeholder.jpg'); ?>"
                             alt="<?php echo escape($product['name']); ?>"
                             class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <h1 class="h2 mb-3"><?php echo escape($product['name']); ?></h1>

                <!-- Category & Badges -->
                <div class="mb-3">
                    <?php if (isset($product['category_name']) && $product['category_name']): ?>
                        <span class="badge bg-primary">
                            <i class="bi bi-tag"></i> <?php echo escape($product['category_name']); ?>
                        </span>
                    <?php endif; ?>

                    <?php if (isset($product['is_new']) && $product['is_new']): ?>
                        <span class="badge bg-success">Mới</span>
                    <?php endif; ?>

                    <?php if (isset($product['is_featured']) && $product['is_featured']): ?>
                        <span class="badge bg-warning text-dark">Nổi bật</span>
                    <?php endif; ?>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <?php if (isset($product['sale_price']) && $product['sale_price'] > 0): ?>
                        <div class="d-flex align-items-center gap-3">
                            <h3 class="text-danger mb-0"><?php echo formatPrice($product['sale_price']); ?></h3>
                            <h5 class="text-muted text-decoration-line-through mb-0"><?php echo formatPrice($product['price']); ?></h5>
                            <span class="badge bg-danger">
                                -<?php echo calculateDiscount($product['price'], $product['sale_price']); ?>%
                            </span>
                        </div>
                    <?php else: ?>
                        <h3 class="text-danger mb-0"><?php echo formatPrice($product['price']); ?></h3>
                    <?php endif; ?>
                </div>

                <!-- Stock Status -->
                <div class="mb-4">
                    <strong>Tình trạng:</strong>
                    <?php if ($product['stock'] > 0): ?>
                        <span class="text-success">
                            <i class="bi bi-check-circle"></i> Còn hàng (<?php echo $product['stock']; ?> sản phẩm)
                        </span>
                    <?php else: ?>
                        <span class="text-danger">
                            <i class="bi bi-x-circle"></i> Hết hàng
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Add to Cart Form -->
                <?php if ($product['stock'] > 0): ?>
                    <form method="POST" action="<?php echo BASE_URL; ?>/cart/add" class="mb-4" id="addToCartForm">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Số lượng:</label>
                                <input type="number"
                                       class="form-control"
                                       id="quantity"
                                       name="quantity"
                                       value="1"
                                       min="1"
                                       max="<?php echo $product['stock']; ?>"
                                       required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                            <a href="<?php echo BASE_URL; ?>/products" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left"></i> Tiếp tục mua
                            </a>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Sản phẩm hiện đang hết hàng
                    </div>
                <?php endif; ?>

                <!-- Product Info -->
                <div class="card">
                    <div class="card-body">
                        <h5><i class="bi bi-info-circle"></i> Thông tin sản phẩm</h5>
                        <hr>
                        <?php if (!empty($product['description'])): ?>
                            <div class="product-description">
                                <?php echo $product['description']; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Chưa có mô tả cho sản phẩm này.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
            <div class="related-products mt-5">
                <h3 class="mb-4">Sản phẩm liên quan</h3>
                <div class="row">
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card product-card h-100">
                                <a href="<?php echo BASE_URL; ?>/product/<?php echo $relatedProduct['slug']; ?>">
                                    <div class="product-image">
                                        <img src="<?php echo getImageUrl($relatedProduct['image'], 'product-placeholder.jpg'); ?>"
                                             alt="<?php echo escape($relatedProduct['name']); ?>"
                                             class="card-img-top">
                                    </div>
                                </a>
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="<?php echo BASE_URL; ?>/product/<?php echo $relatedProduct['slug']; ?>"
                                           class="text-decoration-none text-dark">
                                            <?php echo escape($relatedProduct['name']); ?>
                                        </a>
                                    </h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if ($relatedProduct['sale_price']): ?>
                                            <span class="fw-bold text-danger"><?php echo formatPrice($relatedProduct['sale_price']); ?></span>
                                            <span class="text-muted text-decoration-line-through small"><?php echo formatPrice($relatedProduct['price']); ?></span>
                                        <?php else: ?>
                                            <span class="fw-bold text-danger"><?php echo formatPrice($relatedProduct['price']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    .product-image {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-description {
        line-height: 1.8;
    }

    .product-description img {
        max-width: 100%;
        height: auto;
    }
</style>

<script>
document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?php echo BASE_URL; ?>/cart/add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = '<?php echo BASE_URL; ?>/cart';
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại');
    });
});
</script>

<?php
include PATH_ROOT . '/app/views/layouts/footer.php';
?>
