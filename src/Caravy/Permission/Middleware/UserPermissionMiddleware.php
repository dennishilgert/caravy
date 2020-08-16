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

    public function getPermissions($userId)
    {
        return $this->findModels('user_id', $userId);
    }
}
