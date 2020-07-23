<?php

namespace Caravy\Routing;

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

    public function match($request)
    {
        $methodRoutes = $this->routeRegistry->getByMethod($this->routeRegistry->getRoutes(), $request->getMethod());
        foreach ($methodRoutes as $route) {
            var_dump($route->getUri());
            if ($this->compare($request, $route)) {
                return $route;
            } else {
                continue;
            }
        }
    }

    public function compare($request, $route)
    {
        $requestSegments = $request->getSegments();

        $routeSegments = $route->getSegments();
        $routeSegmentsPriorities = $route->getSegmentPriorities();

        $matched = true;

        if (count($requestSegments) === count($routeSegments)) {
            for ($i = 0; $i < count($routeSegments); $i++) {
                if ($routeSegmentsPriorities[$i] === 'const') {
                    if ($routeSegments[$i] !== $requestSegments[$i]) {
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
}
