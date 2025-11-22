<h1 class="text-white mb-4"><?= $page_title ?></h1>

<form method="POST" action="/cms/faq/add">

    <!-- Câu hỏi -->
    <div class="mb-3">
        <label class="text-white fw-bold">Câu hỏi</label>
        <textarea id="question_editor" name="question"></textarea>
    </div>

    <!-- Trả lời -->
    <div class="mb-3">
        <label class="text-white fw-bold">Trả lời</label>
        <textarea id="answer_editor" name="answer"></textarea>
    </div>

    <!-- Thứ tự -->
    <div class="mb-3">
        <label class="text-white fw-bold">Thứ tự hiển thị</label>
        <input type="number" name="ordering" class="form-control" value="0" min="0">
    </div>

    <!-- Hiển thị -->
    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="is_active" checked>
        <label class="form-check-label text-white">Hiển thị</label>
    </div>

    <button class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Thêm FAQ
    </button>

</form>

<script>
    $('#question_editor').summernote({
        height: 150,
        placeholder: 'Nhập nội dung câu hỏi...'
    });

    $('#answer_editor').summernote({
        height: 200,
        placeholder: 'Nhập nội dung câu trả lời...'
    });
</script>