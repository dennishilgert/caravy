<?php

namespace Caravy\View;

use Caravy\View\Compilers\CompilesCsrf;
use Caravy\View\Compilers\CompilesInclude;
use Caravy\View\Compilers\CompilesMethod;
use Caravy\View\Compilers\CompilesYield;

class CompilerRegistry
{
    /**
     * Registered compilers.
     * 
     * @var array
     */
    private $compilers;

    /**
     * Create a new compiler-registry instance.
     * 
     * @return void
     */
    public function __construct(\Caravy\Container\Container $container)
    {
        $this->compilers = [];

        $this->register(new CompilesCsrf());
        $this->register(new CompilesInclude($container));
        $this->register(new CompilesMethod());
        $this->register(new CompilesYield());
    }

    /**
     * Register a new compiler.
     * 
     * @param \Caravy\View\Compilers\AbstractCompiler $compiler
     * @return void
     */
    public function register($compiler)
    {
        $this->compilers[$compiler->getType()] = $compiler;
    }

    /**
     * Get compiler by type.
     * 
     * @param string $compiles
     * @return \Caravy\View\Compilers\AbstractCompiler|false
     */
    public function getCompiler($compiles)
    {
        $compiler = $this->compilers[$compiles];
        if (empty($compiler)) {
            return false;
        }
        return $compiler;
    }
}
