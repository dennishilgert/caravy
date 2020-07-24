<?php

namespace Caravy\Routing;

/**
 * Create a new request-facotry instance.
 */
class RequestFactory
{
    /**
     * Buold a request for the current url.
     * 
     * @return \Caravy\Routing\Request
     */
    public static function current()
    {
        $queryString = rawurldecode($_SERVER['QUERY_STRING']);
        $queryString = trim($queryString, '/');
        $request = new \Caravy\Routing\Request($_SERVER['REQUEST_METHOD'], $queryString);
        return $request;
    }
}