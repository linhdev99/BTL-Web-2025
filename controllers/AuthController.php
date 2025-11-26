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
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Sai mật khẩu!";
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        unset($user['password']);
        $_SESSION['user'] = $user;

        // Redirect admin/staff to dashboard, regular users to homepage
        if (isset($user['role_id']) && ($user['role_id'] == 1 || $user['role_id'] == 2)) {
            header("Location: " . BASE_URL . "/cms");
        } else {
            header("Location: " . BASE_URL . "/");
        }
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
            header("Location: " . BASE_URL . "/register");
            exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $userModel->insert("users", [
            'email' => $email,
            'password' => $hash,
            'full_name' => $fullName,
            'role_id' => 3  // 1=Admin, 2=Staff, 3=User
        ]);

        $_SESSION['success'] = "Tạo tài khoản thành công!";
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}
