<?php

namespace Core;

class Auth
{
    /**
     * Yêu cầu bắt buộc đăng nhập mới được vào trang.
     */
    public static function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    /**
     * Yêu cầu bắt buộc đăng nhập admin mới được vào trang.
     */
    public static function requireAdmin(): void
    {
        if (!self::isAdmin()) {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    /**
     * Yêu cầu bắt buộc đăng nhập admin or staff mới được vào trang.
     */
    public static function requireAdminOrStaff(): void
    {
        if (!self::isAdminOrStaff()) {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    /**
     * Cho phép user truy cập tự do, trả về user nếu có login.
     */
    public static function optionalUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Nếu đã login thì không cho vào trang login/register nữa.
     */
    public static function redirectIfLoggedIn(): void
    {
        if (!empty($_SESSION['user'])) {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    /**
     * Kiểm tra role theo role_id
     * 1 = admin, 2 = employee, 3 = user
     */
    public static function isAdmin(): bool
    {
        return !empty($_SESSION['user']) && $_SESSION['user']['role_id'] == 1;
    }

    public static function isStaff(): bool
    {
        return !empty($_SESSION['user']) && $_SESSION['user']['role_id'] == 2;
    }

    public static function isUser(): bool
    {
        return !empty($_SESSION['user']) && $_SESSION['user']['role_id'] == 3;
    }

    /**
     * Cho phép admin hoặc nhân viên
     */
    public static function isAdminOrStaff(): bool
    {
        return !empty($_SESSION['user']) && in_array($_SESSION['user']['role_id'], [1, 2]);
    }
}
