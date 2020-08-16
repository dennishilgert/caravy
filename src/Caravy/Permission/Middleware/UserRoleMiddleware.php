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

    public function getRoles($userId)
    {
        return $this->findModels('user_id', $userId);
    }
}
