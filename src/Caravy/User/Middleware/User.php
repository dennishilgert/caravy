<?php

namespace Caravy\User\Middleware;

class User
{
    /**
     * Id of the user.
     * 
     * @var int
     */
    public $id;

    /**
     * Username of the user.
     * 
     * @var string
     */
    public $username;

    /**
     * First name of the user.
     * 
     * @var string
     */
    public $first_name;

    /**
     * Last name of the user.
     * 
     * @var string
     */
    public $last_name;

    /**
     * Email of the user.
     * 
     * @var string
     */
    public $email;

    /**
     * Hash of the user-password.
     * 
     * @var string
     */
    public $pass_hash;
}