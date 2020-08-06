<?php

namespace Caravy\User;

use Caravy\Routing\UrlHandler;

class UserController
{
    /**
     * Instance of the container-object.
     * 
     * @var \Caravy\Container\Container
     */
    private $container;

    /**
     * Instance of the user-middleware-object.
     * 
     * @var \Caravy\User\Middleware\UserMiddleware
     */
    private $userMiddleware;

    /**
     * Instance of the auth-service-object.
     * 
     * @var \Caravy\User\AuthService
     */
    private $authService;

    /**
     * Create a new user-controller instance.
     * 
     * @param \Caravy\Container\Container $container
     * @return void
     */
    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
        $this->userMiddleware = $container->provide(\Caravy\User\Middleware\UserMiddleware::class);
        $this->authService = $container->provide(\Caravy\User\AuthService::class);
    }

    /**
     * Send the login view.
     * 
     * @return void
     */
    public function login()
    {
        if ($this->authService->isLoggedIn()) {
            UrlHandler::redirect('users');
            return;
        }
        view('user/auth/login', [
            'title' => 'Anmeldung',
            'action' => UrlHandler::makeUrl('login'),
        ], $this->container);
    }

    /**
     * Send the logout view.
     * 
     * @return void
     */
    public function logout()
    {
        $this->container->provide(\Caravy\User\UserActionHandler::class)->handleLogout();
        UrlHandler::redirect('login');
    }

    /**
     * Send the user-create view.
     * 
     * @return void
     */
    public function create()
    {
        if ($this->authService->isLoggedIn() === false) {
            UrlHandler::redirect('login');
            return;
        }
        view('user/create', [
            'title' => 'Benutzer erstellen',
            'action' => UrlHandler::makeUrl('user/create'),
        ], $this->container);
    }

    /**
     * Send the user-edit view.
     * 
     * @param string $id
     * @return void
     */
    public function edit($id)
    {
        if ($this->authService->isLoggedIn() === false) {
            UrlHandler::redirect('login');
            return;
        }
        $user = $this->userMiddleware->findFirstModel('id', $id);
        if (empty($user)) {
            view('error', [
                'title' => 'Error 400',
                'code' => '400 Bad request',
                'message' => 'Die angegebene Benutzer-ID "' . $id . '" konnte nicht gefunden werden.',
            ], $this->container);
            return;
        }
        view('user/edit', [
            'title' => 'Benutzer bearbeiten',
            'action' => UrlHandler::makeUrl('user/edit'),
            'user' => $user,
        ], $this->container);
    }

    /**
     * Send the user-delete view.
     * 
     * @param string $id
     * @return void
     */
    public function delete($id)
    {
        if ($this->authService->isLoggedIn() === false) {
            UrlHandler::redirect('login');
            return;
        }
        $user = $this->userMiddleware->findFirstModel('id', $id);
        if (empty($user)) {
            view('error', [
                'title' => 'Error 400',
                'code' => '400 Bad request',
                'message' => 'Die angegebene Benutzer-ID "' . $id . '" konnte nicht gefunden werden.',
            ], $this->container);
            return;
        }
        view('user/delete', [
            'title' => 'Benutzer löschen',
            'action' => UrlHandler::makeUrl('user/delete'),
            'user' => $user,
        ], $this->container);
    }

    /**
     * Send the user-profile view.
     * 
     * @param string $username
     * @return void
     */
    public function profile($username)
    {
        if ($this->authService->isLoggedIn() === false) {
            UrlHandler::redirect('login');
            return;
        }
        $user = $this->userMiddleware->findFirstModel('username', $username);
        if (empty($user)) {
            view('error', [
                'title' => 'Error 400',
                'code' => '400 Bad request',
                'message' => 'Die angegebene Benutzername "' . $username . '" konnte nicht gefunden werden.',
            ], $this->container);
            return;
        }
        view('user/profile', [
            'title' => 'Profil von ' . $username,
            'user' => $user,
        ], $this->container);
    }

    /**
     * Send the user-list view.
     * 
     * @return void
     */
    public function userList()
    {
        if ($this->authService->isLoggedIn() === false) {
            UrlHandler::redirect('login');
            return;
        }
        $users = [];
        $users = $this->userMiddleware->allAsModel();
        view('user/users', [
            'title' => 'Liste aller Benutzer',
            'users' => $users,
        ], $this->container);
    }
}
