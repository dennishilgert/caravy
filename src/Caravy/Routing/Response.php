<?php

namespace Caravy\Routing;

class Response
{
    /**
     * State of success.
     * 
     * @var bool
     */
    private $success;

    /**
     * View for the response.
     * 
     * @var \Caravy\View\View
     */
    private $view;

    /**
     * Redirect after displaying the view.
     * 
     * @var \Caravy\Routing\Redirection
     */
    private $redirection;

    /**
     * Create a new reponse-instance.
     * 
     * @param bool $success
     * @param \Caravy\View\View $view
     * @param \Caravy\Routing\Redirection $redirection
     * @return void
     */
    public function __construct($success, $view, $redirection = null)
    {
        $this->success = $success;
        $this->view = $view;
        $this->redirection = $redirection;
    }

    /**
     * Send the reponse to the user.
     * 
     * @return void
     */
    public function send()
    {
        if (is_null($this->view) === false) {
            $this->view->render();
        }
        if (is_null($this->redirection) === false) {
            $this->redirection->initiate();
        }
    }

    /**
     * Get the state of success.
     * 
     * @return bool
     */
    public function succeed()
    {
        return $this->success;
    }
}
