<?php

namespace Caravy\View\Compiler;

class CompilesMethod extends AbstractCompiler
{
    public function getType()
    {
        return 'method';
    }

    public function compile($parameter, $data)
    {
        return '<input type="hidden" name="_method" id="http-method" value="' . $parameter . '" />';
    }
}
