<?php

namespace Caravy\User\Middleware;

use Caravy\Database\AbstractMiddleware;

class UserMiddleware extends AbstractMiddleware
{
    public function getTableName()
    {
        return 'caravy_users';
    }

    public function getModelName()
    {
        return 'Caravy\\User\\Middleware\\User';
    }

    /**
     * Seek for the id of an user by username
     * 
     * @param string $username
     * @return string
     */
    public function seekId($username)
    {
        return $this->findFirst('id', 'username', $username);
    }

    /**
     * Create a new user.
     * 
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function create($username, $firstName, $lastName, $email, $password)
    {
        $tableName = $this->getTableName();
        $passHash = password_hash($password, PASSWORD_DEFAULT);

        $statement = $this->pdo->prepare("INSERT INTO `$tableName` (`id`, `username`, `first_name`, `last_name`, `email`, `pass_hash`) VALUES (NULL, :username, :firstName, :lastName, :email, :passHash)");
        return $statement->execute([
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'passHash' => $passHash
        ]);
    }

    /**
     * Update the details of an user.
     * 
     * @param string $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @return bool
     */
    public function updateDetails($id, $username, $firstName, $lastName, $email)
    {
        $tableName = $this->getTableName();

        $statement = $this->pdo->prepare("UPDATE `$tableName` SET username = :username, first_name = :firstName, last_name = :lastName, email = :email WHERE id = :id");
        return $statement->execute([
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'id' => $id,
        ]);
    }

    /**
     * Update the password of an user.
     * 
     * @param string $id
     * @param string $password
     * @return bool
     */
    public function updatePassword($id, $password)
    {
        $tableName = $this->getTableName();
        $passHash = password_hash($password, PASSWORD_DEFAULT);

        $statement = $this->pdo->prepare("UPDATE `$tableName` SET pass_hash = :passHash WHERE id = :id");
        return $statement->execute([
            'passHash' => $passHash,
            'id' => $id
        ]);
    }
}