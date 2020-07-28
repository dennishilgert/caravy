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
            'title' => 'Hallo Welt!',
            'params' => [
                'key1' => 'Eintrag 1',
                'key2' => 'Eintrag 2'
            ]
        ]);
        $view->render();
    }
}
