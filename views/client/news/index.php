<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <h2 class="mb-4">Tin tức</h2>
        <?php if (!empty($newsList)): ?>
            <div class="row">
                <?php foreach ($newsList as $news): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="<?php echo BASE_URL; ?>/news/<?php echo $news['slug']; ?>">
                                <img src="<?php echo getImageUrl($news['image'] ?? '', 'news-placeholder.jpg'); ?>"
                                     class="card-img-top" alt="<?php echo escape($news['title']); ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php echo BASE_URL; ?>/news/<?php echo $news['slug']; ?>"
                                       class="text-decoration-none text-dark">
                                        <?php echo escape($news['title']); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo truncate(strip_tags($news['summary'] ?? $news['content'] ?? ''), 150); ?>
                                </p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> <?php echo formatDate($news['created_at']); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Chưa có tin tức nào.</p>
        <?php endif; ?>
    </div>
</section>
<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
