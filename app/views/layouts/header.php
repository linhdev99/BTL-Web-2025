<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="<?php echo isset($metaDescription) ? escape($metaDescription) : escape(getSiteTagline()); ?>">
  <meta name="keywords"
    content="<?php echo isset($metaKeywords) ? escape($metaKeywords) : 'mô hình, figure, đồ chơi, gundam, xe mô hình'; ?>">
  <meta name="author" content="<?= getSiteName() ?>">
  <title><?php echo isset($pageTitle) ? escape($pageTitle) . ' - ' : ''; ?><?php echo escape(getSetting('site_name', 'BK Figure Lab')); ?></title>

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <?php if (isset($additionalCSS)): ?>
    <?php echo $additionalCSS; ?>
  <?php endif; ?>
</head>

<body class="bg-light text-dark">

  <!-- Top Bar -->
  <div class="top-bar bg-primary text-white py-2 small">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <i class="bi bi-telephone"></i> <?= getContactPhone() ?> |
          <i class="bi bi-envelope"></i> <?= getContactEmail() ?>
        </div>
        <div class="col-md-6 text-end">
          <?php if (isLoggedIn()): ?>
            <?php $user = getCurrentUser(); ?>
            Xin chào, <strong><?php echo escape($user['full_name']); ?></strong> |
            <?php if (isAdmin()): ?>
              <a href="<?php echo ADMIN_URL; ?>" class="text-warning text-decoration-none">Quản trị</a> |
            <?php endif; ?>
            <a href="<?php echo BASE_URL; ?>/profile" class="text-white text-decoration-none">Tài khoản</a> |
            <a href="<?php echo BASE_URL; ?>/logout" class="text-white text-decoration-none">Đăng xuất</a>
          <?php else: ?>
            <a href="<?php echo BASE_URL; ?>/login" class="text-white text-decoration-none">Đăng nhập</a> |
            <a href="<?php echo BASE_URL; ?>/register" class="text-white text-decoration-none">Đăng ký</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Header / Navbar -->
  <header class="header shadow-sm bg-white sticky-top">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">

          <!-- Logo -->
          <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="<?php echo BASE_URL; ?>">
            <?php
            $siteLogo = getSetting('site_logo', '');
            $siteName = getSetting('site_name', 'BK Figure Lab');
            if (!empty($siteLogo)):
            ?>
              <img src="<?php echo escape($siteLogo); ?>" alt="<?php echo escape($siteName); ?>"
                   style="max-height: 40px; margin-right: 10px;" class="me-2">
            <?php else: ?>
              <i class="bi bi-cube me-2"></i>
            <?php endif; ?>
            <?php echo escape($siteName); ?>
          </a>

          <!-- Toggler -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- Nav Links -->
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold">
              <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>"><i class="bi bi-house"></i> Trang
                  chủ</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/about"><i
                    class="bi bi-info-circle"></i> Giới thiệu</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/products"><i
                    class="bi bi-box-seam"></i> Sản phẩm</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/news"><i
                    class="bi bi-newspaper"></i> Tin tức</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/faq"><i
                    class="bi bi-question-circle"></i> Hỏi đáp</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/contact"><i
                    class="bi bi-envelope"></i> Liên hệ</a></li>
            </ul>

            <!-- Right icons -->
            <div class="d-flex align-items-center gap-3">
              <!-- Search -->
              <form action="<?php echo BASE_URL; ?>/products" method="GET" class="d-flex">
                <input class="form-control form-control-sm" type="search" name="keyword" placeholder="Tìm kiếm..."
                  style="width: 200px;">
                <button class="btn btn-sm btn-primary ms-1" type="submit"><i class="bi bi-search"></i></button>
              </form>

              <!-- Cart & Orders -->
              <?php if (isLoggedIn()): ?>
                <?php
                $cartModel = new \Models\Cart();
                $cartCount = $cartModel->getCartCount(getCurrentUserId());
                ?>
                <a href="<?php echo BASE_URL; ?>/my-orders" class="text-decoration-none position-relative"
                  title="Đơn hàng của tôi">
                  <i class="bi bi-bag-check fs-5"></i>
                </a>
                <a href="<?php echo BASE_URL; ?>/cart" class="text-decoration-none position-relative" title="Giỏ hàng">
                  <i class="bi bi-cart3 fs-5"></i>
                  <?php if ($cartCount > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      <?php echo $cartCount; ?>
                    </span>
                  <?php endif; ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main>