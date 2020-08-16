<?php

namespace Caravy\User;

class AuthService
{
    private $userMiddleware;

    public function __construct(\Caravy\User\Middleware\UserMiddleware $userMiddleware)
    {
        $this->userMiddleware = $userMiddleware;
    }

    public function login($username, $password)
    {
        $user = $this->userMiddleware->findFirstModel('username', $username);
        if (empty($user)) {
            return false;
        }
        if (password_verify($password, $user->pass_hash)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_username'] = $username;
            session_regenerate_id(true);
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        session_regenerate_id(true);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_username']);
    }

    public function whoAmI()
    {
        return $_SESSION['user_username'];
    }
}
