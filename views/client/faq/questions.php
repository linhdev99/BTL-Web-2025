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

  <form method="get" class="faq-filter-form bg-light p-3 rounded shadow-sm">
    <div class="row g-2 align-items-center">
      <!-- Tìm kiếm -->
      <div class="col-md-4">
        <div class="form-floating">
          <input type="text" class="form-control" id="search" name="search" placeholder="Tìm kiếm câu hỏi..."
            value="<?= $search ?? '' ?>">
          <label for="search"><i class="fa-solid fa-magnifying-glass me-1"></i> Tìm kiếm</label>
        </div>
      </div>

      <!-- Danh mục -->
      <div class="col-md-3">
        <div class="form-floating">
          <select class="form-select" id="category_id" name="category_id">
            <option value="">-- Tất cả danh mục --</option>
            <?php foreach ($categories as $id => $cat): ?>
              <option value="<?= $id ?>" <?= ($filterCategory == $id) ? 'selected' : '' ?>>
                <?= $cat['name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <label for="category_id"><i class="fa-solid fa-list me-1"></i> Phân loại</label>
        </div>
      </div>

      <!-- Sắp xếp -->
      <div class="col-md-3">
        <div class="form-floating">
          <select class="form-select" id="sort" name="sort">
            <option value="newest" <?= (($_GET['sort'] ?? '') === 'newest') ? 'selected' : '' ?>>Mới nhất</option>
            <option value="oldest" <?= (($_GET['sort'] ?? '') === 'oldest') ? 'selected' : '' ?>>Cũ nhất</option>
          </select>
          <label for="sort"><i class="fa-solid fa-arrow-down-short-wide me-1"></i> Sắp xếp</label>
        </div>
      </div>

      <!-- Nút Lọc -->
      <div class="col-md-2 d-flex align-items-center">
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
          <i class="fa-solid fa-filter me-2"></i> Lọc
        </button>
      </div>
    </div>
  </form>

  <!-- ======= Danh sách câu hỏi ======= -->
  <?php if (!empty($faqQuestions)): ?>
    <section class="faq-section">
      <div class="faq-list">
        <?php foreach ($faqQuestions as $question): ?>
          <a href="questions/detail/<?= $question['id'] ?>" class="faq-item card faq-clickable">
            <div class="faq-header-row">
              <?php
              $getId = !empty($question['category_id']) ? (int) $question['category_id'] : 1;
              $categoryName = $question['category_name'];
              ?>
              <div class="faq-category-badge category-<?= $getId ?>">
                <?= $categoryName ?>
              </div>

              <div class="faq-status-badge status-<?= $question['status'] ?>">
                <?= match ($question['status']) {
                  'active' => 'Hiển thị',
                  'pending' => 'Chờ duyệt',
                  'hidden' => 'Ẩn',
                  default => ucfirst($question['status'])
                } ?>
              </div>
            </div>

            <h4>
              <?= htmlspecialchars($question['question']) ?>
            </h4>

            <div class="faq-meta">
              <span><i class="fa-regular fa-user"></i> <?= $question['full_name'] ?? 'Ẩn danh' ?></span>
              <span><i class="fa-regular fa-calendar"></i> <?= $question['created_at'] ?? '' ?></span>
            </div>
          </a>
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