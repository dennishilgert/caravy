<?php

namespace Caravy\Middleware;

use PDO;

abstract class AbstractMiddleware
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function getTableName();

    abstract public function getModelName();

    function allAsModel()
    {
        $tableName = $this->getTableName();
        $modelName = $this->getModelName();

        $statement = $this->pdo->query("SELECT * FROM `$tableName`");
        $result = $statement->fetchAll(PDO::FETCH_CLASS, $modelName);
        return $result;
    }

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

    function findAll(string $search, string $key, string $value)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("SELECT `$search` FROM `$tableName` WHERE `$key` = :value");
        $statement->execute(['value' => $value]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function findFirst(string $search, string $key, string $value)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("SELECT `$search` FROM `$tableName` WHERE `$key` = :value LIMIT 1");
        $statement->execute(['value' => $value]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result[$search];
    }

    function remove(string $key, string $value)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("DELETE FROM `$tableName` WHERE `$key` = :value");
        return $statement->execute([
            'value' => $value
        ]);
    }
}