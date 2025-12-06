<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
  <div class="row g-2 align-items-center">
    <div class="col">
      <h2 class="page-title"><?php echo $pageTitle; ?></h2>
    </div>
    <div class="col-auto ms-auto">
      <a href="<?php echo BASE_URL; ?>/cms/faq" class="btn btn-secondary me-2">
        <i class="ti ti-arrow-left"></i> Quay lại
      </a>
      <a href="<?php echo BASE_URL; ?>/cms/faq/static/add" class="btn btn-primary">
        <i class="ti ti-plus"></i> Thêm FAQ
      </a>
    </div>
  </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    <div class="d-flex">
      <div><i class="ti ti-check icon alert-icon"></i></div>
      <div><?php echo $_SESSION['success'];
      unset($_SESSION['success']); ?></div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Danh sách FAQ tĩnh</h3>
      </div>
      <div class="table-responsive">

        <table class="table table-vcenter card-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Câu hỏi</th>
              <th>Thể loại</th>
              <th>Thứ tự</th>
              <th>Trạng thái</th>
              <th class="w-1"></th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($data)): ?>
              <tr>
                <td colspan="6" class="text-center py-5">
                  <div class="empty">
                    <div class="empty-icon">
                      <i class="ti ti-file-text"></i>
                    </div>
                    <p class="empty-title">Chưa có FAQ nào</p>
                    <div class="empty-action">
                      <a href="<?php echo BASE_URL; ?>/cms/faq/static/add" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Thêm FAQ đầu tiên
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($data as $faq): ?>
                <tr>
                  <td><?php echo $faq['id']; ?></td>
                  <td><?php echo strip_tags($faq['question']); ?></td>
                  <td>
                    <?php if (!empty($faq['category_name'])): ?>
                      <div class="d-flex align-items-center gap-2">
                        <div
                          style="width: 14px; height: 14px; border-radius: 3px; background-color: <?php echo $faq['category_color']; ?>;">
                        </div>
                        <span><?php echo escape($faq['category_name']); ?></span>
                      </div>
                    <?php else: ?>
                      <span class="text-muted">Không có</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo $faq['ordering']; ?></td>
                  <td>
                    <?php if ($faq['is_active']): ?>
                      <span class="badge bg-success">Hiển thị</span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Ẩn</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="btn-list flex-nowrap justify-content-end">
                      <a href="<?php echo BASE_URL; ?>/cms/faq/static/edit/<?php echo $faq['id']; ?>"
                        class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                        <i class="ti ti-edit"></i>
                        <span>Sửa</span>
                      </a>
                      <form method="POST" action="<?php echo BASE_URL; ?>/cms/faq/static/delete/<?php echo $faq['id']; ?>"
                        class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa FAQ này?')">
                        <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1">
                          <i class="ti ti-trash"></i>
                          <span>Xóa</span>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

        <div class="card-footer d-flex align-items-center justify-content-between">
          <p class="m-0 text-muted">
            Trang <?php echo $page; ?> / <?php echo $totalPages; ?>
          </p>
          <ul class="pagination m-0">
            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">
                  <i class="ti ti-chevron-left"></i> Trước
                </a>
              </li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link"><i class="ti ti-chevron-left"></i> Trước</span></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                  Sau <i class="ti ti-chevron-right"></i>
                </a>
              </li>
            <?php else: ?>
              <li class="page-item disabled"><span class="page-link">Sau <i class="ti ti-chevron-right"></i></span></li>
            <?php endif; ?>
          </ul>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>