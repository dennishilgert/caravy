<?php

namespace Caravy\User;

use Caravy\Routing\UrlHandler;

class UserController
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

    public function login()
    {
        view('user/auth/login', [
            'title' => 'Anmeldung',
            'action' => UrlHandler::makeUrl('login'),
        ], $this->container);
    }

    public function create()
    {
        view('user/create', [
            'title' => 'Benutzer erstellen',
            'action' => UrlHandler::makeUrl('user/create'),
        ], $this->container);
    }

    public function edit($id)
    {
        $user = $this->userMiddleware->findFirstModel('id', $id);
        if (empty($user)) {
            // throw bad-identifier exception
            var_dump('Bad-identifier exception: id ' . $id . ' not found');
            return false;
        }
        view('user/edit', [
            'title' => 'Benutzer bearbeiten',
            'action' => UrlHandler::makeUrl('user/edit'),
            'user' => $user,
        ], $this->container);
    }

    public function delete($id)
    {
        $user = $this->userMiddleware->findFirstModel('id', $id);
        if (empty($user)) {
            // throw bad-identifier exception
            var_dump('Bad-identifier exception: id ' . $id . ' not found');
            return false;
        }
        view('user/delete', [
            'title' => 'Benutzer löschen',
            'action' => UrlHandler::makeUrl('user/delete'),
            'user' => $user,
        ], $this->container);
    }

    public function profile($username)
    {
        $user = $this->userMiddleware->findFirstModel('username', $username);
        if (empty($user)) {
            // throw bad-identifier exception
            var_dump('Bad-identifier exception: username ' . $username . ' not found');
            return false;
        }
        view('user/profile', [
            'title' => 'Profil von ' . $username,
            'user' => $user,
        ], $this->container);
    }

    public function userList()
    {
        $users = [];
        $users = $this->userMiddleware->allAsModel();
        view('user/users', [
            'title' => 'Liste aller Benutzer',
            'users' => $users,
        ], $this->container);
    }
}
