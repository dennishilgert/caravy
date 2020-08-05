<?php

namespace Caravy\Routing\Model;

class Route
{
    /**
     * Name of the route.
     * 
     * @var string
     */
    private $name;

    /**
     * HTTP methods of the route.
     * 
     * @var array
     */
    private $methods;

    /**
     * Uri of the route.
     * 
     * @var string
     */
    private $uri;

    /**
     * Segements of the uri.
     * 
     * @var array
     */
    private $segments;

    /**
     * Base-segment of the uri.
     * 
     * @var string
     */
    private $baseSegment;

    /**
     * Complete controller-action.
     * 
     * @var string
     */
    private $controllerAction;

    /**
     * Controller for the Route.
     * 
     * @var string
     */
    private $controller;

    /**
     * Controller-function for the Route.
     * 
     * @var string
     */
    private $action;

    /**
     * Create a new route instance.
     * 
     * @param string $method
     * @param string $uri
     * @param string $controllerAction
     */
    public function __construct($methods, $uri, $controllerAction, $name)
    {
        $this->methods = $methods;
        $this->uri = $uri;
        $this->controllerAction = $controllerAction;
        $this->name = $name;

        $this->seperateController($this->controllerAction);
        $this->seperateAction($this->controllerAction);

        $this->segments = $this->seperate($uri, '/');
    }

    /**
     * Seperate controller-name from controller-action.
     * 
     * @param string $controllerAction
     * @return void
     */
    private function seperateController($controllerAction)
    {
        $this->controller = $this->seperate($controllerAction, '@', 0);
    }

    /**
     * Seperate action-name from controller-action.
     * 
     * @param string $controllerAction
     * @return void
     */
    private function seperateAction($controllerAction)
    {
        $this->action = $this->seperate($controllerAction, '@', 1);
    }

    /**
     * Seperate a string into segments by a delimitter.
     * 
     * @param string $string
     * @param string $delimitter
     * @param int $index
     * @return array|string
     */
    private function seperate($string, $delimitter, $index = null)
    {
        if (strpos($string, $delimitter) === false) {
            return [$string];
        }
        if (is_null($index)) {
            return explode($delimitter, $string);
        }
        return explode($delimitter, $string)[$index];
    }

    /**
     * Check if a segment of a string matches a pattern.
     * 
     * @param string $pattern
     * @param string $input
     * @param int $index
     * @return array
     */
    public static function matchParam($input, $index = 0)
    {
        preg_match('/\{([\w]+?)\}/', $input, $matches);
        if (empty($matches)) {
            return [];
        }
        return $matches[$index];
    }

    /**
     * Check if a string has segments matching a pattern.
     * 
     * @param string $input
     * @param int $index
     * @return array
     */
    public static function matchParams($input, $index = 0)
    {
        preg_match_all('/\{([\w]+?)\}/', $input, $matches);
        if (empty($matches)) {
            return [];
        }
        return $matches[$index];
    }

    /**
     * Get the name of the current route.
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the method of the current route.
     * 
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Get the uri of the current route.
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get the segments of the current route.
     * 
     * @return array
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * Get the base-segment of the current route.
     * 
     * @return string
     */
    public function getBaseSegment()
    {
        return $this->baseSegment;
    }

    /**
     * Get the responsible controller for the current route.
     * 
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get the action for the current route.
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}
