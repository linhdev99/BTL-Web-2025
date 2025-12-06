<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <div class="btn-list">
                <a href="<?php echo BASE_URL; ?>/cms/contacts" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Quay lại
                </a>
                <form method="POST" action="<?php echo BASE_URL; ?>/cms/contacts/<?php echo $contact['id']; ?>/delete" style="display: inline;">
                    <button type="submit" class="btn btn-danger delete-confirm">
                        <i class="ti ti-trash"></i> Xóa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Flash Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php echo escape($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php echo escape($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Nội dung liên hệ</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Chủ đề:</strong><br>
                    <h4><?php echo escape($contact['subject'] ?? 'N/A'); ?></h4>
                </div>

                <div class="mb-3">
                    <strong>Nội dung:</strong>
                    <div class="mt-2 p-3 bg-light rounded">
                        <?php echo nl2br(escape($contact['message'])); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Reply Section -->
        <?php if (!empty($contact['admin_reply'])): ?>
        <div class="card mb-3">
            <div class="card-header bg-success-lt">
                <h3 class="card-title">Phản hồi của bạn</h3>
            </div>
            <div class="card-body">
                <div class="p-3 bg-light rounded">
                    <?php echo nl2br(escape($contact['admin_reply'])); ?>
                </div>
                <?php if (!empty($contact['replied_at'])): ?>
                <small class="text-muted">Phản hồi lúc: <?php echo date('d/m/Y H:i:s', strtotime($contact['replied_at'])); ?></small>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thêm phản hồi</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>/cms/contacts/<?php echo $contact['id']; ?>/add-reply">
                    <div class="mb-3">
                        <label class="form-label required">Nội dung phản hồi</label>
                        <textarea class="form-control" name="admin_reply" rows="5" required placeholder="Nhập nội dung phản hồi cho khách hàng..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-send"></i> Gửi phản hồi
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Thông tin người gửi</h3>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Tên:</strong><br>
                    <?php echo escape($contact['name']); ?>
                </div>
                <div class="mb-2">
                    <strong>Email:</strong><br>
                    <a href="mailto:<?php echo escape($contact['email']); ?>">
                        <?php echo escape($contact['email']); ?>
                    </a>
                </div>
                <?php if (!empty($contact['phone'])): ?>
                <div class="mb-2">
                    <strong>Điện thoại:</strong><br>
                    <a href="tel:<?php echo escape($contact['phone']); ?>">
                        <?php echo escape($contact['phone']); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông tin khác</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Trạng thái:</strong><br>
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
                </div>
                <div class="mb-2">
                    <strong>Ngày gửi:</strong><br>
                    <?php echo date('d/m/Y H:i:s', strtotime($contact['created_at'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
