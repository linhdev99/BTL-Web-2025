<?php
use Core\Auth;
$user = $_SESSION['user'] ?? null;
$isAdmin = $user && ($user['role_id'] == 1 || $user['role_id'] == 2);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "BK Figure Lab" ?></title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/css/client.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/css/styles.css">

</head>

<body>
    <header class="main-header">
        <div class="header-left">
            <div>
                <h1>BK Figure Lab</h1>
                <div class="slogan">For True Figure Lovers</div>
            </div>
        </div>

        <?php require 'navbar.php' ?>

        <div class="header-right">
            <?php if ($user): ?>
                <div class="user-info">
                    <i class="fa-regular fa-user"></i>
                    <?= htmlspecialchars($user['full_name'] ?? 'Người dùng') ?>
                    <a href="/logout" class="btn-login logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>
            <?php else: ?>
                <a href="/login" class="btn-login">
                    <span>Đăng nhập</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">