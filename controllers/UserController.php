<?php

namespace Controllers;

class UserController
{
    public function index()
    {
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/partials/sidebar.php';
        require_once __DIR__ . '/../views/users/index.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }

    public function add()
    {
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/partials/sidebar.php';
        require_once __DIR__ . '/../views/users/add.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }

    public function create()
    {
        echo "Tạo user (POST)";
    }

    public function edit($id)
    {
        require_once __DIR__ . '/../views/partials/header.php';
        require_once __DIR__ . '/../views/partials/sidebar.php';
        require_once __DIR__ . '/../views/users/edit.php';
        require_once __DIR__ . '/../views/partials/footer.php';
    }

    public function update($id)
    {
        echo "Sửa user ID = $id";
    }

    public function delete($id)
    {
        echo "Xóa user ID = $id";
    }
}
