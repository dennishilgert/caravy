<?php

namespace Caravy\Routing;

class Router
{
    /**
     * Instance of the route-registry.
     * 
     * @var \Caravy\Routing\RouteRegistry
     */
    private $routeRegistry;

    /**
     * All methods the router can handle.
     * 
     * @var array
     */
    private $methods = ['GET', 'POST', 'PUT', 'DELETE'];

    /**
     * Create a new router instance.
     * 
     * @param \Caravy\Routing\RouteRegistry $routeRegistry
     */
    public function __construct(\Caravy\Routing\RouteRegistry $routeRegistry)
    {
        $this->routeRegistry = $routeRegistry;
    }

    /**
     * Register a new route corresponding to POST method.
     * 
     * @param string $uri
     * @param mixed $closure
     */
    public function get($uri, $closure)
    {
        $route = new Route(['GET'], $uri, $closure);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to POST method.
     * 
     * @param string $uri
     * @param \Closure $closure
     */
    public function post($uri, $closure)
    {
        $route = new Route(['POST'], $uri, $closure);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to PUT method.
     * 
     * @param string $uri
     * @param \Closure $closure
     */
    public function put($uri, $closure)
    {
        $route = new Route(['PUT'], $uri, $closure);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to DELETE method.
     * 
     * @param string $uri
     * @param \Closure $closure
     */
    public function delete($uri, $closure)
    {
        $route = new Route(['DELETE'], $uri, $closure);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to any method.
     * 
     * @param string $uri
     * @param \Closure $closure
     */
    public function any($uri, $closure)
    {
        $route = new Route($this->methods, $uri, $closure);
        $this->addRoute($route);
    }

    /**
     * Add a Route to the route-registry.
     * 
     * @param \Caravy\Routing\Route $route
     */
    private function addRoute($route)
    {
        $this->routeRegistry->register($route);
    }
}
