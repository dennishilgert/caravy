<?php

namespace Caravy\View;

use Caravy\Support\Str;
use Exception;

class RenderEngine
{
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
     * Instance of the compiler-registry.
     * 
     * @var \Caravy\View\CompilerRegistry
     */
    private $compilerRegistry;

    /**
     * Create a new render-engine instance.
     * 
     * @param string $layout
     * @param array $data
     * @return void
     */
    public function __construct($layout, $data, $compilerRegistry)
    {
        $this->blocks = [];
        $this->layout = $layout;
        $this->data = $data;
        $this->compilerRegistry = $compilerRegistry;
    }

    /**
     * Get the output of the generated layout.
     * 
     * @return string
     */
    public function compile()
    {
        $this->layout = $this->compileTags($this->layout);
        $this->layout = $this->compileStatements($this->layout);

        extract($this->data, EXTR_SKIP);
        ob_start();

        try {
            eval('?>' . $this->layout);
        } catch (Exception $e) {
            // Handle exception
            echo $e->getMessage();
        }

        return ob_get_clean();
    }

    /**
     * Find and compile the tags.
     * 
     * @param string $input
     * @return string|false
     */
    private function compileTags($input)
    {
        $result = preg_replace_callback('/@(?<type>[\w]+)\s?\(\'(?<parameter>[\w\$\-\>\/\.]+)\'\)\;/', function ($match) {
            $type = $match['type'];

            $compiler = $this->compilerRegistry->getCompiler($type);
            if ($compiler === false) {
                // throw bad-compiler exception
                return false;
            }
            $parameter = $match['parameter'];
            $compiled = $compiler->compile($parameter, $this->data);

            return $compiled;
        }, $input);

        return $result;
    }

    /**
     * Find and compile the statement-blocks.
     * 
     * @param string $input
     * @return string
     */
    private function compileStatements($input)
    {
        $result = preg_replace_callback('/@(?<statement>[a-z]{2,})\s?\(\s{1}(?<parameters>.+?)\s{1}\)\s*(?<content>.+?)\s*@end\1/s', function ($match) {
            $statement = $match['statement'];
            $parameters = $match['parameters'];
            $content = $match['content'];

            if ($this->containsStatements($content)) {
                $content = $this->compileStatements($content);
            }
            $block = $this->buildConditionBlock($statement, $parameters, $content);

            return $block;
        }, $input);

        return $result;
    }

    /**
     * Check wether a block contains an embedded statement.
     * 
     * @param string $input
     * @return array|false
     */
    private function containsStatements($input)
    {
        preg_match_all('/@(?<statement>[a-z]{2,})\s?\(\s{1}(?<parameters>.+?)\s{1}\)\s*(?<content>.+?)\s*@end\1/s', $input, $matches, PREG_SET_ORDER, 1);
        return empty($matches) === false;
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
        }, $block);

        return $result;
    }
}
