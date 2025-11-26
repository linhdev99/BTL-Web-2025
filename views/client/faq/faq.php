<section class="section">
    <div class="container">
        <h2 class="mb-4">Câu hỏi thường gặp (FAQ)</h2>
        <?php if (!empty($faqs)): ?>
            <div class="row">
                <?php foreach ($faqs as $faq): ?>
                    <?php
                    $getId = !empty($faq['category_id']) ? (int) $faq['category_id'] : 1;
                    $categoryName = $categories[0]['name'];
                    foreach ($categories as $cat) {
                        if ((int) $cat['id'] === $getId) {
                            $categoryName = $cat['name'];
                            break;
                        }
                    }
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 faq-card">
                            <div class="faq-category-badge category-<?= htmlspecialchars($getId) ?> mt-2 mx-2">
                                <?= htmlspecialchars($categoryName) ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="faq/<?= htmlspecialchars($faq['id']) ?>" class="text-dark text-decoration-none">
                                        <?= htmlspecialchars(strip_tags($faq['question'])) ?>
                                    </a>
                                </h5>
                                <p class="card-text">
                                    <?= nl2br(htmlspecialchars(strip_tags(mb_substr($faq['answer'], 0, 130)))) ?>...
                                </p>
                                <a href="faq/<?= htmlspecialchars($faq['id']) ?>" class="btn btn-primary btn-sm mt-2"><i class="fa-solid fa-comments"></i> Xem câu hỏi</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Không có FAQ nào được tìm thấy.</div>
        <?php endif; ?>
    </div>
</section>