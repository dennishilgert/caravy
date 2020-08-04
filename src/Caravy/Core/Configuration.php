<?php

namespace Caravy\Core;

class Configuration
{
    private $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../../config.php';
    }

    public function getGeneralConfig()
    {
        return $this->config['general'];
    }

    public function getDatabaseConfig()
    {
        return $this->config['database'];
    }
}