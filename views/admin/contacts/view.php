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
        <div class="card">
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
                <div class="mb-2">
                    <strong>Trạng thái:</strong><br>
                    <?php
                    $status = $contact['status'] ?? 'unread';
                    $statusClass = $status == 'read' ? 'success' : 'warning';
                    $statusText = $status == 'read' ? 'Đã đọc' : 'Chưa đọc';
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
