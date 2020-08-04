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
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (empty($_POST['_method']) === false) {
            $requestMethod = $_POST['_method'];
            unset($_POST['_method']);
        }
        $request = new \Caravy\Routing\Request($requestMethod, $queryString, $_POST);
        return $request;
    }
}
