<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/news/add" class="btn btn-primary">
                <i class="ti ti-plus"></i> Thêm tin tức
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
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
                            <th>Trạng thái</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($newsList)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-news"></i>
                                    </div>
                                    <p class="empty-title">Chưa có tin tức nào</p>
                                    <p class="empty-subtitle text-muted">
                                        <a href="<?php echo BASE_URL; ?>/cms/news/add">Thêm tin tức đầu tiên</a>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($newsList as $news): ?>
                            <tr>
                                <td><?php echo $news['id']; ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/cms/news/edit/<?php echo $news['id']; ?>" class="text-reset">
                                        <?php echo escape($news['title']); ?>
                                    </a>
                                </td>
                                <td><?php echo 'Admin'; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($news['created_at'])); ?></td>
                                <td>
                                    <span class="badge <?php echo $news['is_published'] ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo $news['is_published'] ? 'Đã xuất bản' : 'Nháp'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap justify-content-end">
                                        <a href="<?php echo BASE_URL; ?>/cms/news/edit/<?php echo $news['id']; ?>" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                            <i class="ti ti-edit"></i>
                                            <span>Sửa</span>
                                        </a>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/cms/news/delete/<?php echo $news['id']; ?>" style="display: inline;">
                                            <button type="submit" class="btn btn-sm btn-danger delete-confirm d-inline-flex align-items-center gap-1">
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

            <!-- Pagination -->
            <?php if (!empty($newsList) && isset($pagination['total_pages']) && $pagination['total_pages'] > 1): ?>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">
                    Hiển thị <?php echo ($pagination['current_page'] - 1) * $pagination['per_page'] + 1; ?>
                    đến <?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total']); ?>
                    trong tổng số <?php echo $pagination['total']; ?> tin tức
                </p>
                <ul class="pagination m-0 ms-auto">
                    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
