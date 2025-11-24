<?php
/**
 * @var $faq
 * @var $user
 */
?>

<div class="faq-container">
    <div class="page-title d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-question"></i>
            <span>Câu hỏi thường gặp (FAQ)</span>
        </div>

        <div class="d-flex gap-2">
            <a href="/faq" class="btn-view-all">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
            <?php if ($isAdmin): ?>
                <a href="/cms/faq/static/edit/<?= $faq['id'] ?>" class="btn-view-all">
                    <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mt-4 p-4">
        <div class="faq-category-badge category-<?= $faq['category_id'] ?> mb-2">
            <?= $faq['category_name'] ?? 'Khác' ?>
        </div>

        <h4 class="fw-bold mb-3"><?= $faq['question'] ?></h4>

        <div class="faq-answer mb-3">
            <?= nl2br($faq['answer']) ?>
        </div>

        <div class="faq-meta text-muted small">
            <i class="fa-regular fa-calendar"></i> Cập nhật: <?= $faq['updated_at'] ?>
            <?php if (!empty($faq['ordering'])): ?>
                &nbsp; | &nbsp;
                <i class="fa-solid fa-list-ol"></i> Thứ tự: <?= (int) $faq['ordering'] ?>
            <?php endif; ?>
        </div>
    </div>
</div>