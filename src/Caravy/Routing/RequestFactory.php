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
        switch ($requestMethod) {
            case 'POST':
                if (empty($_POST['_method']) === false) {
                    $requestMethod = $_POST['_method'];
                }
                break;
            case 'GET':
                if (empty($_GET['_method']) === false) {
                    $requestMethod = $_GET['_method'];
                }
                break;
        }
        $request = new \Caravy\Routing\Request($requestMethod, $queryString);
        return $request;
    }
}
