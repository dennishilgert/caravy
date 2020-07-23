<?php

namespace Caravy\Routing;

use Caravy\Support\Arr;

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
     * Priorities of the segments.
     * 
     * @var array
     */
    private $segmentPriorities;

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
    public function __construct($methods, $uri, $controllerAction)
    {
        $this->methods = $methods;
        $this->uri = $uri;
        $this->controllerAction = $controllerAction;

        $this->seperateController($this->controllerAction);
        $this->seperateAction($this->controllerAction);

        $this->segments = $this->seperate($uri, '/');

        $this->segmentPriorities = $this->definePriorities($this->segments, $this->uri);
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

    private function definePriorities($segments, $uri)
    {
        $segmentPriorities = [];

        $paramIndex = [];
        $params = $this->extractParams($uri);
        if (empty($params) === false) {
            foreach ($params as $param) {
                array_push($paramIndex, Arr::position($segments, $param));
            }
        }

        for ($i = 0; $i < count($segments); $i++) {
            if (Arr::has($paramIndex, $i)) {
                $segmentPriorities[$i] = 'param';
            } else {
                $segmentPriorities[$i] = 'const';
            }
        }
        return $segmentPriorities;
    }

    private function extractParams($uri)
    {
        preg_match_all('/\{([\w]+?)\}/', $uri, $matches);
        return $matches[0];
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
     * Get the priorities of the segments.
     * 
     * @return array
     */
    public function getSegmentPriorities()
    {
        return $this->segmentPriorities;
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
}
