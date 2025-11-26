<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title"><?php echo $pageTitle; ?></h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="<?php echo BASE_URL; ?>/cms/news" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <form method="POST" action="<?php echo BASE_URL; ?>/cms/news/edit/<?php echo $news['id']; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin tin tức</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="ti ti-alert-circle icon alert-icon"></i>
                                </div>
                                <div>
                                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label required">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" id="title" required
                                       value="<?php echo isset($_SESSION['old']['title']) ? escape($_SESSION['old']['title']) : escape($news['title']); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tóm tắt</label>
                                <textarea class="form-control" name="summary" rows="3"><?php echo isset($_SESSION['old']['summary']) ? escape($_SESSION['old']['summary']) : escape($news['summary'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Nội dung</label>
                                <textarea class="form-control" name="content" rows="10" required><?php echo isset($_SESSION['old']['content']) ? escape($_SESSION['old']['content']) : escape($news['content']); ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Hình ảnh hiện tại</label>
                                <?php if (!empty($news['thumbnail'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo BASE_URL . '/' . $news['thumbnail']; ?>" alt="<?php echo escape($news['title']); ?>" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Chưa có hình ảnh</p>
                                <?php endif; ?>
                                <label class="form-label">Thay đổi hình ảnh</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="form-hint">Chấp nhận: JPG, PNG, GIF (tối đa 2MB)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Trạng thái</label>
                                <select class="form-select" name="status" required>
                                    <?php
                                    $isPublished = isset($_SESSION['old']['status']) ? ($_SESSION['old']['status'] === 'published') : ($news['is_published'] ?? 0);
                                    ?>
                                    <option value="draft" <?php echo !$isPublished ? 'selected' : ''; ?>>Nháp</option>
                                    <option value="published" <?php echo $isPublished ? 'selected' : ''; ?>>Công khai</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ngày xuất bản</label>
                                <?php
                                $publishedAt = isset($_SESSION['old']['published_at']) ? $_SESSION['old']['published_at'] : ($news['published_at'] ?? date('Y-m-d H:i:s'));
                                $publishedAtFormatted = date('Y-m-d\TH:i', strtotime($publishedAt));
                                ?>
                                <input type="datetime-local" class="form-control" name="published_at"
                                       value="<?php echo $publishedAtFormatted; ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted">Ngày tạo</label>
                                <p><?php echo isset($news['created_at']) ? date('d/m/Y H:i', strtotime($news['created_at'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="<?php echo BASE_URL; ?>/cms/news" class="btn btn-link">Hủy</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Cập nhật tin tức
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php
unset($_SESSION['old']);
include PATH_ROOT . '/views/admin/layouts/footer.php';
?>
