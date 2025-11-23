<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?? "CMS Dashboard" ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- jQuery (Summernote bắt buộc) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <!-- Custom admin CSS -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/css/styles.css">

    <script>
        window.addEventListener("pageshow", function (e) {
            if (e.persisted) {
                location.reload();
            }
        });
    </script>
</head>

<body class="bg-dark text-white">

    <!-- TOAST STACK (top-right) -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 999999;">

        <?php if (!empty($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $i => $toast): ?>

                <?php
                $type = $toast['type'] ?? 'success';
                $time = $toast['time'] ?? 4000;
                ?>

                <div id="cmsToast<?= $i ?>" class="toast align-items-center text-white bg-<?= $type ?> border-0 show mb-2"
                    role="alert" aria-live="assertive" aria-atomic="true">

                    <div class="d-flex">
                        <div class="toast-body">
                            <?= $toast['msg'] ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>

                <script>
                    setTimeout(() => {
                        const el = document.getElementById("cmsToast<?= $i ?>");
                        if (el) bootstrap.Toast.getOrCreateInstance(el).hide();
                    }, <?= $time ?>);
                </script>

            <?php endforeach; ?>

            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

    </div>

    <!-- ================= NAVBAR ================= -->
    <?php include 'navbar.php'; ?>

    <!-- ============ START MAIN LAYOUT (SIDEBAR + CONTENT) ============ -->
    <div class="d-flex">