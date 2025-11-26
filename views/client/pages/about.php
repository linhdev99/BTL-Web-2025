<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <h2 class="mb-4"><?= getAboutTitle() ?></h2>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <?= getAboutContent() ?>
            </div>
        </div>
    </div>
</section>
<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
