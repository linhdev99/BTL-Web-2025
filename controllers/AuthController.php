<?php

namespace Controllers;

use Models\UserModel;
use Views\AuthView;
use Core\Auth;

class AuthController
{
    public function loginForm()
    {
        Auth::redirectIfLoggedIn();
        $view = new AuthView();
        $view->render('login', [
            'page_title' => 'Login'
        ]);
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
            $_SESSION['error'] = "Email không tồn tại!";
            header("Location: /login");
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Sai mật khẩu!";
            header("Location: /login");
            exit;
        }

        unset($user['password']);
        $_SESSION['user'] = $user;

        header("Location: /");
        exit;
    }

    public function registerForm()
    {
        Auth::redirectIfLoggedIn();
        $view = new AuthView();
        $view->render('register', [
            'page_title' => 'Đăng ký'
        ]);
    }

    public function registerPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $fullName = $_POST['full_name'] ?? '';

        $userModel = new UserModel();

        $exist = $userModel->getOne(
            "SELECT * FROM users WHERE email = :email",
            ['email' => $email]
        );

        if ($exist) {
            $_SESSION['error'] = "Email đã tồn tại!";
            header("Location: /register");
            exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $userModel->insert("users", [
            'email' => $email,
            'password' => $hash,
            'full_name' => $fullName,
            'role_id' => 3
        ]);

        $_SESSION['success'] = "Tạo tài khoản thành công!";
        header("Location: /login");
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: /login");
        exit;
    }
}
