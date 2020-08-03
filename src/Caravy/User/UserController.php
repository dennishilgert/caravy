<?php

namespace Caravy\User;

class UserController
{
    public function __construct()
    {
        
    }

    public function create()
    {
        var_dump('create');
    }

    public function edit($userId)
    {
        var_dump($userId);
    }

    public function delete($userId)
    {
        var_dump($userId);
    }

    public function profile($username)
    {
        view('user/profile', [
            'id' => '3',
            'username' => $username,
            'firstName' => 'Michael',
            'lastName' => 'Jordan',
            'email' => 'michael@gmail.com',
        ]);
    }
}