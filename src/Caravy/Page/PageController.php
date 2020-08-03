<?php

namespace Caravy\Page;

class PageController
{
    public function __construct()
    {

    }

    public function index()
    {
        $view = new \Caravy\View\View('index', [
            'title' => 'Hallo Welt!',
            'params' => [
                'key1' => 'Eintrag 1',
                'key2' => 'Eintrag 2',
                'key3' => 'Eintrag 3'
            ],
            'footer' => 'footer note'
        ]);
        $view->render();
    }
}
