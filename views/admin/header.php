<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?? "CMS Dashboard" ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom admin CSS -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/css/admin.css">
</head>

<body class="bg-dark text-white">

    <!-- ================= NAVBAR ================= -->
    <?php include 'navbar.php'; ?>

    <!-- ============ START MAIN LAYOUT (SIDEBAR + CONTENT) ============ -->
    <div class="d-flex">