<?php

namespace Caravy\Permission\Middleware;

use Caravy\Database\AbstractMiddleware;

class UserRoleMiddleware extends AbstractMiddleware
{
    public function getTableName()
    {
        return 'caravy_user_roles';
    }

    public function getModelName()
    {
        return 'Caravy\\Permission\\Middleware\\UserRole';
    }

    /**
     * Get all roles of an user.
     * 
     * @param int $userId
     * @return \Caravy\Permission\Middleware\UserRole[]
     */
    public function getRoles($userId)
    {
        return $this->findModels('user_id', $userId);
    }

    /**
     * Add a role to an user.
     * 
     * @param int $userId
     * @param int $roleId
     * @return bool
     */
    public function addPermission($roleId, $userId)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("INSERT INTO `$tableName` (`user_id`, `role_id`) VALUES (:userId, :roleId)");
        return $statement->execute([
            'userId' => $userId,
            'roleId' => $roleId
        ]);
    }

    /**
     * Remove a role from an user.
     * 
     * @param int $userId
     * @param int $roleId
     * @return bool
     */
    public function removePermission($userId, $roleId)
    {
        return $this->removeSpecific('user_id', $userId, 'role_id', $roleId);
    }
}
