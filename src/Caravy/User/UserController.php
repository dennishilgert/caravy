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

    public function delete()
    {
        var_dump('delete');
    }

    public function profile()
    {
        var_dump('profile');
    }
}