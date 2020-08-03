<?php

namespace Caravy\View\Compilers;

abstract class AbstractCompiler
{
    abstract public function getType();

    abstract public function compile($parameter, $data);
}