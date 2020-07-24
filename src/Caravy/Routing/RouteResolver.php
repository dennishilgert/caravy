<?php

namespace Caravy\Routing;

use Caravy\Support\Arr;

class RouteResolver
{
    /**
     * Instance of the route-registry.
     * 
     * @var \Caravy\Routing\RouteRegistry
     */
    private $routeRegistry;

    /**
     * Create a new route-resolver instance.
     * 
     * @param \Caravy\Routing\RouteRegistry $routeRegistry
     */
    public function __construct(\Caravy\Routing\RouteRegistry $routeRegistry)
    {
        $this->routeRegistry = $routeRegistry;
    }

    /**
     * Resolve a request to get a valid route.
     * 
     * @param \Caravy\Routing\Request $request
     * @return \Caravy\Routing\ResolveResult|false
     */
    public function resolve($request)
    {
        if (empty($request->getUri())) {
            $route = Arr::get($this->routeRegistry->sortByName(), 'index');
            return new ResolveResult($route, []);
        }
        $routes = $this->routeRegistry->getByMethod($this->routeRegistry->getRoutes(), $request->getMethod());
        foreach ($routes as $route) {
            if ($this->compare($request, $route)) {
                $params = $this->extractParams($request, $route);
                return new ResolveResult($route, $params);
            } else {
                continue;
            }
        }
        return false;
    }

    /**
     * Compare a request with a route.
     * 
     * @param \Caravy\Routing\Request $request
     * @param \Caravy\Routing\Route $route
     * @return bool
     */
    private function compare($request, $route)
    {
        $requestSegments = $request->getSegments();
        $routeSegments = $route->getSegments();

        $matched = true;

        if (count($requestSegments) === count($routeSegments)) {
            for ($i = 0; $i < count($routeSegments); $i++) {
                if (empty(Route::matchParam($routeSegments[$i]))) {
                    if ($requestSegments[$i] !== $routeSegments[$i]) {
                        $matched = false;
                        break;
                    }
                }
            }
        } else {
            $matched = false;
        }
        return $matched;
    }

    /**
     * Extract params with a param-pattern from a request.
     * 
     * @param \Caravy\Routing\Request $request
     * @param \Caravy\Routing\Route $route
     * @return array
     */
    private function extractParams($request, $route)
    {
        $requestSegments = $request->getSegments();
        $routeSegments = $route->getSegments();

        $params = [];
        for ($i = 0; $i < count($routeSegments); $i++) {
            if (empty(Route::matchParam($routeSegments[$i])) === false) {
                array_push($params, $requestSegments[$i]);
            }
        }
        return $params;
    }
}
