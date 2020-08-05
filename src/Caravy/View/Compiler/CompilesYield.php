<?php

namespace Caravy\View\Compiler;

use Caravy\Support\Str;

class CompilesYield extends AbstractCompiler
{
    public function getType()
    {
        return 'yield';
    }

    public function compile($parameter, $data)
    {
        return Str::asymetric($parameter, '<?php echo escape($', '); ?>');
    }
}