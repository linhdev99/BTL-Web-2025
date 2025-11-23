<?php
/**
 * @var array $categories
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
                    <div class="faq-item card">
                        <div class="faq-category-badge category-<?= htmlspecialchars($faq['category_id']) ?>">
                            <?php
                            $getId = $faq['category_id'];
                            $category = $categories[$getId]['name'] ?? 'Khác';
                            echo htmlspecialchars($category);
                            ?>
                        </div>
                        <h3><?= htmlspecialchars(strip_tags($faq['question'])) ?></h3>
                        <p>
                            <?= nl2br(htmlspecialchars(strip_tags(mb_substr($faq['answer'], 0, 200)))) ?>...
                        </p>
                        <a href="faq-question.php?category_id=<?= htmlspecialchars($faq['id']) ?>" class="btn btn-primary">
                            <i class="fa-solid fa-comments"></i> Xem câu hỏi
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php else: ?>
        <p class="no-data">Không có FAQ nào được tìm thấy.</p>
    <?php endif; ?>
</div>