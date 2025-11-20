<?php

namespace Controllers;

use Models\UserModel;
use Views\CMSAuthView;

class CMSAuthController
{
    public function loginForm()
    {
        \Core\CMSAuth::redirectIfLoggedIn();
        $view = new \Views\CMSAuthView();
        $view->render('login', ['page_title' => 'CMS Login']);
    }

    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new UserModel();

        $user = $userModel->getOne(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        );

        if (!$user) {
            $_SESSION['cms_error'] = "Email không tồn tại!";
            header("Location: /cms/login");
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            $_SESSION['cms_error'] = "Sai mật khẩu!";
            header("Location: /cms/login");
            exit;
        }

        // check role: admin = role_id = 1
        if ($user['role_id'] != 1) {
            $_SESSION['cms_error'] = "Bạn không có quyền truy cập CMS!";
            header("Location: /cms/login");
            exit;
        }

        unset($user['password']);
        $_SESSION['cms_user'] = $user;

        header("Location: /cms");
        exit;
    }

    public function registerForm()
    {
        \Core\CMSAuth::redirectIfLoggedIn();

        $view = new \Views\CMSAuthView();
        $view->render('register', ['page_title' => 'Đăng ký CMS']);
    }

    public function registerPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $fullName = $_POST['full_name'] ?? '';

        $userModel = new UserModel();

        // kiểm tra trùng email
        $exist = $userModel->getOne(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        );

        if ($exist) {
            $_SESSION['cms_error'] = "Email đã tồn tại!";
            header("Location: /cms/register");
            exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        // tạo admin CMS
        $userModel->insert("users", [
            'email' => $email,
            'password' => $hash,
            'full_name' => $fullName,
            'role_id' => 1
        ]);

        $_SESSION['cms_success'] = "Tạo tài khoản CMS thành công!";
        header("Location: /cms/login");
        exit;
    }

    public function logout()
    {
        unset($_SESSION['cms_user']);
        header("Location: /cms/login");
        exit;
    }
}
