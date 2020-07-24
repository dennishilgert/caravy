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
     * @return void
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

    /**
     * Get routes with an explicit variable-value.
     * 
     * @param \Caravy\Routing\Route[] $routes
     * @param mixed $filter
     * @param string $filterName
     * @return \Caravy\Routing\Route[]
     */
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

    /**
     * Get routes sorted by their name.
     * 
     * @param \Caravy\Routing\Route[] $routes
     * @return \Caravy\Routing\Route[]
     */
    public function sortByName($routes = null)
    {
        if (is_null($routes)) {
            $routes = $this->getRoutes();
        }
        return $this->sortRoutes($routes, 'getName');
    }

    /**
     * Get routes sorted by a route-variable.
     * 
     * @param \Caravy\Routing\Route[] $routes
     * @param string $sortName
     * @return \Caravy\Routing\Route[]
     */
    private function sortRoutes($routes, $sortName)
    {
        $result = [];
        foreach ($routes as $route) {
            $result[$route->{$sortName}()] = $route;
        }
        return $result;
    }

    /**
     * Get all registered routes.
     * 
     * @return \Caravy\Routing\Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
