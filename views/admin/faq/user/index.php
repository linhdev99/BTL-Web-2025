<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
            <div class="text-muted mt-1">Tổng số: <?php echo $total; ?> câu hỏi</div>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/faq" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <div class="d-flex">
            <div><i class="ti ti-check icon alert-icon"></i></div>
            <div><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
<?php endif; ?>

<!-- Filter Form -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>/cms/faq/user">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text"
                                   name="keyword"
                                   class="form-control"
                                   placeholder="Tìm kiếm câu hỏi..."
                                   value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="sort" class="form-select">
                                <option value="newest" <?php echo (($_GET['sort'] ?? 'newest') === 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                                <option value="oldest" <?php echo (($_GET['sort'] ?? '') === 'oldest') ? 'selected' : ''; ?>>Cũ nhất</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-search"></i> Lọc
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo BASE_URL; ?>/cms/faq/user" class="btn btn-secondary w-100">
                                <i class="ti ti-refresh"></i> Xóa lọc
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Questions List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách câu hỏi từ người dùng</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người hỏi</th>
                            <th>Câu hỏi</th>
                            <th>Lượt xem</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($userQuestions)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-help"></i>
                                    </div>
                                    <p class="empty-title">Chưa có câu hỏi nào</p>
                                    <p class="empty-subtitle text-muted">
                                        Người dùng chưa gửi câu hỏi nào
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($userQuestions as $q): ?>
                            <tr>
                                <td><?php echo $q['id']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm me-2">
                                            <?php echo strtoupper(substr($q['full_name'] ?? 'U', 0, 1)); ?>
                                        </span>
                                        <div>
                                            <?php echo htmlspecialchars($q['full_name'] ?? 'User #' . $q['user_id']); ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;">
                                        <?php echo htmlspecialchars(strip_tags($q['question'])); ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-outline text-muted">
                                        <i class="ti ti-eye"></i> <?php echo $q['views']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($q['status'] === 'pending'): ?>
                                        <span class="badge bg-yellow">Chờ trả lời</span>
                                    <?php elseif ($q['status'] === 'answered'): ?>
                                        <span class="badge bg-green">Đã trả lời</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Đã đóng</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?php echo date('d/m/Y H:i', strtotime($q['created_at'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap justify-content-end">
                                        <a href="<?php echo BASE_URL; ?>/cms/faq/user/detail/<?php echo $q['id']; ?>"
                                           class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                            <i class="ti ti-eye"></i>
                                            <span>Xem</span>
                                        </a>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/cms/faq/user/delete/<?php echo $q['id']; ?>" class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc muốn xóa câu hỏi này?')">
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1">
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
            </div>

            <?php if ($totalPages > 1): ?>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Trang <?php echo $page; ?> / <?php echo $totalPages; ?></p>
                <ul class="pagination m-0 ms-auto">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo !empty($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : ''; ?><?php echo !empty($_GET['sort']) ? '&sort=' . urlencode($_GET['sort']) : ''; ?>">
                            <i class="ti ti-chevron-left"></i> Trước
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : ''; ?><?php echo !empty($_GET['sort']) ? '&sort=' . urlencode($_GET['sort']) : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo !empty($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : ''; ?><?php echo !empty($_GET['sort']) ? '&sort=' . urlencode($_GET['sort']) : ''; ?>">
                            Sau <i class="ti ti-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
