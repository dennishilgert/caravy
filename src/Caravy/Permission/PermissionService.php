<?php

namespace Caravy\Permission;

use Caravy\Support\Arr;

class PermissionService
{
    /**
     * Instance of the container-object.
     * 
     * @var \Caravy\Container\Container
     */
    private $container;

    /**
     * Instance of the permission-middleware-object.
     * 
     * @var \Caravy\Permission\Middleware\PermissionMiddleware
     */
    private $permissionMiddleware;

    /**
     * Instance of the user-permission-middleware-object.
     * 
     * @var \Caravy\Permission\Middleware\UserPermissionMiddleware
     */
    private $userPermissionMiddleware;

    /**
     * Instance of the role-middleware-object.
     * 
     * @var \Caravy\Permission\Middleware\RoleMiddleware
     */
    private $roleMiddleware;

    /**
     * Instance of the role-permission-middleware-object.
     * 
     * @var \Caravy\Permission\Middleware\RolePermissionMiddleware
     */
    private $rolePermissionMiddleware;

    /**
     * Instance of the user-role-middleware-object.
     * 
     * @var \Caravy\Permission\Middleware\UserRoleMiddleware
     */
    private $userRoleMiddleware;

    /**
     * Create a new permission-service instance.
     * 
     * @param \Caravy\Container\Container $container
     * @return void
     */
    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;

        $this->permissionMiddleware = $container->provide(\Caravy\Permission\Middleware\PermissionMiddleware::class);
        $this->userPermissionMiddleware = $container->provide(\Caravy\Permission\Middleware\UserPermissionMiddleware::class);
        $this->roleMiddleware = $container->provide(\Caravy\Permission\Middleware\RoleMiddleware::class);
        $this->rolePermissionMiddleware = $container->provide(\Caravy\Permission\Middleware\RolePermissionMiddleware::class);
        $this->userRoleMiddleware = $container->provide(\Caravy\Permission\Middleware\UserRoleMiddleware::class);
    }

    /**
     * Get all permissions as models.
     * 
     * @return \Caravy\Permission\Middleware\Permission[]
     */
    public function getAllPermissions()
    {
        return $this->permissionMiddleware->allAsModel();
    }

    /**
     * Get all roles as model.
     * 
     * @return \Caravy\Permission\Middleware\Role[]
     */
    public function getAllRoles()
    {
        return $this->roleMiddleware->allAsModel();
    }

    /**
     * Get permissions assigned to a user as model.
     * 
     * @param int $userId
     * @return \Caravy\Permission\Middleware\Permission[]
     */
    public function getPermissions($userId)
    {
        return $this->userPermissionMiddleware->getPermissions($userId);
    }

    /**
     * Get permissions assigned to a user as string.
     * 
     * @param int $userId
     * @return string[]
     */
    public function getPermissionsAsName($userId)
    {
        $assignedPermissions = [];
        $userPermissions = $this->getPermissions($userId);
        if (empty($userPermissions)) {
            return $assignedPermissions;
        }
        foreach ($userPermissions as $userPermission) {
            array_push($assignedPermissions, $this->permissionMiddleware->seekName($userPermission->permission_id));
        }
        return $assignedPermissions;
    }

    /**
     * Get roles assigned to a user as model.
     * 
     * @param int $userId
     * @return \Caravy\Permission\Middleware\Role[]
     */
    public function getRoles($userId)
    {
        return $this->userRoleMiddleware->getRoles($userId);
    }

    /**
     * Get roles assigned to a user as string.
     * 
     * @param int $userId
     * @return string[]
     */
    public function getRolesAsName($userId)
    {
        $assignedRoles = [];
        $userRoles = $this->userRoleMiddleware->getRoles($userId);
        if (empty($userRoles)) {
            return $assignedRoles;
        }
        foreach ($userRoles as $userRole) {
            array_push($assignedRoles, $this->permissionMiddleware->seekName($userRole->role_id));
        }
        return $assignedRoles;
    }

    /**
     * Collect all user-permissions and store them into session-data.
     * 
     * @param int $userId
     * @return bool
     */
    public function load($userId)
    {
        if (is_null($userId)) {
            return false;
        }
        $permissions = [];

        $userRoles = $this->userRoleMiddleware->getRoles($userId);
        if (empty($userRoles) === false) {
            foreach ($userRoles as $userRole) {
                $rolePermissions = $this->rolePermissionMiddleware->getPermissions($userRole->role_id);
                if (empty($rolePermissions)) {
                    continue;
                }
                foreach ($rolePermissions as $rolePermission) {
                    $permission = $this->permissionMiddleware->seekName($rolePermission->permission_id);
                    array_push($permissions, $permission);
                }
            }
        }

        $userPermissions = $this->userPermissionMiddleware->getPermissions($userId);
        if (empty($userPermissions) === false) {
            foreach ($userPermissions as $userPermission) {
                $permission = $this->permissionMiddleware->seekName($userPermission->permission_id);
                array_push($permissions, $permission);
            }
        }

        $_SESSION['user_permissions'] = array_unique($permissions);
        return true;
    }

    /**
     * Check if the current user has a specific permission.
     * 
     * @param string $permission
     * @return bool
     */
    public function isPermitted($permission)
    {
        return Arr::contains($_SESSION['user_permissions'], $permission);
    }
}
