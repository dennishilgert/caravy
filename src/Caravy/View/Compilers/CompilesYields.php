<?php

namespace Caravy\View\Compilers;

use Caravy\Support\Str;

class CompilesYields extends AbstractCompiler
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