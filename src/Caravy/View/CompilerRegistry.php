<?php

namespace Caravy\View;

use Caravy\View\Compiler\CompilesCsrf;
use Caravy\View\Compiler\CompilesInclude;
use Caravy\View\Compiler\CompilesMessage;
use Caravy\View\Compiler\CompilesMethod;
use Caravy\View\Compiler\CompilesResource;
use Caravy\View\Compiler\CompilesYield;

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
        $this->register(new CompilesMessage());
        $this->register(new CompilesResource());
    }

    /**
     * Register a new compiler.
     * 
     * @param \Caravy\View\Compiler\AbstractCompiler $compiler
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
     * @return \Caravy\View\Compiler\AbstractCompiler|false
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
