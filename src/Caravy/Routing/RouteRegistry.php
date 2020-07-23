<?php

namespace Caravy\Routing;

use Caravy\Support\Arr;

class RouteRegistry
{
    /**
     * Registered routes.
     * 
     * @var array
     */
    private $routes = [];

    /**
     * Register a new route.
     * 
     * @param \Caravy\Routing\Route $route
     */
    public function register($route)
    {
        array_push($this->routes, $route);
    }

    /**
     * Get routes with equal method.
     * 
     * @param \Caravy\Routing\Route[] $routes
     * @param string $method
     * @return \Caravy\Routing\Route[]
     */
    public function getByMethod($routes, $method)
    {
        return $this->filterRoutes($routes, $method, 'getMethods');
    }

    /**
     * Get routes with equal base-segment.
     * 
     * @param \Caravy\Routing\Route[] $routes
     * @param string $baseSegment
     * @return \Caravy\Routing\Route[]
     */
    public function getByBaseSegment($routes, $baseSegment)
    {
        return $this->filterRoutes($routes, $baseSegment, 'getBaseSegment');
    }

    private function filterRoutes($routes, $filter, $filterName)
    {
        $result = [];
        foreach ($routes as $route) {
            if (Arr::has($route->{$filterName}(), $filter)) {
                array_push($result, $route);
            }
        }
        return $result;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}