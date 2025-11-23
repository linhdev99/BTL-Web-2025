<?php
/**
 * @var array $categories
 * @var array $faqQuestions
 * @var int $page
 * @var int $totalPages
 * @var string $search
 * @var string $sort
 * @var int|null $filterCategory
 */
?>

<div class="faq-container">
    <div class="page-title">
        <span><i class="fa-regular fa-circle-question"></i> Danh sách câu hỏi</span>
    </div>

    <!-- ======= Bộ lọc ======= -->
    <form method="get" class="faq-filter-form">
        <input type="text" name="search" placeholder="Tìm kiếm câu hỏi..."
            value="<?= htmlspecialchars($search ?? '') ?>">

        <select name="category_id">
            <option value="">-- Tất cả danh mục --</option>
            <?php foreach ($categories as $id => $cat): ?>
                <option value="<?= $id ?>" <?= ($filterCategory == $id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort">
            <option value="created_at" <?= $sort === 'created_at' ? 'selected' : '' ?>>Mới nhất</option>
            <option value="question" <?= $sort === 'question' ? 'selected' : '' ?>>Theo tên câu hỏi (A-Z)</option>
            <option value="status" <?= $sort === 'status' ? 'selected' : '' ?>>Theo trạng thái</option>
        </select>

        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>

    <!-- ======= Danh sách câu hỏi ======= -->
    <?php if (!empty($faqQuestions)): ?>
        <section class="faq-section">
            <div class="faq-list">
                <?php foreach ($faqQuestions as $q): ?>
                    <div class="faq-item card">
                        <div class="faq-header-row">
                            <?php
                            $getId = !empty($q['category_id']) ? (int) $q['category_id'] : 1;
                            $categoryName = $categories[0]['name'];
                            foreach ($categories as $cat) {
                                if ((int) $cat['id'] === $getId) {
                                    $categoryName = $cat['name'];
                                    break;
                                }
                            }
                            ?>
                            <div class="faq-category-badge category-<?= htmlspecialchars($getId) ?>">
                                <?= htmlspecialchars($categoryName) ?>
                            </div>

                            <div class="faq-status-badge status-<?= htmlspecialchars($q['status']) ?>">
                                <?= match ($q['status']) {
                                    'active' => 'Hiển thị',
                                    'pending' => 'Chờ duyệt',
                                    'hidden' => 'Ẩn',
                                    default => ucfirst($q['status'])
                                } ?>
                            </div>
                        </div>

                        <h4>
                            <a href="faq-question-detail.php?id=<?= htmlspecialchars($q['id']) ?>">
                                <?= htmlspecialchars($q['question']) ?>
                            </a>
                        </h4>

                        <div class="faq-meta">
                            <span><i class="fa-regular fa-user"></i>
                                <?= htmlspecialchars($q['user_name'] ?? 'Ẩn danh') ?></span>
                            <span><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($q['created_at'] ?? '') ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ======= PHÂN TRANG ======= -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <!-- Nút Previous -->
                <a href="<?= $page > 1
                    ? '?page=' . ($page - 1) . '&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&category_id=' . urlencode($filterCategory)
                    : '#' ?>" class="page-link <?= $page <= 1 ? 'disabled' : '' ?>">
                    &laquo;
                </a>

                <!-- Các số trang -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a class="page-link <?= $i == $page ? 'active' : '' ?>"
                        href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&category_id=<?= urlencode($filterCategory) ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <!-- Nút Next -->
                <a href="<?= $page < $totalPages
                    ? '?page=' . ($page + 1) . '&search=' . urlencode($search) . '&sort=' . urlencode($sort) . '&category_id=' . urlencode($filterCategory)
                    : '#' ?>" class="page-link <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    &raquo;
                </a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p class="no-data">Không có câu hỏi nào được tìm thấy.</p>
    <?php endif; ?>
</div>