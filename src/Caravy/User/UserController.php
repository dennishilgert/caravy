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
        var_dump('create');
    }

    public function edit($userId)
    {
        view('user/edit', [
            'title' => 'Benutzer bearbeiten',
            'action' => 'test',
            'id' => $userId,
            'username' => 'rischard',
            'firstName' => 'Richi',
            'lastName' => 'Harung',
            'email' => 'mahrung@gmail.com',
        ], $this->container);
    }

    public function delete($userId)
    {
        var_dump($userId);
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