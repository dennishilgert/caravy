<?php

namespace Caravy\Routing;

class Redirection
{
    /**
     * Destination for the redirect.
     * 
     * @var string
     */
    private $location;

    /**
     * Delay for the redirect.
     * 
     * @var int
     */
    private $delay;

    /**
     * Create a new redirection-instance.
     * 
     * @param string $location
     * @param int $delay
     * @return void
     */
    public function __construct($location, $delay = null)
    {
        $this->location = $location;
        $this->delay = $delay;
    }

    /**
     * Initiate the redirection.
     * 
     * @return void
     */
    public function initiate()
    {
        if (is_null($this->delay) === false) {
            UrlHandler::delayedRedirect($this->location, $this->delay);
            return;
        }
        UrlHandler::redirect($this->location);
    }
}