<div class="page-header d-print-none mb-4">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title"><?= htmlspecialchars($page_title ?? 'Tin tức & Cập nhật'); ?></h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= BASE_URL; ?>/cms/news/add" class="btn btn-primary d-inline-flex align-items-center gap-1">
        <i class="ti ti-plus"></i> <span>Thêm tin tức</span>
      </a>
    </div>
  </div>
</div>

<!-- FORM TÌM KIẾM & LỌC -->
<form method="GET" class="row g-2 align-items-center mb-4">
  <div class="col-md-5">
    <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($keyword ?? '') ?>"
      placeholder="🔍 Tìm kiếm bài viết...">
  </div>

  <div class="col-md-3">
    <select name="sort" class="form-select" onchange="this.form.submit()">
      <option value="newest" <?= ($sort ?? '') === 'newest' ? 'selected' : '' ?>>🕒 Mới nhất</option>
      <option value="oldest" <?= ($sort ?? '') === 'oldest' ? 'selected' : '' ?>>📜 Cũ nhất</option>
      <option value="star_desc" <?= ($sort ?? '') === 'star_desc' ? 'selected' : '' ?>>⭐ Sao cao → thấp</option>
      <option value="star_asc" <?= ($sort ?? '') === 'star_asc' ? 'selected' : '' ?>>⭐ Sao thấp → cao</option>
    </select>
  </div>

  <div class="col-md-2">
    <button type="submit" class="btn btn-primary w-100">
      <i class="ti ti-search me-1"></i> Lọc kết quả
    </button>
  </div>

  <div class="col-md-2">
    <a href="<?= BASE_URL; ?>/cms/news" class="btn btn-outline-secondary w-100">
      <i class="ti ti-refresh me-1"></i> Làm mới
    </a>
  </div>
</form>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Danh sách tin tức</h3>
  </div>

  <div class="table-responsive">
    <table class="table table-vcenter card-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tiêu đề</th>
          <th>Tác giả</th>
          <th>Ngày tạo</th>
          <th>⭐ Đánh giá</th>
          <th>Lượt đánh giá</th>
          <th>Trạng thái</th>
          <th class="w-1"></th>
        </tr>
      </thead>
      <tbody>
        <?php $newsList = $pagination['data'] ?? []; ?>

        <?php if (empty($newsList)): ?>
          <tr>
            <td colspan="9" class="text-center py-5">
              <div class="empty">
                <div class="empty-icon mb-2"><i class="ti ti-news fs-1"></i></div>
                <p class="empty-title fw-semibold">Chưa có tin tức nào</p>
                <p class="empty-subtitle text-muted">
                  <a href="<?= BASE_URL; ?>/cms/news/add">Thêm tin tức đầu tiên</a>
                </p>
              </div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($newsList as $news): ?>
            <tr>
              <td><?= (int) $news['id']; ?></td>
              <td>
                <a href="<?= BASE_URL; ?>/cms/news/edit/<?= (int) $news['id']; ?>" class="text-reset fw-semibold">
                  <?= htmlspecialchars($news['title']); ?>
                </a>
              </td>
              <td><?= htmlspecialchars($news['full_name'] ?? 'Admin'); ?></td>
              <td><?= date('d/m/Y', strtotime($news['created_at'])); ?></td>

              <!-- ⭐ TRUNG BÌNH SAO -->
              <td>
                <?php if (!empty($news['avg_rating'])): ?>
                  <?= number_format($news['avg_rating'], 1); ?> ⭐
                <?php else: ?>
                  <span class="text-muted">—</span>
                <?php endif; ?>
              </td>

              <!-- 💬 SỐ LƯỢT ĐÁNH GIÁ -->
              <td>
                <?= (int) ($news['rating_count'] ?? 0); ?>
              </td>

              <!-- TRẠNG THÁI -->
              <td>
                <span class="badge <?= $news['is_published'] ? 'bg-success' : 'bg-secondary'; ?>">
                  <?= $news['is_published'] ? 'Đã xuất bản' : 'Nháp'; ?>
                </span>
              </td>

              <!-- ACTION -->
              <td>
                <div class="btn-list flex-nowrap justify-content-end">
                  <a href="<?= BASE_URL; ?>/cms/news/edit/<?= (int) $news['id']; ?>"
                    class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                    <i class="ti ti-edit"></i><span>Sửa</span>
                  </a>
                  <form method="POST" action="<?= BASE_URL; ?>/cms/news/delete/<?= (int) $news['id']; ?>"
                    onsubmit="return confirm('Bạn có chắc muốn xóa tin này?');" style="display:inline;">
                    <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1">
                      <i class="ti ti-trash"></i><span>Xóa</span>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- PHÂN TRANG -->
  <?php if (!empty($newsList) && ($pagination['total_pages'] ?? 0) > 1): ?>
    <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-muted">
        Hiển thị
        <?= ($pagination['current_page'] - 1) * $pagination['per_page'] + 1; ?> –
        <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']); ?>
        trong tổng số <?= $pagination['total']; ?> tin tức
      </p>
      <ul class="pagination m-0 ms-auto">
        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
          <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : ''; ?>">
            <a class="page-link"
              href="?page=<?= $i; ?>&search=<?= urlencode($keyword ?? ''); ?>&sort=<?= urlencode($sort ?? ''); ?>">
              <?= $i; ?>
            </a>
          </li>
        <?php endfor; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>