<?php
/**
 * @var array $faq
 * @var array|null $category
 */

$canEdit = isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'staff']);
?>

<div class="faq-container">
    <div class="page-title d-flex justify-content-between align-items-center">
        <h2 class="mb-0">
            <i class="fa-solid fa-circle-question"></i> Chi tiết câu hỏi
        </h2>

        <div class="d-flex gap-2">
            <a href="/faq" class="btn btn-primary">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>

            <?php if ($canEdit): ?>
                <a href="/cms/faq/edit.php?id=<?= $faq['id'] ?>" class="btn btn-success">
                    <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mt-4 p-4">
        <div class="faq-category-badge category-<?= $faq['category_id'] ?> mb-2">
            <?= $category['name'] ?? 'Khác' ?>
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