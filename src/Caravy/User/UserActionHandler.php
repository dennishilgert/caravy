<?php

namespace Caravy\User;

class UserActionHandler
{
    /**
     * Instance of the container.
     * 
     * @var \Caravy\Container\Container
     */
    private $container;

    /**
     * Instance of the user-middleware.
     * 
     * @var \Caravy\User\Middleware\UserMiddleware
     */
    private $userMiddleware;

    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
        $this->userMiddleware = $container->provide(\Caravy\User\Middleware\UserMiddleware::class);
    }

    public function handleCreate()
    {

    }

    public function handleEdit($id, $username, $firstName, $lastName, $email)
    {
        // $result = $this->userMiddleware->updateDetails($id, $username, $firstName, $lastName, $email);
        // if ($result === false) {
        //     // throw bad-update-data exception
        //     return;
        // }
        $this->container->provide(\Caravy\User\UserController::class)->profile($username);
    }

    public function handleDelete($userId)
    {

    }
}