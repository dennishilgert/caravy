<?php

namespace Caravy\Routing\Model;

use Caravy\Support\Arr;

class Request
{
    /**
     * HTTP method of the route.
     * 
     * @var string
     */
    private $method;

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
     * Parameters passed with the http-method.
     * 
     * @var array
     */
    private $params;

    public function __construct($method, $uri, $params)
    {
        $this->method = $method;
        $this->uri = $uri;

        $this->segments = $this->split($uri);
        $this->baseSegment = Arr::first($this->segments);

        $this->params = $params;
    }

    /**
     * Convert uri to segments.
     * 
     * @param string $uri
     * @return string[]
     */
    private function split($uri)
    {
        if (strpos($uri, '/') === false) {
            return [$uri];
        }
        $segments = explode('/', $uri);
        return $segments;
    }

    /**
     * Get the method of the request.
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the uri of the request.
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get the segments of the request.
     * 
     * @return array
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * Get the base-segment of the request.
     * 
     * @return string
     */
    public function getBaseSegment()
    {
        return $this->baseSegment;
    }

    /**
     * Get the params of the request.
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
