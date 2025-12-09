<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>

<section class="hero-section position-relative overflow-hidden">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
      <?php
      $activeBanners = array_filter($banners, function ($banner) {
        return !empty($banner['image']) || !empty($banner['title']);
      });

      if (empty($activeBanners)) {
        // Fallback to default banners if no banners configured
        $activeBanners = [
          1 => [
            'image' => '/assets/img/bg_1.png',
            'title' => 'Chào mừng đến với Toy Model Shop',
            'description' => 'Khám phá thế giới mô hình đồ chơi độc đáo và tinh xảo',
            'button_text' => 'Khám phá ngay',
            'button_link' => '/products'
          ],
          2 => [
            'image' => '/assets/img/bg_2.png',
            'title' => 'Mô hình đa dạng chủ đề',
            'description' => 'Từ anime, xe hơi, đến nhân vật điện ảnh',
            'button_text' => '',
            'button_link' => ''
          ],
          3 => [
            'image' => '/assets/img/bg_3.jpg',
            'title' => 'Ưu đãi cực hot mỗi tuần',
            'description' => 'Giảm giá lên đến 40% cho các sản phẩm nổi bật',
            'button_text' => '',
            'button_link' => ''
          ]
        ];
      }

      $first = true;
      foreach ($activeBanners as $banner):
        // Skip banners without image or title
        if (empty($banner['image']) && empty($banner['title']))
          continue;

        // Get image URL
        $imageUrl = !empty($banner['image']) ? escape($banner['image']) : 'https://picsum.photos/1920/700?random=' . rand(1, 10);

        // Handle button link
        $buttonLink = !empty($banner['button_link']) ? $banner['button_link'] : '#';
        if ($buttonLink !== '#' && !preg_match('/^https?:\/\//', $buttonLink)) {
          $buttonLink = BASE_URL . $buttonLink;
        }
        ?>
        <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
          <img src="<?php echo $imageUrl; ?>" class="d-block w-100" alt="<?php echo escape($banner['title']); ?>">
          <?php if (!empty($banner['title']) || !empty($banner['description'])): ?>
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-4">
              <?php if (!empty($banner['title'])): ?>
                <h1 class="fw-bold text-white"><?php echo escape($banner['title']); ?></h1>
              <?php endif; ?>
              <?php if (!empty($banner['description'])): ?>
                <p class="lead text-light"><?php echo escape($banner['description']); ?></p>
              <?php endif; ?>
              <?php if (!empty($banner['button_text']) && !empty($banner['button_link'])): ?>
                <a href="<?php echo $buttonLink; ?>" class="btn btn-primary btn-lg mt-2">
                  <?php echo escape($banner['button_text']); ?>
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
        <?php
        $first = false;
      endforeach;
      ?>
    </div>
    <?php if (count($activeBanners) > 1): ?>
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>
    <?php endif; ?>
  </div>
</section>

<section class="featured-products py-5 bg-light">
  <div class="container">
    <div class="section-header text-center mb-5">
      <h2 class="fw-bold display-6 mb-3">🌟 Sản phẩm nổi bật</h2>
      <p class="text-muted">Những mẫu mô hình được yêu thích nhất tại cửa hàng</p>
      <hr class="mx-auto" style="width: 80px; height: 3px; background-color: #007bff;">
    </div>

    <?php if (!empty($featuredProducts)): ?>
      <div class="row g-4 justify-content-center">
        <?php foreach ($featuredProducts as $product): ?>
          <?php
          // Use getImageUrl helper for proper image handling
          $imgSrc = getImageUrl($product['image'], 'product-placeholder.jpg');

          $isNew = !empty($product['is_new']) && $product['is_new'] == 1;
          $isFeatured = !empty($product['is_featured']) && $product['is_featured'] == 1;
          ?>
          <div class="col-md-6 col-lg-3 fade-in">
            <div class="card product-card h-100 border-0 shadow-sm position-relative hover-shadow transition">
              <?php if ($isNew): ?>
                <span class="badge bg-success position-absolute top-0 start-0 m-2 px-3 py-2 rounded-3">NEW</span>
              <?php elseif ($isFeatured): ?>
                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2 px-3 py-2 rounded-3">HOT</span>
              <?php endif; ?>

              <a href="<?php echo BASE_URL; ?>/product/<?php echo escape($product['slug']); ?>">
                <img src="<?php echo $imgSrc; ?>" class="card-img-top rounded-top"
                  alt="<?php echo escape($product['name']); ?>"
                  onerror="this.src='<?php echo BASE_URL; ?>/public/images/product-placeholder.jpg'">
              </a>

              <div class="card-body">
                <h5 class="card-title fw-semibold mb-2 text-truncate">
                  <a href="<?php echo BASE_URL; ?>/product/<?php echo escape($product['slug']); ?>"
                    class="text-decoration-none text-dark">
                    <?php echo escape($product['name']); ?>
                  </a>
                </h5>
                <p class="text-muted small mb-2">
                  <i class="bi bi-tag"></i> <?php echo escape($product['category_name'] ?? 'Không phân loại'); ?>
                </p>
                <p class="card-text text-truncate" style="max-height: 2.4em;">
                  <?php echo escape(truncateText($product['description'], 80)); ?>
                </p>
              </div>

              <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                <div>
                  <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0): ?>
                    <span class="text-danger fw-bold fs-5 me-2">
                      <?php echo number_format($product['sale_price'], 0, ',', '.'); ?> ₫
                    </span>
                    <small class="text-muted text-decoration-line-through">
                      <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                    </small>
                  <?php else: ?>
                    <span class="text-primary fw-bold fs-5">
                      <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                    </span>
                  <?php endif; ?>
                </div>
                <a href="<?php echo BASE_URL; ?>/product/<?php echo escape($product['slug']); ?>"
                  class="btn btn-sm btn-outline-primary px-3">
                  Chi tiết
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="text-center mt-5">
        <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary btn-lg shadow-sm px-5">
          Xem tất cả sản phẩm
        </a>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">
        <i class="bi bi-info-circle"></i> Chưa có sản phẩm nổi bật nào.
      </div>
    <?php endif; ?>
  </div>
</section>

<style>
  .transition {
    transition: all 0.3s ease;
  }

  .hover-shadow:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }

  .carousel img {
    object-fit: cover;
    height: 700px;
  }

  @media (max-width: 768px) {
    .carousel img {
      height: 400px;
    }
  }

  .badge {
    font-size: 0.85rem;
    letter-spacing: 0.5px;
  }

  .fade-in {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
  }

  .fade-in.visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const fadeEls = document.querySelectorAll('.fade-in');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
      });
    }, { threshold: 0.2 });

    fadeEls.forEach(el => observer.observe(el));
  });
</script>

<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>