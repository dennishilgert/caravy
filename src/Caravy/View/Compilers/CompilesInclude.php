<?php

namespace Caravy\View\Compilers;

class CompilesInclude extends AbstractCompiler
{
    private $container;

    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
    }

    public function getType()
    {
        return 'include';
    }

    public function compile($parameter, $data)
    {
        ob_start();
        view($parameter, $data, $this->container);
        return ob_get_clean();
    }
}