<?php

namespace Caravy\Permission;

use Caravy\Support\Arr;

class PermissionService
{
    private $container;

    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
    }

    public function load($userId)
    {
        if (is_null($userId)) {
            return false;
        }
        $permissions = [];

        $permissionMiddleware = $this->container->provide(\Caravy\Permission\Middleware\PermissionMiddleware::class);
        $userPermissionMiddleware = $this->container->provide(\Caravy\Permission\Middleware\UserPermissionMiddleware::class);

        $rolePermissionMiddleware = $this->container->provide(\Caravy\Permission\Middleware\RolePermissionMiddleware::class);
        $userRoleMiddleware = $this->container->provide(\Caravy\Permission\Middleware\UserRoleMiddleware::class);
        
        $userRoles = $userRoleMiddleware->getRoles($userId);
        if (empty($userRoles) === false) {
            foreach ($userRoles as $userRole) {
                $rolePermissions = $rolePermissionMiddleware->getPermissions($userRole->role_id);
                if (empty($rolePermissions)) {
                    continue;
                }
                foreach ($rolePermissions as $rolePermission) {
                    $permission = $permissionMiddleware->seekName($rolePermission->permission_id);
                    array_push($permissions, $permission);
                }
            }
        }

        $userPermissions = $userPermissionMiddleware->getPermissions($userId);
        if (empty($userPermissions) === false) {
            foreach ($userPermissions as $userPermission) {
                $permission = $permissionMiddleware->seekName($userPermission->permission_id);
                array_push($permissions, $permission);
            }
        }

        $_SESSION['user_permissions'] = array_unique($permissions);
        return true;
    }

    public function isPermitted($permission)
    {
        return Arr::contains($_SESSION['user_permissions'], $permission);
    }
}
