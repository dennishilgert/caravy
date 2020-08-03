<?php

namespace Caravy\View;

use Caravy\Support\Str;
use Exception;

class RenderEngine
{
    /**
     * Temporary stored blocks.
     * 
     * @var array
     */
    private $blocks;

    /**
     * Content of the layout-file.
     * 
     * @var string
     */
    private $layout;

    /**
     * Data passed to the view.
     * 
     * @var array
     */
    private $data;

    /**
     * Create a new render-engine instance.
     * 
     * @param string $layout
     * @param array $data
     * @return void
     */
    public function __construct($layout, $data)
    {
        $this->blocks = [];
        $this->layout = $layout;
        $this->data = $data;
    }

    /**
     * Get the output of the generated layout.
     * 
     * @return string
     */
    public function compile()
    {
        $this->layout = $this->storeYields();
        $this->layout = $this->storeStatements();

        $restoredLayout = preg_replace_callback('/' . $this->getBlockPlaceholder('(\d+)') . '/', function ($matches) {
            return $this->blocks[$matches[1]];
        }, $this->layout);
        $this->blocks = [];

        extract($this->data, EXTR_SKIP);
        ob_start();

        try {
            eval('?>' . $restoredLayout);
        } catch (Exception $e) {
            // Handle exception
            echo $e->getMessage();
        }

        return ob_get_clean();
    }

    /**
     * Extract the yield-tags from the layout and replace
     * them with a placeholder.
     * 
     * @return string
     */
    private function storeYields()
    {
        $result = preg_replace_callback('/@yield\s?\(\'(?<variable>[\w\$\-\>]+)\'\)\;/', function ($match) {
            $variable = $match['variable'];

            return $this->storeBlock(Str::asymetric($variable, '<?php echo escape($', '); ?>'));
        }, $this->layout, PREG_SET_ORDER);

        return $result;
    }

    /**
     * Extract the statement-blocks from the layout and replace
     * them with a placeholder.
     * 
     * @return string
     */
    private function storeStatements()
    {
        $result = preg_replace_callback('/@(?<statement>[a-z]{2,})\s?\((?<parameters>.+?)\)\s*(?<content>.+?)\s*@end\1/s', function ($match) {
            $statement = $match['statement'];
            $parameters = $match['parameters'];
            $content = $match['content'];

            $block = $this->buildConditionBlock($statement, $parameters, $content);

            return $this->storeBlock($block);
        }, $this->layout, PREG_SET_ORDER);

        return $result;
    }

    /**
     * Save the uncompiled blocks temporary in an array.
     * 
     * @param string $block
     * @return string
     */
    private function storeBlock($block)
    {
        return $this->getBlockPlaceholder(array_push($this->blocks, $block) - 1);
    }

    /**
     * Build a statement out of the segments.
     * 
     * @param string $statement
     * @param string $parameters
     * @param string $content
     * @return string
     */
    private function buildConditionBlock($statement, $parameters, $content)
    {
        $content = $this->convertVariables($content);
        return '<?php ' . $statement . '(' . $parameters . '): ?>' . $content . '<?php end' . $statement . '; ?>';
    }

    /**
     * Convert the variable-syntax into php-syntax.
     * 
     * @param string $block
     * @return string
     */
    private function convertVariables($block)
    {
        $result = preg_replace_callback('/\{(?<type>\{|\!\!)\s?(?<variable>[\w\$\-\>]+)\s?(\1|\})\}/', function ($match) {
            $type = $match['type'];
            $variable = $match['variable'];
            switch ($type) {
                case '{':
                    return Str::asymetric($variable, '<?php echo escape(', '); ?>');
                case '!!':
                    return Str::asymetric($variable, '<?php echo ', '; ?>');
                default:
                    return Str::asymetric($variable, '<?php echo escape(', '); ?>');
            }
        }, $block, PREG_SET_ORDER);

        return $result;
    }

    /**
     * Get a placeholder for a block.
     * 
     * @param int $index
     * @return string
     */
    private function getBlockPlaceholder($index)
    {
        return str_replace('#', $index, '@__raw_block_#__@');
    }
}
