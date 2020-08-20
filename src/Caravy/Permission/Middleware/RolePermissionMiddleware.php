<?php

namespace Caravy\Permission\Middleware;

use Caravy\Database\AbstractMiddleware;

class RolePermissionMiddleware extends AbstractMiddleware
{
    public function getTableName()
    {
        return 'caravy_role_permissions';
    }

    public function getModelName()
    {
        return 'Caravy\\Permission\\Middleware\\RolePermission';
    }

    /**
     * Get all permissions of a role.
     * 
     * @param int $roleId
     * @return \Caravy\Permission\Middleware\RolePermission[]
     */
    public function getPermissions($roleId)
    {
        return $this->findModels('role_id', $roleId);
    }

    /**
     * Add a permission to a role.
     * 
     * @param int $roleId
     * @param int $permissionId
     * @return bool
     */
    public function addPermission($roleId, $permissionId)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("INSERT INTO `$tableName` (`role_id`, `permission_id`) VALUES (:roleId, :permissionId)");
        return $statement->execute([
            'roleId' => $roleId,
            'permissionId' => $permissionId
        ]);
    }

    /**
     * Remove a permission from a role.
     * 
     * @param int $roleId
     * @param int $permissionId
     * @return bool
     */
    public function removePermission($roleId, $permissionId)
    {
        return $this->removeSpecific('role_id', $roleId, 'permission_id', $permissionId);
    }
}
