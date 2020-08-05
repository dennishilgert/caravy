<?php

namespace Caravy\View\Compiler;

use Caravy\Routing\UrlHandler;
use Caravy\Support\Str;

class CompilesResource extends AbstractCompiler
{
    public function getType()
    {
        return 'resource';
    }

    public function compile($parameter, $data)
    {
        return Str::asymetric(UrlHandler::makeUrl($parameter), '<?php echo escape("', '"); ?>');
    }
}