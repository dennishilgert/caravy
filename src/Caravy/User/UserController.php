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
     * Instance of the permission-service-object.
     * 
     * @var \Caravy\Permission\PermissionService
     */
    private $permissionService;

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
        $this->permissionService = $container->provide(\Caravy\Permission\PermissionService::class);
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
        if ($this->permissionService->isPermitted('user_create') === false) {
            UrlHandler::redirect('users');
            return;
        }
        view('user/create', [
            'title' => 'Benutzer erstellen',
            'action' => UrlHandler::makeUrl('user/create'),
        ], $this->container);
    }

    /**
     * Send the user-details-edit view.
     * 
     * @param string $id
     * @return void
     */
    public function editDetails($id)
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
        if ($this->authService->whoAmI() !== $user->username and $this->permissionService->isPermitted('user_edit_details') === false) {
            UrlHandler::redirect('users');
            return;
        }
        view('user/editDetails', [
            'title' => 'Benutzerdaten bearbeiten',
            'action' => UrlHandler::makeUrl('user/edit/details'),
            'user' => $user,
        ], $this->container);
    }

    /**
     * Send the user-permission-edit view.
     * 
     * @param string $id
     * @return void
     */
    public function editPermissions($id)
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
        if ($this->permissionService->isPermitted('user_edit_permissions') === false) {
            UrlHandler::redirect('users');
            return;
        }

        view('user/editPermissions', [
            'title' => 'Benutzerrechte bearbeiten',
            'action' => UrlHandler::makeUrl('user/edit/permissions'),
            'user' => $user,
            'availablePermissions' => $this->permissionService->getAllPermissions(),
            'availableRoles' => $this->permissionService->getAllRoles(),
            'assignedPermissions' => $this->permissionService->getPermissionsasName($user->id),
            'assignedRoles' => $this->permissionService->getRolesAsName($user->id)
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
        if ($this->permissionService->isPermitted('user_delete') === false) {
            UrlHandler::redirect('users');
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
                'message' => 'Der angegebene Benutzername "' . $username . '" konnte nicht gefunden werden.',
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
