<?php

namespace Caravy\Permission\Middleware;

use Caravy\Database\AbstractMiddleware;

class UserPermissionMiddleware extends AbstractMiddleware
{
    public function getTableName()
    {
        return 'caravy_user_permissions';
    }

    public function getModelName()
    {
        return 'Caravy\\Permission\\Middleware\\UserPermission';
    }

    /**
     * Get all permissions of an user.
     * 
     * @param int $userId
     * @return \Caravy\Permission\Middleware\UserPermission[]
     */
    public function getPermissions($userId)
    {
        return $this->findModels('user_id', $userId);
    }

    /**
     * Add a permission to an user.
     * 
     * @param int $userId
     * @param int $permissionId
     * @return bool
     */
    public function addPermission($userId, $permissionId)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("INSERT INTO `$tableName` (`user_id`, `permission_id`) VALUES (:userId, :permissionId)");
        return $statement->execute([
            'userId' => $userId,
            'permissionId' => $permissionId
        ]);
    }

    /**
     * Remove a permission from an user.
     * 
     * @param int $userId
     * @param int $permissionId
     * @return bool
     */
    public function removePermission($userId, $permissionId)
    {
        return $this->removeSpecific('user_id', $userId, 'permission_id', $permissionId);
    }
}
