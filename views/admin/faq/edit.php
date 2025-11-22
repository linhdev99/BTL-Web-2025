<h1 class="text-white mb-4"><?= $page_title ?></h1>

<form method="POST" action="/cms/faq/edit/<?= $faq['id'] ?>">

    <!-- Câu hỏi -->
    <div class="mb-3">
        <label class="text-white fw-bold">Câu hỏi</label>
        <input type="text" name="question" class="form-control" value="<?= htmlspecialchars($faq['question']) ?>"
            required>
    </div>

    <!-- Trả lời -->
    <div class="mb-3">
        <label class="text-white fw-bold">Trả lời</label>
        <textarea id="editor" name="answer"><?= htmlspecialchars($faq['answer']) ?></textarea>
    </div>

    <!-- Thứ tự -->
    <div class="mb-3">
        <label class="text-white fw-bold">Thứ tự hiển thị</label>
        <input type="number" name="ordering" class="form-control" value="<?= $faq['ordering'] ?>">
    </div>

    <!-- Hiển thị -->
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" name="is_active" <?= $faq['is_active'] ? 'checked' : '' ?>>
        <label class="form-check-label text-white">Hiển thị</label>
    </div>

    <button class="btn btn-primary">
        <i class="fa-solid fa-floppy-disk"></i> Cập nhật FAQ
    </button>

    <a href="/cms/faq" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>

</form>

<script>
    $('#editor').summernote({
        height: 200,
        placeholder: 'Nhập nội dung câu trả lời...'
    });
</script>