<?php

namespace Caravy\Routing;

use Caravy\Routing\Model\Route;

class Router
{
    /**
     * Instance of the route-registry.
     * 
     * @var \Caravy\Routing\RouteRegistry
     */
    private $routeRegistry;

    /**
     * Instance of the route-resolver.
     * 
     * @var \Caravy\Routing\RouteResolver
     */
    private $routeResolver;

    /**
     * Instance of the container.
     * 
     * @var \Caravy\Container\Container
     */
    private $container;

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
    public function __construct(\Caravy\Routing\RouteRegistry $routeRegistry, \Caravy\Routing\RouteResolver $routeResolver, \Caravy\Container\Container $container)
    {
        $this->routeRegistry = $routeRegistry;
        $this->routeResolver = $routeResolver;
        $this->container = $container;
    }

    /**
     * Register a new route corresponding to POST method.
     * 
     * @param string $uri
     * @param mixed $closure
     * @return void
     */
    public function get($uri, $closure, $name = null)
    {
        $route = new Route(['GET'], $uri, $closure, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to POST method.
     * 
     * @param string $uri
     * @param \Closure $closure
     * @return void
     */
    public function post($uri, $closure, $name = null)
    {
        $route = new Route(['POST'], $uri, $closure, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to PUT method.
     * 
     * @param string $uri
     * @param \Closure $closure
     * @return void
     */
    public function put($uri, $closure, $name = null)
    {
        $route = new Route(['PUT'], $uri, $closure, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to DELETE method.
     * 
     * @param string $uri
     * @param \Closure $closure
     * @return void
     */
    public function delete($uri, $closure, $name = null)
    {
        $route = new Route(['DELETE'], $uri, $closure, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to any method.
     * 
     * @param string $uri
     * @param \Closure $closure
     * @return void
     */
    public function any($uri, $closure, $name = null)
    {
        $route = new Route($this->methods, $uri, $closure, $name);
        $this->addRoute($route);
    }

    /**
     * Add a Route to the route-registry.
     * 
     * @param \Caravy\Routing\Model\Route $route
     * @return void
     */
    private function addRoute($route)
    {
        $this->routeRegistry->register($route);
    }

    /**
     * Resolve a route and execute the defined function.
     * 
     * @param \Caravy\Routing\Model\Request $request
     * @return void
     */
    public function handleRequest($request)
    {
        $resolveResult = $this->routeResolver->resolve($request);
        if ($resolveResult === false) {
            // throw bad-request exception
            var_dump('Bad-request exception: ');
            var_dump($request);
            return;
        }
        $route = $resolveResult->getRoute();
        $routeController = $this->container->provide($route->getController());
        if ($routeController === false) {
            // throw bad-controller exception
            var_dump('Bad-controller exception');
            return;
        }
        $params = $resolveResult->getParams();
        $response = call_user_func_array(array($routeController, $route->getAction()), $params);
        if ($response === false) {
            // throw bad-function exception
            var_dump('Bad-function exception');
            return;
        }
        if (is_null($response) === false) {
            $response->send();
        }
    }
}
