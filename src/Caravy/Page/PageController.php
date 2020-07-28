<?php

namespace Caravy\Page;

class PageController
{
    private $container;

    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
    }

    public function index()
    {
        $view = new \Caravy\View\View('index', [
            'title' => 'Seitentitel',
            'params' => [
                'key1' => 'value1',
                'key2' => 'value2'
            ]
        ]);
        $view->render();
    }
}
