<?php

namespace Caravy\Database;

use PDO;
use PDOException;

class DatabaseManager
{
    /**
     * Instance of the configuration
     * 
     * @var \Caravy\Core\Configuration
     */
    private $config;

    /**
     * Instance of the pdo-object.
     * 
     * @var PDO
     */
    private $pdo;

    public function __construct(\Caravy\Core\Configuration $config)
    {
        $this->config = $config;

        try {
            $host = $this->config->getDatabaseConfig['host'];
            $port = $this->config->getDatabaseConfig['port'];
            $name = $this->config->getDatabaseConfig['name'];
            $username = $this->config->getDatabaseConfig['username'];
            $password = $this->config->getDatabaseConfig['password'];

            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8";

            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            exit('Fatal Error: Cannot connect to database.');   
        }
    }

    /**
     * 
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}