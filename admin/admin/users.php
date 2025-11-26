<?php
require_once '../config/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Quản lý Người dùng';

// Initialize model
$userModel = new User();

// Get filter parameters
$keyword = isset($_GET['keyword']) ? sanitize($_GET['keyword']) : '';
$role = isset($_GET['role']) ? sanitize($_GET['role']) : '';
$status = isset($_GET['status']) ? sanitize($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;

// Build where conditions
$where = [];
$params = [];

if ($keyword) {
    $where[] = "(username LIKE :keyword OR email LIKE :keyword OR full_name LIKE :keyword)";
    $params['keyword'] = '%' . $keyword . '%';
}

if ($role) {
    $where[] = "role = :role";
    $params['role'] = $role;
}

if ($status) {
    $where[] = "status = :status";
    $params['status'] = $status;
}

$whereClause = !empty($where) ? implode(' AND ', $where) : '';

// Get users
$result = $userModel->paginate($page, $perPage, $whereClause, $params, 'created_at DESC');
$users = $result['data'];
$totalPages = $result['total_pages'];
$totalUsers = $result['total'];

// Get statistics
$stats = [
    'total' => $userModel->count(),
    'admin' => $userModel->count('role = "admin"'),
    'member' => $userModel->count('role = "member"'),
    'active' => $userModel->count('status = "active"'),
    'banned' => $userModel->count('status = "banned"')
];

include 'layouts/header.php';
?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">Quản lý Người dùng</h2>
            <div class="text-muted mt-1">Tổng cộng <?php echo $totalUsers; ?> người dùng</div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-3">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="subheader">Tổng người dùng</div>
                <div class="h1 mb-0"><?php echo $stats['total']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="subheader">Admin</div>
                <div class="h1 mb-0 text-blue"><?php echo $stats['admin']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="subheader">Thành viên</div>
                <div class="h1 mb-0 text-success"><?php echo $stats['member']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="subheader">Bị chặn</div>
                <div class="h1 mb-0 text-danger"><?php echo $stats['banned']; ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="" class="row g-2">
            <div class="col-md-4">
                <input type="text"
                       class="form-control"
                       name="keyword"
                       placeholder="Tìm kiếm theo tên, email, username..."
                       value="<?php echo escape($keyword); ?>">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="role">
                    <option value="">Tất cả vai trò</option>
                    <option value="admin" <?php echo $role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="member" <?php echo $role === 'member' ? 'selected' : ''; ?>>Member</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="status">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="banned" <?php echo $status === 'banned' ? 'selected' : ''; ?>>Banned</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-search"></i> Tìm kiếm
                </button>
                <a href="<?php echo ADMIN_URL; ?>/users.php" class="btn btn-outline-secondary">
                    <i class="ti ti-refresh"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="ti ti-users-off" style="font-size: 48px;"></i>
                            <div class="mt-2">Không tìm thấy người dùng nào</div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td>
                                <div class="fw-bold"><?php echo escape($user['username']); ?></div>
                            </td>
                            <td><?php echo escape($user['full_name']); ?></td>
                            <td><?php echo escape($user['email']); ?></td>
                            <td>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="badge bg-blue">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Member</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($user['status'] === 'active'): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Banned</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo formatDateTime($user['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="card-footer">
            <?php
            $queryParams = $_GET;
            echo generatePagination($page, $totalPages, ADMIN_URL . '/users.php', $queryParams);
            ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'layouts/footer.php'; ?>
