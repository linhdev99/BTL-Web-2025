<?php

namespace Core;

class Auth
{
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
        if (isset($_SESSION['user'])) {
            header("Location: /home");
            exit;
        }
    }
}
