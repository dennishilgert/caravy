<?php

namespace Caravy\View;

class View
{
    /**
     * Name of the view.
     * 
     * @var string
     */
    private $name;

    /**
     * Data to pass to the view.
     * 
     * @var array
     */
    private $data;

    /**
     * Instance of the render-engine.
     * 
     * @var \Caravy\View\RenderEngine
     */
    private $renderEngine;

    /**
     * Create a new View instance.
     * 
     * @param \Caravy\View\RenderEngine $renderEngine
     * @param string $name
     * @param string $path
     * @param array $data
     * @return void
     */
    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;

        $this->renderEngine = new \Caravy\View\RenderEngine($this->loadRawLayout(), $this->data);
    }

    /**
     * Send the view to the client.
     * 
     * @return void
     */
    public function render()
    {
        echo $this->renderEngine->compile();
    }

    /**
     * Get the content of the layout-file as string.
     * 
     * @return string
     */
    private function loadRawLayout()
    {
        $dir = __DIR__ . '/../../../layouts/';
        $file = $dir . $this->name . '.layout.php';
        if (is_null($file)) {
            // throw bad-view-name exception
            return false;
        }
        return file_get_contents($file);
    }
}
