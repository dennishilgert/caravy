<?php

namespace Caravy\Database;

use PDO;

abstract class AbstractMiddleware
{
    /**
     * Instance of the pdo-object.
     * 
     * @var PDO
     */
    protected $pdo;

    /**
     * Create a new abstract-middleware instance.
     * 
     * @param \Caravy\Database\DatabaseManager $databaseManager
     * @return void
     */
    public function __construct(\Caravy\Database\DatabaseManager $databaseManager)
    {
        $this->pdo = $databaseManager->getPdo();
    }

    /**
     * Get the specific table-name.
     * 
     * @return string
     */
    abstract public function getTableName();

    /**
     * Get the specific model-name.
     * 
     * @return string
     */
    abstract public function getModelName();

    /**
     * Get all entries as model.
     * 
     * @return object[]
     */
    function allAsModel()
    {
        $tableName = $this->getTableName();
        $modelName = $this->getModelName();

        $statement = $this->pdo->query("SELECT * FROM `$tableName`");
        $result = $statement->fetchAll(PDO::FETCH_CLASS, $modelName);
        return $result;
    }

    /**
     * Get entry as model.
     * 
     * @return object
     */
    function findModel(string $key, string $value)
    {
        $tableName = $this->getTableName();
        $modelName = $this->getModelName();

        $statement = $this->pdo->prepare("SELECT * FROM `$tableName` WHERE `$key` = :value");
        $statement->execute(['value' => $value]);
        $statement->setFetchMode(PDO::FETCH_CLASS, $modelName);
        $result = $statement->fetch(PDO::FETCH_CLASS);
        return $result;
    }

    /**
     * Get first entry as model.
     * 
     * @return object
     */
    function findFirstModel(string $key, string $value)
    {
        $tableName = $this->getTableName();
        $modelName = $this->getModelName();

        $statement = $this->pdo->prepare("SELECT * FROM `$tableName` WHERE `$key` = :value LIMIT 1");
        $statement->execute(['value' => $value]);
        $statement->setFetchMode(PDO::FETCH_CLASS, $modelName);
        $result = $statement->fetch(PDO::FETCH_CLASS);
        return $result;
    }

    /**
     * Get all entries as array.
     * 
     * @return array
     */
    function findAll(string $search, string $key, string $value)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("SELECT `$search` FROM `$tableName` WHERE `$key` = :value");
        $statement->execute(['value' => $value]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get first entry.
     * 
     * @return array
     */
    function findFirst(string $search, string $key, string $value)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("SELECT `$search` FROM `$tableName` WHERE `$key` = :value LIMIT 1");
        $statement->execute(['value' => $value]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result[$search];
    }

    /**
     * Remove entry.
     * 
     * @return bool
     */
    function remove(string $key, string $value)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("DELETE FROM `$tableName` WHERE `$key` = :value");
        return $statement->execute([
            'value' => $value
        ]);
    }
}
