<?php

namespace Caravy\User;

use Caravy\Routing\Model\Response;

class UserActionHandler
{
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
     * Instance of the permission-service-object.
     * 
     * @var \Caravy\Permission\PermissionService
     */
    private $permissionService;

    /**
     * Create a new user-action-handler instance.
     * 
     * @param \Caravy\Container\Container $container
     * @return void
     */
    public function __construct(\Caravy\Container\Container $container)
    {
        $this->userMiddleware = $container->provide(\Caravy\User\Middleware\UserMiddleware::class);
        $this->authService = $container->provide(\Caravy\User\AuthService::class);
        $this->permissionService = $container->provide(\Caravy\Permission\PermissionService::class);
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
            return (new Response)->err('Der Benutzername und das Passwort stimmen nicht überein oder wurden nicht gefunden.');
        }
        $this->permissionService->load($_SESSION['user_id']);
        return (new Response)->ok()->redirect('users');
    }

    /**
     * Handle the logout demand.
     * 
     * @return \Caravy\Routing\Model\Response
     */
    public function handleLogout()
    {
        $this->authService->logout();
        return (new Response)->ok()->redirect('login');
    }

    /**
     * Handle the create demand.
     * 
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string $passwordRepeat
     * @return \Caravy\Routing\Model\Response
     */
    public function handleCreate($username, $firstName, $lastName, $email, $password, $passwordRepeat)
    {
        if ($password !== $passwordRepeat) {
            return (new Response)->err('Die Passwörter stimmen nicht überein.');
        }
        if ($this->userMiddleware->exists($username)) {
            return (new Response)->err('Ein Benutzer mit diesem Benutzernamen ist bereits vorhanden.');
        }
        $result = $this->userMiddleware->create($username, $firstName, $lastName, $email, $password);
        if ($result === false) {
            return (new Response)->err('Der Benutzer konnte nicht erstellt werden.');
        }
        return (new Response)->ok('Der Benutzer wurde erstellt.');
    }

    /**
     * Handle the edit demand.
     * 
     * @param string $id
     * @param string $oldUsername
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @return \Caravy\Routing\Model\Response
     */
    public function handleEdit($id, $oldUsername, $username, $firstName, $lastName, $email)
    {
        if ($oldUsername !== $username) {
            if ($this->userMiddleware->exists($username)) {
                return (new Response)->err('Ein Benutzer mit diesem Benutzernamen ist bereits vorhanden.');
            }
        }
        $result = $this->userMiddleware->updateDetails($id, $username, $firstName, $lastName, $email);
        if ($result === false) {
            return (new Response)->err('Die Benutzerdaten konnten nicht aktualisiert werden.');
        }
        return (new Response)->ok('Die Benutzerdaten wurden aktualsiert.');
    }

    /**
     * Handle the delete demand.
     * 
     * @param string $id
     * @return \Caravy\Routing\Model\Response
     */
    public function handleDelete($id)
    {
        $result = $this->userMiddleware->delete($id);
        if ($result === false) {
            return (new Response)->err('Der Benutzer konnte nicht gelöscht werden.');
        }
        return (new Response)->ok('Der Benutzer wurde gelöscht.');
    }
}
