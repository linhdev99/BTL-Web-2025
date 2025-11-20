<?php

use Models\UserModel;

// ===============================
// 1. Kiểm tra session timeout
// ===============================

if (!isset($_SESSION['lastTimeStartSession'])) {
    $_SESSION['lastTimeStartSession'] = time();
}

if (time() - $_SESSION['lastTimeStartSession'] > $session_time) {
    session_unset();
    session_destroy();

    // xoá cookie remember me
    setcookie('userRememberToken', '', time() - 3600, '/');
    setcookie('username', '', time() - 3600, '/');
    return;
}

// ===============================
// 2. Tự động login từ cookie
// ===============================

if (!empty($_COOKIE['username']) && !empty($_COOKIE['userRememberToken'])) {

    $userModel = new UserModel();

    // sử dụng query trong BaseModel
    $user = $userModel->getOne(
        "SELECT * FROM User WHERE username = :u AND rememberToken = :t",
        [
            "u" => $_COOKIE['username'],
            "t" => $_COOKIE['userRememberToken']
        ]
    );

    // Nếu token sai → xoá cookie
    if (!$user) {
        unset($_SESSION['user']);
        setcookie('userRememberToken', '', time() - 3600, '/');
        setcookie('username', '', time() - 3600, '/');
        return;
    }

    // set session user
    unset($user['password']);
    $_SESSION['user'] = $user;
    $_SESSION['isRemembered'] = true;

    // Refresh token
    $newToken = $userModel->refreshRememberToken($user['username']);

    // ===============================
    // 3. Set cookie bảo mật
    // ===============================
    setcookie(
        'userRememberToken',
        $newToken,
        [
            "expires" => time() + (30 * 24 * 60 * 60), // 30 ngày
            "path" => "/",
            "secure" => isset($_SERVER['HTTPS']),  // HTTPS thì bật secure
            "httponly" => true,                      // chống XSS
            "samesite" => "Lax"
        ]
    );

    setcookie(
        'username',
        $user['username'],
        [
            "expires" => time() + (30 * 24 * 60 * 60),
            "path" => "/",
            "secure" => isset($_SERVER['HTTPS']),
            "httponly" => false,    // username có thể giữ httponly = false
            "samesite" => "Lax"
        ]
    );

    // update lại thời gian session
    $_SESSION['lastTimeStartSession'] = time();
}
