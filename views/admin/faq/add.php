<h1 class="text-white mb-4"><?= $page_title ?></h1>

<form method="POST" action="/cms/faq/add">

    <div class="mb-3">
        <label class="text-white">Câu hỏi</label>
        <input type="text" name="question" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="text-white">Trả lời</label>
        <textarea id="editor" name="answer"></textarea>
    </div>

    <div class="mb-3">
        <label class="text-white">Thứ tự hiển thị</label>
        <input type="number" name="ordering" class="form-control" value="0" min="0">
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_active" checked>
        <label class="form-check-label text-white">Hiển thị</label>
    </div>

    <button class="btn btn-success">Thêm FAQ</button>
</form>

<script>
    $('#editor').summernote({
        height: 200,
        placeholder: 'Nhập câu trả lời...'
    });
</script>