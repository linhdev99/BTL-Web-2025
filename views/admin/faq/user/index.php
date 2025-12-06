<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title"><?= $pageTitle; ?></h2>
      <div class="text-muted mt-1">Tổng số: <?= $total ?? count($questions); ?> câu hỏi</div>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?= BASE_URL; ?>/cms/faq" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Quay lại
      </a>
    </div>
  </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    <div class="d-flex">
      <div><i class="ti ti-check icon alert-icon"></i></div>
      <div><?= $_SESSION['success'];
      unset($_SESSION['success']); ?></div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
  </div>
<?php endif; ?>


<!-- Lọc dữ liệu -->
<div class="row mb-3">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <form method="GET" action="<?= BASE_URL; ?>/cms/faq/user">
          <div class="row g-2 align-items-center">

            <!-- Tìm kiếm -->
            <div class="col-md-3">
              <input type="text" name="keyword" class="form-control" placeholder="Tìm câu hỏi hoặc người hỏi..."
                value="<?= htmlspecialchars($keyword ?? ''); ?>">
            </div>

            <!-- Thể loại -->
            <div class="col-md-3">
              <?php
              // Gom các thể loại duy nhất từ danh sách câu hỏi
              $uniqueCategories = [];
              foreach ($questions as $q) {
                if (!empty($q['category_id']) && !isset($uniqueCategories[$q['category_id']])) {
                  $uniqueCategories[$q['category_id']] = [
                    'id' => $q['category_id'],
                    'name' => $q['category_name'],
                  ];
                }
              }
              ?>
              <select name="category_id" class="form-select">
                <option value="">Tất cả thể loại</option>
                <?php foreach ($uniqueCategories as $cat): ?>
                  <option value="<?= $cat['id']; ?>" <?= ($category_id == $cat['id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($cat['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Trạng thái -->
            <div class="col-md-3">
              <select name="status" class="form-select">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" <?= in_array('pending', $status ?? []) ? 'selected' : ''; ?>>Chờ trả lời</option>
                <option value="answered" <?= in_array('answered', $status ?? []) ? 'selected' : ''; ?>>Đã trả lời
                </option>
                <option value="closed" <?= in_array('closed', $status ?? []) ? 'selected' : ''; ?>>Đã đóng</option>
              </select>
            </div>

            <!-- Sắp xếp -->
            <div class="col-md-2">
              <select name="sort" class="form-select">
                <option value="newest" <?= $sort === 'newest' ? 'selected' : ''; ?>>Mới nhất</option>
                <option value="oldest" <?= $sort === 'oldest' ? 'selected' : ''; ?>>Cũ nhất</option>
                <option value="views" <?= $sort === 'views' ? 'selected' : ''; ?>>Nhiều lượt xem</option>
              </select>
            </div>

            <!-- Nút lọc -->
            <div class="col-md-3 col-lg-2 d-flex justify-content-end gap-2">
              <button type="submit" class="btn btn-primary flex-fill">
                <i class="ti ti-filter me-1"></i> Lọc
              </button>
              <a href="<?= BASE_URL; ?>/cms/faq/user" class="btn btn-secondary flex-fill">
                <i class="ti ti-refresh me-1"></i> Làm mới
              </a>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Danh sách câu hỏi -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="ti ti-help"></i> Danh sách câu hỏi người dùng</h3>
  </div>

  <div class="table-responsive">
    <table class="table table-vcenter card-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Người hỏi</th>
          <th>Câu hỏi</th>
          <th>Thể loại</th>
          <th>Lượt xem</th>
          <th>Trạng thái</th>
          <th>Ngày tạo</th>
          <th class="w-1"></th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($questions)): ?>
          <tr>
            <td colspan="8" class="text-center py-5">
              <div class="empty">
                <div class="empty-icon"><i class="ti ti-message-question"></i></div>
                <p class="empty-title">Chưa có câu hỏi nào</p>
                <p class="empty-subtitle text-muted">Người dùng chưa gửi câu hỏi nào.</p>
              </div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($questions as $q): ?>
            <tr>
              <td><?= $q['id']; ?></td>

              <!-- Người hỏi -->
              <td>
                <div class="d-flex align-items-center">
                  <span class="avatar avatar-sm me-2">
                    <?= strtoupper(substr($q['full_name'] ?? 'U', 0, 1)); ?>
                  </span>
                  <div><?= htmlspecialchars($q['full_name'] ?? 'User #' . $q['user_id']); ?></div>
                </div>
              </td>

              <!-- Nội dung câu hỏi -->
              <td>
                <div class="text-truncate" style="max-width: 300px;">
                  <?= htmlspecialchars(strip_tags($q['question'])); ?>
                </div>
              </td>

              <!-- Thể loại -->
              <td>
                <?php if (!empty($q['category_name'])): ?>
                  <span class="badge" style="background-color: <?= htmlspecialchars($q['category_color'] ?? '#888'); ?>;">
                    <?= htmlspecialchars($q['category_name']); ?>
                  </span>
                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </td>

              <!-- Lượt xem -->
              <td>
                <span class="badge badge-outline text-muted">
                  <i class="ti ti-eye"></i> <?= $q['views']; ?>
                </span>
              </td>

              <!-- Trạng thái -->
              <td>
                <?php if ($q['status'] === 'pending'): ?>
                  <span class="badge bg-yellow">Chờ trả lời</span>
                <?php elseif ($q['status'] === 'answered'): ?>
                  <span class="badge bg-green">Đã trả lời</span>
                <?php else: ?>
                  <span class="badge bg-secondary">Đã đóng</span>
                <?php endif; ?>
              </td>

              <!-- Thời gian -->
              <td><span class="text-muted"><?= date('d/m/Y H:i', strtotime($q['created_at'])); ?></span></td>

              <!-- Hành động -->
              <td>
                <div class="btn-list flex-nowrap justify-content-end">
                  <a href="<?= BASE_URL; ?>/cms/faq/user/detail/<?= $q['id']; ?>" class="btn btn-sm btn-primary">
                    <i class="ti ti-eye"></i> Xem
                  </a>
                  <form method="POST" action="<?= BASE_URL; ?>/cms/faq/user/delete/<?= $q['id']; ?>" class="d-inline"
                    onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?');">
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="ti ti-trash"></i> Xóa
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

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-muted">Trang <?= $page; ?> / <?= $totalPages; ?></p>
      <ul class="pagination m-0 ms-auto">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">
              <i class="ti ti-chevron-left"></i> Trước
            </a>
          </li>
        <?php endif; ?>

        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])); ?>">
              <?= $i; ?>
            </a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">
              Sau <i class="ti ti-chevron-right"></i>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>