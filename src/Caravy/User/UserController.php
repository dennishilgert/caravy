<?php

namespace Caravy\User;

class UserController
{
    /**
     * Instance of the container.
     * 
     * @var \Caravy\Container\Container
     */
    private $container;

    public function __construct(\Caravy\Container\Container $container)
    {
        $this->container = $container;
    }

    public function create()
    {
        view('user/create', [
            'title' => 'Benutzer erstellen',
            'action' => \Caravy\Routing\UrlHandler::makeUrl('user/create'),
        ], $this->container);
    }

    public function edit($id)
    {
        view('user/edit', [
            'title' => 'Benutzer bearbeiten',
            'action' => \Caravy\Routing\UrlHandler::makeUrl('user/edit'),
            'id' => $id,
            'username' => 'rischard',
            'firstName' => 'Richi',
            'lastName' => 'Harung',
            'email' => 'mahrung@gmail.com',
        ], $this->container);
    }

    public function delete($id)
    {
        var_dump($id);
    }

    public function profile($username)
    {
        view('user/profile', [
            'title' => 'Profil von ' . $username,
            'id' => '3',
            'username' => $username,
            'firstName' => 'Michael',
            'lastName' => 'Jordan',
            'email' => 'michael@gmail.com',
        ], $this->container);
    }
}