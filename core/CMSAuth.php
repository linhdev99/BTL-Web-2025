<?php

namespace Core;

class CMSAuth
{
    /**
     * Kiểm tra xem CMS admin đã đăng nhập chưa
     */
    public static function check()
    {
        if (!isset($_SESSION['cms_user'])) {
            header("Location: /cms/login");
            exit;
        }
    }

    /**
     * Kiểm tra xem user đã đăng nhập chưa
     */
    public static function checkuser()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }

    /**
     * Nếu đã login rồi thì không cho vào trang login/register nữa
     */
    public static function redirectIfLoggedIn()
    {
        if (isset($_SESSION['cms_user'])) {
            header("Location: /cms");
            exit;
        }
    }

    /**
     * Nếu đã login rồi thì không cho vào trang login/register nữa
     */
    public static function redirectIfLoggedInForUser()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /home");
            exit;
        }
    }
}
