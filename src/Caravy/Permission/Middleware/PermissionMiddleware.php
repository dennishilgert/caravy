<?php

namespace Caravy\Permission\Middleware;

use Caravy\Database\AbstractMiddleware;

class PermissionMiddleware extends AbstractMiddleware
{
    public function getTableName()
    {
        return 'caravy_permissions';
    }

    public function getModelName()
    {
        return 'Caravy\\Permission\\Middleware\\Permission';
    }

    /**
     * Seek for the name of a permission by id.
     * 
     * @param int $id
     * @return string
     */
    public function seekName($id)
    {
        return $this->findFirst('name', 'id', $id);
    }

    /**
     * Check wether a permission already exists.
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
     * Create a new permission.
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
     * Delete a permission.
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->remove('id', $id);
    }

    /**
     * Edit a permission.
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
