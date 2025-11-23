<?php
/**
 * @var array $categories
 * @var array $faqQuestions
 */
?>

<div class="faq-container">
    <?php if (!empty($faqQuestions)): ?>
        <section class="faq-section">
            <h2><i class="fa-regular fa-circle-question"></i> Câu hỏi mới nhất</h2>
            <?php foreach ($faqQuestions as $q): ?>
                <div class="faq-question-item">
                    <h4>
                        <a href="faq-question-detail.php?id=<?= htmlspecialchars($q['id']) ?>">
                            <?= htmlspecialchars($q['question']) ?>
                        </a>
                    </h4>
                    <div class="faq-meta">
                        <span><i class="fa-regular fa-user"></i> <?= htmlspecialchars($q['user_name'] ?? 'Ẩn danh') ?></span>
                        <span><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($q['created_at'] ?? '') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</div>

<!-- ===== CSS ===== -->
<style>
    .faq-container {
        padding: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .page-title {
        font-size: 26px;
        margin-bottom: 25px;
        color: #333;
    }

    .faq-section {
        margin-bottom: 40px;
    }

    .faq-category-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .faq-category {
        background: #f3f3f3;
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        color: #333;
        transition: 0.2s;
    }

    .faq-category:hover {
        background: #e0e0e0;
    }

    .faq-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
    }

    .faq-item {
        background: #fff;
        border: 1px solid #ddd;
        padding: 16px;
        border-radius: 10px;
        transition: box-shadow .2s;
    }

    .faq-item:hover {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .faq-item h3 {
        margin: 0 0 10px;
    }

    .btn-primary {
        display: inline-block;
        margin-top: 8px;
        padding: 6px 12px;
        background: #007bff;
        color: #fff;
        border-radius: 6px;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .faq-question-item {
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .faq-question-item:last-child {
        border-bottom: none;
    }

    .faq-question-item a {
        color: #007bff;
        text-decoration: none;
    }

    .faq-question-item a:hover {
        text-decoration: underline;
    }

    .faq-meta {
        font-size: 13px;
        color: #777;
        display: flex;
        gap: 15px;
        margin-top: 4px;
    }

    .no-data {
        color: #888;
        font-style: italic;
    }
</style>