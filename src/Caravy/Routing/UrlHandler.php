<?php

namespace Caravy\Routing;

class UrlHandler
{
    public static function redirect($location)
    {
        $url = static::makeUrl($location);
        header("Location: {$url}");
    }

    public static function delayedRedirect($location, $delay)
    {
        $url = static::makeUrl($location);
        header("Refresh:{$delay}; url={$url}", true, 303);
    }

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