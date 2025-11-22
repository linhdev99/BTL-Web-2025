<h1 class="text-white mb-4"><?= $page_title ?></h1>

<div class="row g-4">

    <!-- FAQ CATEGORY -->
    <div class="col-md-4">
        <a href="/cms/faq/category" class="text-decoration-none">
            <div class="card bg-dark border-secondary p-4 text-center shadow-lg faq-card">
                <h4 class="text-info mb-2">
                    <i class="fa-solid fa-list"></i> Thể loại FAQ
                </h4>
                <p class="text-white-50 mb-0">Quản lý các nhóm chủ đề FAQ</p>
            </div>
        </a>
    </div>

    <!-- FAQ STATIC -->
    <div class="col-md-4">
        <a href="/cms/faq/static" class="text-decoration-none">
            <div class="card bg-dark border-secondary p-4 text-center shadow-lg faq-card">
                <h4 class="text-warning mb-2">
                    <i class="fa-solid fa-file-lines"></i> FAQ tĩnh
                </h4>
                <p class="text-white-50 mb-0">Câu hỏi & trả lời do admin tạo</p>
            </div>
        </a>
    </div>

    <!-- FAQ USER -->
    <div class="col-md-4">
        <a href="/cms/faq/user" class="text-decoration-none">
            <div class="card bg-dark border-secondary p-4 text-center shadow-lg faq-card">
                <h4 class="text-success mb-2">
                    <i class="fa-solid fa-comments"></i> FAQ tương tác
                </h4>
                <p class="text-white-50 mb-0">Câu hỏi người dùng + bình luận</p>
            </div>
        </a>
    </div>

</div>

<style>
    .faq-card {
        transition: 0.25s ease;
        border-radius: 12px;
    }

    .faq-card:hover {
        transform: translateY(-4px);
        border-color: #0d6efd !important;
        box-shadow: 0 0 12px rgba(13, 110, 253, 0.6) !important;
    }
</style>