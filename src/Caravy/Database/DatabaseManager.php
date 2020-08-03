<?php

namespace Caravy\Database;

use PDO;
use PDOException;

class DatabaseManager
{
    /**
     * Instance of the pdo-object.
     * 
     * @var PDO
     */
    private $pdo;

    public function __construct(\Caravy\Core\Configuration $config)
    {
        try {
            $host = $config->getDatabaseConfig['host'];
            $port = $config->getDatabaseConfig['port'];
            $name = $config->getDatabaseConfig['name'];
            $username = $config->getDatabaseConfig['username'];
            $password = $config->getDatabaseConfig['password'];

            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8";

            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            exit('Fatal Error: Cannot connect to database.');
        }
    }

    /**
     * Get the pdo-instance.
     * 
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}
