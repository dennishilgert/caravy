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
     * Content of the layout-file.
     * 
     * @var string
     */
    private $rawLayout;

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
        $this->loadLayout();
        $this->renderEngine = new \Caravy\View\RenderEngine($this->rawLayout, $this->data);
    }

    /**
     * Render the contents of the view.
     * 
     * @return string
     */
    public function renderContents()
    {
        $this->renderEngine->compileVariables();
        $this->renderEngine->storeUncompiledBlocks();
    }

    /**
     * Send the view to the client.
     * 
     * @return void
     */
    public function render()
    {
        echo $this->renderContents();
    }

    private function loadLayout()
    {
        $dir = __DIR__ . '/../../../layouts/';
        $file = $dir . $this->name . '.layout.php';
        if (is_null($file)) {
            // throw bad-view-name exception
            return;
        }
        $this->rawLayout = file_get_contents($file);
    }
}
