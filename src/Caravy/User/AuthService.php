<?php

namespace Caravy\User;

class AuthService
{
    /**
     * Instance of the user-middleware-object.
     * 
     * @var \Caravy\User\Middleware\UserMiddleware
     */
    private $userMiddleware;

    /**
     * Create a new auth-service instance.
     * 
     * @param \Caravy\User\Middleware\UserMiddleware $userMiddleware
     * @return void
     */
    public function __construct(\Caravy\User\Middleware\UserMiddleware $userMiddleware)
    {
        $this->userMiddleware = $userMiddleware;
    }

    /**
     * Verfiy user-credentials and set session-data.
     * 
     * @param string $username
     * @param string $password
     * @return bool
     */
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

    /**
     * Clear session-data.
     * 
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        session_regenerate_id(true);
    }

    /**
     * Check if the current user is logged in.
     * 
     * @return bool
     */
    public function isLoggedIn()
    {
        return isset($_SESSION['user_username']);
    }

    /**
     * Get the username of the current user.
     * 
     * @return string
     */
    public function whoAmI()
    {
        return $_SESSION['user_username'];
    }

    public function whatIsMyId()
    {
        return $_SESSION['user_id'];
    }
}
