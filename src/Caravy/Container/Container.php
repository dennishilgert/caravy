<?php

namespace Caravy\Container;

class Container
{
    /**
     * Array of shared instances.
     * 
     * @var array
     */
    private $sharedInstances;

    /**
     * Create a new InstanceFactory instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->sharedInstances = [];
    }

    /**
     * Create or get instance-object.
     * 
     * @param string $instance
     * @return object|false
     */
    public function provide($instance)
    {
        if (array_key_exists($instance, $this->sharedInstances) === false) {
            $instanceObject = $this->new($instance);
            if (is_null($instanceObject)) {
                return false;
            }
            $this->sharedInstances[$instance] = $instanceObject;
        }
        return $this->sharedInstances[$instance];
    }

    /**
     * Create a new instance-object.
     * 
     * @param string $instance
     * @return object
     */
    private function new($instance)
    {
        $reflectionClass = new \ReflectionClass($instance);
        if (is_null($reflectionClass)) {
            return null;
        }
        // check whether the instance has defined a constructor
        $constructor = $reflectionClass->getConstructor();
        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        }
        // check whether the constructor has dependencies
        $dependencies = $reflectionClass->getConstructor()->getParameters();
        if (is_null($dependencies)) {
            return $reflectionClass->newInstance();
        }
        $instance = $reflectionClass->newInstanceArgs($this->provideDependencies($dependencies));

        return $instance;
    }

    /**
     * Get dependencies as instance-objects.
     * 
     * @param \ReflectionParamater[] $params
     * @return object[]
     */
    private function provideDependencies($constrcutorDependencies)
    {
        $dependencies = [];
        foreach ($constrcutorDependencies as $dependency) {
            array_push($dependencies, $this->provide($dependency->getClass()->getName()));
        }
        return $dependencies;
    }
}
