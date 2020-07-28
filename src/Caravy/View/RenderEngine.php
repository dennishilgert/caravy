<?php

namespace Caravy\View;

class RenderEngine
{
    /**
     * Temporary stored raw blocks.
     * 
     * @var array
     */
    private $rawBlocks;

    /**
     * Content of the layout-file.
     * 
     * @var string
     */
    private $rawLayout;

    /**
     * Data passed to the view.
     * 
     * @var array
     */
    private $data;

    /**
     * Create a new render-engine instance.
     * 
     * @param string $rawLayout
     * @param array $data
     * @return void
     */
    public function __construct($rawLayout, $data)
    {
        $this->rawBlocks = [];
        $this->rawLayout = $rawLayout;
        $this->data = $data;
    }

    /**
     * Compile the raw layout with the given data.
     * 
     * @return string
     */
    public function compile()
    {
        $this->rawLayout = $this->compileVariables();
        $this->rawLayout = $this->storeUncompiledBlocks();
        $this->rawLayout = $this->compilePhpBlocks();

        return $this->restoreRawBlocks();
    }

    /**
     * Compile the raw variables into a php-expression.
     * 
     * @return string
     */
    private function compileVariables()
    {
        $result = preg_replace_callback('/{{\s(.+)\s}}/', function ($match) {
            return '<?php echo escape(' . $match[1] . '); ?>';
        }, $this->rawLayout);

        return $result;
    }

    private function compilePhpBlocks()
    {
        $result = preg_replace_callback('/\<\?php\s(.+)\s\?>/', function ($match) {
            extract($this->data);

            ob_start();
            eval($match[1]);
            $compiledBlock = ob_get_clean();

            return $compiledBlock;
        }, $this->rawLayout);

        return $result;
    }

    /**
     * Extract the uncompiled blocks.
     * 
     * @param string $rawContent
     * @return void
     */
    public function storeUncompiledBlocks()
    {
        // matches[i][0] Full match [@if (condition) ... @endif]
        // matches[i][1] Group 1 @[if (condition)] ... @endif
        // matches[i][2] Group 2 @[if] (condition) ... @endif
        // matches[i][3] Group 3 @if (condition) [...] @endif
        // matches[i][4] Group 4 @if (condition) ... @end[if]
        $result = preg_replace_callback('/@(([a-z]{2,})\s\(.*?\)\n)\s*(.*?\n)\s*@end([a-z]{2,})/s', function ($match) {
            extract($this->data);

            if ($match[2] !== $match[4]) {
                // throw bad-block exception
                return;
            }
            $rawCondition = $match[1];
            $rawContent = $this->surroundUncompiledContent($match[3]);
            $preparedCondition = $this->prepareCondition($rawCondition, $rawContent);

            ob_start();
            eval($preparedCondition);
            $rawBlock = ob_get_clean();

            return $this->storeUncompiledBlock($rawBlock);
        }, $this->rawLayout, PREG_SET_ORDER);

        return $result;
    }

    /**
     * Save the uncompiled blocks temporary in an array.
     * 
     * @param string $rawBlock
     * @return string
     */
    private function storeUncompiledBlock($rawBlock)
    {
        return $this->getBlockPlaceholder(array_push($this->rawBlocks, $rawBlock) - 1);
    }

    /**
     * Compile the stored raw-blocks into the layout.
     * 
     * @return string
     */
    public function restoreRawBlocks()
    {
        $result = preg_replace_callback('/' . $this->getBlockPlaceholder('(\d+)') . '/', function ($matches) {
            return $this->rawBlocks[$matches[1]];
        }, $this->rawLayout);
        $this->rawBlocks = [];

        return $result;
    }

    /**
     * Get a placeholder for a raw-block.
     * 
     * @param int $index
     * @return string
     */
    private function getBlockPlaceholder($index)
    {
        return str_replace('#', $index, '@__raw_block_#__@');
    }

    /**
     * Add php-tags to a string.
     * 
     * @param string $rawContent
     * @return string
     */
    private function surroundUncompiledContent($rawContent)
    {
        return '?>' . $rawContent . '<?php';
    }

    /**
     * Append the content to the condition.
     * 
     * @param string $rawCondition
     * @param string $rawContent
     * @return string
     */
    private function prepareCondition($rawCondition, $rawContent)
    {
        return $rawCondition . ' {' . $rawContent . ' }';
    }
}
