<?php

/**
 * Converts critial symbols for XSS-injections 
 * into html entities.
 * 
 * @var string $input
 * @return string
 */
function escape(string $input)
{
    return htmlentities($input, ENT_QUOTES, "UTF-8");
}

/**
 * Short version of rendering a view.
 * 
 * @param string $name
 * @param array $data
 * @return \Caravy\View\View
 */
function view($name, $data, $container)
{
    $view = new \Caravy\View\View($name, $data, $container);
    return $view->render();
}