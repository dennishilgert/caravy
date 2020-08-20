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

    /**
     * Seek for the id of a role by name.
     * 
     * @param string $name
     * @return int
     */
    public function seekId($name)
    {
        return $this->findFirst('id', 'name', $name);
    }

    /**
     * Check wether a role with this name already exists.
     * 
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        $id = $this->findFirst('id', 'name', $name);
        return empty($id) === false;
    }

    /**
     * Create a new role.
     * 
     * @param string $name
     * @param string $description
     * @return bool
     */
    public function create($name, $description)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("INSERT INTO `$tableName` (`id`, `name`, `description`) VALUES (NULL, :name, :description)");
        return $statement->execute([
            'name' => $name,
            'description' => $description
        ]);
    }

    /**
     * Delete a role.
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("DELETE FROM `$tableName` WHERE id = :id");
        return $statement->execute([
            'id' => $id,
        ]);
    }

    /**
     * Edit a role.
     * 
     * @param int $id
     * @param string $name
     * @param string $description
     * @return bool
     */
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
