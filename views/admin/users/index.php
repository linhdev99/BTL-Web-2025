<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/admin/users.php" class="btn btn-primary">
                <i class="ti ti-external-link"></i> Quản lý Users (Admin cũ)
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách người dùng</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <p class="empty-title">Chưa có người dùng nào</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2"><?php echo strtoupper(substr($user['name'], 0, 1)); ?></div>
                                        <div><?php echo escape($user['name']); ?></div>
                                    </div>
                                </td>
                                <td><?php echo escape($user['email']); ?></td>
                                <td>
                                    <?php
                                    $roleClass = 'secondary';
                                    $roleName = 'User';
                                    if (isset($user['role_id'])) {
                                        if ($user['role_id'] == 1) {
                                            $roleClass = 'danger';
                                            $roleName = 'Admin';
                                        } elseif ($user['role_id'] == 2) {
                                            $roleClass = 'warning';
                                            $roleName = 'Staff';
                                        }
                                    } elseif (isset($user['role'])) {
                                        // Fallback to old 'role' field
                                        if ($user['role'] == 'admin') {
                                            $roleClass = 'danger';
                                            $roleName = 'Admin';
                                        } elseif ($user['role'] == 'staff') {
                                            $roleClass = 'warning';
                                            $roleName = 'Staff';
                                        }
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $roleClass; ?>"><?php echo $roleName; ?></span>
                                </td>
                                <td>
                                    <?php
                                    $status = $user['status'] ?? 'active';
                                    $statusClass = $status == 'active' ? 'success' : 'secondary';
                                    ?>
                                    <span class="badge bg-<?php echo $statusClass; ?>"><?php echo ucfirst($status); ?></span>
                                </td>
                                <td><?php echo isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'N/A'; ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin/users.php?edit=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
