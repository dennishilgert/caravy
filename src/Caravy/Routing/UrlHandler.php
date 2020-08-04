<?php

namespace Caravy\Routing;

class UrlHandler
{
    /**
     * Redirection to a new location.
     * 
     * @param string $location
     * @return void
     */
    public static function redirect($location)
    {
        $url = static::makeUrl($location);
        header("Location: {$url}");
    }

    /**
     * Delayed redirection to a new location.
     * 
     * @param string $location
     * @param int $delay
     * @return void
     */
    public static function delayedRedirect($location, $delay)
    {
        $url = static::makeUrl($location);
        header("Refresh:{$delay}; url={$url}", true, 303);
    }

    /**
     * Make the new url by prepending the base-path.
     * 
     * @param string $location
     * @return string
     */
    public static function makeUrl($location)
    {
        $baseUrl = BASE_URL;
        if (substr($baseUrl, -1) == '/') {
            return $baseUrl . $location;
        } else {
            return $baseUrl . '/' . $location;
        }
    }
}