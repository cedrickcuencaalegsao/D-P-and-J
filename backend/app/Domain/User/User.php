<?php

namespace App\Domain\User;

class User
{
    private ?int $id;
    private ?int $roleID;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $apiToken;
    private ?String $email;
    private ?String $password;

    public function __construct(
        ?int $id = null,
        ?int $roleID = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $email = null,
        ?string $password = null,
        ?string $apiToken = null
    )
    {
        $this->id = $id;
        $this->roleID = $roleID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->apiToken = $apiToken;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'roleID' => $this->roleID,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'apiToken' => $this->apiToken
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function getRoleID()
    {
        return $this->roleID;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
        }
    public function getApiToken()
    {
        return $this->apiToken;
    }
}
