<?php

namespace Caravy\View\Compilers;

use Caravy\Support\Arr;
use Caravy\Support\Str;

class CompilesMessage extends AbstractCompiler
{
    public function getType()
    {
        return 'message';
    }

    public function compile($parameter, $data)
    {
        $messageType = $parameter . '-message';
        if (Arr::contains($data, $messageType)) {
            return Str::asymetric($data[$messageType], '<?php echo escape("', '"); ?>');
        }
        return '';
    }
}