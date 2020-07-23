<?php

namespace Caravy\Extendables;

abstract class AbstractRegistry
{
    /**
     * Array containing instances.
     * 
     * @var array
     */
    private $instances;

    /**
     * Create a new AbstractRegistry instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->instances = [];
    }

    /**
     * Register a new instance.
     * 
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function register($key, $value) {
        $this->instances[$key] = $value;
    }

    /**
     * Check if an instance is registered.
     * 
     * @param mixed $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->instances);
    }

    /**
     * Get a registered instance.
     * 
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->instances[$key];
    }
}