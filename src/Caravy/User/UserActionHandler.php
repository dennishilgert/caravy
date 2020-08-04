<?php

namespace Caravy\User;

use Caravy\Routing\Redirection;
use Caravy\Routing\Response;
use Caravy\Routing\UrlHandler;
use Caravy\View\View;

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

    /**
     * Instance of the auth-service.
     * 
     * @var \Caravy\User\AuthService
     */
    private $authService;

    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
        $this->userMiddleware = $container->provide(\Caravy\User\Middleware\UserMiddleware::class);
        $this->authService = $container->provide(\Caravy\User\AuthService::class);
    }

    /**
     * Handle the sent login-data.
     * 
     * @param string $username
     * @param string $password
     * @return true|string
     */
    public function handleLogin($username, $password)
    {
        $result = $this->authService->login($username, $password);
        if ($result === false) {
            // return invalid username or password
            $response = new Response(false, new View('user/auth/login', [
                'title' => 'Anmeldung',
                'action' => UrlHandler::makeUrl('login'),
                'info-message' => 'Der Benutzername und das Passwort stimmen nicht überein oder wurden nicht gefunden.'
            ], $this->container));
        } else {
            $response = new Response(true, null, new Redirection('users'));
        }
        return $response;
    }

    /**
     * Handle the sent logout-demand.
     * 
     * @return true
     */
    public function handleLogout()
    {
        $this->authService->logout();

        $response = new Response(true, null, new Redirection('login'));
        return $response;
    }

    public function handleCreate($username, $firstName, $lastName, $email, $password, $passwordRepeat)
    {
        if ($password !== $passwordRepeat) {
            var_dump('The passwords do not match');
            return false;
        }
        if ($this->userMiddleware->exists($username)) {
            var_dump('A user with the username "' . $username . '" already exists');
            return false;
        }
        $result = $this->userMiddleware->create($username, $firstName, $lastName, $email, $password);
        if ($result === false) {
            // throw bad-create-data exception
            var_dump('Bad-update-data exception with username ' . $username);
            return false;
        }
        \Caravy\Routing\UrlHandler::redirect('user/' . $username);
        return true;
    }

    public function handleEdit($id, $username, $firstName, $lastName, $email)
    {
        if ($this->userMiddleware->exists($username)) {
            var_dump('A user with the username "' . $username . '" already exists');
            return false;
        }
        $result = $this->userMiddleware->updateDetails($id, $username, $firstName, $lastName, $email);
        if ($result === false) {
            // throw bad-update-data exception
            var_dump('Bad-update-data exception with id ' . $id);
            return false;
        }
        view('user/edit', [
            'title' => 'Benutzer bearbeiten',
        ], $this->container);
        return true;
    }

    public function handleDelete($id)
    {
        $result = $this->userMiddleware->delete($id);
        if ($result === false) {
            // throw bad-update-data exception
            var_dump('Bad-update-data exception with id ' . $id);
            return false;
        }
        \Caravy\Routing\UrlHandler::redirect('users');
        return true;
    }
}
