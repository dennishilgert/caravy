<?php

namespace Caravy\Routing\Model;

use Caravy\Routing\UrlHandler;

class Response
{
    const OK = 0;
    const ERR = 1;

    /**
     * Response data.
     * 
     * @var array
     */
    private $data;

    /**
     * Create a new reponse-instance.
     * 
     * @param array $data
     * @return void
     */
    public function __construct()
    {
        $this->data = [];
    }

    public function ok($message = null)
    {
        $this->data['status'] = 'ok';
        if (is_null($message) === false) {
            $this->data['message'] = $message;
        }
    }

    public function err($message)
    {
        $this->data['status'] = 'error';
        $this->data['message'] = $message;
    }

    public function redirect($location, $delay = null)
    {
        $redirect = [
            'location' => UrlHandler::makeUrl($location)
        ];
        if (is_null($delay) === false) {
            $redirect['delay'] = $delay;
        }
        $this->data['redirect'] = $redirect;
        return $this;
    }

    /**
     * Send the json-reponse to the user.
     * 
     * @return void
     */
    public function send()
    {
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}
