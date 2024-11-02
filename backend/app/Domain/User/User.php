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
    private ?string $created_at;
    private ?string $updated_at;

    public function __construct(
        ?int $id = null,
        ?int $roleID = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $email = null,
        ?string $password = null,
        ?string $apiToken = null,
        ?string $created_at = null,
        ?string $updated_at = null
    ) {
        $this->id = $id;
        $this->roleID = $roleID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->apiToken = $apiToken;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'roleID' => $this->roleID,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'apiToken' => $this->apiToken,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
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
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
