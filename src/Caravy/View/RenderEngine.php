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
     */
    private $rawLayout;

    /**
     * Data passed to the view.
     */
    private $data;

    /**
     * Create a new render-engine instance.
     * 
     * @param array $data
     * @return void
     */
    public function __construct($rawLayout, $data)
    {
        $this->rawBlocks = [];
        $this->rawLayout = $rawLayout;
        $this->data = $data;
    }

    public function compile()
    {
        $this->rawLayout = $this->compileVariables();
    }

    public function compileVariables()
    {
        $result = preg_replace_callback('/{{\s(.+)\s}}/', function ($matches) {
            return '<?php echo escape(' . $matches[1] . '); ?>';
        }, $this->rawLayout);

        return $result;
    }

    /**
     * Extract raw tags and temporary save them into an array.
     * 
     * @param string $rawContent
     * @return void
     */
    public function storeUncompiledBlocks()
    {
        extract($this->data);

        // matches[i][0] Full match [@if (condition) ... @endif]
        // matches[i][1] Group 1 @[if (condition)] ... @endif
        // matches[i][2] Group 2 @[if] (condition) ... @endif
        // matches[i][3] Group 3 @if (condition) [...] @endif
        // matches[i][4] Group 4 @if (condition) ... @end[if]
        preg_match_all('/@(([a-z]{2,})\s\(.*?\)\n)\s*(.*?\n)\s*@end([a-z]{2,})/', $this->rawLayout, $matches, PREG_SET_ORDER, 0);

        if (empty($matches)) {
            var_dump('Empty');
            return;
        }
        for ($i = 0; $i < count($matches); $i++) {
            $match = $matches[$i];
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

            $this->storeUncompiledBlock($rawBlock);
        }
        var_dump($this->rawBlocks);
    }

    private function storeUncompiledBlock($rawBlock)
    {
        return $this->getBlockPlaceholder(array_push($this->rawBlocks, $rawBlock) - 1);
    }

    public function restoreRawBlocks($rawContent)
    {

    }

    private function restoreRawBlock($rawBlock)
    {
        $result = preg_replace_callback('/' . $this->getBlockPlaceholder('(\d+)') . '/', function ($matches) {
            return $this->rawBlocks[$matches[1]];
        }, $rawBlock);
        $this->rawBlocks = [];

        return $result;
    }

    private function getBlockPlaceholder($index)
    {
        return str_replace('#', $index, '@__raw_block_#__@');
    }

    private function surroundUncompiledContent($rawContent)
    {
        return '?>' . $rawContent . '<?php';
    }

    private function prepareCondition($rawCondition, $rawContent)
    {
        return $rawCondition . ' {' . $rawContent . ' }';
    }
}
