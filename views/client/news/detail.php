<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article>
                    <h1 class="mb-3"><?php echo escape($news['title']); ?></h1>
                    <div class="mb-4 text-muted">
                        <i class="bi bi-calendar"></i> <?php echo formatDate($news['created_at']); ?>
                        <i class="bi bi-person ms-3"></i> <?php echo escape($news['author_name'] ?? 'Admin'); ?>
                    </div>
                    <?php if (!empty($news['image'])): ?>
                        <img src="<?php echo getImageUrl($news['image']); ?>"
                             alt="<?php echo escape($news['title']); ?>"
                             class="img-fluid mb-4">
                    <?php endif; ?>
                    <div class="news-content">
                        <?php echo $news['content']; ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
