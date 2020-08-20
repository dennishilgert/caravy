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
     * Seek for the id of an user by username.
     * 
     * @param string $username
     * @return int
     */
    public function seekId($username)
    {
        return $this->findFirst('id', 'username', $username);
    }

    /**
     * Check if a username already exists.
     * 
     * @param string $username
     * @return bool
     */
    public function exists($username)
    {
        $id = $this->findFirst('id', 'username', $username);
        return empty($id) === false;
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
     * Delete a user.
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->remove('id', $id);
    }

    /**
     * Update the details of an user.
     * 
     * @param int $id
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
     * @param int $id
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