<?php

namespace Caravy\Page;

class PageController
{
    /**
     * Instance of the container.
     * 
     * @var \Caravy\Container\Container
     */
    private $container;

    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
    }

    public function index()
    {
        view('index', [
            'title' => 'Hallo Welt!',
            'params' => [
                'key1' => 'Eintrag 1',
                'key2' => 'Eintrag 2',
                'key3' => 'Eintrag 3'
            ],
        ], $this->container);
    }
}
