<?php

namespace Caravy\View\Compilers;

class CompilesCsrf extends AbstractCompiler
{
    public function getType()
    {
        return 'csrf';
    }

    public function compile($parameter, $data)
    {
        return '<input type="hidden" name="_token" id="csrf-token" value="' . 'CSRF->TOKEN' . '" />';
    }
}