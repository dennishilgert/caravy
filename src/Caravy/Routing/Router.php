<?php

namespace Caravy\Routing;

use Caravy\Routing\Model\Route;

class Router
{
    /**
     * Instance of the container.
     * 
     * @var \Caravy\Container\Container
     */
    private $container;

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
    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
        $this->routeRegistry = $container->provide(\Caravy\Routing\RouteRegistry::class);
        $this->routeResolver = $container->provide(\Caravy\Routing\RouteResolver::class);
    }

    /**
     * Register a new route corresponding to POST method.
     * 
     * @param string $uri
     * @param string $controllerAction
     * @return void
     */
    public function get($uri, $controllerAction, $name = null)
    {
        $route = new Route(['GET'], $uri, $controllerAction, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to POST method.
     * 
     * @param string $uri
     * @param string $controllerAction
     * @return void
     */
    public function post($uri, $controllerAction, $name = null)
    {
        $route = new Route(['POST'], $uri, $controllerAction, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to PUT method.
     * 
     * @param string $uri
     * @param string $controllerAction
     * @return void
     */
    public function put($uri, $controllerAction, $name = null)
    {
        $route = new Route(['PUT'], $uri, $controllerAction, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to DELETE method.
     * 
     * @param string $uri
     * @param string $controllerAction
     * @return void
     */
    public function delete($uri, $controllerAction, $name = null)
    {
        $route = new Route(['DELETE'], $uri, $controllerAction, $name);
        $this->addRoute($route);
    }

    /**
     * Register a new route corresponding to any method.
     * 
     * @param string $uri
     * @param string $controllerAction
     * @return void
     */
    public function any($uri, $controllerAction, $name = null)
    {
        $route = new Route($this->methods, $uri, $controllerAction, $name);
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
            view('error', [
                'title' => 'Error 404',
                'code' => '404 Not found',
                'message' => 'Die angeforderte Seite konnte nicht gefunden werden.',
            ], $this->container);
            return;
        }
        $route = $resolveResult->getRoute();
        $routeController = $this->container->provide($route->getController());
        if ($routeController === false) {
            view('error', [
                'title' => 'Error 400',
                'code' => '400 Bad request',
                'message' => 'Die angegebene Controller existiert nicht.',
            ], $this->container);
            return;
        }
        $params = $resolveResult->getParams();
        $response = call_user_func_array(array($routeController, $route->getAction()), $params);
        if ($response === false) {
            view('error', [
                'title' => 'Error 400',
                'code' => '400 Bad request',
                'message' => 'Die angegebene Funktion existiert nicht.',
            ], $this->container);
            return;
        }
        if (is_null($response) === false) {
            $response->send();
        }
    }
}
