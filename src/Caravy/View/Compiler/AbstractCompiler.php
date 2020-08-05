<?php

namespace Caravy\View\Compiler;

abstract class AbstractCompiler
{
    abstract public function getType();

    abstract public function compile($parameter, $data);
}