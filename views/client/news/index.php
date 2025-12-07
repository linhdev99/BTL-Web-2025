<?php
/**
 * @var string $page_title
 * @var array $pagination
 * @var string $keyword
 * @var string $sort
 */
?>

<section class="section py-5">
  <div class="container">

    <!-- PAGE TITLE -->
    <h2 class="text-center mb-4 fw-bold text-primary">
      📰 <?= htmlspecialchars($page_title) ?>
    </h2>

    <!-- FILTER BAR -->
    <form method="GET" class="row g-2 align-items-center mb-4">

      <!-- Ô tìm kiếm -->
      <div class="col-md-5">
        <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($keyword) ?>"
          placeholder="🔍 Tìm kiếm bài viết...">
      </div>

      <!-- Bộ chọn sắp xếp -->
      <div class="col-md-3">
        <select name="sort" class="form-select" onchange="this.form.submit()">
          <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>🕒 Mới nhất</option>
          <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>📜 Cũ nhất</option>
          <option value="star_desc" <?= $sort === 'star_desc' ? 'selected' : '' ?>>⭐ Sao cao → thấp</option>
          <option value="star_asc" <?= $sort === 'star_asc' ? 'selected' : '' ?>>⭐ Sao thấp → cao</option>
        </select>
      </div>

      <!-- Nút lọc -->
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
          <i class="fa-solid fa-magnifying-glass me-1"></i> Lọc kết quả
        </button>
      </div>

      <!-- Nút làm mới -->
      <div class="col-md-2">
        <a href="/news" class="btn btn-outline-secondary w-100">
          <i class="fa-solid fa-rotate-right me-1"></i> Làm mới
        </a>
      </div>
    </form>

    <!-- Nếu không có bài viết -->
    <?php if (empty($pagination['data'])): ?>
      <div class="text-center py-5">
        <p class="text-muted fs-5">Không tìm thấy bài viết nào phù hợp với từ khóa của bạn.</p>
      </div>

    <?php else: ?>
      <!-- GRID: Danh sách bài viết -->
      <div class="row g-4">
        <?php foreach ($pagination['data'] as $news): ?>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 hover-shadow">

              <!-- Thumbnail -->
              <?php if (!empty($news['thumbnail'])): ?>
                <img src="<?= htmlspecialchars($news['thumbnail']) ?>" alt="<?= htmlspecialchars($news['title']) ?>"
                  class="card-img-top rounded-top" style="object-fit: cover; height: 200px;">
              <?php else: ?>
                <div class="bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 200px;">
                  <span class="text-muted">Không có ảnh</span>
                </div>
              <?php endif; ?>

              <!-- Nội dung -->
              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-semibold text-primary mb-2">
                  <?= htmlspecialchars($news['title']) ?>
                </h5>

                <!-- ⭐ 10 sao -->
                <?php
                $star = floatval($news['avg_rating'] ?? 0);
                $fullStars = floor($star);
                $halfStar = ($star - $fullStars >= 0.5);
                $emptyStars = 10 - $fullStars - ($halfStar ? 1 : 0);
                ?>
                <div class="mb-2">
                  <?php for ($i = 0; $i < $fullStars; $i++): ?>
                    <i class="fa-solid fa-star text-warning"></i>
                  <?php endfor; ?>
                  <?php if ($halfStar): ?>
                    <i class="fa-regular fa-star-half-stroke text-warning"></i>
                  <?php endif; ?>
                  <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                    <i class="fa-regular fa-star text-warning"></i>
                  <?php endfor; ?>
                  <span class="text-muted small ms-1">(<?= number_format($star, 1) ?>/10)</span>
                </div>

                <p class="text-muted small mb-3"><?= htmlspecialchars($news['summary']) ?></p>

                <div class="mt-auto">
                  <a href="/news/<?= $news['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    Xem chi tiết →
                  </a>
                </div>
              </div>

              <div class="card-footer bg-light text-muted small py-2 px-3">
                👤 <?= htmlspecialchars($news['full_name'] ?? 'Không rõ tác giả') ?>
                <span class="float-end">
                  🕒 <?= date('d/m/Y', strtotime($news['published_at'] ?? $news['created_at'])) ?>
                </span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- PAGINATION -->
      <?php if ($pagination['total_pages'] > 1): ?>
        <nav class="mt-5">
          <ul class="pagination justify-content-center mb-0">
            <?php
            $total = $pagination['total_pages'];
            $current = $pagination['current_page'];
            $range = 2;
            $start = max(1, $current - $range);
            $end = min($total, $current + $range);
            $query = http_build_query(['search' => $keyword, 'sort' => $sort]);
            ?>

            <!-- Prev -->
            <?php if ($current > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?<?= $query ?>&page=<?= $current - 1 ?>">‹</a>
              </li>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
              <li class="page-item <?= $i == $current ? 'active' : '' ?>">
                <a class="page-link" href="?<?= $query ?>&page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>

            <!-- Next -->
            <?php if ($current < $total): ?>
              <li class="page-item">
                <a class="page-link" href="?<?= $query ?>&page=<?= $current + 1 ?>">›</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<style>
  .hover-shadow:hover {
    transform: translateY(-3px);
    transition: all 0.25s ease;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  }
</style>