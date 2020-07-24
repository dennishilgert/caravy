<?php

namespace Caravy\Routing;

class ResolveResult
{
    /**
     * Resolved route intance.
     * 
     * @var \Caravy\Routing\Route
     */
    private $route;

    /**
     * Resolved route params.
     * 
     * @var array
     */
    private $params;

    /**
     * Create a new resolve-result instance.
     * 
     * @param \Caravy\Routing\Route $route
     * @param array $params
     */
    public function __construct($route, $params)
    {
        $this->route = $route;
        $this->params = $params;
    }

    /**
     * Get the resolved route.
     * 
     * @return \Caravy\Routing\Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get the resolved parameters.
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}