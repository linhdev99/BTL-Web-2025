<?php
/**
 * @var array $faqs
 */
?>

<link rel="stylesheet" href="/public/css/faq.css">

<div class="faq-container">
    <!-- ======= Tiêu đề & nút xem thêm ======= -->
    <div class="page-title">
        <span><i class="fa-solid fa-circle-question"></i> Câu hỏi thường gặp (FAQ)</span>
        <a href="/faq/questions" class="btn-view-all">
            <i class="fa-solid fa-list"></i> Xem nhiều câu hỏi
        </a>
    </div>

    <!-- ======= Danh sách FAQ ======= -->
    <?php if (!empty($faqs)): ?>
        <section class="faq-section">
            <div class="faq-list">
                <?php foreach ($faqs as $faq): ?>
                    <?php
                    $getId = !empty($faq['category_id']) ? (int) $faq['category_id'] : 1;
                    $categoryName = $faq['category_name'];
                    ?>
                    <a href="faq/<?= $faq['id'] ?>" class="faq-item card faq-clickable">
                        <div class="faq-category-badge category-<?= $getId ?>">
                            <?= $categoryName ?>
                        </div>

                        <h3><?= htmlspecialchars(strip_tags($faq['question'])) ?></h3>

                        <p><?= nl2br(htmlspecialchars(strip_tags(mb_substr($faq['answer'], 0, 200)))) ?>...</p>

                        <div class="btn btn-primary">
                            <i class="fa-solid fa-comments"></i> Xem câu hỏi
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php else: ?>
        <p class="no-data">Không có FAQ nào được tìm thấy.</p>
    <?php endif; ?>
</div>