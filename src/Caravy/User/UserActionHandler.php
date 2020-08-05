<?php

namespace Caravy\User;

use Caravy\Routing\Model\Redirection;
use Caravy\Routing\Model\Response;
use Caravy\Routing\UrlHandler;
use Caravy\View\Model\View;

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
            $response = new Response();
            $response->err('Der Benutzername und das Passwort stimmen nicht überein oder wurden nicht gefunden.');
            return $response;
        }
        $response = new Response();
        $response->ok();
        $response->redirect('users');
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

        $response = new Response();
        $response->ok();
        $response->redirect('login');
        return $response;
    }

    public function handleCreate($username, $firstName, $lastName, $email, $password, $passwordRepeat)
    {
        if ($password !== $passwordRepeat) {
            return new Response(false, new View('user/create', [
                'title' => 'Benutzer erstellen',
                'action' => UrlHandler::makeUrl('user/create'),
                'info-message' => 'Die Passwörter stimmen nicht überein.',
            ], $this->container));
        }
        if ($this->userMiddleware->exists($username)) {
            return new Response(false, new View('user/create', [
                'title' => 'Benutzer erstellen',
                'action' => UrlHandler::makeUrl('user/create'),
                'info-message' => 'Ein Benutzer mit dem Namen "' . $username . '" ist bereits vorhanden.',
            ], $this->container));
        }
        $result = $this->userMiddleware->create($username, $firstName, $lastName, $email, $password);
        if ($result === false) {
            return new Response(false, new View('user/create', [
                'title' => 'Benutzer erstellen',
                'action' => UrlHandler::makeUrl('user/create'),
                'info-message' => 'Der Benutzer mit dem Namen "' . $username . '" konnte nicht erstellt werden.',
            ], $this->container));
        }
        $user = $this->userMiddleware->findFirstModel('username', $username);
        return new Response(true, new View('user/profile', [
            'title' => 'Profil von ' . $user->username,
            'user' => $user,
            'info-message' => 'Der Benutzer wurde erfolgreich erstellt.',
        ], $this->container));
    }

    public function handleEdit($id, $oldUsername, $username, $firstName, $lastName, $email)
    {
        if ($oldUsername !== $username) {
            if ($this->userMiddleware->exists($username)) {
                var_dump('A user with the username "' . $username . '" already exists');
                return false;
            }
        }
        $result = $this->userMiddleware->updateDetails($id, $username, $firstName, $lastName, $email);
        if ($result === false) {
            // throw bad-update-data exception
            var_dump('Bad-update-data exception with id ' . $id);
            return false;
        }
        $user = $this->userMiddleware->findFirstModel('id', $id);
        return new Response(true, new View('user/edit', [
            'title' => 'Benutzer bearbeiten',
            'user' => $user,
        ], $this->container));
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
