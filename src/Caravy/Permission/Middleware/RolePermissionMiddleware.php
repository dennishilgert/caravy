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

    public function getPermissions($roleId)
    {
        return $this->findModels('role_id', $roleId);
    }
}
