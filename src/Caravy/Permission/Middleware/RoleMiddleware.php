<?php

namespace Caravy\Permission\Middleware;

use Caravy\Database\AbstractMiddleware;

class RoleMiddleware extends AbstractMiddleware
{
    public function getTableName()
    {
        return 'caravy_roles';
    }

    public function getModelName()
    {
        return 'Caravy\\Permission\\Middleware\\Role';
    }

    public function seekId($name)
    {
        return $this->findFirst('id', 'name', $name);
    }

    public function exists($name)
    {
        $id = $this->findFirst('id', 'name', $name);
        return empty($id) === false;
    }

    public function create($name, $description)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("INSERT INTO `$tableName` (`id`, `name`, `description`) VALUES (NULL, :name, :description)");
        return $statement->execute([
            'name' => $name,
            'description' => $description
        ]);
    }

    public function delete($id)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("DELETE FROM `$tableName` WHERE id = :id");
        return $statement->execute([
            'id' => $id,
        ]);
    }

    public function edit($id, $name, $description)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("UPDATE `$tableName` SET name = :name, description = :description WHERE id = :id");
        return $statement->execute([
            'name' => $name,
            'description' => $description,
            'id' => $id
        ]);
    }
}
