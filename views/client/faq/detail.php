<section class="section">
    <div class="container">
        <h2 class="mb-4">Chi tiết câu hỏi thường gặp (FAQ)</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card p-4 mb-4">
                    <div class="faq-category-badge category-<?= $faq['category_id'] ?> mb-2">
                        <?= $category['name'] ?? 'Khác' ?>
                    </div>
                    <h4 class="fw-bold mb-3"><?= htmlspecialchars($faq['question']) ?></h4>
                    <div class="faq-answer mb-3">
                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                    </div>
                    <div class="faq-meta text-muted small mb-3">
                        <i class="fa-regular fa-calendar"></i> Cập nhật: <?= htmlspecialchars($faq['updated_at']) ?>
                        <?php if (!empty($faq['ordering'])): ?>
                            &nbsp; | &nbsp;
                            <i class="fa-solid fa-list-ol"></i> Thứ tự: <?= (int) $faq['ordering'] ?>
                        <?php endif; ?>
                    </div>
                    <a href="/faq" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-left"></i> Quay lại danh sách</a>
                    <?php if (isset($isAdmin) && $isAdmin): ?>
                        <a href="/cms/faq/edit.php?id=<?= $faq['id'] ?>" class="btn btn-warning ms-2"><i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>