<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="<?php echo isset($metaDescription) ? escape($metaDescription) : escape(getSiteTagline()); ?>">
  <meta name="keywords"
    content="<?php echo isset($metaKeywords) ? escape($metaKeywords) : 'mô hình, đồ chơi, gundam, figure'; ?>">
  <meta name="author" content="<?= getSiteName() ?>">
  <title><?php echo isset($pageTitle) ? escape($pageTitle) . ' - ' : ''; ?><?= getSiteName() ?></title>

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

<body>
  <!-- Top Bar -->
  <div class="top-bar">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <small>
            <i class="bi bi-telephone"></i> <?= getContactPhone() ?> |
            <i class="bi bi-envelope"></i> <?= getContactEmail() ?>
          </small>
        </div>
        <div class="col-md-6 text-end">
          <?php if (isLoggedIn()): ?>
            <?php $user = getCurrentUser(); ?>
            <small>
              Xin chào, <strong><?php echo escape($user['full_name']); ?></strong> |
              <?php if (isAdmin()): ?>
                <a href="<?php echo ADMIN_URL; ?>" style="color: #ffd43b;">Quản trị</a> |
              <?php endif; ?>
              <a href="<?php echo BASE_URL; ?>/profile" style="color: #fff;">Tài khoản</a> |
              <a href="<?php echo BASE_URL; ?>/logout" style="color: #fff;">Đăng xuất</a>
            </small>
          <?php else: ?>
            <small>
              <a href="<?php echo BASE_URL; ?>/login" style="color: #fff;">Đăng nhập</a> |
              <a href="<?php echo BASE_URL; ?>/register" style="color: #fff;">Đăng ký</a>
            </small>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Header -->
  <header class="header">
    <div class="container">
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
            <i class="bi bi-shop"></i> <?= getSiteName() ?>
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>">Trang chủ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/about">Giới thiệu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/products">Sản phẩm</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/news">Tin tức</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/faq">Hỏi đáp</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/contact">Liên hệ</a>
              </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
              <!-- Search Form -->
              <form action="<?php echo BASE_URL; ?>/products" method="GET" class="d-flex">
                <input class="form-control form-control-sm" type="search" name="keyword" placeholder="Tìm kiếm..."
                  style="width: 200px;">
                <button class="btn btn-sm btn-primary ms-1" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </form>

              <?php if (isLoggedIn()): ?>
                <?php
                $cartModel = new \Models\Cart();
                $cartCount = $cartModel->getCartCount(getCurrentUserId());
                ?>
                <!-- My Orders Icon -->
                <a href="<?php echo BASE_URL; ?>/my-orders" class="text-decoration-none" title="Đơn hàng của tôi">
                  <i class="bi bi-bag-check" style="font-size: 24px;"></i>
                </a>

                <!-- Cart Icon -->
                <a href="<?php echo BASE_URL; ?>/cart" class="cart-badge position-relative" title="Giỏ hàng">
                  <i class="bi bi-cart3" style="font-size: 24px;"></i>
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