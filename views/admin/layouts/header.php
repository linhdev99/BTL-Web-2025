<?php
// BTL structure: Auth check
use Core\Auth;
Auth::requireAdminOrStaff();

$currentUser = getCurrentUser();
$currentPath = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? escape($pageTitle) . ' - ' : ''; ?>Admin | <?= getSiteName() ?></title>

    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet">
    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons@2.40.0/iconfont/tabler-icons.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (fallback) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        .navbar-brand-image {
            height: 32px;
        }
        .nav-item.active .nav-link {
            background-color: rgba(32, 107, 196, 0.06);
            color: #206bc4;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="<?php echo BASE_URL; ?>/cms">
                        <i class="ti ti-shopping-cart me-2"></i>
                        <?= getSiteName() ?> Admin
                    </a>
                </h1>

                <div class="navbar-nav flex-row order-md-last">
                    <!-- User dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                            <?php
                            $displayName = $currentUser['full_name'] ?? $currentUser['name'] ?? $currentUser['email'];
                            ?>
                            <span class="avatar avatar-sm"><?php echo strtoupper(substr($displayName, 0, 1)); ?></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?php echo escape($displayName); ?></div>
                                <div class="mt-1 small text-muted">
                                    <?php echo isAdmin() ? 'Administrator' : 'Staff'; ?>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="<?php echo BASE_URL; ?>/profile" class="dropdown-item">
                                <i class="ti ti-user me-2"></i> Tài khoản
                            </a>
                            <a href="<?php echo BASE_URL; ?>" class="dropdown-item" target="_blank">
                                <i class="ti ti-world me-2"></i> Xem website
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo BASE_URL; ?>/logout" class="dropdown-item">
                                <i class="ti ti-logout me-2"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <div class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar navbar-light">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item <?php echo strpos($currentPath, '/cms') !== false && strpos($currentPath, '/cms/') === false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-home"></i>
                                    </span>
                                    <span class="nav-link-title">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo strpos($currentPath, '/cms/products') !== false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms/products">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-package"></i>
                                    </span>
                                    <span class="nav-link-title">Sản phẩm</span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo strpos($currentPath, '/cms/orders') !== false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms/orders">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-shopping-cart"></i>
                                    </span>
                                    <span class="nav-link-title">Đơn hàng</span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo strpos($currentPath, '/cms/users') !== false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms/users">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-users"></i>
                                    </span>
                                    <span class="nav-link-title">Người dùng</span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo strpos($currentPath, '/cms/faq') !== false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms/faq">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-help"></i>
                                    </span>
                                    <span class="nav-link-title">FAQ</span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo strpos($currentPath, '/cms/news') !== false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms/news">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-news"></i>
                                    </span>
                                    <span class="nav-link-title">Tin tức</span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo strpos($currentPath, '/cms/contacts') !== false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms/contacts">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-mail"></i>
                                    </span>
                                    <span class="nav-link-title">Liên hệ</span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo strpos($currentPath, '/cms/settings') !== false ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/cms/settings">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-settings"></i>
                                    </span>
                                    <span class="nav-link-title">Cài đặt</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo escape($_SESSION['success']); unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo escape($_SESSION['error']); unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
