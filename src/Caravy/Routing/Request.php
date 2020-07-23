<?php

namespace Caravy\Routing;

use caravy\Support\Arr;

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

    public function __construct($method, $uri)
    {
        $this->method = $method;
        $this->uri = $uri;

        $this->segments = $this->convert($uri);
        $this->baseSegment = Arr::first($this->segments);
    }

    /**
     * Convert uri to segments.
     * 
     * @param string $uri
     * @return string[]
     */
    private function convert($uri)
    {
        if (strpos($uri, '/') === false) {
            return [$uri];
        }
        $segments = explode('/', $uri);
        return $segments;
    }

    /**
     * Get the method of the current request.
     * 
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the uri of the current request.
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get the segments of the current request.
     * 
     * @return array
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * Get the base-segment of the current request.
     * 
     * @return string
     */
    public function getBaseSegment()
    {
        return $this->baseSegment;
    }
}
