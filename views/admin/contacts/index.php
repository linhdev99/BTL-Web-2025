<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
    </div>
</div>

<!-- Status Filter -->
<div class="row mb-3">
    <div class="col-12">
        <div class="btn-list">
            <a href="<?php echo BASE_URL; ?>/cms/contacts" class="btn <?php echo !$currentStatus ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Tất cả
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/contacts?status=unread" class="btn <?php echo $currentStatus == 'unread' ? 'btn-warning' : 'btn-outline-warning'; ?>">
                Chưa đọc
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/contacts?status=read" class="btn <?php echo $currentStatus == 'read' ? 'btn-info' : 'btn-outline-info'; ?>">
                Đã đọc
            </a>
            <a href="<?php echo BASE_URL; ?>/cms/contacts?status=replied" class="btn <?php echo $currentStatus == 'replied' ? 'btn-success' : 'btn-outline-success'; ?>">
                Đã phản hồi
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách liên hệ</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Chủ đề</th>
                            <th>Trạng thái</th>
                            <th>Ngày gửi</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($contacts)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-mail"></i>
                                    </div>
                                    <p class="empty-title">Chưa có liên hệ nào</p>
                                    <p class="empty-subtitle text-muted">
                                        Các liên hệ từ khách hàng sẽ hiển thị ở đây
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($contacts as $contact): ?>
                            <tr class="<?php echo empty($contact['is_read']) ? 'table-active' : ''; ?>">
                                <td><?php echo $contact['id']; ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/cms/contacts/<?php echo $contact['id']; ?>" class="text-reset">
                                        <?php echo escape($contact['name']); ?>
                                    </a>
                                </td>
                                <td><?php echo escape($contact['email']); ?></td>
                                <td>
                                    <?php
                                    $subject = $contact['subject'] ?? 'N/A';
                                    echo escape(strlen($subject) > 50 ? substr($subject, 0, 50) . '...' : $subject);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $status = $contact['status'] ?? 'unread';
                                    if ($status === 'replied') {
                                        $statusClass = 'success';
                                        $statusText = 'Đã phản hồi';
                                    } elseif ($status === 'read') {
                                        $statusClass = 'info';
                                        $statusText = 'Đã đọc';
                                    } else {
                                        $statusClass = 'warning';
                                        $statusText = 'Chưa đọc';
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($contact['created_at'])); ?></td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="<?php echo BASE_URL; ?>/cms/contacts/<?php echo $contact['id']; ?>" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                                            <i class="ti ti-eye"></i>
                                            <span>Xem</span>
                                        </a>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/cms/contacts/<?php echo $contact['id']; ?>/toggle-read" style="display: inline;">
                                            <button type="submit" class="btn btn-sm btn-<?php echo $contact['is_read'] ? 'warning' : 'info'; ?> d-inline-flex align-items-center gap-1" title="<?php echo $contact['is_read'] ? 'Đánh dấu chưa đọc' : 'Đánh dấu đã đọc'; ?>">
                                                <i class="ti ti-<?php echo $contact['is_read'] ? 'mail' : 'mail-opened'; ?>"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="<?php echo BASE_URL; ?>/cms/contacts/<?php echo $contact['id']; ?>/delete" style="display: inline;">
                                            <button type="submit" class="btn btn-sm btn-danger delete-confirm d-inline-flex align-items-center gap-1">
                                                <i class="ti ti-trash"></i>
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
            <?php if (!empty($contacts) && $pagination['total_pages'] > 1): ?>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">
                    Hiển thị <?php echo ($pagination['current_page'] - 1) * $pagination['per_page'] + 1; ?>
                    đến <?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total']); ?>
                    trong tổng số <?php echo $pagination['total']; ?> liên hệ
                </p>
                <ul class="pagination m-0 ms-auto">
                    <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo $currentStatus ? '&status=' . urlencode($currentStatus) : ''; ?>">
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
